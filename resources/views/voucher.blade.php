@extends('main')

@section('content')
<!-- App container -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column-2">
                <nav class="manager">
                    <h3 class="manager__heading">{{ $title }}</h3>
                    <ul class="manager-list">
                        <li class="manager-item">
                            <a href="{{ route('user.profile', ['id' => $currentUser->id]) }}" class="manager-item__link">Tài khoản của tôi</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.password', ['id' => $currentUser->id]) }}" class="manager-item__link">Mật khẩu</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.purchase') }}" class="manager-item__link">Đơn mua</a>
                        </li>
                        <li class="manager-item">
                            <a href="{{ route('user.voucher', ['id' => $currentUser->id]) }}" class="manager-item__link active">Voucher</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="grid__column-10">
                <!-- content -->
                <br>
                <h2>Danh Sách Voucher</h2>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($vouchers->isEmpty())
                    <p>Không có voucher nào.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Code</th>
                                <th>Số tiền giảm giá</th>
                                <th>Hiệu lực từ</th>
                                <th>Hiệu lực đến</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $voucher)
                                <tr>
                                    <td>{{ $voucher->id }}</td>
                                    <td>{{ $voucher->code }}</td>
                                    <td>{{ $voucher->discount_amount }}</td>
                                    <td>{{ $voucher->valid_from }}</td>
                                    <td>{{ $voucher->valid_until }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
