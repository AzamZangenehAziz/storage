<?php

namespace App\Http\Controllers;

use App\Services\Product\Service as ProductService;
use App\Services\Order\Service as OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    protected ProductService $productService;
    protected OrderService $orderService;

    public function __construct(ProductService $productService, OrderService $orderService)
    {
        $this->productService = $productService;
        $this->orderService = $orderService;
    }
}
