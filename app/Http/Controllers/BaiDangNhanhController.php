<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\BaiDangNhanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaiDangNhanhController extends Controller
{
    public function index(){
        return view('dangtinnhanh.index',[
            'title' => __('common.quick_post')
        ]);
    }

    public function list(){
        $baidangnhanhs = BaiDangNhanh::orderByDesc('id')->paginate(10);
        $count_unread = BaiDangNhanh::where('isRead', null)->count();

        return view('dangtinnhanh.list',compact('baidangnhanhs','count_unread'),[
            'title' => __('post.title')
        ]);
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // Trả về lỗi 422 (Unprocessable Entity)
        }
    
        // Lưu thông tin bài đăng
        $baidang = new BaiDangNhanh();
        $baidang->title = $request->title;
        $baidang->description = $request->description;
        $baidang->name = $request->name;
        $baidang->phone = $request->phone;
    
        // Xử lý địa chỉ (nối các phần từ form)
        $address = $request->address . ', ' . 
                  $request->ward_name . ', ' . 
                  $request->district_name . ', ' . 
                  $request->province_name . ', ' . 
                  $request->country;
    
        $baidang->address = $address; // Gán địa chỉ vào bài đăng
    
        // Xử lý ảnh
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/temp/images/baidang/'), $fileName);
                    $imagePaths[] = '/temp/images/baidang/' . $fileName;
                }
            }
        }
        $baidang->images = !empty($imagePaths) ? json_encode($imagePaths) : null;
        $baidang->save();
        $baidang->slug = Str::slug($baidang->title . '-' . $baidang->id);
        $baidang->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Bài đăng đã được tạo thành công!',
            'baidang' => $baidang
        ]);
    }
    

    public function deleteBaiDangNhanh($id)
    {
        // Tìm bài đăng theo ID
        $baidang = BaiDangNhanh::findOrFail($id);

        // Xóa bài đăng
        $baidang->delete();

        // Trả về thông báo và chuyển hướng về danh sách
        return redirect()->back();
    }

    public function chiTietBaiDangNhanh($slug)
    {
        // Tìm bài đăng theo ID
        $baidang = BaiDangNhanh::where('slug', $slug)->first();

        // Trả về view chi tiết với bài đăng
        return view('dangtinnhanh.detail', compact('baidang'), [
            'title' => $baidang->title
        ]);
    }

    public function markAsRead(BaiDangNhanh $baidang)
    {
        $baidang->isRead = true; // Cập nhật isRead thành true
        $baidang->save(); // Lưu vào cơ sở dữ liệu

        return response()->json([
            'status' => 'success',
            'message' => 'Bài đăng đã được đánh dấu là đã đọc'
        ]);
    }


}
