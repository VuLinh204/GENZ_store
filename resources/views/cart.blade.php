@extends('main')
@section('content')
<!-- sidebar -->
<!-- App container -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column">
                <!-- content -->
                <section class="shopping-cart">
                    <h2>Giỏ Hàng</h2>
                    <div class="cart-actions">
                        @if($carts->isEmpty())
                        <img src="{{ asset('assets/img/no-cart.webp') }}" alt="No-cart">
                        <a href="{{route('user.product')}}" class="button buy-now-btn">Mua Ngay</a>
                        @else
                        <table class="cart-table">
                            <thead>
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
                            </thead>
                            <tbody>
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
                                <tr class="cart-item" id="cart-item-{{ $cart->id }}">
                                    <td><a href="{{ route('user.detail', ['id' => $cart->product->id]) }}"><img src="{{ asset('assets/img/' . $cart->product->image) }}" alt="Product Image" style="width: 100px;"></a></td>
                                    <td><a href="{{ route('user.detail', ['id' => $cart->product->id]) }}">{{ $cart->product->name }}</a></td>
                                    <td>{{ $cart->product->id }}</td>
                                    <td style="padding-left: 10px; padding-right: 10px;">{{ $cart->size }}</td>
                                    <td style="padding-left: 10px; padding-right: 10px;">{{ $cart->color }}</td>
                                    <td class="price">{{ number_format($newPrice) }}</td>
                                    <td>
                                        <button id="reduce-{{$cart->id}}" class="quantity-btn" type="submit" name="change" value="-1"><i class="fas fa-minus"></i></button>
                                        <span id="product_qty-{{ $cart->id }}" class="quantity">{{ $cart->quantity }}</span>
                                        <button id="increase-{{$cart->id}}" class="quantity-btn" type="submit" name="change" value="1"><i class="fas fa-plus"></i></button>
                                    </td>
                                    <td class="total item-total">{{ number_format($cart->quantity * $newPrice) }}</td>
                                    <td>
                                        <button id="remove-{{$cart->id}}" class="remove-item">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" class="text-right">Tổng Số Lượng Sản Phẩm:</td>
                                    <td colspan="2" id="total-quantity">{{ $totalQuantity }}</td>
                                    <td colspan="2">Tổng Số Tiền:</td>
                                    <td colspan="2"><strong id="total-price">{{ number_format($totalPrice) }}</strong></td>
                                    <td>
                                        <form method="POST" action="{{ route('user.checkout') }}">
                                            @csrf
                                            <button type="submit" class="button checkout-btn">Thanh Toán</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                </section>
                <!-- Relate products -->
                <section class="related-products">
                    <div class="container">
                        <div class="more">
                            <h2 class="related-products__title"> Có thể bạn sẽ thích </h2>
                            <a href="{{ route('user.all-products') }}" class="btn-more">Xem Thêm<i style="padding-left: 6px;" class="fa-solid fa-arrow-right"></i></a>
                        </div>
                        <div class="grid__row">
                            @foreach($relatedProducts as $row)
                            <!-- Product item -->
                            <div class="grid__column-2-4">
                                <a class="home-product-item" href="{{ route('user.detail', ['id' => $row->id]) }}">
                                    @php
                                    $isFavorited = false;
                                    $imageUrl = asset('assets/img/' . $row->image);
                                    $newPrice = $row->price - ($row->price * $row->percent_discount / 100);
                                    foreach ($favoriteProducts as $favoriteProduct) {
                                    if ($favoriteProduct->product_id === $row->id && $favoriteProduct->is_favorite) {
                                    $isFavorited = true;
                                    break;
                                    }
                                    }
                                    @endphp
                                    <div class="home-product-item__img" style="background-image: url('{{ $imageUrl }}');"></div>
                                    <h4 class="home-product-item__name">{{ $row->name }}</h4>
                                    <div class="home-product-item__price">
                                        <span class="home-product-item__price-old">{{ number_format($row->price) }}</span>
                                        <span class="home-product-item__price-current">{{ number_format($newPrice) }}</span>
                                    </div>
                                    <div class="home-product-item__action">
                                        @if($isFavorited)
                                        <span class="home-product-item__like home-product-item__like--liked">
                                            <i class="home-product-item__like-icon-empty fa-regular fa-heart"></i>
                                            <i class="home-product-item__like-icon-fill fa-solid fa-heart"></i>
                                        </span>
                                        @endif
                                        <div class="home-product-item__rating">
                                            <i class="home-product-item__star--gold fa-solid fa-star"></i>
                                            <i class="home-product-item__star--gold fa-solid fa-star"></i>
                                            <i class="home-product-item__star--gold fa-solid fa-star"></i>
                                            <i class="home-product-item__star--gold fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                        </div>
                                        <span class="home-product-item__sold">{{ $row->quantity_sold }} Đã bán</span>
                                    </div>
                                    <div class="home-product-item__origin">
                                        <span class="home-product-item__brand">GenZ</span>
                                        <span class="home-product-item__origin-name">Việt Nam</span>
                                    </div>
                                    <div class="home-product-item__favourite">
                                        <i class="fa-solid fa-check"></i>
                                        <span>Yêu thích</span>
                                    </div>
                                    @if( $row->percent_discount > 0 )
                                    <div class="home-product-item__sale-off">
                                        <span class="home-product-item__sale-off-percent">{{ number_format($row->percent_discount) }}%</span>
                                        <span class="home-product-item__sale-off-label">GIẢM</span>
                                    </div>
                                    @endif
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <br>
            </div>
        </div>
    </div>
