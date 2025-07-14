<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.setting.index',compact('settings'),[
            'title' => 'Thiết lập'  
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
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'key' => 'required|string|max:255',
    //         'value' => 'required|numeric|min:0',
    //     ]);
    
    //     // Tạo bản ghi mới
    //     Setting::create([
    //         'key' => $request->key,
    //         'value' => $request->value,
    //     ]);
    
    //     return redirect()->back()->with('success', 'Thêm mới thành công!');
    
    // }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function updateAll(Request $request)
    {
        // Danh sách các key cần cập nhật
        $keys = ['logo','logo_en', 'banner', 'phone', 'email', 'link_fb', 'address'];

        foreach ($keys as $key) {
            $setting = Setting::where('key', $key)->first();

            if (!$setting) {
                continue; // Bỏ qua nếu không tìm thấy setting
            }

            // Xử lý upload ảnh cho logo & banner
            if (in_array($key, ['logo_en', 'banner'])) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    
                    // Lấy tên gốc của ảnh
                    $fileName = $file->getClientOriginalName(); // Lấy tên gốc của tệp
    
                    // Nếu bạn muốn chuyển tên tệp thành dạng duy nhất (tránh trùng lặp), bạn có thể kết hợp thời gian hoặc một mã duy nhất
                    // Ví dụ: $fileName = time() . '_' . $fileName;
    
                    $destinationPath = public_path('/temp/images/settings/');
    
                    // Di chuyển file vào thư mục
                    $file->move($destinationPath, $fileName);
    
                    // Lưu đường dẫn vào DB
                    $setting->update(['value' => '/temp/images/settings/' . $fileName]);
                }
            }  else {
                // Cập nhật dữ liệu text (số điện thoại, email)
                if ($request->filled($key)) {
                    $setting->update(['value' => $request->input($key)]);
                }
            }
        }

        return redirect()->back()->with('success', 'Cập nhật tất cả thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function toggleAutoApprove(Request $request)
{
    // Kiểm tra request có hợp lệ không
    $request->validate([
        'tudongduyet' => 'required|boolean', // Chỉ chấp nhận 0 hoặc 1
    ]);

    // Lấy setting từ database
    $setting = Setting::where('key', 'tudongduyet')->first();

    if ($setting) {
        $setting->update(['value' => $request->tudongduyet]);
    } else {
        Setting::create(['key' => 'tudongduyet', 'value' => $request->tudongduyet]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Cập nhật thành công!',
        'status' => $request->tudongduyet
    ]);
}

}
