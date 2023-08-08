<?php


namespace App\Http\Services;


use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function create($request)
    {
        $qty = (int)$request->input('num_product');
        $product_id = (int)$request->input('product_id');//product_id là name của 1 trường bên product.lits.blade


        if ($qty <= 0 || $product_id <= 0)
        {
            Session::flash('error', 'Số lượng hoặc sản phẩm không chính xác!');
            return false;
        }

        $carts = Session::get('carts');// dùng 1 mảng để chứa giá trị trả về
        if(is_null($carts)){
            Session::put('carts', [
                $product_id => $qty
            ]);
            return true;
        }

//        Session::forget('carts');
        $exists = Arr::exists($carts, $product_id);//kiem tra xen trong mang co gia tri product_id chưa
        if ($exists)
        {
            $qtyNew = $carts[$product_id] + $qty;
            Session::put('carts', [
                $product_id => $qtyNew
            ]);
            return true;
        }

        Session::put('carts', [
            $product_id => $qty
        ]);

        return true;
    }

    public function getProduct()
    {
        $carts = Session::get('carts');
        if (is_null($carts)) return [];

        $productId = array_keys($carts);
        return Product::select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1)
            ->whereIn('id', $productId)
            ->get();
    }
}
