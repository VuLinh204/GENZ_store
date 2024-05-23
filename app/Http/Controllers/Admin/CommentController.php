<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function poComment(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn phải đăng nhập để bình luận.'], 401);
        }

        $request->validate([
            'body' => 'required|max:255',
        ]);

        $user = Auth::user();
        $imageUrl = $user->image ? asset('assets/img/' . $user->image) : asset('assets/img/User.png');

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = $user->id;
        $comment->image = $imageUrl;
        $comment->product_id = $product->id;
        $comment->save();

        return back()->with('success', 'Bình luận đã được thêm.');
    }

    public function update(Request $request, Comment $comment)
    {
        // Kiểm tra xem người dùng có quyền chỉnh sửa bình luận hay không
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa bình luận này.'], 403);
        }

        // Xác thực dữ liệu đầu vào
        $request->validate(['body' => 'required|string']);

        // Cập nhật nội dung của bình luận
        $comment->update(['body' => $request->body]);

        return response()->json(['success' => 'Bình luận đã được cập nhật thành công.'], 200);
    }

    public function destroy(Comment $comment)
    {
        // Kiểm tra xem người dùng có quyền xóa bình luận hay không
        if (Auth::id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa bình luận này.');
        }

        // Xóa bình luận
        $comment->delete();

        // Chuyển hướng người dùng về trang trước đó với thông báo thành công
        return redirect()->back()->with('success', 'Bình luận đã được xóa thành công.');
    }
}
