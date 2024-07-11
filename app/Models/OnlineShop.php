<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OnlineShop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'base_url'];

    public function products(): HasMany
    {
        return $this->hasMany(OnlineShopProduct::class);
    }
}
