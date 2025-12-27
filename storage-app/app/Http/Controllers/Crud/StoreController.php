<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Resources\Product\ProductResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();
        $product = $this->productService->storeWithTransaction($data);        
        return new ProductResource($product);
    }
}
