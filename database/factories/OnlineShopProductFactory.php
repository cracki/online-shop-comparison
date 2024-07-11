<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\OnlineShop;
use App\Models\OnlineShopProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineShopProductFactory extends Factory
{
    protected $model = OnlineShopProduct::class;

    public function definition()
    {
        return [
            'origin_id' => $this->faker->numberBetween(1000, 9999),
            'brand' => $this->faker->company,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'size' => $this->faker->word,
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'category' => $this->faker->word,
            'online_shop_id' => OnlineShop::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
