<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductsImported
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


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

    public function importProducts()
    {

        // After import is done, fire the event
        event(new ProductsImported());
    }
}
