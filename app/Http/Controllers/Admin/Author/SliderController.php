<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\SliderAddRequest;


class SliderController extends Controller
{
    private $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ yêu cầu
        $keyword = $request->input('keyword', '');

        // Nếu có từ khóa, tìm kiếm theo tên danh mục hoặc mô tả
        if (!empty($keyword)) {
            $sliders = $this->slider->where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                ->latest()->paginate(10); // Thực hiện phân trang
        } else {
            $sliders = $this->slider->latest()->paginate(10); // Trường hợp không có từ khóa, trả về tất cả
        }
        $title = 'DANH SÁCH CÁC DANH MỤC';
        // Trả về view với dữ liệu danh mục đã tìm kiếm
        return view('users/admin/slider/index', compact('sliders', 'keyword', 'title'));
    }

    public function create()
    {
        return view('users/admin/slider/add', [
            'title' => 'ADD',
        ]);
    }

    public function store(SliderAddRequest $request)
    {
        try {
            $dataInsert = [
                'name' => $request->name,
                'description' => $request->description,
            ];

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = 'assets/img/';
                $file->move(public_path('assets/img'), $filename);
                $dataInsert['img_name'] = $filename;
                $dataInsert['img_path'] = $filePath;
            }

            $this->slider->create($dataInsert);
            return redirect()->route('admin.slider.index')->with('success', 'Slider đã được thêm thành công.');
        } catch (\Exception $exception) {
            Log::error('Lỗi:' . $exception->getMessage() . '---Line :' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $slider = $this->slider->find($id);
        return view('users/admin/slider/edit', [
            'title' => 'Update Slider',
            'slider' => $slider,
        ]);
    }

    public function update($id, SliderAddRequest $request)
    {
        try {
            DB::beginTransaction();
            $slider = $this->slider->find($id);
            $dataSliderUpdate = [
                'name' => $request->name,
                'description' => $request->description,
            ];

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = 'assets/img/';
                $file->move(public_path('assets/img'), $filename);
                // Delete old image
                if ($slider->img_name) {
                    unlink(public_path($slider->img_path . $slider->img_name));
                }
                $dataSliderUpdate['img_name'] = $filename;
                $dataSliderUpdate['img_path'] = $filePath;
            }

            $slider->update($dataSliderUpdate);
            DB::commit();
            return redirect()->route('admin.slider.index')->with('success', 'Slider đã được update thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
        }
    }

    
    public function delete($id)
    {
        try {
            $slider = $this->slider->find($id);
            if ($slider->img_name) {
                $imagePath = public_path('assets/img/' . $slider->img_name);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $slider->delete();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
