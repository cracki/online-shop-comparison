<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\OnlineShopProduct;
use App\Models\ProductCombination;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCombinationFactory extends Factory
{
    protected $model = ProductCombination::class;

    public function definition()
    {
        return [
            'productA_id' => OnlineShopProduct::factory(),
            'productB_id' => OnlineShopProduct::factory(),
            'percentage' => $this->faker->numberBetween(1, 100),
            'category_id' => Category::factory(),
            'engine_type' => $this->faker->word,
        ];
    }
}
