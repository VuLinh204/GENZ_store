@extends('users.admin.layout.admin')

@section('js')
    {{-- <script src="https://cdn.tiny.cloud/1/nymzs9hxuibktema7sjx487fimwtfztxjl0i7w89tsm04d1f/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script> --}}
    <script src="{{ asset('admins/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea[name="description"]',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Thêm Voucher Mới</h2>
                <form action="{{ route('admin.vouchers.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="code">Mã Voucher</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_amount">Số Tiền Giảm</label>
                        <input type="number" class="form-control" id="discount_amount" name="discount_amount" required>
                    </div>
                    <div class="form-group">
                        <label for="valid_from">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="valid_from" name="valid_from">
                    </div>
                    <div class="form-group">
                        <label for="valid_until">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="valid_until" name="valid_until">
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm Voucher</button>
                </form>
            </div>
        </div>
    </div>
@endsection
