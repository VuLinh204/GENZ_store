<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderAddRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'img.image' => 'Tệp tải lên phải là một tệp hình ảnh',
            'img.mimes' => 'Chỉ chấp nhận tệp hình ảnh định dạng JPEG, PNG hoặc GIF',
            'img.max' => 'Kích thước tệp quá lớn. Vui lòng chọn một tệp nhỏ hơn 5MB',
        ];
    }
}
