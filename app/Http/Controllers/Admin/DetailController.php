<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function detail($id)
    {
        $perPage = 16; // Số sản phẩm hiển thị trên mỗi trang
        $product = Product::find($id);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }

        // Truy vấn các sản phẩm liên quan
        $relatedProducts = Product::where('cate_id', $product->cate_id)
            ->where('id', '!=', $product->id) // Loại bỏ sản phẩm đang xem
            ->paginate($perPage); // Sử dụng phân trang

        // Lấy giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Check if the product is already favorited by the user
        $favorite = Favorite::where('customer_id', $currentUser->customer_id)
            ->where('product_id', $id)
            ->first();

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();



        return view('detail', [
            'product' => $product,
            'carts' => $carts,
            'relatedProducts' => $relatedProducts,
            'currentUser' => $currentUser,
            'title' => 'Trang chi tiết sản phẩm',
            'favorite' => $favorite,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }

    public function toggleFavorite($id)
    {
        $user = auth()->user();

        $product = Product::find($id);

        $favorite = Favorite::where('customer_id', $user->customer_id)
            ->where('product_id', $id)
            ->first();

        $is_fav = false;
        $favorite_count = $product->favorite_count;

        if (!$favorite) {
            Favorite::create([
                'customer_id' => $user->customer_id,
                'product_id' => $id,
                'is_favorite' => true,
            ]);
            $favorite_count++;
            $is_fav = true;
        } else {
            if ($favorite->is_favorite) {
                $favorite->update([
                    'is_favorite' => false,
                ]);
                $favorite_count--;
                $is_fav = false;
            } else {
                $favorite->update([
                    'is_favorite' => true
                ]);
                $favorite_count++;
                $is_fav = true;
            }
        }

        $product->update([
            'favorite_count' => $favorite_count,
        ]);

        return response(["isFav" => $is_fav, "favorite_count" => $favorite_count], 200);
    }

    public function guest($id)
    {
        $perPage = 16; // Số sản phẩm hiển thị trên mỗi trang
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại');
        }

        // Truy vấn các sản phẩm liên quan
        $relatedProducts = Product::where('cate_id', $product->cate_id)
            ->where('id', '!=', $product->id) // Loại bỏ sản phẩm đang xem
            ->paginate($perPage); // Sử dụng phân trang

        $currentUser = false;

        // Truy vấn danh sách các sản phẩm được yêu thích
        $favoriteProductIds = Favorite::where('is_favorite', true)->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();
        
        return view('detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'title' => 'Trang chi tiết sản phẩm',
            'currentUser' => $currentUser,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }
}
