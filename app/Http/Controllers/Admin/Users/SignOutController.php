<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            // Gán giá trị null cho vai trò trong session
            $request->session()->forget('role');

            // Đăng xuất người dùng
            Auth::logout();


            // Làm mới session và token
            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }
        return redirect()->route('guest.home');
    }
}
