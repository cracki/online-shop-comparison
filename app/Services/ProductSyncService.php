<?php

namespace App\Services;

use App\Models\ProductCombination;
use Illuminate\Support\Facades\DB;

class ProductSyncService
{
    /**
     *
     * @param array $productAIds
     * @param array $productBIds
     * @param int $percentage
     * @param string $engineType
     * @return void
     */
    public function storeCategoryProducts(array $productAIds, array $productBIds, array $percentage, string $engineType,int $categoryId)
    {
        DB::transaction(function () use ($productAIds, $productBIds, $percentage, $engineType,$categoryId) {
            for ($i = 0; $i < count($productAIds); $i++) {
                ProductCombination::create([
                    'productA_id' => $productAIds[$i],
                    'productB_id' => $productBIds[$i],
                    'percentage' => $percentage[$i],
                    'engine_type' => $engineType,
                    'category_id'=> $categoryId
                ]);
            }
        });
    }
}
