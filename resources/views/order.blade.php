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
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    <button class="close" onclick="closeAlert()">&times;</button>
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ Session::get('error') }}</li>
                    </ul>
                    <button class="close" onclick="closeAlert()">&times;</button>
                </div>
                @endif
                <!-- content -->
                <div class="container order-summary-container">
                    <h1>Tóm Tắt Đơn Hàng</h1>
                    <div class="order-details">
                        <p><strong>Mã Đơn Hàng:</strong> {{ $order->id }}</p>
                        <p><strong>Tổng Số Tiền:</strong> {{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
                        <p><strong>Trạng Thái:</strong> {{ ucfirst($order->status) }}</p>
                    </div>
                    <h2>Danh Sách Sản Phẩm</h2>
                    <ul class="order-items-list">
                        @foreach($order->items as $item)
                        <li>
                            <span class="item-name">{{ $item->product->name }}</span>
                            <span class="item-quantity">Số Lượng: {{ $item->quantity }}</span>
                            <span class="item-price">Giá: {{ number_format($item->price, 0, ',', '.') }} VND</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>

@endsection
