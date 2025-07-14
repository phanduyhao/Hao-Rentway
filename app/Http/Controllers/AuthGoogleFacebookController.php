<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthGoogleFacebookController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();
    
            if (!$user) {
                $user = new User;
                $user->name = $googleUser->getName();
                $user->email = $googleUser->getEmail();
                $user->avatar = $googleUser->getAvatar();
                $user->password = bcrypt(Str::random(16));
                $user->save();
            }
    
            Auth::login($user, true);
    
            Log::info('User logged in via Google:', ['user' => $user]);
    
            return redirect()->intended('/'); 
        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Đăng nhập Google thất bại.');
        }
    }


       /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            
            // Kiểm tra nếu người dùng đã tồn tại trong hệ thống
            $user = User::where('email', $facebookUser->getEmail())->first();

            if (!$user) {
                // Nếu người dùng chưa tồn tại, tạo mới
                $user = new User;
                $user->name = $facebookUser->getName();
                $user->email = $facebookUser->getEmail();
                $user->avatar = $facebookUser->getAvatar();
                $user->facebook_id = $facebookUser->id;
                $user->password = bcrypt(Str::random(16));  // Tạo password ngẫu nhiên
                $user->save();
            }

            // Đăng nhập người dùng
            Auth::login($user, true);
    
            // Log thông tin người dùng đã đăng nhập
            Log::info('User logged in via Facebook:', ['user' => $user]);
    
            return redirect()->intended('/'); // Điều hướng tới trang chủ
        } catch (\Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Đăng nhập Facebook thất bại.');
        }
    }
}
