<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Các vai trò hợp lệ của admin
     *
     * @var array
     */
    private $validRoles = ['admin', 'nhanvien']; // Ví dụ vai trò hợp lệ

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có vai trò hợp lệ
        if (Auth::check() && in_array(Auth::user()->role, $this->validRoles)) {
            return $next($request);
        }

        // Nếu không có quyền admin, chuyển hướng về trang chủ hoặc trang lỗi
        return redirect('/')->with('error', 'Bạn không có quyền truy cập vào trang này.');
    }
}
