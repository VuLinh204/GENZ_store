@extends('main')
@section('content')
<!-- sidebar -->

<!-- App container -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column-2">
                <nav class="manager">
                    <h3 class="manager__heading">{{ $title }}</h3>
                    <ul class="manager-list">
                        <li class="manager-item">
                            <a href="{{route('user.profile', ['id' => $currentUser->id])}}" class="manager-item__link">Tài khoản của tôi</a>
                        </li>
                        <li class="manager-item">
                            <a href="#" class="manager-item__link active">Mật Khẩu</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.purchase') }}" class="manager-item__link">Đơn Mua</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.voucher') }}" class="manager-item__link">Mã Giảm Giá</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="grid__column-10">
                <!-- content -->
                <!-- Show success from controller -->
                @if (session('success'))
                <div class="alert alert-success" style="margin-left: 40px;">
                    {{ session('success') }}
                    <button class="close" onclick="closeAlert()">
                        &times;
                    </button>
                </div>
                @endif

                <!-- Show error from controller -->
                @if (session('error'))
                <div class="alert alert-danger" style="margin-left: 40px;">
                    {{ session('error') }}
                    <button class="close" onclick="closeAlert()">
                        &times;
                    </button>
                </div>
                @endif

                <!-- Show validation errors -->
                @if ($errors->any())
                <div class="alert alert-danger" style="margin-left: 40px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="close" onclick="closeAlert()">
                        &times;
                    </button>
                </div>
                @endif
                <form class="password" action="{{ route('user.password', ['id' => $currentUser->id]) }}" method="POST" enctype="multipart/form-data">
                    <h1>Đổi Mật Khẩu</h1>
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ $currentUser->email }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="old_password">Nhập Mật Khẩu Hiện Tại</label>
                        <input type="password" id="old_password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Nhập Mật Khẩu Mới:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Nhập Lại Mật Khẩu Mới:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button class="btn btn--primary" type="submit">Đổi Mật Khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
