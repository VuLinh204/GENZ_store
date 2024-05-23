<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');

        // Initialize the query builder with the role condition
        $query = User::where('role', '1'); // Chỉ lấy những người dùng có vai trò là khách hàng

        if (!empty($keyword)) {
            // Apply the keyword filter to the existing query
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%');
            });
        }

        // Get the paginated results
        $users = $query->latest()->paginate(10);

        $title = "Danh sách khách hàng";

        return view('users.admin.customers.listcustomer', compact('users', 'title'));
    }

    public function lock($id)
    {
        try {
            // Tìm khách hàng với ID tương ứng
            $customer = User::findOrFail($id);
    
            // Kiểm tra trạng thái hiện tại của tài khoản
            if ($customer->is_locked) {
                return redirect()->route('admin.users.index')->with('error', 'Tài khoản đã bị khóa trước đó.');
            }
    
            // Khóa tài khoản
            $customer->is_locked = true;
            $customer->save();
    
            // Redirect với thông báo thành công
            return redirect()->route('admin.users.index')->with('success', 'Khóa tài khoản thành công.');
        } catch (\Exception $exception) {
            // Xử lý lỗi và redirect với thông báo lỗi
            Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return redirect()->route('admin.users.index')->with('error', 'Khóa tài khoản thất bại.');
        }       
    }

    public function unlock($id)
    {
        try {
            // Tìm khách hàng với ID tương ứng
            $customer = User::findOrFail($id);
    
            // Kiểm tra trạng thái hiện tại của tài khoản
            if (!$customer->is_locked) {
                return redirect()->route('admin.users.index')->with('error', 'Tài khoản không được khóa trước đó.');
            }
    
            // Mở khóa tài khoản
            $customer->is_locked = false;
            $customer->save();
    
            // Redirect với thông báo thành công
            return redirect()->route('admin.users.index')->with('success', 'Mở khóa tài khoản thành công.');
        } catch (\Exception $exception) {
            // Xử lý lỗi và redirect với thông báo lỗi
            Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return redirect()->route('admin.users.index')->with('error', 'Mở khóa tài khoản thất bại.');
        }       
    }

}
