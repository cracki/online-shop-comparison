<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\CheapestProductController;
use App\Models\ProductCombination;
use App\Models\OnlineShopProduct;
use App\Services\RedirectToCheapestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class CheapestProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the redirect method.
     *
     * @return void
     */
    public function testRedirect()
    {
        // Mock the RedirectToCheapestService
        $cheapestService = Mockery::mock(RedirectToCheapestService::class);
        $cheapestService->shouldReceive('redirect')
            ->with('1')
            ->andReturn('some-route');

        // Create an instance of the controller with the mocked service
        $controller = new CheapestProductController($cheapestService);

        // Call the redirect method
        $response = $controller->redirect('1');

        // Assert the view is returned with the correct data
        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('cheapestProduct.redirect', $response->name());
        $this->assertArrayHasKey('route', $response->getData());
        $this->assertEquals('some-route', $response->getData()['route']);
    }
}
