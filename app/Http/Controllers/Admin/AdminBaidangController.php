<?php

namespace App\Http\Controllers\Admin;

use App\Models\Baidang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBaidangController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
    
        // Tạo query cơ bản để lấy các Bài đăng chưa bị xóa
        $query = BaiDang::query();
    
        // Kiểm tra điều kiện tìm kiếm theo từng trường
        if ($request->filled('search_user')) {
            $query->whereHas('User', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_user . '%');
            });
        }
        
        if ($request->filled('search_title')) {
            $query->where('title', 'LIKE', '%' . $request->search_title . '%');
        }
                // Lọc theo tiêu đề bài đăng
        if ($request->filled('search_mabaidang')) {
            $query->where('mabaidang', 'LIKE', '%' . $request->search_mabaidang . '%');
        }
        if ($request->filled('search_mamoigioi')) {
            $query->where('mamoigioi', 'LIKE', '%' . $request->search_mamoigioi . '%');
        }
    
        if ($request->filled('search_mohinh')) {
            $query->where('mohinh', 'LIKE', '%' . $request->search_mohinh . '%');
        }
        
        if ($request->filled('search_loainhadat')) {
            $query->whereHas('nhadat', function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search_loainhadat . '%');
            });
        }
        
        if ($request->filled('search_trangthai')) {
            $query->where('status', 'LIKE', '%' . $request->search_trangthai . '%');
        }
        // Lấy danh sách Bài đăng với phân trang và giữ các tham số tìm kiếm trong liên kết phân trang
        $BaiDangs = $query->orderByDesc('id')->where('adminduyet',true)->paginate($perPage)->appends($request->all());
    
        return view('admin.baidang.index', compact('BaiDangs'), [
            'title' => 'Bài đăng đã duyệt'
        ]);
    }

    public function loading(Request $request)
    {
        $perPage = 10;
    
        // Tạo query cơ bản để lấy các Bài đăng chưa bị xóa
        $query = BaiDang::query();
    
        // Kiểm tra điều kiện tìm kiếm theo từng trường
        if ($request->filled('search_user')) {
            $query->whereHas('User', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_user . '%');
            });
        }
        
        if ($request->filled('search_title')) {
            $query->where('title', 'LIKE', '%' . $request->search_title . '%');
        }
        
        if ($request->filled('search_mohinh')) {
            $query->where('mohinh', 'LIKE', '%' . $request->search_mohinh . '%');
        }
        
        if ($request->filled('search_loainhadat')) {
            $query->whereHas('nhadat', function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search_loainhadat . '%');
            });
        }
        
        if ($request->filled('search_trangthai')) {
            $query->where('status', 'LIKE', '%' . $request->search_trangthai . '%');
        }
        // Lấy danh sách Bài đăng với phân trang và giữ các tham số tìm kiếm trong liên kết phân trang
        $BaiDangs = $query->orderByDesc('id')->where('adminduyet',null)->paginate($perPage)->appends($request->all());
    
        return view('admin.baidang.loading', compact('BaiDangs'), [
            'title' => 'Bài đăng đang chờ duyệt'
        ]);
    }

    public function cancel(Request $request)
    {
        $perPage = 10;
    
        // Tạo query cơ bản để lấy các Bài đăng chưa bị xóa
        $query = BaiDang::query();
    
        // Kiểm tra điều kiện tìm kiếm theo từng trường
        if ($request->filled('search_user')) {
            $query->whereHas('User', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search_user . '%');
            });
        }
        
        if ($request->filled('search_title')) {
            $query->where('title', 'LIKE', '%' . $request->search_title . '%');
        }
        
        if ($request->filled('search_mohinh')) {
            $query->where('mohinh', 'LIKE', '%' . $request->search_mohinh . '%');
        }
        
        if ($request->filled('search_loainhadat')) {
            $query->whereHas('nhadat', function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search_loainhadat . '%');
            });
        }
        
        if ($request->filled('search_trangthai')) {
            $query->where('status', 'LIKE', '%' . $request->search_trangthai . '%');
        }
        // Lấy danh sách Bài đăng với phân trang và giữ các tham số tìm kiếm trong liên kết phân trang
        $BaiDangs = $query->orderByDesc('id')->where('adminduyet',false)->paginate($perPage)->appends($request->all());
    
        return view('admin.baidang.cancel', compact('BaiDangs'), [
            'title' => 'Bài đăng đã hủy'
        ]);
    }

    public function approve($id)
    {
        // Tìm Bài đăng theo ID
        $baidang = Baidang::find($id);

        if (!$baidang) {
            return redirect()->back()->with('error', 'Bài đăng không tồn tại.');
        }

        // Cập nhật trạng thái Bài đăng
        $baidang->adminduyet = true; // Duyệt
        $baidang->save();

        return redirect()->back()->with('success', 'Bài đăng đã được duyệt thành công.');
    }

    public function cancelPost($id)
    {
        // Tìm Bài đăng theo ID
        $baidang = Baidang::find($id);
    
        if (!$baidang) {
            return redirect()->back()->with('error', 'Bài đăng không tồn tại.');
        }
    
        // Cập nhật trạng thái Bài đăng
        $baidang->adminduyet = false; // Hủy
        $baidang->save();
    
        return redirect()->back()->with('success', 'Bài đăng đã bị hủy.');
    }
}
