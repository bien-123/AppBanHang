<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.users.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->input());
        $this->validate($request, [
            'email' => 'required|email:filter',//kiểm tra xem đã nhập đúng định dạng mật khẩu chưa
            'password' => 'required',// kiểm tra xem nhập email chưa
        ]);

        // Nếu kiểm tra email, mk xem có đúng ko. Nếu đúng trả về router admin trong LoginController
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            return redirect()-> route('admin');
        }

        // Đăng nhập User
        // elseif (Auth::attempt([
        //     'email' => $request->input('email'),
        //     'password' => $request->input('password'),
        //     'level' => 0,
        // ], $request->input('remember'))) {
        //     dd($request->input());
        // }

        else {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu bạn nhập không đúng!',
            ])->onlyInput('email');
        }

        // Nếu sai thì load lại trang login
        // return redirect()->back();
    }
}
