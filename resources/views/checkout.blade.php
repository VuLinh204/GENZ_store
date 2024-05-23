@extends('main')
@section('content')
<!-- App container -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column">
                <div class="container">
                    <!-- Kiểm tra và hiển thị thông báo -->
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
                    <section class="shopping-cart">
                        <div class="container">
                            <div class="grid__row">
                                <div class="grid__column">
                                    <h2>Thanh Toán</h2>
                                    <div class="cart-actions">
                                        @if($carts->isEmpty())
                                        <img src="{{ asset('assets/img/no-cart.webp') }}" alt="No-cart">
                                        <a href="{{route('user.product')}}" class="button buy-now-btn">Mua Thêm</a>
                                        @else
                                    </div>
                                    <table class="cart-table">
                                        <tbody>
                                            <tr>
                                                <th>Hình Ảnh</th>
                                                <th>Tên</th>
                                                <th>Mã Sản Phẩm</th>
                                                <th style="padding-left: 10px; padding-right: 10px;">Size</th>
                                                <th style="padding-left: 10px; padding-right: 10px;">Color</th>
                                                <th>Đơn Giá (VND)</th>
                                                <th>Số Lượng</th>
                                                <th>Số Tiền (VND)</th>
                                                <th>Thao Tác</th>
                                            </tr>
                                            @php
                                            $totalQuantity = 0;
                                            $totalPrice = 0;
                                            @endphp
                                            @foreach($carts as $cart)
                                            @php
                                            $totalQuantity += $cart->quantity;
                                            $newPrice = $cart->product->price - ($cart->product->price * $cart->product->percent_discount / 100);
                                            $totalPrice += $cart->quantity * $newPrice;
                                            @endphp
                                            <tr class="cart-item" data-product-id="{{ $cart->product->id }}">
                                                <td><a href="{{ route('user.detail', ['id' => $cart->product->id]) }}"><img src="{{ asset('assets/img/' . $cart->product->image) }}" alt="Product Image" style="width: 100px;"></a></td>
                                                <td><a href="{{ route('user.detail', ['id' => $cart->product->id]) }}">{{ $cart->product->name }}</a></td>
                                                <td>{{ $cart->product->id }}</td>
                                                <td style="padding-left: 10px; padding-right: 10px;">{{ $cart->size }}</td>
                                                <td style="padding-left: 10px; padding-right: 10px;">{{ $cart->color }}</td>
                                                <td class="price">{{ number_format($newPrice) }}</td>
                                                <td>
                                                    <form action="{{ route('user.cart.update', ['cartId' => $cart->id]) }}" method="POST">
                                                        @csrf
                                                        <button class="quantity-btn" type="submit" name="change" value="-1"><i class="fas fa-minus"></i></button>
                                                        <span class="quantity">{{ $cart->quantity }}</span>
                                                        <button class="quantity-btn" type="submit" name="change" value="1"><i class="fas fa-plus"></i></button>
                                                    </form>
                                                </td>
                                                <td class="total">{{ number_format($cart->quantity * $newPrice) }}</td>
                                                <td>
                                                    <form action="{{ route('user.cart.remove', ['cartId' => $cart->id]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="remove-item">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="text-right">Tổng Số Lượng Sản Phẩm:</td>
                                                <td colspan="2" id="total-quantity">{{ $totalQuantity }}</td>
                                                <td colspan="2">Tổng Số Tiền:</td>
                                                <td colspan="2"><strong id="total-price">{{ number_format($totalPrice) }}</strong></td>
                                                <td>
                                                    <form action="{{route('user.checkout.vnpay')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="amount" value="{{ $totalPrice }}">
                                                        <button type="submit" class="button checkout-btn">Thanh Toán</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection