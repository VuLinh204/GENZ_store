<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAddRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributesProduct;
use App\Components\Recusive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductAdminController extends Controller
{
    private $category;
    private $product;
    private $attri;

    public function __construct(Category $category, Product $product, AttributesProduct $attri)
    {
        $this->category = $category;
        $this->product = $product;
        $this->attri = $attri;
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');

        if (!empty($keyword)) {
            $products = $this->product->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                ->latest()->paginate(5);
        } else {
            $products = $this->product->latest()->paginate(5);
        }

        $title = 'DANH SÁCH SẢN PHẨM';

        return view('users/admin/products/listproduct', compact('products', 'keyword', 'title'));
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
        $color = $this->attri::where('name', 'color')->get();
        $size = $this->attri::where('name', 'size')->get();
        return view('users/admin/products/addproduct', [
            'title' => 'THÊM SẢN PHẨM',
            'option' => $htmlOption,
            'colors' => $color,
            'sizes' => $size
        ]);
    }

    public function store(ProductAddRequest $request)
    {
        try {
            DB::beginTransaction();

            $dataProductCreate = [
                'name' => $request->name,
                'cate_id' => $request->category,
                'description' => $request->description,
                'price' => $request->price,
                'percent_discount' => $request->percent_discount,
                'quantity_sold' => $request->qty,
            ];

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $imageName);
                $dataProductCreate['image'] = $imageName;
            }

            $this->product->create($dataProductCreate);

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được thêm thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return redirect()->route('admin.product.index')->with('error', 'Thêm sản phẩm không thành công.');
        }
    }

    public function edit($id)
    {
        $product = $this->product->find($id);
        $htmlOption = $this->getCategory($product->cate_id);
        return view('users/admin/products/edit', [
            'title' => 'Update Sản Phẩm',
            'product' => $product,
            'option' => $htmlOption
        ]);
    }

    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $dataProductUpdate = [
                'name' => $request->name,
                'cate_id' => $request->category,
                'description' => $request->description,
                'price' => $request->price,
                'percent_discount' => $request->percent_discount,
                'quantity_sold' => $request->qty,
            ];

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $imageName);
                $dataProductUpdate['image'] = $imageName;
            }

            $this->product->find($id)->update($dataProductUpdate);

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được cập nhật thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return redirect()->route('admin.product.index')->with('error', 'Cập nhật sản phẩm không thành công.');
        }
    }

    public function delete($id)
    {
        try {
            $product = $this->product->find($id);
            if (!$product) {
                return response()->json([
                    'code' => 404,
                    'message' => 'Sản phẩm không tồn tại'
                ], 404);
            }

            // Xóa ảnh từ thư mục public/assets/img
            if ($product->image) {
                $imagePath = public_path('assets/img/' . $product->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Xóa bản ghi từ cơ sở dữ liệu
            $product->delete();

            return response()->json([
                'code' => 200,
                'message' => 'Xóa sản phẩm thành công'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Lỗi khi xóa sản phẩm'
            ], 500);
        }
    }
}
