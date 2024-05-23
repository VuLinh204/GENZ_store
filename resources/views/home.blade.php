@extends('main')
@section('content')


<div class="app">
    <!-- sidebar -->
    
    <!-- Banner section -->
    <div class="app__banner">
        <div class="grid wide">
            <div class="row sm-gutter app__banner-content">
                <div class="col l-8 m-12 c-12">
                    <div class="full-home-banners__main">
                        <div class="full-home-banners__main-inner">
                            @foreach($sliders as $key => $slider)
                            <a href="" class="full-home-banners__main-item {{$key == 0 ? 'active' : ''}}">
                                <img src="{{ asset($slider->img_path . $slider->img_name) }}" alt="{{ $slider->name }}">
                            </a>
                            @endforeach
                        </div>
                        <div class="full-home-banners__main-controls">
                            <i class="carosel-btn-left fa-solid fa-angle-left"></i>
                            <i class="carosel-btn-right fa-solid fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($currentUser)
    <!-- App container -->
    <div class="app__container">
        <div class="grid">
            <div class="grid__row app__content">
                <div class="grid__column">
                    <div style="color: var(--primary-color); font-size: 3rem; text-align: center; height: 50px;">Danh Mục</div>
                    <div class="home__category">
                        <div class="home__category-item-list">
                            @foreach($categories as $category)
                            <a href="{{ route('products.by.category', ['category' => $category->id]) }}" class="home__category-item">
                                @php
                                $imageUrl = asset('assets/img/' . $category->image);
                                @endphp
                                <div class="home__category-image" style="background-image: url('{{ $imageUrl }}');" alt="Product Image"></div>
                                <div class="home__category-name">
                                    {{ $category->name }}
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div style="color: var(--primary-color); font-size: 3rem; text-align: center; height: 50px;">Gợi ý hôm nay</div>
                    <hr style="background-color: var(--primary-color); border: 0; height: 10px;">
                    <div class="home-product">

                        <div class="grid__row">

                            @foreach($data as $row)
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
                    <!-- Hiển thị số trang theo số thứ tự -->
                    <div class="home-pagination">
                        <!-- Nút Trước -->
                        @if ($currentPage > 1)
                        <a href="{{ route('user.home', ['page' => $currentPage - 1, 'sort' => request()->input('sort')]) }}">
                            < @endif <!-- Hiển thị số trang -->
                                @for ($i = 1; $i <= $totalPages; $i++) <a href="{{ route('user.home', ['page' => $i, 'sort' => request()->input('sort')]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}
                        </a>
                        @endfor

                        <!-- Nút Sau -->
                        @if ($currentPage < $totalPages) <a href="{{ route('user.home', ['page' => $currentPage + 1, 'sort' => request()->input('sort')]) }}"> > </a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guest -->
    @else
    <!-- App container -->
    <div class="app__container">
        <div class="grid">
            <div class="grid__row app__content">
                <div class="grid__column">
                    <div style="color: var(--primary-color); font-size: 3rem; text-align: center; height: 50px;">Danh Mục</div>
                    <div class="home__category">
                        <div class="home__category-item-list">
                            @foreach($categories as $category)
                            <a href="{{ route('guest.products.by.category', ['category' => $category->id]) }}" class="home__category-item">
                                @php
                                $imageUrl = asset('assets/img/' . $category->image);
                                @endphp
                                <div class="home__category-image" style="background-image: url('{{ $imageUrl }}');" alt="Product Image"></div>
                                <div class="home__category-name">
                                    {{ $category->name }}
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <div style="color: var(--primary-color); font-size: 3rem; text-align: center; height: 50px;">Gợi ý hôm nay</div>
                    <hr style="background-color: var(--primary-color); border: 0; height: 10px;">
                    <div class="home-product">

                        <div class="grid__row">

                            @foreach($data as $row)
                            <!-- Product item -->
                            <div class="grid__column-2-4">
                                <a class="home-product-item" href="{{ route('guest.detail', ['id' => $row->id]) }}">
                                    @php
                                    $imageUrl = asset('assets/img/' . $row->image);
                                    $newPrice = $row->price - ($row->price * $row->percent_discount / 100);
                                    $isFavorited = false;
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
                    <!-- Hiển thị số trang theo số thứ tự -->
                    <div class="home-pagination">
                        <!-- Nút Trước -->
                        @if ($currentPage > 1)
                        <a href="{{ route('guest.home', ['page' => $currentPage - 1, 'sort' => request()->input('sort')]) }}">
                            < @endif <!-- Hiển thị số trang -->
                                @for ($i = 1; $i <= $totalPages; $i++) <a href="{{ route('guest.home', ['page' => $i, 'sort' => request()->input('sort')]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}
                        </a>
                        @endfor

                        <!-- Nút Sau -->
                        @if ($currentPage < $totalPages) <a href="{{ route('guest.home', ['page' => $currentPage + 1, 'sort' => request()->input('sort')]) }}"> > </a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection