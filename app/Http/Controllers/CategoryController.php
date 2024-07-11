<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\OnlineShopProduct;
use App\Models\ProductCombination;
use App\Services\ProductSyncService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected ProductSyncService $productSyncService;


    public function __construct(ProductSyncService $productSyncService)
    {
        $this->productSyncService = $productSyncService;
    }
    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        $categories = Category::all();
        return view('category.index',compact('categories'));
    }


    public function show(Category $category)
    {
        // Retrieve all online shop IDs dynamically
        $onlineShopIds = $category->products()
            ->distinct()
            ->pluck('online_shop_id');

        $products = [];

        foreach ($onlineShopIds as $shopId) {
            $products[$shopId] = $category->products()
                ->where('online_shop_id', $shopId)
                ->get();
        }

        return view('category.show', [
            'products' => $products,
            'category' => $category,
            'onlineShopIds' => $onlineShopIds,
        ]);
    }


    /**
     * @return View|Factory|Application
     */
    public function create(): View|Factory|Application
    {
        return view('category.create');
    }

    /**
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());
        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * @param string $id
     * @return View|Factory|Application
     */
    public function edit(Category $category): View|Factory|Application
    {
        return view('category.edit', compact('category'));
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function syncProduct(Request $request,Category $category)
    {
        //todo: can be moved to Request class
        $data = $request->validate([
            'colesProductIds' => 'required|array',
            'colesProductIds.*' => 'required',
            'woolworthsProductIds' => 'required|array',
            'woolworthsProductIds.*' => 'required',
        ]);

        $this->productSyncService->storeCategoryProducts(
            $data['colesProductIds'],
            $data['woolworthsProductIds'],
           100,
           'manual',
            $category->id
        );

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    public function showProductsOfCategory(Category $category): View|Factory|Application
    {
        $products = $category->ProductCombinations()
            ->with(['productA', 'productB', 'category'])
            ->paginate();

        return view('category.index-products', compact('products'));
    }
}

