@extends('main')
@section('content')

<!-- tất cả sản phẩm -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column">
                <div class="container">
                    <h1>Tất cả sản phẩm</h1>
                    <div class="grid__row">
                        @foreach ($products as $product)
                        <div class="grid__column-2-4">
                            <a class="home-product-item" href="{{ route('user.detail', ['id' => $product->id]) }}">
                                @php
                                $isFavorited = false;
                                $imageUrl = asset('assets/img/' . $product->image);
                                $newPrice = $product->price - ($product->price * $product->percent_discount / 100);
                                foreach ($favoriteProducts as $favoriteProduct) {
                                if ($favoriteProduct->product_id === $product->id && $favoriteProduct->is_favorite) {
                                $isFavorited = true;
                                break;
                                }
                                }
                                @endphp
                                <div class="home-product-item__img" style="background-image: url('{{ $imageUrl }}');"></div>
                                <h4 class="home-product-item__name">{{ $product->name }}</h4>
                                <div class="home-product-item__price">
                                    <span class="home-product-item__price-old">{{ number_format($product->price) }}</span>
                                    <span class="home-product-item__price-current"></span>
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
                                    <span class="home-product-item__sold">{{ $product->quantity_sold }} Đã bán</span>
                                </div>
                                <div class="home-product-item__origin">
                                    <span class="home-product-item__brand">GenZ</span>
                                    <span class="home-product-item__origin-name">Việt Nam</span>
                                </div>
                                <div class="home-product-item__favourite">
                                    <i class="fa-solid fa-check"></i>
                                    <span>Yêu thích</span>
                                </div>
                                @if( $product->percent_discount > 0 )
                                <div class="home-product-item__sale-off">
                                    <span class="home-product-item__sale-off-percent">{{ number_format($product->percent_discount) }}%</span>
                                    <span class="home-product-item__sale-off-label">GIẢM</span>
                                </div>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <!-- Hiển thị số trang theo số thứ tự -->
                    <div class="home-pagination">
                        <!-- Nút Trước -->
                        @if ($currentPage > 1)
                        <a href="{{ route('user.all-products', ['page' => $currentPage - 1, 'sort' => request()->input('sort')]) }}">
                            < </a>
                                @endif

                                <!-- Hiển thị số trang -->
                                @for ($i = 1; $i <= $totalPages; $i++) <a href="{{ route('user.all-products', ['page' => $i, 'sort' => request()->input('sort')]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}
                        </a>
                        @endfor

                        <!-- Nút Sau -->
                        @if ($currentPage < $totalPages) <a href="{{ route('user.all-products', ['page' => $currentPage + 1, 'sort' => request()->input('sort')]) }}"> > </a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
