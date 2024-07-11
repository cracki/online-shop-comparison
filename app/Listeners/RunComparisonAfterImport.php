<?php

namespace App\Listeners;

use App\Events\ProductsImported;
use App\Models\OnlineShopProduct;
use App\Services\ProductSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class RunComparisonAfterImport
{
    protected ProductSyncService $productSyncService;

    /**
     * Create the event listener.
     */
    public function __construct(ProductSyncService $productSyncService)
    {
        $this->productSyncService = $productSyncService;
    }

    /**
     * Handle the event.
     */
    public function handle(ProductsImported $event): void
    {
        $categoryA = $this->getProductsByShopId(1);
        $categoryB = $this->getProductsByShopId(2);

        $results = $this->calculateSimilarities($categoryA, $categoryB);

        [$productAIds, $productBIds, $similarities] = $this->extractSimilarities($results);

        $this->productSyncService->storeCategoryProducts($productAIds, $productBIds, $similarities, 'engine', 1);
    }

    /**
     * Get products by shop ID.
     *
     * @param int $shopId
     * @return array
     */
    protected function getProductsByShopId(int $shopId): array
    {
        return OnlineShopProduct::where('online_shop_id', $shopId)
            ->select('id', 'name', 'brand', 'description', 'category', 'price')
            ->get()
            ->toArray();
    }

    /**
     * Calculate similarities between two categories of products.
     *
     * @param array $categoryA
     * @param array $categoryB
     * @return array
     */
    protected function calculateSimilarities(array $categoryA, array $categoryB): array
    {
        $engines = app('similarityEngines');
        $results = [];

        foreach ($engines as $engine) {
            $results[get_class($engine)] = $engine->calculateSimilarities($categoryA, $categoryB)->getSimilarities();
        }

        return $results;
    }

    /**
     * Extract similarities from the results.
     *
     * @param array $results
     * @return array
     */
    protected function extractSimilarities(array $results): array
    {
        $productAIds = [];
        $productBIds = [];
        $similarities = [];

        foreach ($results["App\Services\Similarity\PhpMLSimilarityEngine"] as $item) {
            $productAIds[] = $item["product_a_id"];
            $productBIds[] = $item["product_b_id"];
            $similarities[] = $item["similarity"];
        }

        return [$productAIds, $productBIds, $similarities];
    }
}
