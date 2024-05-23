<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        // Dữ liệu phân trang
        $perPage = 20;
        $currentPage = request()->input('page', 1);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Truy vấn giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Truy vấn danh mục
        $categories = Category::all();

        $totalProducts = Product::count();
        $totalPages = ceil($totalProducts / $perPage);

        // Lấy giá trị của selectedCategory từ URL
        $selectedCategory = request()->input('category');

        if ($currentPage >= $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn dữ liệu sản phẩm từ database và sắp xếp theo giá mặc định (id)
        $products = Product::orderBy('id')->paginate($perPage);

        $sort = $request->input('sort');

        $productsQuery = Product::query();

        if ($selectedCategory) {
            $productsQuery->where('cate_id', $selectedCategory);
        }

        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) ASC');
                    break;
                case 'price_desc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) DESC');
                    break;
                case 'percent_asc':
                    $productsQuery->orderBy('percent_discount', 'asc');
                    break;
                case 'percent_desc':
                    $productsQuery->orderBy('percent_discount', 'desc');
                    break;
                case 'popular':
                    $productsQuery->orderByDesc('favorite_count');
                    break;
                case 'newest':
                    $productsQuery->orderByDesc('created_at'); // Sắp xếp theo sản phẩm mới nhất
                    break;
                case 'best_selling':
                    $productsQuery->orderByDesc('quantity_sold');
                    break;
                default:
                    $productsQuery->orderBy('id');
                    break;
            }
        } else {
            $productsQuery->orderBy('id');
        }

        $products = $productsQuery->paginate($perPage);
        $totalPages = $products->lastPage();

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();

        return view('product', [
            'title' => 'Trang sản phẩm',
            'products' => $products,
            'carts' => $carts,
            'currentUser' => $currentUser,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }

    public function search(Request $request)
    {
        $title = "Kết quả tìm kiếm";
        $query = $request->input('query');
        $perPage = 20;

        $totalProducts = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->count();
        $totalPages = ceil($totalProducts / $perPage);
        $currentPage = $request->input('page', 1);
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Truy vấn giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        // Truy vấn danh mục
        $categories = Category::all();

        $products = Product::where('name', 'LIKE BINARY', "%$query%")
            ->orWhere('description', 'LIKE BINARY', "%$query%");

        // Áp dụng sắp xếp theo giá nếu được yêu cầu
        if ($request->has('sort')) {
            if ($request->input('sort') == 'price_asc') {
                $products = $products->orderBy('percent_discount');
            } elseif ($request->input('sort') == 'price_desc') {
                $products = $products->orderByDesc('percent_discount');
            }
        }

        $products = $products->paginate($perPage);

        // Xử lí lịch sử tìm kiếm
        if (request()->isMethod('get') && request()->has('query')) {
            $query = request()->input('query');

            // Lấy lịch sử tìm kiếm từ session, hoặc khởi tạo nếu chưa tồn tại
            $searchHistory = session('search_history', []);

            // Kiểm tra xem từ khóa đã tồn tại trong lịch sử tìm kiếm chưa
            if (!in_array($query, $searchHistory)) {
                // Thêm từ khóa tìm kiếm mới vào đầu mảng lịch sử
                array_unshift($searchHistory, $query);

                // Giới hạn số lượng mục trong lịch sử tìm kiếm
                if (count($searchHistory) > 5) {
                    array_pop($searchHistory);
                }
            }

            session(['search_history' => $searchHistory]);
        }

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();

        return view('search_results', compact(
            'title',
            'products',
            'query',
            'currentUser',
            'totalPages',
            'currentPage',
            'carts',
            'categories',
            'favoriteProducts',
        ));
    }

    public function productsByCategory(Request $request, $categoryId)
    {
        $perPage = 20;
        $currentPage = $request->input('page', 1);

        $currentUser = auth()->user();
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();
        $categories = Category::all();

        $sort = $request->input('sort');

        $productsQuery = Product::where('cate_id', $categoryId);

        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) ASC');
                    break;
                case 'price_desc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) DESC');
                    break;
                case 'percent_asc':
                    $productsQuery->orderBy('percent_discount', 'asc');
                    break;
                case 'percent_desc':
                    $productsQuery->orderBy('percent_discount', 'desc');
                    break;
                case 'popular':
                    $productsQuery->orderByDesc('favorite_count');
                    break;
                case 'newest':
                    $productsQuery->orderByDesc('created_at');
                    break;
                case 'best_selling':
                    $productsQuery->orderByDesc('quantity_sold');
                    break;
                default:
                    $productsQuery->orderBy('id');
                    break;
            }
        } else {
            $productsQuery->orderBy('id');
        }

        $products = $productsQuery->paginate($perPage);
        $totalPages = $products->lastPage();

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();

        return view('product', [
            'title' => 'Trang sản phẩm',
            'products' => $products,
            'carts' => $carts,
            'currentUser' => $currentUser,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }

    public function allProducts()
    {
        $title = "Tất cả sản phẩm";
        $perPage = 30;
        $totalProducts = Product::count();
        $totalPages = ceil($totalProducts / $perPage);
        $currentPage = request()->input('page', 1);

        // Truy vấn thông tin của người dùng hiện tại
        $currentUser = auth()->user();

        // Truy vấn giỏ hàng của người dùng hiện tại
        $carts = Cart::where('customer_id', $currentUser->customer_id)->get();

        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $favoriteProducts = Favorite::where('customer_id', $currentUser->customer_id)->get();

        $products = Product::orderBy('id')->paginate($perPage);

        return view('all', compact('title', 'products', 'carts', 'currentUser', 'totalPages', 'currentPage', 'favoriteProducts'));
    }

    // guest
    public function guest(Request $request)
    {
        // Dữ liệu phân trang
        $perPage = 20;
        $currentPage = request()->input('page', 1);

        // Truy vấn danh mục
        $categories = Category::all();

        $totalProducts = Product::count();
        $totalPages = ceil($totalProducts / $perPage);

        // Lấy giá trị của selectedCategory từ URL
        $selectedCategory = request()->input('category');

        if ($currentPage >= $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn dữ liệu sản phẩm từ database và sắp xếp theo giá mặc định (id)
        $products = Product::orderBy('id')->paginate($perPage);

        $sort = $request->input('sort');

        $productsQuery = Product::query();

        if ($selectedCategory) {
            $productsQuery->where('cate_id', $selectedCategory);
        }

        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) ASC');
                    break;
                case 'price_desc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) DESC');
                    break;
                case 'percent_asc':
                    $productsQuery->orderBy('percent_discount', 'asc');
                    break;
                case 'percent_desc':
                    $productsQuery->orderBy('percent_discount', 'desc');
                    break;
                case 'popular':
                    $productsQuery->orderByDesc('favorite_count');
                    break;
                case 'newest':
                    $productsQuery->orderByDesc('created_at'); // Sắp xếp theo sản phẩm mới nhất
                    break;
                case 'best_selling':
                    $productsQuery->orderByDesc('quantity_sold');
                    break;
                default:
                    $productsQuery->orderBy('id');
                    break;
            }
        } else {
            $productsQuery->orderBy('id');
        }

        $products = $productsQuery->paginate($perPage);
        $totalPages = $products->lastPage();

        $currentUser = false;

        // Truy vấn danh sách các sản phẩm được yêu thích
        $favoriteProductIds = Favorite::where('is_favorite', true)->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();

        return view('product', [
            'title' => 'Trang sản phẩm',
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'currentUser' => $currentUser,
            'favoriteProducts' => $favoriteProducts,
        ]);
    }

    public function guestProductsByCategory(Request $request, $categoryId)
    {
        $perPage = 20;
        $currentPage = $request->input('page', 1);

        $categories = Category::all();

        $sort = $request->input('sort');

        $productsQuery = Product::where('cate_id', $categoryId);

        if ($sort) {
            switch ($sort) {
                case 'price_asc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) ASC');
                    break;
                case 'price_desc':
                    $productsQuery->orderByRaw('price - (price * percent_discount / 100) DESC');
                    break;
                case 'percent_asc':
                    $productsQuery->orderBy('percent_discount', 'asc');
                    break;
                case 'percent_desc':
                    $productsQuery->orderBy('percent_discount', 'desc');
                    break;
                case 'popular':
                    $productsQuery->orderByDesc('favorite_count');
                    break;
                case 'newest':
                    $productsQuery->orderByDesc('created_at');
                    break;
                case 'best_selling':
                    $productsQuery->orderByDesc('quantity_sold');
                    break;
                default:
                    $productsQuery->orderBy('id');
                    break;
            }
        } else {
            $productsQuery->orderBy('id');
        }

        $products = $productsQuery->paginate($perPage);
        $totalPages = $products->lastPage();


        $currentUser = false;

        // Truy vấn danh sách các sản phẩm được yêu thích
        $favoriteProductIds = Favorite::where('is_favorite', true)->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();

        return view('product', [
            'title' => 'Trang sản phẩm',
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'currentUser' => $currentUser,
            'favoriteProducts' => $favoriteProducts,

        ]);
    }

    public function guestSearch(Request $request)
    {
        $title = "Kết quả tìm kiếm";
        $query = $request->input('query');
        $perPage = 20;

        $totalProducts = Product::where('name', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->count();
        $totalPages = ceil($totalProducts / $perPage);
        $currentPage = $request->input('page', 1);
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        // Truy vấn danh mục
        $categories = Category::all();

        $products = Product::where('name', 'LIKE BINARY', "%$query%")
            ->orWhere('description', 'LIKE BINARY', "%$query%");

        // Áp dụng sắp xếp theo giá nếu được yêu cầu
        if ($request->has('sort')) {
            if ($request->input('sort') == 'price_asc') {
                $products = $products->orderBy('percent_discount');
            } elseif ($request->input('sort') == 'price_desc') {
                $products = $products->orderByDesc('percent_discount');
            }
        }

        $products = $products->paginate($perPage);

        // Xử lí lịch sử tìm kiếm
        if (request()->isMethod('get') && request()->has('query')) {
            $query = request()->input('query');

            // Lấy lịch sử tìm kiếm từ session, hoặc khởi tạo nếu chưa tồn tại
            $searchHistory = session('search_history', []);

            // Kiểm tra xem từ khóa đã tồn tại trong lịch sử tìm kiếm chưa
            if (!in_array($query, $searchHistory)) {
                // Thêm từ khóa tìm kiếm mới vào đầu mảng lịch sử
                array_unshift($searchHistory, $query);

                // Giới hạn số lượng mục trong lịch sử tìm kiếm
                if (count($searchHistory) > 5) {
                    array_pop($searchHistory);
                }
            }

            session(['search_history' => $searchHistory]);
        }


        $currentUser = false;

        // Truy vấn danh sách các sản phẩm được yêu thích
        $favoriteProductIds = Favorite::where('is_favorite', true)->pluck('product_id')->toArray();
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();

        return view('search_results', compact(
            'title',
            'products',
            'query',
            'currentUser',
            'totalPages',
            'currentPage',
            'categories',
            'favoriteProducts',
        ));
    }
}
