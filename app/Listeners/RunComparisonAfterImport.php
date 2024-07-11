<?php

namespace App\Listeners;

use App\Events\ProductsImported;
use App\Models\OnlineShopProduct;
use App\Services\ProductSyncService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $category_id = $event->category_id;

        $shopIds = $this->getDistinctShopIds($category_id);

        foreach ($shopIds as $shopIdA) {
            foreach ($shopIds as $shopIdB) {
                if ($shopIdA !== $shopIdB) {
                    $categoryA = $this->getProductsByShopId($shopIdA, $category_id);
                    $categoryB = $this->getProductsByShopId($shopIdB, $category_id);

                    $results = $this->calculateSimilarities($categoryA, $categoryB);

                    foreach ($results as $engineClass => $similarities) {
                        [$productAIds, $productBIds, $similarityValues] = $this->extractSimilarities($similarities);
                        $engineName = (new \ReflectionClass($engineClass))->getShortName();
                        $this->productSyncService->storeCategoryProducts($productAIds, $productBIds, $similarityValues, $engineName, $category_id);
                    }
                }
            }
        }
    }

    /**
     * Get distinct shop IDs for a given category.
     *
     * @param string $category_id
     * @return array
     */
    protected function getDistinctShopIds(string $category_id): array
    {
        return OnlineShopProduct::where('category_id', $category_id)
            ->distinct()
            ->pluck('online_shop_id')
            ->toArray();
    }

    /**
     * Get products by shop ID.
     *
     * @param int $shopId
     * @param string $category_id
     * @return array
     */
    protected function getProductsByShopId(int $shopId, string $category_id): array
    {
        return OnlineShopProduct::where('online_shop_id', $shopId)
            ->where('category_id', $category_id)
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

        foreach ($results as $item) {
            $productAIds[] = $item["product_a_id"];
            $productBIds[] = $item["product_b_id"];
            $similarities[] = $item["similarity"];
        }

        return [$productAIds, $productBIds, $similarities];
    }
}
