<?php

namespace App\Http\Controllers\Admin;

use App\Models\Thietbi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminThietbiController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 20; // Số bản ghi trên mỗi trang

        // Tạo query cơ bản để lấy các thiết bị chưa bị xóa
        $query = Thietbi::query();  // Sử dụng query builder

        // Kiểm tra điều kiện tìm kiếm
        if ($request->has('search_id') && $request->search_id) {
            $query->where('id', $request->search_id);
        }
        if ($request->has('search_name') && $request->search_name) {
            $query->where('title', 'LIKE', '%' . $request->search_name . '%');
        }

        // Lấy danh sách các thiết bị với phân trang và thêm các tham số tìm kiếm vào liên kết phân trang
        $thietbis = $query->orderByDesc('id')->paginate($perPage)->appends($request->only('search_id', 'search_name'));
        return view('admin.thietbi.index', compact('thietbis'), [
            'title' => 'Quản lý thiết bị'
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ], [
            'title.required' => 'Vui lòng nhập tên Thiết bị!',
        ]);
    
        $thietbi = new Thietbi();
        $title = $request->title;
        $thietbi->title = $title ;
        $icon = $request->file('icon'); // Lấy file ảnh từ file Upload
        if ($icon) {
            $fileName = Str::slug($title) . '.jpg'; // Tên ảnh theo Slug Title
            $icon->move(public_path('/temp/images/thietbi/'), $fileName); // Di chuyển ảnh vào thư mục này

            $thietbi->icon = '/temp/images/thietbi/'. $fileName; // Lưu tên file ảnh theo slug Title
        }
        $thietbi->save();
    
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $thietbi = Thietbi::find($id);

        if (!$thietbi) {
            return response()->json([
                'message' => 'Không tìm thấy thiết bị với ID: ' . $id
            ], 404); 
        }

        return response()->json($thietbi); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thietbi $Thietbi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => [
                'required',
                Rule::unique('thietbis')->ignore($id),
            ],
        ], [
            'title.required' => 'Vui lòng nhập tên Thiết bị!',
            'title.unique' => 'title này đã bị trùng!',
        ]);
        $Thietbi = Thietbi::find($id);
        $title = $request->title;
        $Thietbi->title = $title ;
        $icon = $request->file('icon'); // Lấy file ảnh từ file Upload
        if ($icon) {
            $fileName = Str::slug($title) . '.jpg'; // Tên ảnh theo Slug Title
            $icon->move(public_path('/temp/images/thietbi/'), $fileName); // Di chuyển ảnh vào thư mục này

            $Thietbi->icon = '/temp/images/thietbi/'. $fileName; // Lưu tên file ảnh theo slug Title
        }
        $Thietbi->save();
    
        return redirect()->back();
    }
    
    /**
     * Remove the specified resource from storage.
     */    public function destroy(string $id)
    {
        $thietbi = Thietbi::find($id);

        if (!$thietbi) {
            return response()->json([
               'message' => 'Không tìm thấy thiết bị với ID: '. $id
            ], 404); 
        }
        $thietbi->delete();
        return response()->json([
           'message' => 'Đã xóa thiết bị ID: '. $id
        ], 200);
    }
}
