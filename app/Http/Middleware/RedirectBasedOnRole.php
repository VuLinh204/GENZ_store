<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle($request, Closure $next, $role)
    {
        // Kiểm tra vai trò của người dùng
        if (Auth::user()->role != $role) {
            // Xử lý khi vai trò không khớp với vai trò được chỉ định
            return redirect()->route('users.signin');
        }

        // Chuyển tiếp yêu cầu sang Controller
        return $next($request);
    }
}
