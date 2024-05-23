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
                            <a href="#" class="manager-item__link active">Đơn Mua</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.voucher') }}" class="manager-item__link">Voucher</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="grid__column-10">
                <!-- Main content -->
                <div class="container__order">
                    <h1>{{ $title }}</h1>
                    <!-- Order list -->
                    <table class="purchase-table">
                        <thead>
                            <tr>
                                <th>Mã Đơn Hàng</th>
                                <th>Tổng Số Tiền</th>
                                <th>Trạng Thái</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="purchase-item">
                                <td>{{ $order->id }}</td>
                                <td>{{number_format($order->total_amount) }}</td>
                                <td>{{ $order->status }}</td>
                                <!-- Link to view order details -->
                                <td><a href="{{ route('user.order', ['order' => $order->id]) }}" class="btn btn--primary">Xem Chi Tiết</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
