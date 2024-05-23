@extends('users.admin.layout.admin')
@section('js')
    {{-- <script src="https://cdn.tiny.cloud/1/nymzs9hxuibktema7sjx487fimwtfztxjl0i7w89tsm04d1f/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script> --}}
    <script src="{{asset('admins/tinymce.min.js')}}"></script>
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

        <form action="{{ route('admin.slider.update', ['id' => $slider->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="ten">Tên Slider:</label>
                <input type="text" class="form-control" name="name" placeholder="Nhập tên Slider" required=""
                    value="{{ $slider->name }}">
            </div>
            <div class="form-group">
                <label for="description">Mô Tả:</label>
                <textarea class="form-control" name="description" id="" cols="30" rows="10"
                    placeholder="Nhập mô tả slider">{{ $slider->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="img">Hình ảnh:</label>
                <input type="file" name="img" class="form-control-file">
                <div class="col-md-12 mt-2">
                    <div class="row">
                        <img class="product_img" src="{{ $slider->img_path . $slider->img_name }}" alt="">
                    </div>
                </div>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="EDIT">
        </form>
    </div>
@endsection
