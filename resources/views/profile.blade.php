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
                            <a href="#" class="manager-item__link active">Tài Khoản Của Tôi</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.password', ['id' => $currentUser->id])}}" class="manager-item__link">Mật Khẩu</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.purchase') }}" class="manager-item__link">Đơn Mua</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.voucher') }}" class="manager-item__link">Voucher</a>
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
                <form class="profile" action="{{ route('user.profile', ['id' => $currentUser->id]) }}" method="POST" enctype="multipart/form-data">
                    <h1>Thông Tin Tài Khoản</h1>
                    @csrf
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="{{ $currentUser->email }}" hidden required>
                        <input type="email" name="email" value="{{ $currentUser->email }}" disabled required>
                    </div>
                    <div class="form-group">
                        <label for="name">Họ và Tên:</label>
                        <input type="text" id="name" name="name" value="{{ $currentUser->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại:</label>
                        <input type="text" id="phone" name="phone" value="{{ $currentUser->customer->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Địa Chỉ:</label>
                        <input type="text" id="address" name="address" value="{{ $currentUser->customer->address }}" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Ảnh Đại Diện:</label>
                        @php
                        $imageUrl = asset('assets/img/' . $currentUser->customer->image);
                        @endphp
                        @if ($currentUser->customer->image)
                        <div class="profile__avatar" style="background-image: url('{{ $imageUrl }}');"></div>
                        @else
                        <p>Không có ảnh đại diện</p>
                        @endif
                        <input type="file" id="image" name="image">
                        <button class="btn btn--primary" type="submit">Cập Nhật Thông Tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
