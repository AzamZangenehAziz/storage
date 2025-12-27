<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();
        $product = $this->productService->updateWithTransaction($data, $product);
        return new ProductResource($product);
    }
}
