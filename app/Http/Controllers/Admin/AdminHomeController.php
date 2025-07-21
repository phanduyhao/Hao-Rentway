<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index(Request $request)
    {
        // Lọc theo khoảng ngày từ request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
    
        // Điều kiện lọc ngày
        $filterDate = function ($query) use ($fromDate, $toDate) {
            if ($fromDate && $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }
        };
    
        // Thống kê tổng số bài đăng của mỗi user (lọc theo khoảng ngày)
        $thongkes = User::select('name', 'email', 'role')
            ->withCount(['baidangs' => $filterDate])
            ->orderByDesc('baidangs_count')
            ->get();
    
        // Thống kê bài đăng trong tháng (lọc theo khoảng ngày)
        $thongkeotheothang = User::select('name', 'email', 'role')
            ->withCount(['baidangs' => function ($query) use ($filterDate) {
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                $filterDate($query);
            }])
            ->orderByDesc('baidangs_count')
            ->get();
    
        // Thống kê bài đăng trong tuần (lọc theo khoảng ngày)
        $thongkesoWeek = User::select('name', 'email', 'role')
            ->withCount(['baidangs' => function ($query) use ($filterDate) {
                $startOfWeek = Carbon::now()->startOfWeek()->toDateString(); // Lấy ngày đầu tuần
                $endOfWeek = Carbon::now()->endOfWeek()->toDateString(); // Lấy ngày cuối tuần
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                $filterDate($query);
            }])
            ->orderByDesc('baidangs_count')
            
            ->get();

        // Thống kê bài đăng trong ngày (lọc theo khoảng ngày)
        $thongketheongay = User::select('name', 'email', 'role')
            ->withCount(['baidangs' => function ($query) use ($filterDate) {
                $query->whereDate('created_at', now()->toDateString());
                $filterDate($query);
            }])
            ->orderByDesc('baidangs_count')
            ->get();
    
        return view('admin.home', [
            'title' => 'Trang quản trị',
            'thongkes' => $thongkes,
            'thongkeotheothang' => $thongkeotheothang,
            'thongketheongay' => $thongketheongay,
            'thongkesoWeek' => $thongkesoWeek,
            'fromDate' => $fromDate,
            'toDate' => $toDate
        ]);
    }
    
    
}
