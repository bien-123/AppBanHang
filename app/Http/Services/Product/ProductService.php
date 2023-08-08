<?php


namespace App\Http\Services\Product;


use App\Models\Product;

class ProductService
{
    const LIMIT = 16;

    public function get($page = null)
    {
//        chưa loadMore
//        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
//            ->orderByDesc('id')->limit(self::LIMIT)->get();
//        loadMore
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->orderByDesc('id')
            ->when($page != null, function ($query) use ($page) {
                $query->offset($page * self::LIMIT);
            })
            ->limit(self::LIMIT)->get();
    }

    public function show($id)
    {
        return Product::where('id', $id)
            ->where('active', 1)
            ->with('menu')//gọi đến function menu trong Product
            ->firstOrFail();
    }

    public function more($id)
    {
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->where('id', '!=', $id) // id khác vs id sản phẩm đang load
            ->orderByDesc('id')
            ->limit(8)//giới hạn 8 sản phẩm
            ->get();
    }
}
