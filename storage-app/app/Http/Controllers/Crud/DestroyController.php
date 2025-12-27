<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyController extends BaseController
{
    public function __invoke(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted succesfully',
        ]);
    }
}
