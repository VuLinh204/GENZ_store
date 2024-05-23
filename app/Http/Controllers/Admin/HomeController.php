<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        // Dữ liệu phân trang
        $perPage = 20;

        $totalProducts = Product::count();

        $totalPages = ceil($totalProducts / $perPage);

        $currentPage = request()->input('page', 1);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Lấy giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Truy vấn danh sách các danh mục sản phẩm
        $categories = Category::all();

        //Truy vấn danh sách slider
        $sliders = Slider::latest()->get();
        if ($currentPage >= $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn dữ liệu sản phẩm từ database và sắp xếp theo giá mặc định (id)
        $products = Product::orderBy('id')->paginate($perPage);

        // Nếu có yêu cầu sắp xếp theo giá từ thấp đến cao
        if (request()->has('sort') && request()->input('sort') == 'price_asc') {
            $products = Product::orderBy('price_sale')->paginate($perPage);
        }

        // Nếu có yêu cầu sắp xếp theo giá từ cao đến thấp
        if (request()->has('sort') && request()->input('sort') == 'price_desc') {
            $products = Product::orderByDesc('price_sale')->paginate($perPage);
        }

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();

        return view('home', [
            'title' => 'Trang chủ',
            'data' => $products,
            'carts' => $carts,
            'currentUser' => $currentUser,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories,
            'sliders' => $sliders,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }

    public function guest()
    {
        // Dữ liệu phân trang
        $perPage = 20;

        $totalProducts = Product::count();

        $totalPages = ceil($totalProducts / $perPage);

        $currentPage = request()->input('page', 1);

        // Truy vấn danh sách các danh mục sản phẩm
        $categories = Category::all();

        //Truy vấn danh sách slider
        $sliders = Slider::latest()->get();
        if ($currentPage >= $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn dữ liệu sản phẩm từ database và sắp xếp theo giá mặc định (id)
        $products = Product::orderBy('id')->paginate($perPage);

        // Nếu có yêu cầu sắp xếp theo giá từ thấp đến cao
        if (request()->has('sort') && request()->input('sort') == 'price_asc') {
            $products = Product::orderBy('price_sale')->paginate($perPage);
        }

        // Nếu có yêu cầu sắp xếp theo giá từ cao đến thấp
        if (request()->has('sort') && request()->input('sort') == 'price_desc') {
            $products = Product::orderByDesc('price_sale')->paginate($perPage);
        }

        $currentUser = false;

        // Truy vấn danh sách các sản phẩm được yêu thích
        $favoriteProductIds = Favorite::where('is_favorite', true)->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();

        return view('home', [
            'title' => 'Trang chủ',
            'data' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories,
            'sliders' => $sliders,
            'currentUser' => $currentUser,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }
}
