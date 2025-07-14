<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class AdminDiachiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 20; // Số bản ghi trên mỗi trang
    
        // Tạo query cơ bản để lấy các địa chỉ
        $query = Address::with(['ward.district.province']);
    
        // Tìm kiếm theo ID
        if ($request->has('search_id') && $request->search_id) {
            $query->where('id', $request->search_id);
        }
    
        // Tìm kiếm theo tên loại địa chỉ
        if ($request->has('search_name') && $request->search_name) {
            $query->where('street', 'LIKE', '%' . $request->search_name . '%');
        }
    
        // Tìm kiếm theo quốc gia
        if ($request->has('search_country') && $request->search_country) {
            $query->whereHas('ward.district.province', function ($query) use ($request) {
                $query->where('country', $request->search_country);
            });
        }
    
        // Tìm kiếm theo tỉnh/thành phố
        if ($request->has('search_province') && $request->search_province) {
            $query->whereHas('ward.district.province', function ($query) use ($request) {
                $query->where('name', $request->search_province);
            });
        }
    
        // Tìm kiếm theo quận/huyện
        if ($request->has('search_district') && $request->search_district) {
            $query->whereHas('ward.district', function ($query) use ($request) {
                $query->where('name', $request->search_district);
            });
        }
    
        // Tìm kiếm theo phường/xã
        if ($request->has('search_ward') && $request->search_ward) {
            $query->whereHas('ward', function ($query) use ($request) {
                $query->where('name', $request->search_ward);
            });
        }
    
        // Lọc theo quốc gia (không phải Vietnam)
        $addresses = $query->whereHas('ward.district.province', function ($query) {
            $query->where('country', '<>', 'Vietnam');
        })->paginate($perPage)->appends($request->only('search_id', 'search_name', 'search_country', 'search_province', 'search_district', 'search_ward'));
    
        // Lấy danh sách các tỉnh, ngoại trừ "Vietnam"
        $provinces = Province::where('country', '<>', 'Vietnam')->get();
        $districts = District::all(); // Lấy tất cả districts (hoặc có thể tùy chỉnh thêm lọc)
        $wards = Ward::all(); // Lấy tất cả wards (hoặc có thể tùy chỉnh thêm lọc)
    
        return view('admin.diachi.index', [
            'addresses' => $addresses,
            'provinces' => $provinces,
            'districts' => $districts,
            'wards' => $wards,
            'title' => 'Quản lý địa chỉ'
        ]);
    }
    
    public function update(Request $request, $type, $id)
    {
        // Tìm đối tượng Address (hoặc các loại khác như Province, District, Ward) dựa trên type và id
        switch ($type) {
            case 'province':
                $province = Province::find($id);
                if ($province) {
                    $province->name = $request->input('value');
                    $province->save();
                    return response()->json(['message' => 'Province updated successfully.']);
                }
                break;
    
            case 'district':
                $district = District::find($id);
                if ($district) {
                    $district->name = $request->input('value');
                    $district->save();
                    return response()->json(['message' => 'District updated successfully.']);
                }
                break;
    
            case 'ward':
                $ward = Ward::find($id);
                if ($ward) {
                    $ward->name = $request->input('value');
                    $ward->save();
                    return response()->json(['message' => 'Ward updated successfully.']);
                }
                break;
    
            case 'street':
                $address = Address::find($id);
                if ($address) {
                    $address->street = $request->input('value');
                    $address->save();
                    return response()->json(['message' => 'Street updated successfully.']);
                }
                break;
    
            default:
                return response()->json(['error' => 'Invalid type.'], 400);
        }
    
        return response()->json(['error' => 'Update failed.'], 500);
    }
    
}
