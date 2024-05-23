<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $title = "Giỏ Hàng";

        // Dữ liệu phân trang
        $perPage = 20;

        $totalProducts = Product::count();

        $totalPages = ceil($totalProducts / $perPage);

        $currentPage = request()->input('page', 1);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Lấy giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        if ($currentPage >= $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn dữ liệu sản phẩm từ database
        $products = Product::orderBy('id');

        // Truy vấn các sản phẩm khác ngoài giỏ hàng
        $relatedProducts = Product::whereNotIn('id', $carts->pluck('product_id'))->limit(10)->get();

        if ($carts->isNotEmpty()) {
            // Nếu có sản phẩm trong giỏ hàng, thực hiện truy vấn các sản phẩm khác ngoài giỏ hàng
            $relatedProducts = Product::whereNotIn('id', $carts->pluck('product_id'))->limit(10)->get();
        }

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();

        return view('cart', compact(
            'title',
            'carts',
            'products',
            'relatedProducts',
            'totalPages',
            'currentPage',
            'currentUser',
            'favoriteProducts',
        ));
    }

    public function detail($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }

        // Truy vấn các sản phẩm liên quan
        $relatedProducts = Product::where('cate_id', $product->cate_id)
            ->where('id', '!=', $product->id)
            ->limit(10)
            ->get();

        return view('detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'title' => 'Trang chi tiết sản phẩm',
        ]);
    }

    public function store(Request $request)
    {
        $customerId = auth()->user()->customer_id;
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $size = $request->input('selected_size');
        $color = $request->input('selected_color');

        // Kiểm tra size và color có null không
        if (empty($size) || empty($color)) {
            return back()->with('error', 'Bạn cần chọn size và màu sắc của sản phẩm.');
        }

        // Tìm giỏ hàng hiện tại với sản phẩm, size và màu sắc tương ứng
        $existingCartItem = Cart::where([
            ['product_id', $product_id],
            ['customer_id', $customerId],
            ['size', $size],
            ['color', $color]
        ])->first();

        if ($existingCartItem) {
            // Cập nhật số lượng của sản phẩm nếu đã có trong giỏ
            $existingCartItem->increment('quantity', $quantity);
        } else {
            // Thêm mới sản phẩm vào giỏ hàng nếu chưa có
            Cart::create([
                'customer_id' => $customerId,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color
            ]);
        }
        return redirect()->route('user.cart')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // Xóa toàn bộ sản phẩm trong giỏ hàng
    public function clearCart()
    {
        Cart::truncate();
        return redirect()->back();
    }

    public function updateCart(Request $request, $cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $change = $request->input('change');
        if ($change > 0) {
            $cart->quantity += $change;
        } else if ($change < 0 && $cart->quantity > 1) {
            $cart->quantity += $change;
        }

        $cart->update();
        $newQuantity = $cart->quantity;
        $totalPrice = $cart->product->price * $newQuantity;
        return response()->json([
            'newQuantity' => $newQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function removeItem($cartId)
    {
        // Xóa một sản phẩm khỏi giỏ hàng
        $cart = Cart::findOrFail($cartId);
        $cart->delete();
        $newQuantity = $cart->quantity;
        $totalPrice = $cart->product->price * $newQuantity;
        return response()->json([
            'success' => true,
            'newQuantity' => $newQuantity,
            'totalPrice' => $totalPrice,
        ]);
    }
}
