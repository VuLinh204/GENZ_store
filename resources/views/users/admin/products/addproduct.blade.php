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
    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-20">
            <div class="pull-left">
                <h4 class="text-blue h4">{{ $title }}</h4>
            </div>
        </div>

        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="ten">Tên sản phẩm:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    placeholder="Nhập tên sản phẩm" required value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Danh mục:</label>
                <select class="form-control @error('category') is-invalid @enderror" name="category" required>
                    <option value="" disabled selected>Chọn tên danh mục sản phẩm</option>
                    {!! $option !!}
                </select>
                @error('category')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="namsinh">Mô tả:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                    cols="30" rows="10" placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Giá:</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                    placeholder="Nhập giá sản phẩm" required value="{{ old('price') }}">
                @error('price')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sdt">Phần trăm chiết khấu</label>
                <input type="text" class="form-control @error('percent_discount') is-invalid @enderror"
                    name="percent_discount" placeholder="Nhập phần trăm chiết khấu" value="{{ old('percent_discount') }}"
                    required>
                @error('percent_discount')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="sdt">Phần trăm chiết khấu</label>
                <input type="text" class="form-control @error('percent_discount') is-invalid @enderror"
                    name="percent_discount" placeholder="Nhập phần trăm chiết khấu" value="{{ old('percent_discount') }}"
                    required>
                @error('percent_discount')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- <div class="form-group">
                <label for="sdt">Size</label>
                <input type="text" class="form-control @error('percent_discount') is-invalid @enderror" name="percent_discount"
                    placeholder="Nhập phần trăm chiết khấu" value="{{ old('percent_discount') }}" required>
                @error('percent_discount')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div> --}}
            {{-- <div class="form-group">
                <label for="">Màu sắc</label><br>
                @foreach($colors as $data)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="{{$data->id}}" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        {{$data->value}}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="">Kích thước</label><br>
                @foreach($sizes as $data)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="{{$data->id}}" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        {{$data->value}}
                    </label>
                </div>
                @endforeach
            </div> --}}
            <div class="form-group">
                <label for="namsinh">Hình ảnh sản phẩm:</label>
                <input type="file" name="img" class="form-control-file" required>
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="THÊM">
        </form>
    </div>
@endsection
