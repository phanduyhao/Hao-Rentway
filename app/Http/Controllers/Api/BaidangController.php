<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Baidang;
use App\Models\BaidangChitiet;
use App\Models\BaiDangNhanh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Carbon\Carbon;
use App\Models\Loainhadat;
use App\Models\Baidanglienhe;
use App\Models\Address;
use App\Models\Ward;
use App\Models\District;
use App\Models\Province;

class BaidangController extends Controller
{
    /**
     * Get all posts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $baidangs = Baidang::with(['user', 'chitiet', 'loainhadat', 'address'])->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $baidangs
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a specific post
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $baidang = Baidang::with(['user', 'chitiet', 'loainhadat', 'address'])->find($id);
            
            if (!$baidang) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found'
                ], 404);
            }
            
            return response()->json([
                'status' => 'success',
                'data' => $baidang
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new post
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'tieude' => 'required|string|max:255',
                'title_en' => 'nullable|string|max:255',
                'loainhadat_id' => 'required|exists:loainhadats,id',
                // Địa chỉ fields - chỉ yêu cầu ward_id và street
                'ward_id' => 'required|exists:wards,id',
                'street' => 'required|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'gia' => 'required|numeric',
                'dientich' => 'required|numeric',
                'mota' => 'required|string',
                'description_en' => 'nullable|string',
                'hinhanh' => 'nullable|array',
                'hinhanh.*' => 'string|max:1024', // Allow string URLs for images
                'videos' => 'nullable|array',
                'videos.*' => 'string|max:1024', // Allow string URLs for videos
                'sophongngu' => 'nullable|integer',
                'sophongtam' => 'nullable|integer',
                'huongnha' => 'nullable|string',
                'huongbancong' => 'nullable|string',
                'age' => 'nullable|integer',
                'mohinh' => 'nullable|string|in:ban,thue,chuyennhuong,oghep',
                'unit' => 'nullable|string',
                'isVip' => 'nullable|boolean',
                'thietbi' => 'nullable|array',
                // Contact info fields
                'name_contact' => 'required|string|max:255',
                'phone_contact' => 'required|string|max:20',
                'email_contact' => 'required|email|max:255',
                'link_zalo' => 'nullable|url',
                'facebook' => 'nullable|url',
                'telegram' => 'nullable|url',
                // Additional details
                'tongsophong' => 'nullable|integer',
                'tongsotang' => 'nullable|integer',
                'hoahong' => 'nullable|numeric',
                'thangdatcoc' => 'nullable|integer',
                'thangtratruoc' => 'nullable|integer',
                'hopdong' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if user is authenticated
            if (!auth('api')->check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not authenticated'
                ], 401);
            }

            // Generate mabaidang
            $maLoaiBds = $this->maLoaiBds($request->loainhadat_id, $request->mohinh);
            $maDoiTuong = $this->maDoiTuong();
            $tenNguoiDang = $this->tenNguoiDangVietTat();
            $ngaydang = Carbon::now('Asia/Ho_Chi_Minh')->format('ymd');
            $postOrder = $this->getPostOrderInDayByUser(); 

            if (!$maLoaiBds) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mã loại bất động sản không hợp lệ.',
                ], 400);
            }
            $mabaidang = $maLoaiBds . "SAI" . $ngaydang . $postOrder;

            // Lấy ward từ ID
            $ward = Ward::find($request->ward_id);
            if (!$ward) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ward not found',
                ], 404);
            }

            // Create address - chỉ cần ward_id và street
            $address = new Address();
            $address->street = $request->street;
            $address->ward_id = $request->ward_id;
            $address->latitude = $request->latitude;
            $address->longitude = $request->longitude;
            $address->save();

            // Create contact information
            $contact = new Baidanglienhe();
            $contact->agent_name = $request->name_contact;
            $contact->phone = $request->phone_contact;
            $contact->email = $request->email_contact;
            $contact->zalo_link = $request->link_zalo;
            $contact->facebook = $request->facebook;
            $contact->telegram = $request->telegram;
            $contact->save();

            // Create post details first
            $chitiet = new BaidangChitiet();
            $chitiet->sophong = $request->tongsophong ?? 0;
            $chitiet->sotang = $request->tongsotang ?? 0;
            $chitiet->hoahong = $request->hoahong ?? 0;
            $chitiet->thangdatcoc = $request->thangdatcoc ?? 0;
            $chitiet->thangtratruoc = $request->thangtratruoc ?? 0;
            $chitiet->hopdong = $request->hopdong;
            $chitiet->save();

            // Create new post
            $baidang = new Baidang();
            $baidang->mabaidang = $mabaidang;
            $baidang->user_id = auth('api')->id();
            $baidang->title = $request->tieude;
            $baidang->title_en = $request->title_en;
            $baidang->loainhadat_id = $request->loainhadat_id;
            $baidang->address_id = $address->id;
            $baidang->price = $request->gia;
            $baidang->dientich = $request->dientich;
            $baidang->slug = Str::slug($request->tieude) . '-' . time();
            $baidang->status = 'cosan'; // Set status to be visible on the web
            $baidang->adminduyet = 1; // Set admin approval to visible on the web
            $baidang->mohinh = $request->mohinh ?? 'ban'; // Default model
            $baidang->unit = $request->unit;
            $baidang->huongnha = $request->huongnha;
            $baidang->huongbancong = $request->huongbancong;
            $baidang->age = $request->age;
            $baidang->description = $request->mota; // Correctly assign description
            $baidang->description_en = $request->description_en; // Correctly assign English description
            $baidang->isVip = $request->isVip ?? false;
            $baidang->bedrooms = $request->sophongngu;
            $baidang->bathrooms = $request->sophongtam;
            $baidang->lienhe_id = $contact->id;
            $baidang->baidangchitiet_id = $chitiet->id; // Assign the details ID

            // Use image and video paths directly from the request body
            $imagePaths = $request->input('hinhanh', []);
            $videoPaths = $request->input('videos', []);

            $baidang->images = !empty($imagePaths) ? json_encode($imagePaths) : null;
            $baidang->thumb = !empty($imagePaths) ? $imagePaths[0] : null;
            $baidang->videos = !empty($videoPaths) ? json_encode($videoPaths) : null;
            
            $baidang->save();

            // Attach equipment if provided
            if ($request->has('thietbi')) {
                try {
                    // JSON encode the equipment array, similar to PostController
                    $baidang->thietbis = json_encode($request->thietbi);
                    $baidang->save();
                } catch (Exception $e) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Post created but failed to attach equipment',
                        'error' => $e->getMessage(),
                        'data' => $baidang->load(['user', 'chitiet', 'loainhadat', 'address'])
                    ], 201);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Post created successfully',
                'data' => $baidang->load(['user', 'baidangchitiet', 'nhadat', 'address', 'lienhe'])
            ], 201);
        } catch (Exception $e) {
            // Rollback and return error
            if (isset($address)) {
                $address->delete();
            }
            if (isset($contact)) {
                $contact->delete();
            }
            if (isset($chitiet)) {
                $chitiet->delete();
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save post data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new quick post (baidangnhanh)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeQuickPost(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'title' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'nullable|email',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'ward_name' => 'nullable|string',
                'district_name' => 'nullable|string',
                'province_name' => 'nullable|string',
                'country' => 'nullable|string',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'image_urls' => 'nullable|array',
                'image_urls.*' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create new quick post
            $baidang = new BaiDangNhanh();
            $baidang->title = $request->title;
            $baidang->name = $request->name;
            $baidang->phone = $request->phone;
            $baidang->email = $request->email;
            $baidang->description = $request->description;
            
            // Generate a temporary slug before saving
            $baidang->slug = Str::slug($request->title) . '-' . time();
            
            // Format address
            $addressParts = [];
            if ($request->address) $addressParts[] = $request->address;
            if ($request->ward_name) $addressParts[] = $request->ward_name;
            if ($request->district_name) $addressParts[] = $request->district_name;
            if ($request->province_name) $addressParts[] = $request->province_name;
            if ($request->country) $addressParts[] = $request->country;
            
            $baidang->address = implode(', ', $addressParts);
            
            // Handle images - combine uploaded files and provided URLs
            $imagePaths = [];
            
            // Process uploaded files
            if ($request->hasFile('images')) {
                try {
                    foreach ($request->file('images') as $image) {
                        $fileName = Str::slug($request->title) . '-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('/temp/images/baidang/'), $fileName);
                        $imagePaths[] = '/temp/images/baidang/' . $fileName;
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to upload images',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }
            
            // Add image URLs if provided
            if ($request->has('image_urls') && is_array($request->image_urls)) {
                foreach ($request->image_urls as $url) {
                    // Only add valid URLs that point to our server
                    if (!empty($url) && (strpos($url, '/temp/images/') === 0 || strpos($url, url('/temp/images/')) === 0)) {
                        // Extract path from full URL if needed
                        $path = str_replace(url('/'), '', $url);
                        $path = ltrim($path, '/');
                        $imagePaths[] = $path;
                    }
                }
            }
            
            // Save images if any were processed
            if (!empty($imagePaths)) {
                $baidang->images = json_encode($imagePaths);
            }
            
            $baidang->save();
            
            // Update slug with ID for uniqueness if needed
            if ($request->has('update_slug_with_id') && $request->update_slug_with_id) {
                $baidang->slug = Str::slug($baidang->title . '-' . $baidang->id);
                $baidang->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Quick post created successfully',
                'data' => $baidang
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create quick post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all quick posts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuickPosts()
    {
        try {
            $quickPosts = BaiDangNhanh::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'status' => 'success',
                'data' => $quickPosts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve quick posts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a post
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $baidang = Baidang::find($id);
            
            if (!$baidang) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found'
                ], 404);
            }
            
            // Check if the user is the owner of the post
            if ($baidang->user_id !== auth('api')->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $validator = Validator::make($request->all(), [
                'tieude' => 'nullable|string|max:255',
                'loainhadat_id' => 'nullable|exists:loainhadats,id',
                // Địa chỉ fields - chỉ yêu cầu ward_id và street
                'ward_id' => 'nullable|exists:wards,id',
                'street' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'gia' => 'nullable|numeric',
                'dientich' => 'nullable|numeric',
                'mota' => 'nullable|string',
                'hinhanh' => 'nullable|array',
                'hinhanh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'sophongngu' => 'nullable|integer',
                'sophongtam' => 'nullable|integer',
                'huongnha' => 'nullable|string',
                'thietbi' => 'nullable|array',
                'thietbi.*' => 'exists:thietbis,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update post
            if ($request->has('tieude')) {
                $baidang->tieude = $request->tieude;
                $baidang->slug = Str::slug($request->tieude) . '-' . time();
            }
            
            if ($request->has('loainhadat_id')) $baidang->loainhadat_id = $request->loainhadat_id;
            
            // Update address if any address field is provided
            if ($request->has('ward_id') || $request->has('street') || 
                $request->has('latitude') || $request->has('longitude')) {
                
                $address = Address::find($baidang->address_id);
                if ($address) {
                    if ($request->has('street')) $address->street = $request->street;
                    if ($request->has('ward_id')) $address->ward_id = $request->ward_id;
                    if ($request->has('latitude')) $address->latitude = $request->latitude;
                    if ($request->has('longitude')) $address->longitude = $request->longitude;
                    $address->save();
                }
            }
            
            if ($request->has('gia')) $baidang->price = $request->gia;
            if ($request->has('dientich')) $baidang->dientich = $request->dientich;
            
            $baidang->save();

            // Update post details
            $chitiet = $baidang->chitiet;
            if ($chitiet) {
                if ($request->has('mota')) $chitiet->mota = $request->mota;
                if ($request->has('sophongngu')) $chitiet->sophongngu = $request->sophongngu;
                if ($request->has('sophongtam')) $chitiet->sophongtam = $request->sophongtam;
                if ($request->has('huongnha')) $chitiet->huongnha = $request->huongnha;
                $chitiet->save();
            }

            // Handle images if provided
            if ($request->hasFile('hinhanh')) {
                $images = [];
                foreach ($request->file('hinhanh') as $image) {
                    $filename = $baidang->slug . '-' . time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('temp/images/baidang'), $filename);
                    $images[] = $filename;
                }
                $baidang->hinhanh = json_encode($images);
                $baidang->save();
            }

            // Update equipment if provided
            if ($request->has('thietbi')) {
                $baidang->thietbis()->sync($request->thietbi);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully',
                'data' => $baidang->load(['user', 'chitiet', 'loainhadat', 'address'])
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a post
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $baidang = Baidang::find($id);
            
            if (!$baidang) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Post not found'
                ], 404);
            }
            
            // Check if the user is the owner of the post
            if ($baidang->user_id !== auth('api')->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $baidang->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Post deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload images and return their URLs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImages(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'images' => 'required|array',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'type' => 'nullable|string|in:baidang,baidangnhanh,profile',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $type = $request->input('type', 'baidang');
            $imagePaths = [];

            foreach ($request->file('images') as $image) {
                $fileName = 'upload-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Determine directory based on type
                $directory = 'temp/images/';
                switch ($type) {
                    case 'baidangnhanh':
                        $directory .= 'baidang/';
                        break;
                    case 'profile':
                        $directory .= 'avatar/';
                        break;
                    default:
                        $directory .= 'baidang/';
                        break;
                }
                
                $image->move(public_path($directory), $fileName);
                $fullPath = '/' . $directory . $fileName;
                $imagePaths[] = $fullPath;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Images uploaded successfully',
                'data' => [
                    'images' => $imagePaths
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload images',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Upload videos and return their URLs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadVideos(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'videos' => 'required|array',
                'videos.*' => 'required|file|mimes:mp4,mov,ogg,qt|max:20000', // max 20MB
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $videoPaths = [];

            foreach ($request->file('videos') as $video) {
                $fileName = 'upload-' . time() . '-' . uniqid() . '.' . $video->getClientOriginalExtension();
                $directory = 'temp/videos/';
                
                $video->move(public_path($directory), $fileName);
                $fullPath = '/' . $directory . $fileName;
                $videoPaths[] = $fullPath;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Videos uploaded successfully',
                'data' => [
                    'videos' => $videoPaths
                ]
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to upload videos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function maLoaiBds($loaiNhadatId, $mohinh)
    {
        $loaiNhadat = Loainhadat::find($loaiNhadatId);

        if (!$loaiNhadat || !isset($loaiNhadat->ma_nha_dat)) {
            return null;
        }

        $maNhaDat = $loaiNhadat->ma_nha_dat;

        switch ($mohinh) {
            case 'thue':
                return $maNhaDat . 'F';
            case 'ban':
                return $maNhaDat . 'S';
            case 'chuyennhuong':
                return $maNhaDat . 'T';
            case 'oghep':
                return $maNhaDat . 'S';
            default:
                return null;
        }
    }

    private function maDoiTuong()
    {
        $role = auth('api')->user()->role;
        switch ($role) {
            case 'admin':
                return 'M';
            case 'chunha':
                return 'O';
            case 'moigioi':
                return 'A';
            case 'nhanvien':
                return 'S';
            case 'user':
            default:
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
        $username = auth('api')->user()->name;
        $nameParts = explode(' ', $username);

        if (count($nameParts) < 2) {
            return '';
        }
        
        $lastName = $nameParts[count($nameParts) - 2];
        $firstName = $nameParts[count($nameParts) - 1];

        $lastName = $this->removeVietnameseAccents($lastName);
        $firstName = $this->removeVietnameseAccents($firstName);

        return strtoupper(substr($lastName, 0, 1) . substr($firstName, 0, 1));
    }

    private function getPostOrderInDayByUser()
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $postCount = Baidang::where('user_id', auth('api')->id())
            ->whereDate('created_at', $today)
            ->count();

        $postOrder = $postCount + 1;

        return str_pad($postOrder, 3, '0', STR_PAD_LEFT);
    }
} 