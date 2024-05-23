<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    public function index()
    {
        return view('users/admin/home');
    }

    public function statistics()
    {
        $user = Auth::user();
        // Tổng số sản phẩm
        $totalProducts = Product::count();

        //Tổng số danh mục
        $totalCategories = Category::count();

        // Tổng số lượng sản phẩm đã bán
        $totalQuantitySold = Product::sum('quantity_sold');

        // Sản phẩm yêu thích nhất
        $mostFavoritedProduct = Product::orderBy('favorite_count', 'desc')->first();

        // Danh mục có nhiều sản phẩm nhất
        $categoryWithMostProducts = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->first();

        return response()->json([
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalQuantitySold' => $totalQuantitySold,
            'mostFavoritedProduct' => $mostFavoritedProduct,
            'categoryWithMostProducts' => $categoryWithMostProducts,
            'user' => $user
        ]);
    }

    public function user()
    {
        $userId = Auth::id();
        $user = User::with('customer')->findOrFail($userId);
        return view('users/admin/profile', compact('user'));
    }

    public function updateInformation(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = User::with('customer')->findOrFail($userId);

            // Kiểm tra xem yêu cầu đến từ form nào
            if ($request->hasFile('img')) {
                // Xử lý upload hình ảnh
                $request->validate([
                    'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = 'assets/img/user/';
                $file->move(public_path('assets/img/user'), $filename);

                if (!empty($filename)) {
                    $user->customer->image = $filename;
                    $user->customer->save();
                }

                return redirect()->route('admin.profile')->with('success', 'Hình ảnh đã được cập nhật thành công.');
            } else {
                // Xác thực dữ liệu đầu vào cho các thông tin khác
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                    'phone' => 'required|numeric',
                    'address' => 'required|string',
                    'password' => 'nullable|string|confirmed',
                ]);

                // Cập nhật thông tin người dùng
                $userData = [
                    'name' => $request->name,
                    'email' => $request->email,
                ];
                $user->customer->phone = $request->phone;
                $user->customer->address = $request->address;

                // Xử lý mật khẩu
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $user->update($userData);
                $user->customer->save();

                return redirect()->route('admin.profile')->with('success', 'Thông tin người dùng đã được cập nhật thành công.');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return redirect()->route('admin.profile')->with('error', 'Cập nhật không thành công.');
        }
    }

}
