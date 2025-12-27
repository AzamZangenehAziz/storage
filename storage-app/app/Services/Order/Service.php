<?php

namespace App\Services\Order;

use App\Exceptions\OutOfStockException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class Service {
    public function storeWithTransaction(StoreRequest $request){
        return DB::transaction(function() use($request){
            $products = $request->validated()['products'];
            $productsFromDb = Product::whereIn('id', collect($products)->pluck('id'))->get()->keyBy('id');
            $order = Order::create([
                'total_sum' => 0,
                'total_quantity' => 0,
            ]);
            $totalSum = 0;
            $totalQuantity = 0;
            $orderItems = [];
            foreach ($products as $product){
                if (!isset($productsFromDb[$product['id']])){
                    throw new ProductNotFoundException("Товар с вашим id не найден");
                }
                $productModel = $productsFromDb[$product['id']];
                if ($productModel->stock < $product['quantity']) {
                    throw new OutOfStockException("Товара '{$productModel->name}' недостаточно на складе");
                }
                $productModel->decrement('stock', $product['quantity']); //Минусует количество заказанных продуктов в базе
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $productModel->id,
                    'quantity' => $product['quantity'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $totalSum += $productModel->price * $product['quantity'];
                $totalQuantity += $product['quantity'];
            }
            OrderProduct::insert($orderItems);
            $order->update([
                'total_sum' => $totalSum,
                'total_quantity' => $totalQuantity,
            ]);
        });
    }
}