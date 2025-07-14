<?php

use App\Http\Controllers\Admin\AdminBaidangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminThietbiController;
use App\Http\Controllers\Admin\AdminLoainhadatController;
use App\Http\Controllers\Admin\AdminDiachiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthGoogleFacebookController;
use App\Http\Controllers\BaiDangNhanhController;
use App\Http\Controllers\LocationController;

Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'vi'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

Route::middleware(['setlocale'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/delete-user-data', [HomeController::class, 'deleteUserData']);
    Route::get('/privacy', [HomeController::class, 'privacy']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
    Route::get('/showRegister', [AuthController::class, 'showRegister'])->name('showRegister');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPass'])->name('showForgotPass');
    Route::post('/forgot-password', [AuthController::class, 'sendMailForgotPass'])->name('sendMailForgotPass');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('resetPassword');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('postResetPassword');

    Route::get('/dangtinnhanh', [BaiDangNhanhController::class, 'index'])->name('baidangnhanh.index');
    Route::post('/dangtinnahnh/store', [BaiDangNhanhController::class, 'store'])->name('baidangnhanh.store');

    // Route để redirect đến Google
    Route::get('login/google', [AuthGoogleFacebookController::class, 'redirectToGoogle'])->name('google.login');

    // Route nhận phản hồi từ Google
    Route::get('login/google/callback', [AuthGoogleFacebookController::class, 'handleGoogleCallback']);

    // Route để redirect tới Facebook
    Route::get('login/facebook', [AuthGoogleFacebookController::class, 'redirectToFacebook'])->name('facebook.login');

    // Route nhận phản hồi từ Facebook
    Route::get('login/facebook/callback', [AuthGoogleFacebookController::class, 'handleFacebookCallback']);


    Route::prefix('posts')->group(function () {
        Route::get('/list', [PostController::class, 'listBaidang'])->name('posts.list');
        Route::get('/baidang/loai/{slug}', [PostController::class, 'getByLoaiNhadat'])->name('listByNhadat');
        Route::get('/posts/detail/{slug}', [PostController::class, 'baidangDetail'])->name('baidangDetail');
    });
    // Route để lấy Province (tỉnh)
    Route::get('/getProvince/{country}',  [LocationController::class, 'getProvince']);

    // Route để lấy District (quận/huyện) theo province_code
    Route::get('/getDistrict/{provinceCode}/{country}',  [LocationController::class, 'getDistrict']);

    // Route để lấy Ward (phường/xã) theo district_code
    Route::get('/getWard/{districtCode}/{country}',  [LocationController::class, 'getWard']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::middleware(['setlocale'])->group(function () {
        Route::post('/addLocation/{locationType}', [LocationController::class, 'addLocation']);
        Route::get('/list-bai-dang-nhanh', [BaiDangNhanhController::class, 'list'])->name('baidangnhanh.list');
        // Route để xem chi tiết bài đăng nhanh
        Route::get('/dangtinnhanh/{slug}', [BaiDangNhanhController::class, 'chiTietBaiDangNhanh'])->name('chiTietBaiDangNhanh');
        // Route để xóa bài đăng nhanh
        Route::delete('/dangtinnhanh/{id}/delete', [BaiDangNhanhController::class, 'deleteBaiDangNhanh'])->name('deleteBaiDangNhanh');
        Route::post('/mark-as-read/{baidang}', [BaiDangNhanhController::class, 'markAsRead'])->name('markAsRead');

        Route::post('/check-duplicate-post', [PostController::class, 'checkDuplicate'])->name('check-duplicate-post');

        Route::prefix('posts')->group(function () {
            Route::get('', [PostController::class, 'index'])->name('postPage');
            Route::post('/upload', [PostController::class, 'store'])->name('dangbai');
            Route::post('/isVip/{id}', [PostController::class, 'toggleIsVip']);
            Route::post('/update-status', [PostController::class, 'updateStatus']);
            Route::post("/delete-image", [PostController::class, "deleteImage"])->name("delete.image");
            Route::post("/delete-video", [PostController::class, "deleteVideo"])->name("delete.video");
            Route::post('/update/{id}', [PostController::class, 'update'])->name('updateBaidang');
        });

        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
            Route::post('/update/{user}', [ProfileController::class, 'updateProfile'])->name('profile.update');
            Route::get('/list-baidang', [ProfileController::class, 'listBaidang'])->name('profile.listBaidang');
            Route::get('/{slug}/edit', [ProfileController::class, 'editBaidang'])->name('baidang.edit');
            Route::get('/showChangePass', [ProfileController::class, 'showChangePass'])->name('showChangePass');
            Route::post('/change-password', [ProfileController::class, 'changePass'])->name('changePass');
            Route::delete('/delete/baidang/{id}', [PostController::class, 'destroy'])->name('baidang.destroy');
            Route::delete('/delete/baidangDetail/{id}', [PostController::class, 'destroyInDetail'])->name('baidang.destroyDetail');
        });
    });

    // Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::prefix('admin')->group(function () {
            // Quản lý USERS 
            Route::resource('users', AdminUserController::class);
            Route::get('/adminUser', [AdminUserController::class, 'adminUser'])->name('adminUser');
            Route::get('/user', [AdminUserController::class, 'user'])->name('user');
            Route::delete('/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('destroyUser');

            // Quản lý Job_Category
            Route::resource('thietbi', AdminThietbiController::class);
            Route::resource('loainhadat', AdminLoainhadatController::class);
            Route::prefix('posts')->group(function () {
                Route::get('/', [AdminBaidangController::class, 'index'])->name('baidangDaduyet');
                Route::get('/loading', [AdminBaidangController::class, 'loading'])->name('baidangChoduyet');
                Route::get('/cancel', [AdminBaidangController::class, 'cancel'])->name('baidangDahuy');
                Route::post('/{id}/approve', [AdminBaidangController::class, 'approve'])->name('baidang.approve');
                Route::post('/{id}/cancel', [AdminBaidangController::class, 'cancelPost'])->name('baidang.cancel');
            });

            Route::get('/', [AdminHomeController::class, 'index'])->name('homeAdmin');
            Route::resource('settings', AdminSettingController::class);
            Route::post('/settings/updateAll', [AdminSettingController::class, 'updateAll'])->name('updateSetting');
            Route::post('/settings/update-toggle', [AdminSettingController::class, 'toggleAutoApprove'])->name('toggleAutoApprove');

            // Địa chỉ
            Route::get('/addresses', [AdminDiachiController::class, 'index'])->name('addresses.index');
            Route::post('/addresses/update/{type}/{id}', [AdminDiachiController::class, 'update'])->name('addresses.update');
        });
    });
});
