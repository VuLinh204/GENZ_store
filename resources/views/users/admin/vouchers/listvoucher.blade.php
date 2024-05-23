@extends('users.admin.layout.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('admins/voucher/index/list.css') }}">
<style>
    /* Kiểm tra CSS nội tuyến */
    .test-css {
        background-color: yellow;
    }
</style>
@endsection

@section('js')
<script src="{{ asset('admins/sweetalert2@11.js') }}"></script>
<script src="{{ asset('admins/voucher/index/list.js') }}"></script>
<script>
    // Kiểm tra JS nội tuyến
    console.log('JS đã được tải');
</script>
@endsection

<!--Container-->
@section('search')
<div class="header-left mb-5">
    <div class="header-search">
        <form action="{{ route('admin.vouchers.index') }}" method="GET">
            <div class="form-group mb-0">
                <i class="dw dw-search2 search-icon"></i>
                <input type="text" class="form-control search-input" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Tìm kiếm" />
            </div>
        </form>
    </div>
</div>
@endsection

@section('content')
<div class="pd-20 card-box mb-30">
    <div class="clearfix mb-20">
        <div class="pull-left">
            <h4 class="text-blue h4">{{ $title }}</h4>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="pull-right mt-5">
            <a href="{{ route('admin.vouchers.create') }}" class="add_voucher"><i class="fa-solid fa-square-plus"></i> ADD</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Discount Amount</th>
                    <th>Valid From</th>
                    <th>Valid Until</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->id }}</td>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $voucher->discount_amount }}</td>
                    <td>{{ $voucher->valid_from }}</td>
                    <td>{{ $voucher->valid_until }}</td>
                    <td>
                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.vouchers.delete', $voucher->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $vouchers->links() }} <!-- Hiển thị phân trang -->
    </div>
</div>
@endsection