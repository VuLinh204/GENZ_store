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
<!--Container-->
@section('content')
    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-20">
            <div class="pull-left">
                <h4 class="text-blue h4">{{ $title }}</h4>
            </div>
        </div>

        <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="ten">Tên sản phẩm:</label>
                <input type="text" class="form-control" name="name"
                    placeholder="Nhập tên sản phẩm" required="" value="{{ $product->name }}">
            </div>
            <div class="form-group">
                <label for="category">Danh mục:</label>
                <select class="form-control" name="category" required>
                    <!-- Option để chọn danh mục -->
                    <option value="0" disabled selected>Chọn tên danh mục sản phẩm</option>
                    <!-- PHP code để lấy danh mục từ cơ sở dữ liệu và tạo các option tương ứng -->
                    {!! $option !!}
                </select>
            </div>
            <div class="form-group">
                <label for="namsinh">Mô tả:</label>
                <textarea class="form-control my-editor" name="description" id=""
                    cols="30" rows="10" placeholder="Nhập mô tả sảm phẩm" required>{{ $product->name }}</textarea>
            </div>
            <div class="form-group">
                <label for="sdt">Giá</label>
                <input type="text" class="form-control" name="price" required ="Nhập giá sản phẩm"
                    value="{{ $product->price }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sdt">Phần trăm chiết khấu</label>
                <input type="text" class="form-control" required name="percent_discount" placeholder="Nhập giá giảm"
                    value="{{ $product->percent_discount }}">
            </div>
            <div class="form-group">
                <label for="soluong">Số lượng</label>
                <input type="number" class="form-control" name="qty" value="{{ $product->quantity_sold }}" required>
            </div>
            <div class="form-group">
                <label for="namsinh">Hình ảnh sản phẩm:</label>
                <input type="file" name="img" class="form-control-file @error('img') is-invalid @enderror">
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @else
                    @if ($product->image)
                        <div class="col-md-12 mt-2">
                            <div class="row">
                                <img class="product_img" src="{{ asset('assets/img/' . $product->image) }}" alt="">
                            </div>
                        </div>
                    @endif
                @enderror
            </div>
            
            <input type="submit" name="submit" class="btn btn-primary" value="EDIT">
        </form>
    </div>
@endsection
