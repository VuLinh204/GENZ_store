<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'code' => 'required|unique:vouchers,code,' . $this->voucher,
            'discount_amount' => 'required|numeric',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã voucher là bắt buộc.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'discount_amount.required' => 'Số tiền giảm giá là bắt buộc.',
            'discount_amount.numeric' => 'Số tiền giảm giá phải là số.',
            'valid_from.date' => 'Ngày bắt đầu phải là ngày hợp lệ.',
            'valid_until.date' => 'Ngày kết thúc phải là ngày hợp lệ.',
        ];
    }
}
