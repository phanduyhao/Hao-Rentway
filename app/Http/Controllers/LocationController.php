<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    /**
     * Hàm thêm mới Tỉnh/Thành, Quận/Huyện, Phường/Xã
     */
    public function addLocation(Request $request, $locationType)
    {
        switch (strtolower($locationType)) {
            case 'province':
                $model = new Province();
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'country' => 'required|string|max:255',
                ]);
                
                // Sinh mã code ngẫu nhiên, đảm bảo không trùng
                do {
                    $code = rand(10000, 99999); // Random 5 số
                } while ($model::where('code', $code)->exists());
                // Gán dữ liệu
                $model->name = $validated['name'];
                $model->code = $code;
                $model->is_custom = true; // Flag đánh dấu tự thêm
                $model->country = $validated['country'];
                break;
    
            case 'district':
                $model = new District();
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'province_code' => 'required|numeric',  // Kiểm tra province_id là kiểu số
                ]);
                // Kiểm tra xem province_id có tồn tại chưa
                $province = Province::where('code', $request->province_code)->first(); 
                do {
                    $code = rand(10000, 99999); // Random 5 số
                } while ($model::where('code', $code)->exists());
                    $model->name = $validated['name'];
                    $model->code = $code;
                    $model->is_custom = true; // Flag đánh dấu tự thêm
                if (!$province) {
                    // Nếu province_id không tồn tại, tạo province mới
                    $province = new Province();
                    $province->name = $request->province_name;  // Hoặc có thể lấy giá trị từ request nếu muốn
                    $province->code = $request->province_code;  // Hoặc có thể lấy giá trị từ request nếu muốn
                    $province->country = $request->country;  // Cập nhật giá trị country nếu cần
                    $province->save();  // Lưu province mới vào cơ sở dữ liệu
    
                    // Gán lại province_id mới cho district
                    $province_id = $province->id;
                    $model->province_id = $province_id;

                }
                    $model->province_id = $province->id;
                        
                // Sinh mã code ngẫu nhiên, đảm bảo không trùng
                
                break;
    
                case 'ward':
                    $model = new Ward();
                    $validated = $request->validate([
                        'name' => 'required|string|max:255',
                        'district_code' => 'required|numeric',  // Kiểm tra district_id là kiểu số
                    ]);
                    // Kiểm tra xem district_id có tồn tại chưa
                    $district = District::where('code', $request->district_code)->first(); 
                    do {
                        $code = rand(10000, 99999); // Random 5 số
                    } while ($model::where('code', $code)->exists());
                        $model->name = $validated['name'];
                        $model->code = $code;
                        $model->is_custom = true; // Flag đánh dấu tự thêm
                    if (!$district) {
                        // Nếu district_id không tồn tại, tạo district mới
                        $district = new District();
                        $district->name = $request->district_name;  // Hoặc có thể lấy giá trị từ request nếu muốn
                        $district->code = $request->district_code;  // Hoặc có thể lấy giá trị từ request nếu muốn
                        $district->country = $request->country;  // Cập nhật giá trị country nếu cần
                        $district->save();  // Lưu district mới vào cơ sở dữ liệu
        
                        // Gán lại district_id mới cho district
                        $district_id = $district->id;
                        $model->district_id = $district_id;
    
                    }
                        $model->district_id = $district->id;
                            
                    // Sinh mã code ngẫu nhiên, đảm bảo không trùng
                    
                    break;
    
            default:
                return response()->json(['error' => 'Invalid location type'], 400);
        }

    
        // // Gán quan hệ cha nếu có
        // if ($locationType == 'province') {
        // } elseif ($locationType == 'district') {
        //     $model->province_id = $province_id;  // Gán giá trị province_id từ validated
        // } elseif ($locationType == 'ward') {
        //     $model->district_id = $validated['district_id'];  // Gán giá trị district_id từ validated
        // }
    
        $model->save();
    
        return response()->json([
            'success' => true,
            "{$locationType}_id" => $model->id,
            "{$locationType}_code" => $model->code,
        ]);
    }
    
    public function getProvince($country)
    {
        // Lấy tỉnh từ database
        $provincesFromDatabase = Province::where('country', $country)->get(); // Lọc theo quốc gia, nếu cần
    
        // Gọi dữ liệu API từ bên ngoài chỉ khi quốc gia là Vietnam
        $provincesFromApi = [];
    
        // if ($country === 'Vietnam') {
        //     // Gọi API từ Vietnam
        //     $provincesFromApi = json_decode(file_get_contents('https://provinces.open-api.vn/api/p/'));
        // }
    
        // Kiểm tra nếu dữ liệu từ API là mảng, nếu không xử lý lỗi
        // if ($country === 'Vietnam' && !is_array($provincesFromApi)) {
        //     return response()->json(['error' => 'Dữ liệu API không đúng định dạng'], 400);
        // }
    
        // // Chuẩn hóa dữ liệu API về cùng định dạng như database (chỉ thực hiện cho Vietnam)
        // if ($country === 'Vietnam') {
        //     $provincesFromApi = array_map(function($province) {
        //         return [
        //             'id' => isset($province->id) ? $province->id : null, // Province ID từ API (có thể không có)
        //             'name' => isset($province->name_en) ? $province->name_en : (isset($province->name) ? $province->name : ''), // Tên tỉnh (dùng tên tiếng Anh nếu có)
        //             'code' => isset($province->id) ? $province->id : (isset($province->code) ? $province->code : null), // Mã tỉnh
        //             'is_custom' => 0, // Gán mặc định 0 nếu là tỉnh từ API (không phải tỉnh tự thêm)
        //         ];
        //     }, $provincesFromApi);
        // }
    
        // Gộp dữ liệu từ database và API lại (chỉ gộp khi có dữ liệu từ API)
        $allProvinces = $provincesFromDatabase->toArray();
    
        // if ($country === 'Vietnam') {
        //     // Chỉ merge dữ liệu từ API khi là Vietnam
        //     $allProvinces = $provincesFromApi;
        // }
    
        // Trả về dữ liệu đã được chuẩn hóa
        return response()->json($allProvinces);
    }
    
    public function getDistrict($provinceCode, $country)
    {
        // Lấy province_id từ province_code (tìm province_id dựa trên province_code)
        $province = Province::where('code', $provinceCode)->where('country', $country)->first();
    
        // Kiểm tra nếu province không có trong database, chỉ gọi API khi quốc gia là Vietnam
        if (!$province) {
            // if ($country === 'Vietnam') {
            //     // Gọi API từ Vietnam để lấy districts
            //     $districtsFromApi = json_decode(file_get_contents("https://provinces.open-api.vn/api/p/{$provinceCode}?depth=2"));
            // } else {
                // Nếu không phải Vietnam, chỉ trả về dữ liệu từ database (không gọi API)
                $districtsFromApi = [];
            // }
        } else {
            // Lấy tất cả districts từ database theo province_id
            $districtsFromDatabase = District::where('province_id', $province->id)->get();
    
            // Gọi dữ liệu API từ bên ngoài nếu country là Vietnam
            $districtsFromApi = [];
            
            // if ($country === 'Vietnam') {
            //     // Gọi API từ Vietnam để lấy districts
            //     $districtsFromApi = json_decode(file_get_contents("https://provinces.open-api.vn/api/p/{$provinceCode}?depth=2"));
            // }
        }
    
        // Kiểm tra nếu dữ liệu từ API không phải là mảng, xử lý lại
        if (!is_array($districtsFromApi)) {
            // Kiểm tra nếu dữ liệu trả về từ API là đối tượng và không có key cần thiết
            if (isset($districtsFromApi->districts) && is_array($districtsFromApi->districts)) {
                $districtsFromApi = $districtsFromApi->districts; // Dữ liệu của Vietnam API có key "districts"
            } elseif (isset($districtsFromApi->cities) && is_array($districtsFromApi->cities)) {
                $districtsFromApi = $districtsFromApi->cities; // Dữ liệu Philippines có key "cities"
            } else {
                return response()->json(['error' => 'Dữ liệu API không đúng định dạng'], 400);
            }
        }
    
        // Chuẩn hóa dữ liệu API về cùng định dạng như database
        $districtsFromApi = array_map(function($district) use ($country) {
            // Tùy thuộc vào quốc gia, xử lý dữ liệu khác nhau
            if ($country === 'Thailand') {
                return [
                    'id' => isset($district->id) ? $district->id : null, // District ID từ API Thái Lan
                    'name' => isset($district->name_en) ? $district->name_en : '', // Tên quận/huyện (name_en trong API Thái Lan)
                    'code' => isset($district->code) ? $district->code : null, // Mã quận/huyện
                    'is_custom' => 0, // Gán mặc định 0 nếu là quận/huyện từ API (không phải tự thêm)
                ];
            } elseif ($country === 'Philippines') {
                return [
                    'id' => isset($district->code) ? $district->code : null, // Mã quận/huyện trong Philippines
                    'name' => isset($district->name) ? $district->name : '', // Tên quận/huyện
                    'code' => isset($district->code) ? $district->code : null, // Mã quận/huyện
                    'is_custom' => 0,
                ];
            } else {
                return [
                    'id' => isset($district->code) ? $district->code : null, // Dữ liệu từ API Vietnam
                    'name' => isset($district->name) ? $district->name : '', // Tên quận/huyện
                    'code' => isset($district->code) ? $district->code : null, // Mã quận/huyện
                    'is_custom' => 0,
                ];
            }
        }, $districtsFromApi);
    
        // Gộp dữ liệu từ database và API lại
        $allDistricts = array_merge($districtsFromDatabase->toArray(), $districtsFromApi);
    
        // Trả về dữ liệu đã được chuẩn hóa
        return response()->json($allDistricts);
    }
    
    public function getWard($districtCode, $country)
    {
        // Lấy province_id từ province_code (tìm province_id dựa trên province_code)
        $district = District::where('code', $districtCode)->first();
    
        // Kiểm tra nếu province không có trong database, chỉ gọi API khi quốc gia là Vietnam
        if (!$district) {
            // if ($country === 'Vietnam') {
            //     // Gọi API từ Vietnam để lấy districts
            //     $sFromApi = json_decode(file_get_contents("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2"));
            // } else {
                // Nếu không phải Vietnam, chỉ trả về dữ liệu từ database (không gọi API)
                $sFromApi = [];
            // }
        } else {
            // Lấy tất cả districts từ database theo province_id
            $wardsFromDatabase = Ward::where('district_id', $district->id)->get();
    
            // Gọi dữ liệu API từ bên ngoài nếu country là Vietnam
            $sFromApi = [];
            
            // if ($country === 'Vietnam') {
            //     // Gọi API từ Vietnam để lấy districts
            //     $sFromApi = json_decode(file_get_contents("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2"));
            // }
        }
    
        // Kiểm tra nếu dữ liệu từ API không phải là mảng, xử lý lại
        if (!is_array($sFromApi)) {
            // Kiểm tra nếu dữ liệu trả về từ API là đối tượng và không có key cần thiết
            if (isset($sFromApi->districts) && is_array($sFromApi->districts)) {
                $sFromApi = $sFromApi->districts; // Dữ liệu của Vietnam API có key "districts"
            } elseif (isset($sFromApi->cities) && is_array($sFromApi->cities)) {
                $sFromApi = $sFromApi->cities; // Dữ liệu Philippines có key "cities"
            } else {
                return response()->json(['error' => 'Dữ liệu API không đúng định dạng'], 400);
            }
        }
    
        // Chuẩn hóa dữ liệu API về cùng định dạng như database
        $sFromApi = array_map(function($district) use ($country) {
            // Tùy thuộc vào quốc gia, xử lý dữ liệu khác nhau
            if ($country === 'Thailand') {
                return [
                    'id' => isset($district->id) ? $district->id : null, // District ID từ API Thái Lan
                    'name' => isset($district->name_en) ? $district->name_en : '', // Tên quận/huyện (name_en trong API Thái Lan)
                    'code' => isset($district->code) ? $district->code : null, // Mã quận/huyện
                    'is_custom' => 0, // Gán mặc định 0 nếu là quận/huyện từ API (không phải tự thêm)
                ];
            } elseif ($country === 'Philippines') {
                return [
                    'id' => isset($district->code) ? $district->code : null, // Mã quận/huyện trong Philippines
                    'name' => isset($district->name) ? $district->name : '', // Tên quận/huyện
                    'code' => isset($district->code) ? $district->code : null, // Mã quận/huyện
                    'is_custom' => 0,
                ];
            } else {
                return [
                    'id' => isset($district->code) ? $district->code : null, // Dữ liệu từ API Vietnam
                    'name' => isset($district->name) ? $district->name : '', // Tên quận/huyện
                    'code' => isset($district->code) ? $district->code : null, // Mã quận/huyện
                    'is_custom' => 0,
                ];
            }
        }, $sFromApi);
    
        // Gộp dữ liệu từ database và API lại
        $allWards = array_merge($wardsFromDatabase->toArray(), $sFromApi);
    
        // Trả về dữ liệu đã được chuẩn hóa
        return response()->json($allWards);
    }
    
    
}
