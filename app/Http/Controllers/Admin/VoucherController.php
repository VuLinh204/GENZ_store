<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $title = "Tài Khoản";

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Truy vấn giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Truy vấn đơn hàng của người dùng hiện tại
        $orders = Order::where('user_id', $currentUser->id)->get();

        // Lấy tất cả các voucher
        $vouchers = Voucher::all();

        return view('voucher', compact(
            'title',
            'currentUser',
            'carts',
            'orders',
            'vouchers'
        ));
    }
}
