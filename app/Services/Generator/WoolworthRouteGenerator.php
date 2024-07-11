<?php

namespace App\Services\Generator;

use App\Models\OnlineShopProduct;
use App\Services\Generator\Interfaces\RouteGeneratorInterface;

class WoolworthRouteGenerator implements RouteGeneratorInterface
{
    public function generator(string $id): string
    {
       $product = OnlineShopProduct::find($id);

        $name = str_replace(' ','-',$product->name);
        $id =$product->origin_id;
        $route = $product->onlineShop->base_url  .'shop' .'/productdetails/' .$id .'/' .$name;

        return $route;

    }

}
