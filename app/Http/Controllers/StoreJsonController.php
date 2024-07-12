<?php

namespace App\Http\Controllers;

use App\Events\ProductsImported;
use App\Http\Requests\UploadJsonRequest;
use App\Models\Category;
use App\Models\OnlineShop;
use App\Models\OnlineShopProduct;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class StoreJsonController extends Controller
{
    public function showUploadForm(): View|Factory|Application
    {
        $categories = Category::all();
        $onlineShops = OnlineShop::all();
        return view('upload', compact('categories', 'onlineShops'));
    }

    public function uploadJson(UploadJsonRequest $request): RedirectResponse
    {
        $category_id = $request->input('category');
        $online_shop_id = $request->input('online_shop_id');

        $file = $request->file('jsonFile');
        $jsonContent = file_get_contents($file->getRealPath());
        $data = json_decode($jsonContent, true);

        foreach ($data as $item) {
            OnlineShopProduct::create([
                'origin_id' => $item['id'],
                'brand' => $item['brand'],
                'price' => $item['price'],
                'size' => $item['size'] ?? null,
                'name' => $item['name'],
                'description' => $item['description'],
                'category' => $item['category'],
                'online_shop_id' => $online_shop_id,
                'category_id' => $category_id,
            ]);
        }


        event(new ProductsImported($category_id));

        return redirect()->back()->with('success', 'JSON data imported successfully');
    }
}
