<?php

namespace App\Http\Controllers\Admin\Author;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Http\Requests\VoucherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoucheradminController extends Controller
{
    private $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    public function index(Request $request)
    {
        $title = 'DANH SÁCH VOUCHER';
        $vouchers = Voucher::all();
        $vouchers = $this->voucher->latest()->paginate(10);
        return view('users.admin.vouchers.listvoucher', compact('vouchers', 'title'));
    }

    public function create()
    {
        return view('users.admin.vouchers.addvoucher', ['title' => 'Thêm voucher']);
    }

    public function store(VoucherRequest $request)
    {
        try {
            DB::beginTransaction();
            $dataVoucherCreate = [
                'code' => $request->code,
                'discount_amount' => $request->discount_amount,
                'valid_from' => $request->valid_from,
                'valid_until' => $request->valid_until,
            ];
            $voucher = $this->voucher->create($dataVoucherCreate);
            DB::commit();
            return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được thêm thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return redirect()->route('admin.vouchers.index')->with('error', 'Thêm voucher không thành công.');
        }
    }

    public function edit(Voucher $voucher)
    {
        return view('users.admin.vouchers.edit', compact('voucher'));
    }

    public function update(Voucher $voucher, Request $request)
    {
        try {
            DB::beginTransaction();
            $dataVoucherUpdate = [
                'code' => $request->code,
                'discount_amount' => $request->discount_amount,
                'valid_from' => $request->valid_from,
                'valid_until' => $request->valid_until,
            ];
            $voucher->update($dataVoucherUpdate);
            DB::commit();
            return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được cập nhật thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return redirect()->route('admin.vouchers.index')->with('error', 'Cập nhật voucher không thành công.');
        }
    }

    public function destroy($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();
            return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được xóa thành công.');
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . '   Line: ' . $exception->getLine());
            return redirect()->route('admin.vouchers.index')->with('error', 'Xóa voucher không thành công.');
        }
    }
}
