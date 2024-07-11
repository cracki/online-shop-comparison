<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductCombination;
use App\Services\RedirectToCheapestService;
use Illuminate\View\View;

class CheapestProductController extends Controller
{
    protected RedirectToCheapestService $cheapestService;

    /**
     * CheapestProductController constructor.
     *
     * @param RedirectToCheapestService $cheapestService
     */
    public function __construct(RedirectToCheapestService $cheapestService)
    {
        $this->cheapestService = $cheapestService;
    }

    /**
     * Display a list of the cheapest products.
     *
     * @param string|int $id
     * @return View
     */
    public function show(Category $category): View
    {
        $products = $category->ProductCombinations()
            ->with(['productA', 'productB'])
            ->where('percentage','>','80') //todo: this must be chosen carefully
            ->get()
            ->map(function ($productCombination) {
                if ($productCombination->productA->price < $productCombination->productB->price) {
                    return $productCombination->productA;
                } else {
                    return $productCombination->productB;
                }
            })
             ->all(); // todo: paginate in production

        return view('cheapestProduct.show', compact('products'));
    }

    /**
     * Redirect to the cheapest product.
     *
     * @param string $id
     * @return View
     */
    public function redirect(string $id): View
    {
        $route = $this->cheapestService->redirect($id);
        return view('cheapestProduct.redirect', compact('route'));
    }
}
