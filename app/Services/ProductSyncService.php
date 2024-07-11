<?php

namespace App\Services;

use App\Models\ProductCombination;
use Illuminate\Support\Facades\DB;

class ProductSyncService
{
    /**
     * Store category products with their similarities.
     *
     * @param array $productAIds
     * @param array $productBIds
     * @param array|int $percentage
     * @param string $engineType
     * @param int $categoryId
     * @return void
     */
    public function storeCategoryProducts(array $productAIds, array $productBIds, array|int $percentage, string $engineType, int $categoryId): void
    {
        DB::transaction(function () use ($productAIds, $productBIds, $percentage, $engineType, $categoryId) {
            for ($i = 0; $i < count($productAIds); $i++) {
                $currentPercentage = is_array($percentage) ? $percentage[$i] : $percentage;

                ProductCombination::create([
                    'productA_id' => $productAIds[$i],
                    'productB_id' => $productBIds[$i],
                    'percentage' => $currentPercentage,
                    'engine_type' => $engineType,
                    'category_id' => $categoryId,
                ]);
            }
        });
    }
}
