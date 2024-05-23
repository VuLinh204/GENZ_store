<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\OtpMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        $currentUser = false;
        return view('users.forgot_password', ['title' => 'Quên mật khẩu', 'currentUser' => $currentUser]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = Str::random(6);
        $email = $request->email;

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' =>  Hash::make($otp),
                'created_at' => Carbon::now()
            ]
        );

        Mail::to($email)->send(new OtpMail($otp));

        // Lưu giá trị của biến $email vào session
        $request->session()->put('reset_password_email', $email);

        return redirect()->route('forgot_password_verify.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // Lấy email từ session
        $email = $request->session()->get('reset_password_email');

        $otp = $request->input('otp');

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$record || !Hash::check($otp, $record->token)) {
            return redirect()->back()->withErrors(['otp' => 'OTP không hợp lệ.']);
        }

        // Chuyển hướng đến trang đặt lại mật khẩu với email và mã OTP
        return redirect()->route('users.reset_password', ['email' => $email, 'otp' => $otp, 'title' => 'Đặt lại mật khẩu']);
    }

    public function showVerifyOTPForm()
    {
        return view('users.forgot_password_verify', ['title' => 'Xác nhận OTP']);
    }

    public function showResetForm(Request $request)
    {
        return view('users.reset_password', [
            'email' => $request->query('email'),
            'otp' => $request->query('otp'),
            'title' => 'Đặt lại mật khẩu'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required',
                'password' => 'required|confirmed|min:6|regex:/^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]+$/',
                'password_confirmation' => 'required',
            ],
            [
                'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
                'password.min' => 'Mật khẩu phải có ít nhất 6 kí tự.',
                'password.regex' => 'Mật khẩu chỉ được chứa các ký tự chữ cái, số và các ký tự đặc biệt như !@#$%^&*()+=._-',
            ]
        );

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('users.signin')->with('success', 'Đặt lại mật khẩu thành công.');
    }
}
