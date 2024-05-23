<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAddRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->route('id'),
            'parent_id' => 'required|integer',
            'description' => 'required|string',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'slug' => 'nullable|string'
        ];      
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'parent_id.required' => 'Vui lòng chọn danh mục cha.',
            'parent_id.integer' => 'Danh mục cha không hợp lệ.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'img.image' => 'Tệp tải lên phải là một tệp hình ảnh.',
            'img.mimes' => 'Chỉ chấp nhận tệp hình ảnh định dạng JPEG, PNG, JPG, hoặc GIF.',
            'img.max' => 'Kích thước tệp quá lớn. Vui lòng chọn một tệp nhỏ hơn 5MB.',
        ];
    }
}
