<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\OnlineShop;
use App\Models\OnlineShopProduct;
use App\Models\ProductCombination;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $categories = Category::factory(5)->create();

        $onlineShops = OnlineShop::factory()->createMany([
            ['name' => 'coles', 'base_url' => 'https://www.coles.com.au'],
            ['name' => 'woolworths', 'base_url' => 'https://www.woolworths.com.au'],
        ]);

//        foreach ($categories as $category) {
//            foreach ($onlineShops as $shop) {
//                OnlineShopProduct::factory(10)->create([
//                    'online_shop_id' => $shop->id,
//                    'category_id' => $category->id,
//                ]);
//            }
//        }
//
//        $products = OnlineShopProduct::all();
//
//        for ($i = 0; $i < 10; $i++) {
//            ProductCombination::factory()->create([
//                'productA_id' => $products->random()->id,
//                'productB_id' => $products->random()->id,
//                'category_id' => $categories->random()->id,
//            ]);
//        }
    }
}
