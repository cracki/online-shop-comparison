<?php

namespace App\Http\Controllers;

use App\Events\ProductsImported;
use App\Models\Category;
use App\Models\OnlineShopProduct;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreJsonController extends Controller
{
    public function showUploadForm(): View|Factory|Application
    {
        $categories = Category::all();
        return view('upload', compact('categories'));
    }

    public function uploadJson(Request $request): RedirectResponse
    {
        $request->validate([
            'jsonFile' => 'required|file|mimes:json|max:2048',
            'category' => 'required|exists:categories,id', // Ensure category exists in categories table
        ]);

        $category_id = $request->input('category');

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
                'online_shop_id' => $item['online_shop_id']?? 2,
                'category_id' => $category_id,
            ]);
        }

        // Check if all products have the same online_shop_id and dispatch event if true

        if (!$this->checkIfAllProductsHaveSameOnlineShopId()) {
            event(new ProductsImported());
        }

        return redirect()->back()->with('success', 'JSON data imported successfully');
    }

    /**
     * @return bool
     */
    private function checkIfAllProductsHaveSameOnlineShopId(): bool
    {
        $distinctOnlineShopCount = OnlineShopProduct::select('online_shop_id')->distinct()->count();
        return $distinctOnlineShopCount == 1;
    }
}
