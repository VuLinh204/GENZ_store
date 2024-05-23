<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SignUpController extends Controller
{
    public function index()
    {
        $currentUser = false;
        return view('users.signup', ['title' => 'Đăng ký hệ thống', 'currentUser' => $currentUser]);
    }

    public function sendCreateLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;

        // Kiểm tra xem email đã tồn tại trong bảng users chưa
        $existingUser = User::where('email', $email)->exists();

        if ($existingUser) {
            // Nếu đã tồn tại, hiển thị thông báo lỗi
            return redirect()->back()->withErrors(['email' => 'Email đã tồn tại.']);
        }

        // Tạo mã OTP
        $otp = Str::random(6);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            [
                'email' => $email,
                'token' =>  Hash::make($otp),
                'created_at' => Carbon::now()
            ]
        );

        // Gửi OTP qua email
        Mail::to($email)->send(new OtpMail($otp));

        // Lưu email và mã OTP vào session để xác thực sau này
        $request->session()->put('create_password_email', $email);

        // Chuyển hướng người dùng đến trang nhập OTP
        return redirect()->route('signup_verify.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // Lấy email từ session
        $email = $request->session()->get('create_password_email');

        $otp = $request->input('otp');
        $request->session()->put('signup_otp', $otp); // Lưu mã OTP vào session

        $record = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$record || !Hash::check($otp, $record->token)) {
            return redirect()->back()->withErrors(['otp' => 'OTP không hợp lệ.']);
        }
        // Chuyển hướng đến trang đặt lại mật khẩu với email và mã OTP
        return redirect()->route('users.signup_create_password', ['email' => $email, 'otp' => $otp, 'title' => 'Tạo mật khẩu']);
    }

    public function showVerifyOTPForm()
    {
        return view('users.signup_verify', ['title' => 'Xác nhận OTP']);
    }

    public function showCreateForm(Request $request)
    {
        return view('users.signup_create_password', [
            'email' => $request->query('email'),
            'otp' => $request->query('otp'),
            'title' => 'Tạo mật khẩu'
        ]);
    }

    public function createPassword(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validatedData = $request->validate(
            [
                'otp' => 'required',
                'email' => 'required|email:filter|unique:users,email',
                'password' => 'required|min:6|regex:/^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]+$/',
                'password_confirmation' => 'required|same:password'
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ email.',
                'email.email' => 'Địa chỉ email không hợp lệ.',
                'email.unique' => 'Email đã tồn tại.',
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.min' => 'Mật khẩu phải có ít nhất :min kí tự.',
                'password.regex' => 'Mật khẩu chỉ được chứa các ký tự chữ cái, số và các ký tự đặc biệt như !@#$%^&*()+=._-',
                'password_confirmation.required' => 'Vui lòng nhập mật khẩu xác nhận.',
                'password_confirmation.same' => 'Mật khẩu xác nhận không trùng khớp với mật khẩu đã nhập.'
            ]
        );

        // Lấy mã OTP từ session
        $otp = $request->input('otp');

        // So sánh mã OTP nhập vào với mã OTP trong session
        if ($otp === $request->session()->get('signup_otp')) {
            // Xác thực thành công, tạo tài khoản
            $user = new User();
            $user->role = 1; // Gán vai trò cho người dùng, ví dụ ở đây là 1
            $user->image = 'User.png'; // Gán hình ảnh mặc định cho người dùng
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            // Tạo thông tin khách hàng tương ứng
            $customer = new Customer();
            $customer->name = ''; // Tùy chỉnh tên khách hàng nếu cần
            $customer->phone = ''; // Tùy chỉnh số điện thoại khách hàng nếu cần
            $customer->address = ''; // Tùy chỉnh địa chỉ khách hàng nếu cần
            $customer->email = $validatedData['email']; // Sử dụng email từ người dùng
            $customer->password = $user->password; // Sử dụng mật khẩu đã được mã hóa của người dùng
            $customer->role = $user->role;
            $customer->image = $user->image;
            $customer->save();

            $user->customer_id = $customer->id;
            $user->save();

            // Xóa các session liên quan đến đăng ký
            $request->session()->forget('signup_email');
            $request->session()->forget('signup_otp');
            $request->session()->forget('signup_password');
            // Chuyển hướng đến trang đăng nhập hoặc trang chính
            return redirect()->route('users.signin')->with('success', 'Đăng ký thành công! Hãy đăng nhập để tiếp tục.');
        } else {
            // Mã OTP không hợp lệ, trả về thông báo lỗi
            return redirect()->back()->withErrors(['otp' => 'Mã OTP không hợp lệ.'])->withInput();
        }
    }
}
