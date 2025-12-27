<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ShowController extends BaseController
{
    public function __invoke(Product $product)
    {
        return new ProductResource($product);
    }
}
