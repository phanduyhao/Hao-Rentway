<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function showRegister(){
        return view('auth.register',[
            'title' => __('common.register'),
        ]);
    }

    /**
     * Đăng ký tài khoản.
     * @param Request $request
     */
    public function register(Request $request)
    {
       // Validate the request
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
            // 'quoctich' => 'required',

        ], [
            'name.required' => 'Vui lòng nhập tên của bạn!',
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Email không hợp lệ!',
            'email.unique' => 'Email đã tồn tại!',
            'username.required' => 'Vui lòng nhập username!',
            'username.unique' => 'Username đã tồn tại!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'phone.unique' => 'Số điện thoại đã tồn tại!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'confirmPassword.required' => 'Vui lòng xác nhận mật khẩu!',
            'confirmPassword.same' => 'Mật khẩu xác nhận không khớp!',
            // 'quoctich.required' => 'Vui lòng chọn Quốc tịch!',

        ]);
        $confirmPass = $request->confirmPassword;
        $pass = $request->password;
        if ($confirmPass == $pass) {
            // Kiểm tra xem email đã tồn tại chưa
            $emailExists = User::where('email', $request->email)->exists();

            if (!$emailExists) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->username = $request->username;
                $user->phone = $request->phone;
                $user->password = bcrypt($request->password);
                $user->role = $request->role;
                $user->language = $request->language ?? 'vn';
                $user->link_zalo = $request->zalo;
                $user->link_tele = $request->telegram;
                $user->quoctich = $request->quoctich;
                $user->save();
                Auth::login($user);
            } else {
                return back()->with('error', 'Email đã tồn tại');
            }
        } else {
            return back()->with('error', 'Xác nhận lại mật khẩu !');
        }
        return redirect('/'); // Điều hướng sau khi đăng ký
    }

    
    public function showLogin(){
        return view('auth.login',[
            'title' => __('common.login')
        ]);
    }

    /**
     * Đăng nhập.
     * @param Request $request
     */
   
public function login(Request $request)
{
    // Validate trường login và password
    $this->validate($request, [
        'login' => 'required|string',
        'password' => 'required|string',
    ], [
        'login.required' => 'Vui lòng nhập số điện thoại hoặc tên đăng nhập',
        'password.required' => 'Vui lòng nhập mật khẩu',
    ]);

    $login = $request->input('login');
  $password = $request->input('password');

    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $fieldType = 'email';
    } elseif (preg_match('/^[0-9]{9,15}$/', $login)) {
        $fieldType = 'phone'; 
    } else {
        $fieldType = 'username'; 
    }

    $credentials = [
        $fieldType => $login,
        'password' => $password
    ];

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/')->with('success', 'Đăng nhập thành công');
    }

    return back()->withErrors([
        'login' => 'Số điện thoại hoặc tên đăng nhập hoặc mật khẩu không đúng',
    ])->withInput($request->only('login'));
}


     public function showForgotPass(){
         return view('auth.forgotPass',[
             'title' => __('common.forgot_password')
         ]);
     }

     public function sendMailForgotPass(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ],[
            'email.required' => 'Vui lòng nhập email !',
            'email.exists' => 'Email không tồn tại !',
        ]);
    
        $token = Str::random(64);
    
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);
    
        Mail::send('auth.emailResetPassword', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu');
        });
    
        return back()->with('success', 'Email đặt lại mật khẩu đã được gửi.');
    }

    public function showResetPassword($token) {
        return view('auth.resetPassword', ['token' => $token, 'title' => __('common.reset_password')]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);
    
        $reset = DB::table('password_resets')->where('token', $request->token)->first();
    
        if (!$reset) {
            return back()->withErrors(['token' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }
    
        $user = \App\Models\User::where('email', $reset->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }
    
        $user->password = bcrypt($request->password);
        $user->save();
    
        DB::table('password_resets')->where(['email' => $reset->email])->delete();
    
        return redirect()->route('login')->with('success', 'Mật khẩu của bạn đã được đặt lại thành công.');
    }
    

    /**
     * Đăng xuất.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLogin');    
    }
}
