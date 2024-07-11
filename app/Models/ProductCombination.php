<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductCombination extends Model
{
    use HasFactory;
    public $timestamps = false; // Disable timestamps

    protected $fillable = ['productA_id', 'productB_id', 'percentage', 'category_id', 'engine_type'];

    public function productA(): BelongsTo
    {
        return $this->belongsTo(OnlineShopProduct::class, 'productA_id');
    }

    public function productB(): BelongsTo
    {
        return $this->belongsTo(OnlineShopProduct::class, 'productB_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function onlineShops(): BelongsToMany
    {
        return $this->belongsToMany(OnlineShopProduct::class, 'online_shop_has_products', 'product_id', 'online_shop_product_id')
            ->withTimestamps();
    }

    public function productCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_has_products', 'product_id');
    }
}
