<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OnlineShopProduct;
use App\Services\ProductSyncService;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected ProductSyncService $productSyncService;
    public function __construct(ProductSyncService $productSyncService)
    {
        $this->productSyncService = $productSyncService;
    }

    public function compare()
    {
        $categoryA = json_decode(file_get_contents(storage_path('Coles.json')), true);
        $categoryB = json_decode(file_get_contents(storage_path('Woolworths.json')), true);

        $engines = app('similarityEngines');
        $results = [];
        foreach ($engines as $engine) {
            $results[get_class($engine)] = $engine->calculateSimilarities($categoryA, $categoryB)->getSimilarities(); //->saveSimilarities()
        }


        $productAIds = [];
        $productBIds = [];
        $similarities = [];

// Extracting values
        foreach ($results["App\Services\Similarity\PhpMLSimilarityEngine"] as $item) {
            $productAIds[] = $item["product_a_id"];
            $productBIds[] = $item["product_b_id"];
            $similarities[] = $item["similarity"];
        }

// Now $productAIds, $productBIds, and $similarities contain the required values as arrays
//        dd($productAIds, $productBIds, $similarities);

        $this->productSyncService->storeCategoryProducts($productAIds,$productBIds,$similarities,'engine',1);
    }

    public function compare1()
    {

        // Fetch specific fields for products from Coles and Woolworths
        $categoryA = OnlineShopProduct::where('online_shop_id', 1)
            ->select('id', 'name', 'brand', 'description', 'category', 'price')
            ->get()
            ->toArray();

        $categoryB = OnlineShopProduct::where('online_shop_id', 2)
            ->select('id', 'name', 'brand', 'description', 'category', 'price')
            ->get()
            ->toArray();

        $distinctCategoriesCount = DB::table('online_shop_products')->select('online_shop_id')->distinct()->count('online_shop_id');

        $areAllSameCategory = ($distinctCategoriesCount == 1);
        // Initialize similarity engines
        $engines = app('similarityEngines');
        $results = [];

        // Calculate similarities using each engine
        foreach ($engines as $engine) {
            $results[get_class($engine)] = $engine->calculateSimilarities($categoryA, $categoryB)->getSimilarities();
        }
        $productAIds = [];
        $productBIds = [];
        $similarities = [];

// Extracting values
        foreach ($results["App\Services\Similarity\PhpMLSimilarityEngine"] as $item) {
            $productAIds[] = $item["product_a_id"];
            $productBIds[] = $item["product_b_id"];
            $similarities[] = $item["similarity"];
        }

// Now $productAIds, $productBIds, and $similarities contain the required values as arrays
//        dd($productAIds, $productBIds, $similarities);

        $this->productSyncService->storeCategoryProducts($productAIds,$productBIds,$similarities,'engine',1);


        // Output the results
        dd($results);
    }
}
