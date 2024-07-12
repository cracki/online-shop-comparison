<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;


class ProductsImported
{
    use Dispatchable;

    public int $category_id;

    /**
     * Create a new event instance.
     *
     * @param int $category_id
     */
    public function __construct(int $category_id)
    {
        $this->category_id = $category_id;
    }
}
