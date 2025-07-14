<?php

namespace App\Providers;

use App\Models\Baidang;
use App\Models\BaiDangNhanh;
use App\Models\Setting;
use App\Models\Loainhadat;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(env('FORCE_HTTPS', false)) { // Default value should be false for local server
            URL::forceScheme('https');
        }
        
        View::composer('layout.layout', function ($view) {
            $loainhadats = Loainhadat::select('title','slug','icon')->get(); // Mặc định là 0 nếu người dùng chưa đăng nhập
            $settings = Setting::pluck('value', 'key')->toArray();
            $count_tinnhanh_unread = BaiDangNhanh::where('isRead', null)->count();
            // Truyền biến sang view
            $view->with('loainhadats', $loainhadats)->with('settings',$settings)->with('count_tinnhanh_unread',$count_tinnhanh_unread);
        });
        View::composer('admin.sidebar', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();
            $count_baidang = 0; // Mặc định là 0 nếu người dùng chưa đăng nhập
            if (Auth::check()) { // Kiểm tra xem người dùng có đăng nhập hay không
               $count_baidang = Baidang::where('adminduyet',null)->count();

            // Truyền biến sang view
            $view->with('count_baidang', $count_baidang)->with('settings',$settings);
            }
        });
        View::composer('admin.main', function ($view) {
            $settings = Setting::pluck('value', 'key')->toArray();
            $view->with('settings',$settings);
        });
    }
}
