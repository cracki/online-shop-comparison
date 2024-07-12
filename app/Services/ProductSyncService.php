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
            foreach ($productAIds as $index => $productAId) {
                // Determine the current percentage, either as an array element or a single value
                $currentPercentage = is_array($percentage) ? $percentage[$index] : $percentage;

                // Create a new ProductCombination record
                ProductCombination::create([
                    'productA_id' => $productAId,
                    'productB_id' => $productBIds[$index],
                    'percentage' => $currentPercentage,
                    'engine_type' => $engineType,
                    'category_id' => $categoryId,
                ]);
            }
        });
    }
}
