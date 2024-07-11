<?php

namespace App\Http\Controllers;

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


    public function show(string $id)
    {
        $shopProducts = [];
        $onlineShops = [1 => 'colesProduct', 2 => 'woolworthsProduct'];

        foreach ($onlineShops as $shopId => $variableName) {
            $shopProducts[$variableName] = OnlineShopProduct::where('onlineshop_id', '=', $shopId)
                ->where('category_id', '=', $id)
                ->get();
        }

        $colesProduct = $shopProducts['colesProduct'];
        $woolworthsProduct = $shopProducts['woolworthsProduct'];

        return view('products.create', compact('colesProduct','woolworthsProduct'));
    }
    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        $products = ProductCombination::with(['productA', 'productB', 'category'])->paginate(15);
        return view('products.index', compact('products'));
    }

//    /**
//     * @return Factory|View|Application
//     */
//    public function create(): Factory|View|Application
//    {
//        $products = OnlineShopProduct::all();
//        $categories = Category::all();
//        return view('products.create', compact('products','categories'));
//    }
//
//    /**
//     * @param StoreProductRequest $request
//     * @return RedirectResponse
//     */
//    public function store(StoreProductRequest $request): RedirectResponse
//    {
//
//        $productIds = $request->input('productIds');
//        $categoryIds = $request->input('categoryIds');
//        $product = CategoryProduct::create($request->validated());
//        $this->productSyncService->sync($productIds, $product);
//        $this->syncProductToCategory->sync($categoryIds,$product);
//        return redirect()->route('product.index')->with('success', 'Product created successfully.');
//    }
//
//    /**
//     * @param string $id
//     * @return View|Factory|Application
//     */
//    public function edit(string $id): View|Factory|Application
//    {
//        $product = CategoryProduct::with('onlineShops')->findOrFail($id);
//        $products = CategoryProduct::all(); // Fetch all products for the multiple products select input
//        return view('products.edit', compact('product', 'products'));
//    }
//
//
//    /**
//     * @param UpdateProductRequest $request
//     * @param CategoryProduct $product
//     * @return RedirectResponse
//     */
//    public function update(UpdateProductRequest $request, CategoryProduct $product): RedirectResponse
//    {
//        $product->update($request->validated());
//        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
//    }

}
