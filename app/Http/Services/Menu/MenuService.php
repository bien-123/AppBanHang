<?php


namespace App\Http\Services\Menu;


use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class MenuService
{

    public function getParent()
    {
        return Menu::where('parent_id', 0)->get();
//        return Menu::
//        when($parent_id == 0, function ($query) use ($parent_id){
//            $query->where('parent_id', $parent_id);
//        })
//            ->get();
    }

    public function show()
    {
        return Menu::select('name', 'id')
            ->where('parent_id', 0)
            ->orderbyDesc('id')
            ->get();
    }

    public function getAll()
    {
        return Menu::orderbyDesc('id')->paginate(10);//sử dụng khi nhiều menu để phân trang
//        return Menu::orderbyDesc('id')->get();
    }

    public function create($request)
    {
        try {
            Menu::create([
                'name' => (string) $request->input('name'),
                'parent_id' => (int) $request->input('parent_id'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (string) $request->input('active'),
//                'slug' => Str::slug($request->input('name'), '-')
            ]);
            Session::flash('success','Tạo Danh Mục Thành Công');
        } catch (\Exception $err)
        {
            Session::flash('error', $err->getMessage());
            return false;
        }

        return true;
    }

    public function update($request, $menu):bool
    {
//        $menu->fill($request->input());
//        $menu->save();
        if($request->input('parent_id') != $menu->id)//nếu parent_id ko bằng vs id thì cho sửa
        {
            $menu->parent_id = (int) $request->input('parent_id');
        }

        $menu->name = (string) $request->input('name');
        $menu->description = (string) $request->input('description');
        $menu->content = (string) $request->input('content');
        $menu->active = (string) $request->input('active');
        $menu->save();

        Session::flash('success', 'Cập nhật thành công Danh mục');
        return true;
    }

    public function destroy($request)
    {
//        gán biến cho id để sử dụng nhiều lần
        $id = (int) $request->input('id');
//        kiểm tra xem sản phẩm có id cần xóa đã có trong data chưa
        $menu = Menu::where('id', $id)->first();
        if ($menu) {
            return Menu::where('id', $id)->orWhere('parent_id', $id)->delete();
        }

        return false;
    }

    public function getId($id)
    {
        return Menu::where('id', $id)->where('active', 1)->firstOrFail(); // firstOrFail() dùng để kiểm tra xem có id hay ko. ko có thì báo lỗi

    }

    public function getProduct($menu, $request)
    {

        $query = $menu->products()
            ->select('id', 'name', 'price', 'price_sale', 'thumb')
            ->where('active', 1);

        if ($request->input('price')) {
            $query->orderBy('price', $request->input('price'));
        }

        return $query->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();
    }
}
