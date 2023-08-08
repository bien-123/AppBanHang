<?php


namespace App\Http\Services\Product;


use App\Models\Menu;
//use MongoDB\Driver\Session;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    protected function isValidPrice($request)
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
        && $request->input('price_sale') >= $request->input('price'))
        {
            Session::flash('error','Giá giảm phải nhỏ hơn giá gốc!');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') ==0) {
            Session::flash('error','Vui lòng nhập giá gốc!');
            return false;
        }

        return true;
    }

    public function insert($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice == false) return false;

        try {
            $request->except('_token');//loại bỏ token
            Product::create($request->all());

            Session::flash('success','Thêm sản phẩm thành công!');
        } catch (\Exception $err) {
//            Session::flash('error','Thêm sản phẩm lỗi!');
//            \Log::info($err->getMessage());
            Session::flash('error', $err->getMessage());
            return false;
        }

        return true;
    }

    public function get()
    {
        return Product::with('menu')->orderBy('id')->paginate(15); // sắp xếp tăng dần theo id
//        return Product::with('menu')->orderBy('id')->paginate(15); Sắp xếp giảm dần theo id
    }

    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if ($isValidPrice == false) return false;

        try {
            $product->fill($request->input());
            $product->save();
            Session::flash('success', 'Cập nhật thành công!');
        } catch (\Exception $err)
        {
            Session::flash('error', 'Có lỗi vui lòng nhập lại!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
        $id = (int) $request->input('id');
//        kiểm tra xem sản phẩm có id cần xóa đã có trong data chưa
        $menu = Product::where('id', $id)->first();
        if ($menu) {
            return Product::where('id', $id)->delete();
        }

        return false;
    }
}
