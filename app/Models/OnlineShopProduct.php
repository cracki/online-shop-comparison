<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineShopProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin_id', 'brand', 'price', 'size', 'name', 'description', 'category', 'online_shop_id', 'category_id'
    ];

    public function onlineShop(): BelongsTo
    {
        return $this->belongsTo(OnlineShop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
