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

        <form action="{{ route('admin.category.update', ['id' => $category->id]) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên Danh Mục</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    placeholder="Nhập tên danh mục" value="{{ $category->name }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Chọn Danh Mục Cha</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id">
                    <!-- Option để chọn danh mục -->
                    <option value="0"></option>
                    {!! $option !!}
                    <!-- PHP code để lấy danh mục từ cơ sở dữ liệu và tạo các option tương ứng -->
                </select>
                @error('parent_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" cols="50" rows="10" name="description">{{ $category->description }}</textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="img">Hình ảnh :</label>
                <input type="file" name="img" class="form-control-file @error('img') is-invalid @enderror">
                @error('img')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="col-md-12 mt-2">
                    <div class="row">
                        <img class="product_img" src="{{ asset('assets/img/' . $category->image) }}" alt="">
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Edit">
        </form>
    </div>
@endsection
