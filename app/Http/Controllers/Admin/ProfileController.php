<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $title = "Tài Khoản";

        // Truy vấn người dùng
        $users = User::all();

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Lấy giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Truy vấn đơn hàng
        $orders = Order::all();

        return view('profile', compact(
            'title',
            'users',
            'carts',
            'currentUser',
            'orders',
        ));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->customer->name = $request->input('name');
        $user->email = $request->input('email');
        $user->customer->email = $request->input('email');
        $user->customer->phone = $request->input('phone');
        $user->customer->address = $request->input('address');
        // $user->image = $request->input('image');
        // $user->customer->image = $request->input('image');

        // Kiểm tra xem có file hình ảnh được tải lên không
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Lưu hình ảnh vào thư mục 'public/assets/img'
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/img/'), $imageName);

            // Cập nhật tên hình ảnh trong database
            $user->image = $imageName;
            $user->customer->image = $imageName;
        } else {
            // Nếu hình ảnh chưa được chọn, gán hình ảnh bằng hình ảnh hiện tại
            $imageName = $user->image;
            $user->image = $imageName;
            $user->customer->image = $imageName;
        }

        // Lưu các thay đổi vào database
        $user->save();
        $user->customer->save();

        // $imageUrl = asset('uploads/' . $user->image);

        if ($user->wasChanged() || $user->customer->wasChanged()) {
            return redirect()->route('user.profile', ['id' => $currentUser->id])->with('success', 'Cập nhật thông tin thành công');
        } else {
            return redirect()->route('user.profile', ['id' => $currentUser->id])->with('error', 'Không có thay đổi nào được thực hiện');
        }
    }
    public function showVouchers()
    {
        $vouchers = Voucher::all();
        return view('vouchers', compact('vouchers'));
    }
}
