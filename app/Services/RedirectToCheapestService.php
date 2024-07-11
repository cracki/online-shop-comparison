<?php

namespace App\Services;

use App\Models\OnlineShopProduct;
use App\Services\Generator\Interfaces\RouteGeneratorInterface;
use App\Services\Generator\ColesRouteGenerator;
use App\Services\Generator\WoolworthRouteGenerator;
use Illuminate\Support\Facades\Redirect;

class RedirectToCheapestService
{
    protected WoolworthRouteGenerator $woolworthRouteGenerator;
    protected ColesRouteGenerator $colesRouteGenerator;

    public function __construct(WoolworthRouteGenerator $woolworthRouteGenerator, ColesRouteGenerator $colesRouteGenerator)
    {
        $this->woolworthRouteGenerator = $woolworthRouteGenerator;
        $this->colesRouteGenerator = $colesRouteGenerator;
    }

    public function redirect(string $productId)
    {
        $product = OnlineShopProduct::find($productId);

        if ($product) {
            $routeGenerator = $this->getRouteGenerator($product->online_shop_id);
            return $routeGenerator->generator($product->id);
        }

        return Redirect::back()->with('error', 'No online shop found for this product.');
    }

    protected function getRouteGenerator(int $onlineShopId): RouteGeneratorInterface
    {
        switch ($onlineShopId) {
            case 2:
                return $this->woolworthRouteGenerator;
            case 1:
                return $this->colesRouteGenerator;
            default:
                throw new \Exception('Unsupported online shop ID.');
        }
    }
}
