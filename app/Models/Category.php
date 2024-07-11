<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    /**
     * @return HasMany
     */
    public function ProductCombinations(): HasMany
    {
        return $this->hasMany(ProductCombination::class, 'category_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(OnlineShopProduct::class, 'category_id');
    }
}
