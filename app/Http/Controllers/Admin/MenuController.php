<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller
{

    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function create() {
        return view('admin.menu.add',[
            'title' => 'Thêm Danh Mục Mới',
             'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        // dd($request->input());
        $result = $this->menuService->create($request);//gọi đến function create trong MenuService.php

        return redirect()->back();//load lại trang
    }

    public function index()
    {
        return view('admin.menu.list', [
           'title' => 'Danh Sách Danh Mục Mới Nhất',
           'menus' => $this->menuService->getAll()
        ]);
    }

    public function show(Menu $menu) //Menu $menu để kiểm tra xem có id trong data hay chưa. $menu phải trùng vs edit/{menu} trong file web.php
    {
//        dd($menu);
        return view('admin.menu.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent()//lấy menu cha nếu cần update
        ]);
    }

    public function update(Menu $menu, CreateFormRequest $request)
    {
        $this->menuService->update($request,$menu);//gọi đến function update bên MenuService

//        nếu thành công thì trả về link
        return redirect('/admin/menus/list');
    }

    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->menuService->destroy($request);
        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa thành công danh mục'
            ]);
        }

        return response()->json([
            'error'=>true,
        ]);
    }
}
