<?php

namespace Tests\Unit;

use App\Events\ProductsImported;
use PHPUnit\Framework\TestCase;

class ProductsImportedTest extends TestCase
{
    /** @test */
    public function it_correctly_initializes_with_category_id()
    {
        $categoryId = 1;
        $event = new ProductsImported($categoryId);

        $this->assertEquals($categoryId, $event->category_id);
    }
}
