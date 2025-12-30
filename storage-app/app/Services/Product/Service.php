<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Service
{
    public function storeWithTransaction($data):Product{
        return DB::transaction(function() use ($data){
            $product = Product::create($data);
            return $product;
        });
    }

    public function updateWithTransaction($data, Product $product){
        return DB::transaction(function() use($data, $product){
            if (isset($data['price']) && $data['price'] != $product->price){
                DB::table('product_price_history')->insert([
                    'product_id' => $product->id,
                    'old_price' => $product->price,
                ]);
            }
            $product->update($data);
            return $product;
        });
    }
}