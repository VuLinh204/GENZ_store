<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;

class PasswordController extends Controller
{
    public function index()
    {
        $title = "Mật Khẩu";


        // Truy vấn người dùng
        $users = User::all();

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = Auth::user();

        // Truy vấn giỏ hàng
        $carts = Cart::all();

        // Lấy giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Truy vấn đơn hàng
        $orders = Order::all();

        return view('password', compact(
            'title',
            'users',
            'carts',
            'currentUser',
            'orders',
        ));
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Validate dữ liệu đầu vào
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6',
                'password_confirmation' => 'required|same:password'
            ],
            [
                'password.required' => 'Vui lòng nhập mật khẩu mới.',
                'password.min' => 'Mật khẩu phải có ít nhất :min kí tự.',
                'password_confirmation.required' => 'Vui lòng nhập mật khẩu xác nhận.',
                'password_confirmation.same' => 'Mật khẩu xác nhận không trùng khớp với mật khẩu mới.'
            ]
        );

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->input('old_password'), $currentUser->password)) {
            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng. Vui lòng thử lại.')->withInput();
        } else if (Hash::check($request->input('password'), $currentUser->password)) {
            return redirect()->back()->with('error', 'Mật khẩu mới không được trùng với mật khẩu cũ. Vui lòng chọn mật khẩu khác.')->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $user->password = Hash::make($request->input('password'));
        $user->customer->password = $request->input('password');
        $user->save();
        $user->customer->save();

        // Redirect về trang tài khoản của người dùng với thông báo thành công
        return redirect()->route('user.password', ['id' => $currentUser->id])->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

}
