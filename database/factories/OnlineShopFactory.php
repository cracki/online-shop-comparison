<?php

namespace Database\Factories;

use App\Models\OnlineShop;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineShopFactory extends Factory
{
    protected $model = OnlineShop::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['coles', 'woolworths']),
            'base_url' => $this->faker->randomElement(['https://www.coles.com.au', 'https://www.woolworths.com.au']),
        ];
    }
}
