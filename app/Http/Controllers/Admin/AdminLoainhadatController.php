<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loainhadat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminLoainhadatController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 20; // Số bản ghi trên mỗi trang

        // Tạo query cơ bản để lấy các loại nhà đất chưa bị xóa
        $query = Loainhadat::query();  // Sử dụng query builder

        // Kiểm tra điều kiện tìm kiếm
        if ($request->has('search_id') && $request->search_id) {
            $query->where('id', $request->search_id);
        }
        if ($request->has('search_name') && $request->search_name) {
            $query->where('title', 'LIKE', '%' . $request->search_name . '%');
        }

        // Lấy danh sách các loại nhà đất với phân trang và thêm các tham số tìm kiếm vào liên kết phân trang
        $loainhadats = $query->orderByDesc('id')->paginate($perPage)->appends($request->only('search_id', 'search_name'));
        return view('admin.nhadat.index', compact('loainhadats'), [
            'title' => 'Quản lý loại nhà đất'
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
            'title.required' => 'Vui lòng nhập tên Loại nhà đất!',
        ]);
    
        $loainhadat = new Loainhadat();
        $title = $request->title;
        $loainhadat->slug = $request->slug;
        $loainhadat->title = $title ;
        $icon = $request->file('icon'); // Lấy file ảnh từ file Upload
        if ($icon) {
            $fileName = Str::slug($title) . '.jpg'; // Tên ảnh theo Slug Title
            $icon->move(public_path('/temp/images/loainhadat/'), $fileName); // Di chuyển ảnh vào thư mục này

            $loainhadat->icon = '/temp/images/loainhadat/'. $fileName; // Lưu tên file ảnh theo slug Title
        }
        $loainhadat->save();
    
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loainhadat = Loainhadat::find($id);

        if (!$loainhadat) {
            return response()->json([
                'message' => 'Không tìm thấy loại nhà đất với ID: ' . $id
            ], 404); 
        }

        return response()->json($loainhadat); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loainhadat $Loainhadat)
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
                Rule::unique('loainhadats')->ignore($id),
            ],
        ], [
            'title.required' => 'Vui lòng nhập tên Loại nhà đất!',
            'title.unique' => 'title này đã bị trùng!',
        ]);
        $Loainhadat = Loainhadat::find($id);
        $title = $request->title;
        $Loainhadat->slug = $request->slug;
        $Loainhadat->ma_nha_dat = $request->ma_nha_dat ;
        $Loainhadat->title = $title ;
        $icon = $request->file('icon'); // Lấy file ảnh từ file Upload
        if ($icon) {
            $fileName = Str::slug($title) . '.jpg'; // Tên ảnh theo Slug Title
            $icon->move(public_path('/temp/images/loainhadat/'), $fileName); // Di chuyển ảnh vào thư mục này

            $Loainhadat->icon = '/temp/images/loainhadat/'. $fileName;; // Lưu tên file ảnh theo slug Title
        }
        $Loainhadat->save();
    
        return redirect()->back();
    }
    
    /**
     * Remove the specified resource from storage.
     */    public function destroy(string $id)
    {
        $loainhadat = Loainhadat::find($id);

        if (!$loainhadat) {
            return response()->json([
               'message' => 'Không tìm thấy loại nhà đất với ID: '. $id
            ], 404); 
        }
        $loainhadat->delete();
        return response()->json([
           'message' => 'Đã xóa loại nhà đất ID: '. $id
        ], 200);
    }
}
