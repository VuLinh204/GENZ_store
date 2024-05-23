<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'unique:products',
            'category' => 'required|string',
            'description' => 'required|string',
            'price' => 'numeric',
            'percent_discount' => 'numeric',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Kiểm tra tệp ảnh, kích thước tối đa 5MB
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'category.required' => 'Vui lòng chọn danh mục',
            'description.required' => 'Vui lòng nhập mô tả',
            'price.numeric' => 'Nhập không chính xác. Vui lòng nhập số',
            'percent_discount.numeric' => 'Nhập không chính xác. Vui lòng nhập số',
            'img.required' => 'Vui lòng chọn một tệp hình ảnh',
            'img.image' => 'Tệp tải lên phải là một tệp hình ảnh',
            'img.mimes' => 'Chỉ chấp nhận tệp hình ảnh định dạng JPEG, PNG hoặc GIF',
            'img.max' => 'Kích thước tệp quá lớn. Vui lòng chọn một tệp nhỏ hơn 5MB',
        ];
    }
}
