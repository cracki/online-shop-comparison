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
     *
     * @param ProductsImported $event
     * @return void
     */
    public function handle(ProductsImported $event): void
    {
        $category_id = $event->category_id;

        $shopIds = $this->getDistinctShopIds($category_id);
        foreach ($shopIds as $shopIdA) {
            foreach ($shopIds as $shopIdB) {
                if ($shopIdA !== $shopIdB) {
                    $productsA = $this->getProductsByShopId($shopIdA, $category_id);
                    $productsB = $this->getProductsByShopId($shopIdB, $category_id);

                    $results = $this->calculateSimilarities($productsA, $productsB);

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
     * @param int $category_id
     * @return array
     */
    protected function getDistinctShopIds(int $category_id): array
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
     * @param int $category_id
     * @return array
     */
    protected function getProductsByShopId(int $shopId, int $category_id): array
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
     * @param array $productsA
     * @param array $productsB
     * @return array
     */
    protected function calculateSimilarities(array $productsA, array $productsB): array
    {
        $engines = app('similarityEngines');
        $results = [];

        foreach ($engines as $engine) {
            $results[get_class($engine)] = $engine->calculateSimilarities($productsA, $productsB)->getSimilarities();
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
        $similarityValues = [];

        foreach ($results as $item) {
            $productAIds[] = $item["product_a_id"];
            $productBIds[] = $item["product_b_id"];
            $similarityValues[] = $item["similarity"];
        }

        return [$productAIds, $productBIds, $similarityValues];
    }
}