</div>


<!-- Ajax (Minus & Plus) -->
<script>
    $(document).ready(function() {

        function updateTotal() {
            var totalQuantity = 0;
            var totalPrice = 0;

            // Duyệt qua từng dòng trong bảng giỏ hàng
            $('.cart-item').each(function() {
                var quantity = parseInt($(this).find('.quantity').text());
                var price = parseInt($(this).find('.price').text().replace(/\D/g, '')); // Loại bỏ ký tự không phải số
                var total = quantity * price;
                totalQuantity += quantity;
                totalPrice += quantity * price;

                // Cập nhật giá trị mới cho từng mặt hàng
                $(this).find('.item-total').text(numberWithCommas(total));
            });

            // Cập nhật tổng số tiền và tổng số lượng sản phẩm trên trang
            $('#total-price').text(numberWithCommas(totalPrice));
            $('#total-quantity').text(totalQuantity);
        }

        function onTogglePlus() {
            var cartId = $(this).attr('id').split('-')[1];
            $.ajax({
                url: "/user/cart/update/" + cartId,
                type: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    change: 1
                },
                success: function() {
                    var $quantity = $("#product_qty-" + cartId);
                    var newQuantity = parseInt($quantity.text()) + 1;
                    $quantity.text(newQuantity);
                    updateTotal();
                },
            })
        }

        function onToggleMinus() {
            var cartId = $(this).attr('id').split('-')[1];
            $.ajax({
                url: "/user/cart/update/" + cartId,
                type: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    change: -1
                },
                success: function() {
                    var $quantity = $("#product_qty-" + cartId);
                    var newQuantity = parseInt($quantity.text()) - 1;
                    $quantity.text(newQuantity >= 1 ? newQuantity : 1);
                    updateTotal();
                },

            })
        }
        $(".quantity-btn").click(function() {
            var action = $(this).val();
            if (action == "1") {
                onTogglePlus.call(this);
            } else if (action == "-1") {
                onToggleMinus.call(this);
            }
        });
        $(".remove-item").click(function() {
            var cartId = $(this).attr('id').split('-')[1];
            $.ajax({
                url: "/user/cart/remove/" + cartId,
                type: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Xóa dòng sản phẩm khỏi bảng giỏ hàng
                    $("#cart-item-" + cartId).remove();
                    // Cập nhật tổng số tiền và tổng số lượng sản phẩm trên trang
                    updateTotal();
                }
            });
        });
    })

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endsection
