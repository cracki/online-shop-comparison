<?php

namespace Tests\Unit\Http\Controllers;

use App\Events\ProductsImported;
use App\Http\Controllers\StoreJsonController;
use App\Models\Category;
use App\Models\OnlineShop;
use App\Models\OnlineShopProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Tests\TestCase;

class StoreJsonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testShowUploadForm()
    {
        Category::factory()->count(3)->create();
        OnlineShop::factory()->count(2)->create();

        $controller = new StoreJsonController();
        $response = $controller->showUploadForm();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('upload', $response->name());
        $this->assertArrayHasKey('categories', $response->getData());
        $this->assertArrayHasKey('onlineShops', $response->getData());
    }

}
