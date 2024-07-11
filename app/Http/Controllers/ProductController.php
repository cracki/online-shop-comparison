<?php

namespace App\Http\Controllers;

use App\Models\OnlineShop;
use App\Models\OnlineShopProduct;
use App\Models\ProductCombination;
use App\Services\ProductSyncService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ProductController extends Controller
{
    protected ProductSyncService $productSyncService;

    public function __construct(ProductSyncService $productSyncService)
    {
        $this->productSyncService = $productSyncService;
    }

    /**
     * @return View|Factory|Application
     */
    public function __invoke(): View|Factory|Application
    {
        $products = ProductCombination::with(['productA', 'productB', 'category'])->paginate();
        return view('products.index', compact('products'));
    }
}
