<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaidangController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\LoainhadatController;
use App\Http\Controllers\Api\ThietbiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

// Public baidang routes (GET only)
Route::get('baidang', [BaidangController::class, 'index']);
Route::get('baidang/{id}', [BaidangController::class, 'show']);

// Quick posts (public)
Route::post('quickpost', [BaidangController::class, 'storeQuickPost']);
Route::get('quickposts', [BaidangController::class, 'getQuickPosts']);

// Image upload (public)
Route::post('upload/images', [BaidangController::class, 'uploadImages']);
Route::post('upload/videos', [BaidangController::class, 'uploadVideos']);


// Location routes (public)
Route::group(['prefix' => 'locations'], function () {
    Route::get('provinces', [LocationController::class, 'getProvinces']);
    Route::post('provinces/search', [LocationController::class, 'searchProvinces']);
    Route::get('districts/{provinceId}', [LocationController::class, 'getDistricts']);
    Route::post('districts/search', [LocationController::class, 'searchDistricts']);
    Route::get('wards/{districtId}', [LocationController::class, 'getWards']);
    Route::post('wards/search', [LocationController::class, 'searchWards']);
    Route::get('address/{id}', [LocationController::class, 'getAddress']);
});

// Property types (public)
Route::get('loainhadat', [LoainhadatController::class, 'index']);
Route::get('loainhadat/{id}', [LoainhadatController::class, 'show']);
Route::get('thietbi', [ThietbiController::class, 'index']);

// Protected routes
Route::group(['middleware' => 'auth:api'], function () {
    // Auth routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
      
    });
    
    // Protected baidang routes (POST, PUT, DELETE)
    Route::post('baidangdaydu', [BaidangController::class, 'store']);
    Route::put('baidang/{id}', [BaidangController::class, 'update']);
    Route::delete('baidang/{id}', [BaidangController::class, 'destroy']);
    
    // Address creation (protected)
    Route::post('locations/address', [LocationController::class, 'createAddress']);
}); 