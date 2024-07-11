<?php

namespace App\Services\Generator;

use App\Models\OnlineShopProduct;
use App\Services\Generator\Interfaces\RouteGeneratorInterface;

class ColesRouteGenerator implements RouteGeneratorInterface
{
    public function generator(string $id): string
    {
        $product = OnlineShopProduct::find($id);
        $name = str_replace(' ','-','Tip Top The One White Sandwich Bread');
        $size = $product->size;
        $id = $product->origin_id;
        $route = 'https://www.coles.com.au'  .'/product' .'/' .$name .'-' .$size .'-' .$id;

        return $route;

    }


}
