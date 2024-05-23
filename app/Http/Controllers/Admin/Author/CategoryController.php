<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Components\Recusive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CategoryAddRequest;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');

        if (!empty($keyword)) {
            $categories = $this->category->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                ->latest()->paginate(10);
        } else {
            $categories = $this->category->latest()->paginate(10);
        }
        $title = 'DANH SÁCH CÁC DANH MỤC';

        return view('users/admin/categories/listcategory', compact('categories', 'keyword', 'title'));
    }

    public function getCategory($parent_id)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryResusive($parent_id);
        return $htmlOption;
    }

    public function create()
    {
        $htmlOption = $this->getCategory($parentId = "");
        return view('users/admin/categories/addcategory', [
            'title' => 'THÊM DANH MỤC',
            'option' => $htmlOption
        ]);
    }

    public function store(CategoryAddRequest $request)
    {
        try {
            DB::beginTransaction();

            $dataCategoryCreate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'slug' => $request->slug ?? null,
            ];

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $imageName);
                $dataCategoryCreate['image'] = $imageName;
            }

            $category = $this->category->create($dataCategoryCreate);

            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được thêm thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return redirect()->route('admin.category.index')->with('error', 'Thêm danh mục không thành công.');
        }
    }

    public function edit($id)
    {
        $category = $this->category->find($id);
        $htmlOption = $this->getCategory($category->parent_id);
        return view('users/admin/categories/edit', [
            'title' => 'Update Danh Mục',
            'category' => $category,
            'option' => $htmlOption
        ]);
    }

    public function update($id, CategoryAddRequest $request)
    {
        try {
            DB::beginTransaction();
            $category = $this->category->find($id);
            if (!$category) {
                throw new \Exception("Category not found with id: $id");
            }
            $dataCategoryCreate = [
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'description' => $request->description,
            ];

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $imageName);
                $dataCategoryCreate['image'] = $imageName;
            }

            $category->update($dataCategoryCreate);
            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Danh mục đã được cập nhật thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return redirect()->route('admin.category.index')->with('error', 'Cập nhật danh mục không thành công.');
        }
    }

    public function delete($id)
    {
        try {
            $category = $this->category->find($id);
            if (!$category) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Danh mục không tồn tại',
                ], 404);
            }

            $productCount = $category->products()->count();
            if ($productCount > 0) {
                return response()->json([
                    'code' => 400,
                    'message' => "Không thể xóa danh mục vì nó có $productCount sản phẩm liên quan.",
                ], 400);
            }

            $category->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Danh mục đã được xóa thành công',
            ], 200);
        } catch (\Exception $e) {
            Log::error("Lỗi: {$e->getMessage()} tại dòng {$e->getLine()}");
            return response()->json([
                'code' => 500,
                'message' => 'Đã xảy ra lỗi trong quá trình xóa.',
            ], 500);
        }
    }

}
