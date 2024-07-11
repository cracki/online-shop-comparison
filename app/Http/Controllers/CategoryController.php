<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\OnlineShopProduct;
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


    public function show(string $id)
    {
        $category = Category::find($id);
            $colesProducts = OnlineShopProduct::where('online_shop_id', 1)
                ->where('category_id', $id)
                ->get();

            $woolworthsProducts = OnlineShopProduct::where('online_shop_id', 2)
                ->where('category_id', $id)
                ->get();

            return view('category.show', [
                'colesProducts' => $colesProducts,
                'woolworthsProducts' => $woolworthsProducts,
                'category' => $category
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
    public function edit(string $id): View|Factory|Application
    {
        $category = Category::find($id);
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
    public function syncProduct(Request $request,string $id)
    {

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
            $id
        );

        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

}

