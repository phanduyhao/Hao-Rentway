<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ward;
use App\Models\Address;
use App\Models\Baidang;
use App\Models\Setting;
use App\Models\Thietbi;
use App\Models\District;
use App\Models\Province;
use App\Models\Favourite;
use App\Models\Loainhadat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Baidanglienhe;
use App\Models\BaidangChitiet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $loainhadats = Loainhadat::select('id', 'title', 'slug')->get();
        $thietbis = Thietbi::select('id', 'title', 'icon')->get();
        return view('posts.index', compact('loainhadats', 'thietbis'), [
            'title' => __('post.post')
        ]);
    }

    public function listBaidang(Request $request)
    {
        // Lấy giá trị mô hình từ request
        $mohinh = $request->input('mohinh');

        // Query cơ bản
        $query = Baidang::where('status', 'cosan')->where('adminduyet', 1);

        // Nếu có giá trị mô hình hợp lệ thì lọc theo mô hình
        if (in_array($mohinh, ['ban', 'thue', 'chuyennhuong', 'oghep'])) {
            $query->where('mohinh', $mohinh);
        }

        // Gọi hàm applyFilters để áp dụng bộ lọc chung
        $query = $this->applyFilters($query, $request);
        // dd($request->all());
        // Lấy danh sách bài đăng
        $list_baidangs = $query->orderByDesc('id')->paginate(10);
        $listnhadats = Loainhadat::select('title', 'id', 'slug', 'icon')->get();

        // Xác định tiêu đề trang
        $supportedTypes = ['thue', 'ban', 'chuyennhuong', 'oghep'];
        $key = in_array($mohinh, $supportedTypes) ? $mohinh : 'default';
        $title = __('post.listing_title.' . $key);
        $selectedValue = $request->input('huongnha', '');
        $users = User::whereHas('baidangs')
            ->select('id', 'name')
            ->distinct()
            ->get();
        return view('posts.list_baidang', compact('list_baidangs', 'listnhadats', 'mohinh', 'users', 'selectedValue'), [
            'title' => $title
        ]);
    }

    public function getByLoaiNhadat(Request $request, $slug)
    {
        $loaiNhadat = Loainhadat::where('slug', $slug)->firstOrFail();

        $query = Baidang::where('loainhadat_id', $loaiNhadat->id)->where('adminduyet', 1);
        $query = $this->applyFilters($query, $request);

        $list_baidangs = $query->orderByDesc('id')->paginate(10);
        $listnhadats = Loainhadat::select('title', 'id', 'slug', 'icon')->get();
        $slugCurrent = $slug;

        $users = User::whereHas('baidangs')->select('id', 'name')->distinct()->get();
        $selectedValue = $request->input('huongnha', '');

        // Map slug → key dịch
        $propertyTypeMap = [
            'can-ho-chung-cu' => 'apartment',
            'nha-dan' => 'private_house',
            'phong-tro' => 'rental_room',
            'biet-thu' => 'villa',
            'khach-san' => 'hotel',
            'van-phong-cong-ty' => 'office',
            'mat-bang-kinh-doanh' => 'business',
        ];

        $translationKey = $propertyTypeMap[$slug] ?? null;
        $translatedType = $translationKey
            ? __('common.property_type.' . $translationKey)
            : $loaiNhadat->title;

        $title = __('post.list_by_property_type', ['type' => $translatedType]);

        return view('posts.list_by_nhadat', compact(
            'list_baidangs',
            'listnhadats',
            'loaiNhadat',
            'slugCurrent',
            'users',
            'selectedValue'
        ), [
            'title' => $title
        ]);
    }


    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422); // Trả về lỗi 422 (Unprocessable Entity)
        }

        if ($request->input('loailienhe')) {
            $user = Auth::user();
            $user->role = $request->input('loailienhe'); // Cập nhật role
            $user->save(); // Lưu lại thay đổi
        }

        // Lấy mã loại BĐS, đối tượng, viết tắt tên người đăng và ngày
        $maLoaiBds = $this->maLoaiBds($request->loainhadat_id, $request->mohinh);
        $maDoiTuong = $this->maDoiTuong();
        $tenNguoiDang = $this->tenNguoiDangVietTat();
        $ngaydang = Carbon::now('Asia/Ho_Chi_Minh')->format('ymd');
        $postOrder = $this->getPostOrderInDayByUser(); // Số thứ tự bài đăng trong ngày

        // Kiểm tra xem mã loại BĐS có hợp lệ không
        if (!$maLoaiBds) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mã loại bất động sản không hợp lệ.',
            ], 400); // Trả về lỗi nếu mã loại không hợp lệ
        }

        // Tạo mã bài đăng
        $mabaidang = $maLoaiBds . $maDoiTuong . $tenNguoiDang . $ngaydang . $postOrder;

        $tudongduyet = Setting::where('key', 'tudongduyet')->value('value');
            Log::info('Request data: ', $request->all());

        try {
            Log::info('Request data: ', $request->all());

            DB::beginTransaction(); // Bắt đầu transaction

            $provinceCode = $request->input('province');
            $provinceName = $request->input('province_name');
            $country = $request->input('country'); // Nhận giá trị quốc gia

            $province = Province::where('code', $provinceCode)
                ->where('country', $country) // Thêm điều kiện country
                ->first();

            if (!$province) {
                $province = new Province();
                $province->code = $provinceCode;
                $province->name = $provinceName;
                $province->country = $country; // Lưu country vào database
                $province->save();
            }


            $districtCode = $request->input('districts');
            $districtName = $request->input('district_name');
            $district = District::where('code', $districtCode)->first();
            if (!$district) {
                $district = new District();
                $district->code = $districtCode;
                $district->name = $districtName;
                $district->province_id = $province->id;
                $district->save();
            }
            $wardCode = $request->input('wards');
            $wardName = $request->input('ward_name');
            $ward = Ward::where('code', $wardCode)->first();
            if (!$ward) {
                $ward = new Ward();
                $ward->code = $wardCode;
                $ward->name = $wardName;
                $ward->district_id = $district->id;
                $ward->save();
            }

            $address = new Address();
            $address->street = $request->input('address');
            $address->ward_id = $ward->id;
            $address->latitude = $request->input('latitude');
            $address->longitude = $request->input('Longitude');
            $address->save();

            // Lưu thông tin liên hệ
            $contact = new Baidanglienhe();
            $contact->agent_name = $request->name_contact;
            $contact->phone = $request->phone_contact;
            $contact->email = $request->email_contact;
            $contact->zalo_link = $request->link_zalo;
            $contact->facebook = $request->facebook;
            $contact->telegram = $request->telegram;
            // $contact->loailienhe = $request->loailienhe;
            $contact->save();

            // Xử lý thiết bị
            $thietbis = [];

            if ($request->has('thietbis')) {
                foreach ($request->input('thietbis') as $id => $name) {
                    // Lấy icon dựa vào key giống nhau
                    $icon = $request->input("icon_thietbi.{$id}") ?? null;

                    // Thêm vào danh sách
                    $thietbis[] = ['name' => $name, 'icon' => $icon];
                }
            }
            // Kiểm tra kết quả

            $baidang_chitiet = new BaidangChitiet();
            // $baidang_chitiet->video = $videoPath;
            $baidang_chitiet->sophong = $request->tongsophong ?? 0;
            $baidang_chitiet->sotang = $request->tongsotang ?? 0;
            $baidang_chitiet->hoahong = $request->hoahong ?? 0;
            $baidang_chitiet->thangdatcoc = $request->thangdatcoc ?? 0;
            $baidang_chitiet->thangtratruoc = $request->thangtratruoc ?? 0;
            $baidang_chitiet->hopdong = $request->hopdong;
            $baidang_chitiet->save();

            // Lưu thông tin bài đăng
            $baidang = new Baidang();
            $baidang->mabaidang = $mabaidang;
            $baidang->mamoigioi = $request->mamoigioi;
            $baidang->title = $request->title;
            $baidang->title_en = $request->title_en;
            $baidang->mohinh = $request->mohinh;
            $baidang->unit = $request->unit;
            $baidang->loainhadat_id = $request->loainhadat_id;
            $baidang->price = $request->price;
            $baidang->dientich = $request->area;
            $baidang->isVip = $request->isVip ? 1 : 0;
            $baidang->bedrooms = $request->bedrooms ?? 0;
            $baidang->bathrooms = $request->bathrooms ?? 0;
            $baidang->description = $request->description;
            $baidang->description_en = $request->description_en;
            $baidang->huongnha = $request->huongnha;
            $baidang->huongbancong = $request->huongbancong;
            $baidang->age = $request->age;
            $baidang->user_id = Auth::id();
            $baidang->address_id = $address->id;
            $baidang->baidangchitiet_id = $baidang_chitiet->id;
            $baidang->thietbis = json_encode($thietbis);
            $baidang->status = 1;
            if (Auth::user()->role == 'admin' || $tudongduyet == 1 || Auth::user()->role == 'chunha') {
                $baidang->adminduyet = 1;
            }
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

            $videoPaths = [];

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    if ($video->isValid()) {
                        $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('/temp/videos/'), $fileName);
                        $videoPaths[] = '/temp/videos/' . $fileName;
                    }
                }
            }

            $baidang->images = !empty($imagePaths) ? json_encode($imagePaths) : null;
            $baidang->videos = !empty($videoPaths) ? json_encode($videoPaths) : null;
            $baidang->thumb = !empty($imagePaths) ? $imagePaths[0] : null;
            $baidang->lienhe_id = $contact->id;
            $baidang->save();
            $baidang->slug = Str::slug($baidang->title . '-' . $baidang->id);
            $currentTime = Carbon::now('Asia/Ho_Chi_Minh');
            $baidang->created_at = $currentTime;
            $baidang->updated_at = $currentTime;
            $baidang->save();


            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Bài đăng đã được tạo thành công!',
                'baidang' => $baidang
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi đăng tin: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'debug' => $request->all() // Trả về dữ liệu để debug
            ], 400);
        }
    }

    public function toggleIsVip(Request $request, $id)
    {
        $baidang = BaiDang::findOrFail($id);
        $baidang->isVip = $request->input('isVip'); // Cập nhật theo giá trị từ frontend
        $baidang->save();

        return response()->json(['status' => 'success', 'isVip' => $baidang->isVip]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:baidangs,id',
            'status' => 'required|in:cosan,dathue,hethan'
        ]);

        $baidang = BaiDang::findOrFail($request->id);
        $baidang->status = $request->status;
        $baidang->save();

        return response()->json(['success' => true, 'message' => 'Trạng thái đã được cập nhật.']);
    }

    // Xem preview Bài đăng
    public function baidangDetail($slug)
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        // Tìm baidang theo slug
        $baidang = Baidang::where('slug', $slug)->first();
        $baidanghots = Baidang::where('isVip', true)->take(4)->get();
        $baidangnews = Baidang::orderByDesc('id')->take(4)->get();

        $favourite = null;
        if (Auth::check()) {
            $favourite = Favourite::where('user_id', Auth::user()->id)->where('baidang_id', $baidang->id)->first();
        }
        // Kiểm tra nếu không tìm thấy baidang
        if (!$baidang) {
            return redirect()->back()->with('error', 'Baidang not found!');
        }

        $user = null;

        if ($baidang->user_id != null) {
            $user = User::find($baidang->user_id);
        }
        $title = $baidang->title;
        return view('posts.detail', compact('baidang', 'favourite', 'user', 'settings', 'baidanghots', 'baidangnews'), [
            'title' => $title
        ]);
    }

    public function deleteImage(Request $request)
    {
        $imagePath = str_replace(asset("storage/"), "", $request->image); // Lấy đường dẫn file thực tế
        $baidang = BaiDang::where("images", "LIKE", "%{$imagePath}%")->first();

        if (!$baidang) {
            return response()->json(["success" => false, "message" => "Không tìm thấy bài đăng!"]);
        }

        // Xóa ảnh khỏi storage
        if (Storage::disk("public")->exists($imagePath)) {
            Storage::disk("public")->delete($imagePath);
        }

        // Cập nhật JSON images trong database
        $images = json_decode($baidang->images, true) ?? [];
        $images = array_filter($images, function ($img) use ($imagePath) {
            return $img !== $imagePath; // Loại bỏ ảnh đã xóa
        });

        $baidang->images = json_encode(array_values($images)); // Lưu lại
        $baidang->save();

        return response()->json(["success" => true]);
    }

    public function deleteVideo(Request $request)
    {
        $videoPath = str_replace(asset("storage/"), "", $request->video); // Lấy đường dẫn file thực tế
        $baidang = BaiDang::where("videos", "LIKE", "%{$videoPath}%")->first();

        if (!$baidang) {
            return response()->json(["success" => false, "message" => "Không tìm thấy bài đăng!"]);
        }

        // Xóa ảnh khỏi storage
        if (Storage::disk("public")->exists($videoPath)) {
            Storage::disk("public")->delete($videoPath);
        }

        // Cập nhật JSON videos trong database
        $videos = json_decode($baidang->videos, true) ?? [];
        $videos = array_filter($videos, function ($img) use ($videoPath) {
            return $img !== $videoPath; // Loại bỏ ảnh đã xóa
        });

        $baidang->videos = json_encode(array_values($videos)); // Lưu lại
        $baidang->save();

        return response()->json(["success" => true]);
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra bài đăng có tồn tại không
        $baidang = Baidang::find($id);
        if (!$baidang) {
            return response()->json(['status' => 'error', 'message' => 'Bài đăng không tồn tại'], 404);
        }

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'mohinh' => 'required|string',
            'loainhadat_id' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'description' => 'nullable|string',
            'email_contact' => 'required|email',
            'phone_contact' => 'nullable|string',
            'link_zalo' => 'nullable|string',
            'facebook' => 'nullable|string',
            'telegram' => 'nullable|string',
            'images.*' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:100000',
            'thietbis' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }
        $maLoaiBds = $this->maLoaiBds($request->loainhadat_id, $request->mohinh);
        $maDoiTuong = $this->maDoiTuong();
        $tenNguoiDang = $this->tenNguoiDangVietTat();
        $ngaydang = date('ymd'); // Ngày theo định dạng YYMMDD
        $postOrder = $baidang->mabaidang ? substr(strrchr($baidang->mabaidang, '-'), 1) : '001'; // Số thứ tự bài đăng trong ngày
        $mabaidang = $maLoaiBds . $maDoiTuong . $tenNguoiDang . $ngaydang . $postOrder;

        try {
            DB::beginTransaction();
            $provinceCode = $request->input('province');
            $provinceName = $request->input('province_name');
            $country = $request->input('country'); // Lấy thông tin quốc gia

            if ($provinceCode && $country) {
                // Kiểm tra xem tỉnh đã tồn tại với `code` + `country` chưa
                $province = Province::where('code', $provinceCode)
                    ->where('country', $country)
                    ->first();

                // Nếu chưa có, tạo mới
                if (!$province) {
                    $province = new Province();
                    $province->code = $provinceCode;
                    $province->name = $provinceName;
                    $province->country = $country;
                    $province->save();
                }
            }

            // Xử lý quận/huyện
            $districtCode = $request->input('districts');
            $districtName = $request->input('district_name');
            $district = null;
            if ($districtCode && $province) {
                $district = District::where('code', $districtCode)->first();
                if (!$district) {
                    $district = new District();
                    $district->code = $districtCode;
                    $district->name = $districtName;
                    $district->province_id = $province->id;
                    $district->save();
                }
            }

            // Xử lý phường/xã
            $wardCode = $request->input('wards');
            $wardName = $request->input('ward_name');
            $ward = null;
            if ($wardCode && $district) {
                $ward = Ward::where('code', $wardCode)->first();
                if (!$ward) {
                    $ward = new Ward();
                    $ward->code = $wardCode;
                    $ward->name = $wardName;
                    $ward->district_id = $district->id;
                    $ward->save();
                }
            }

            // Cập nhật hoặc tạo mới địa chỉ
            $address = Address::find($baidang->address_id);
            if ($address) {
                $address->street = $request->input('address');
                $address->latitude = $request->input('latitude');
                $address->longitude = $request->input('longitude');
                $address->ward_id = $ward->id;
                $address->save();
            } else {
                $address = new Address();
                $address->street = $request->input('address');
                $address->latitude = $request->input('latitude');
                $address->longitude = $request->input('longitude');
                $address->ward_id = $ward->id;
                $address->save();

                // Gán địa chỉ mới cho bài đăng
                $baidang->address_id = $address->id;
            }

            // Cập nhật thông tin liên hệ
            $contact = Baidanglienhe::find($baidang->lienhe_id);
            if ($contact) {
                $contact->agent_name = $request->name_contact;
                $contact->phone = $request->phone_contact;
                $contact->email = $request->email_contact;
                $contact->zalo_link = $request->link_zalo;
                $contact->facebook = $request->facebook;
                $contact->telegram = $request->telegram;
                // $contact->loailienhe = $request->loailienhe;
                $contact->save();
            }

            // Cập nhật danh sách thiết bị
            $thietbis = [];
            if ($request->has('thietbis')) {
                foreach ($request->input('thietbis') as $id => $name) {
                    $icon = $request->input("icon_thietbi.{$id}") ?? null;
                    $thietbis[] = ['name' => $name, 'icon' => $icon];
                }
            }

            // Cập nhật thông tin bài đăng
            $baidang->mabaidang = $request->mabaidang;
            $baidang->mamoigioi = $request->mamoigioi;
            $baidang->title = $request->title;
            $baidang->title_en = $request->title_en;
            $baidang->mohinh = $request->mohinh;
            $baidang->unit = $request->unit;
            $baidang->loainhadat_id = $request->loainhadat_id;
            $baidang->price = $request->price;
            $baidang->dientich = $request->area;
            $baidang->bedrooms = $request->bedrooms;
            $baidang->bathrooms = $request->bathrooms;
            $baidang->description = $request->description;
            $baidang->description_en = $request->description_en;
            $baidang->huongnha = $request->huongnha;
            $baidang->huongbancong = $request->huongbancong;
            $baidang->age = $request->age;
            $baidang->thietbis = json_encode($thietbis);

            // Cập nhật ảnh (thêm mới, không xóa ảnh cũ)
            $imagePaths = json_decode($baidang->images, true) ?? [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/temp/images/baidang/'), $fileName);
                        $imagePaths[] = '/temp/images/baidang/' . $fileName;
                    }
                }
            }
            // Lấy danh sách video cũ (giải mã JSON hoặc mảng rỗng)
            $videoPaths = json_decode($baidang->videos, true) ?? [];

            if ($request->hasFile('videos')) {
                foreach ($request->file('videos') as $video) {
                    if ($video->isValid()) {
                        $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $video->getClientOriginalExtension();
                        $video->move(public_path('/temp/videos/'), $fileName);
                        $videoPaths[] = '/temp/videos/' . $fileName; // Thêm video mới vào mảng
                    }
                }
            }

            // Lưu lại mảng video (cũ + mới) vào trường videos
            $baidang->videos = !empty($videoPaths) ? json_encode($videoPaths) : null;
            $baidang->images = json_encode($imagePaths);
            $baidang->thumb = $imagePaths[0] ?? null;

            $baidang->save();
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Bài đăng đã được cập nhật thành công!', 'baidang' => $baidang]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi xảy ra khi cập nhật bài đăng: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function destroy(string $id)
    {
        $baidang = Baidang::find($id);

        if (!$baidang) {
            return response()->json([
                'message' => 'Không tìm thấy bài đăng với ID: ' . $id
            ], 404);
        }
        $baidang->delete();
        return redirect()->back();
    }

    public function destroyInDetail(string $id)
    {
        $baidang = Baidang::find($id);

        if (!$baidang) {
            return response()->json([
                'message' => 'Không tìm thấy bài đăng với ID: ' . $id
            ], 404);
        }
        $baidang->delete();
        return redirect()->route('home');
    }

    public function checkDuplicate(Request $request)
    {
        // Khởi tạo query
        $query = BaiDang::query();

        // Kiểm tra nếu có quốc gia, áp dụng lọc qua quan hệ address -> ward -> district -> province
        if ($request->filled('country')) {
            $query->whereHas('address.ward.district.province', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        // Kiểm tra nếu có tỉnh thành, áp dụng lọc qua quan hệ address -> ward -> district -> province
        if ($request->filled('province')) {
            $query->whereHas('address.ward.district.province', function ($q) use ($request) {
                $q->where('code', $request->province);
            });
        }

        // Kiểm tra nếu có quận huyện, áp dụng lọc qua quan hệ address -> ward -> district
        if ($request->filled('district')) {
            $query->whereHas('address.ward.district', function ($q) use ($request) {
                $q->where('code', $request->district);
            });
        }

        // Kiểm tra nếu có phường, áp dụng lọc qua quan hệ address -> ward
        if ($request->filled('ward')) {
            $query->whereHas('address.ward', function ($q) use ($request) {
                $q->where('code', $request->ward);
            });
        }

        // Kiểm tra nếu có đường/phố, áp dụng lọc qua quan hệ address
        if ($request->filled('street')) {
            $query->whereHas('address', function ($q) use ($request) {
                $q->where('street', $request->street);
            });
        }

        // Kiểm tra các trường khác trong bảng BaiDang như giá, mô hình, loại nhà đất
        if ($request->filled('price')) {
            $query->where('price', $request->price);
        }

        if ($request->filled('mohinh')) {
            $query->where('mohinh', $request->mohinh);
        }

        if ($request->filled('loainhadat_id')) {
            $query->where('loainhadat_id', $request->loainhadat_id);
        }

        // Kiểm tra xem có bài đăng nào trùng không
        $exists = $query->exists();

        return response()->json(['exists' => $exists]);
    }

    private function maLoaiBds($loaiNhadatId, $mohinh)
    {
        // Tìm loại nhà đất theo ID
        $loaiNhadat = Loainhadat::find($loaiNhadatId);

        // Kiểm tra xem loại nhà đất có tồn tại không
        if (!$loaiNhadat) {
            // Trả về null hoặc bạn có thể ném ra một ngoại lệ nếu cần thiết
            return null;
        }

        $maNhaDat = $loaiNhadat->ma_nha_dat;

        // Tạo mã loại bất động sản dựa trên mô hình
        switch ($mohinh) {
            case 'thue':
                return $maNhaDat . 'F'; // Đối với thuê
            case 'ban':
                return $maNhaDat . 'S'; // Đối với bán
            case 'chuyennhuong':
                return $maNhaDat . 'T'; // Đối với chuyển nhượng
            case 'oghep':
                return $maNhaDat . 'S'; // Đối với ô ghép
            default:
                // Trả về null nếu mô hình không hợp lệ
                return null;
        }
    }

    private function maDoiTuong()
    {
        $role = Auth::user()->role;  // Lấy vai trò người dùng từ Auth
        // Trả về mã đối tượng dựa trên vai trò
        switch ($role) {
            case 'admin': // Admin
                return 'M';
            case 'chunha': // Chủ nhà
                return 'O';
            case 'moigioi': // Môi giới
                return 'A';
            case 'nhanvien': // Nhân viên hỗ trợ
                return 'S';
            case 'user': // Khách
                return 'U';
        }
    }

    private function removeVietnameseAccents($str)
    {
        $unicode = [
            'a' => ['á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'],
            'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ'],
            'd' => ['đ'],
            'D' => ['Đ'],
            'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'],
            'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ'],
            'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị'],
            'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'],
            'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'],
            'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'],
            'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'],
            'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'],
            'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'],
            'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'],
        ];

        foreach ($unicode as $nonUnicode => $uniArr) {
            foreach ($uniArr as $uni) {
                $str = str_replace($uni, $nonUnicode, $str);
            }
        }
        return $str;
    }

    private function tenNguoiDangVietTat()
    {
        $username = Auth::user()->name; // Lấy tên người dùng

        // Tách tên thành các từ
        $nameParts = explode(' ', $username);

        if (count($nameParts) < 2) {
            return ''; // Nếu không đủ 2 từ, trả về chuỗi rỗng
        }

        // Lấy 2 từ cuối cùng
        $lastName = $nameParts[count($nameParts) - 2];
        $firstName = $nameParts[count($nameParts) - 1];

        // Bỏ dấu tiếng Việt
        $lastName = $this->removeVietnameseAccents($lastName);
        $firstName = $this->removeVietnameseAccents($firstName);

        // Lấy ký tự đầu và chuyển thành chữ hoa
        $initials = strtoupper(substr($lastName, 0, 1) . substr($firstName, 0, 1));

        return $initials;
    }

    private function getPostOrderInDayByUser()
    {
        // Lấy ngày hiện tại theo định dạng 'Y-m-d' (ví dụ: 2025-04-07)
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        // Đếm số bài đăng của người dùng đã có trong ngày (theo user_id và ngày hiện tại)
        $postCount = Baidang::where('user_id', Auth::user()->id)
            ->whereDate('created_at', $today)  // Lọc bài đăng trong ngày
            ->count();

        // Số thứ tự bài đăng tiếp theo (số thứ tự là tổng số bài đăng hiện tại + 1)
        $postOrder = $postCount + 1;

        // Đảm bảo số thứ tự có 3 chữ số
        return str_pad($postOrder, 3, '0', STR_PAD_LEFT);
    }

    // private function
    private function applyFilters($query, Request $request)
    {
        // dd($request->all());
        // Lọc theo quốc gia
        if ($request->filled('country')) {
            $query->whereHas('address.ward.district.province', function ($q) use ($request) {
                $q->where('country', $request->country);
            });
        }

        // Lọc theo tỉnh/thành phố
        if ($request->filled('province')) {
            $query->whereHas('address.ward.district.province', function ($q) use ($request) {
                $q->where('code', $request->province);
            });
        }

        // Lọc theo quận/huyện
        if ($request->filled('districts')) {
            $query->whereHas('address.ward.district', function ($q) use ($request) {
                $q->where('code', $request->districts);
            });
        }

        // Lọc theo phường
        if ($request->filled('wards')) {
            $query->whereHas('address.ward', function ($q) use ($request) {
                $q->where('code', $request->wards);
            });
        }

        // Lọc theo phường
        if ($request->filled('address')) {
            $query->whereHas('address', function ($q) use ($request) {
                $q->where('street', $request->address);
            });
        }

        // Lọc theo phường/xã
        if ($request->filled('author')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', $request->author);
            });
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Lọc theo diện tích
        if ($request->filled('area_min')) {
            $query->where('dientich', '>=', $request->area_min);
        }
        if ($request->filled('area_max')) {
            $query->where('dientich', '<=', $request->area_max);
        }

        // Lọc theo số phòng ngủ
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        // Lọc theo số phòng tắm
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        // Lọc theo hướng nhà
        if ($request->filled('huongnha')) {
            $query->where('huongnha', $request->huongnha);
        }

        // Lọc theo mô hình
        if ($request->filled('mohinh')) {
            $query->where('mohinh', $request->mohinh);
        }

        // Lọc theo hướng nhà
        if ($request->filled('loainhadat')) {
            $query->where('loainhadat_id', $request->loainhadat);
        }

        // Lọc theo Ban công
        if ($request->filled('huongbancong')) {
            $query->where('huongbancong', $request->huongbancong);
        }
        if ($request->filled('start_date') || $request->filled('end_date')) {
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($request->filled('start_date')) {
                $startDate = Carbon::parse($request->start_date);
                $query->where('created_at', '>=', $startDate);
            } elseif ($request->filled('end_date')) {
                $endDate = Carbon::parse($request->end_date);
                $query->where('created_at', '<=', $endDate);
            }
        }

        if ($request->filled('ten_baidang')) {
            $searchTerm = $request->ten_baidang;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('mabaidang', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Sắp xếp theo tiêu chí
        if ($request->filled('shorty')) {
            if ($request->shorty == 1) {
                $query->orderBy('price', 'asc'); // Giá từ thấp đến cao
            } elseif ($request->shorty == 2) {
                $query->orderBy('price', 'desc'); // Giá từ cao đến thấp
            } elseif ($request->shorty == 3) {
                $query->orderBy('created_at', 'desc'); // Ngày đăng mới nhất
            }
        }

        // Lọc theo tin VIP
        if ($request->filled('isVip')) {
            $query->where('isVip', 1);
        }

        return $query;
    }
}
