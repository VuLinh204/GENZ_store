@extends('main')
@section('content')

<div class="app">
    @if($currentUser)
    <!-- App container -->
    <div class="app__container">
        <div class="grid">
            <div class="grid__row app__content">
                <div class="grid__column-2">
                    <nav class="manager">
                        <h3 class="manager__heading">{{ $title }}</h3>
                        <ul class="manager-list">
                            <li class="manager-item">
                                <a href="{{ route('user.product') }}" class="manager-item__link">Tất cả sản phẩm</a>
                            </li>
                            @foreach ($categories as $category)
                            <li class="manager-item">
                                <a href="{{ route('products.by.category', ['category' => $category->id]) }}" class="manager-item__link">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                <div class="grid__column-10">
                    @if(!$products->isEmpty())
                    <div class="home-filter">
                        @if(isset($selectedCategory))
                        @php
                        $popularUrl = route('products.by.category', ['category' => $selectedCategory, 'sort' => 'popular']);
                        $newestUrl = route('products.by.category', ['category' => $selectedCategory, 'sort' => 'newest']);
                        $bestSellingUrl = route('products.by.category', ['category' => $selectedCategory, 'sort' => 'best_selling']);
                        @endphp
                        <span class="home-filter__label">Sắp xếp theo</span>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $popularUrl }}')">Yêu Thích</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $newestUrl }}')">Mới nhất</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $bestSellingUrl }}')">Bán chạy</button>
                        @else
                        @php
                        $popularUrl = route('user.product', ['sort' => 'popular']);
                        $newestUrl = route('user.product', ['sort' => 'newest']);
                        $bestSellingUrl = route('user.product', ['sort' => 'best_selling'])
                        @endphp
                        <span class="home-filter__label">Sắp xếp theo</span>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $popularUrl }}')">Yêu Thích</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $newestUrl }}')">Mới Nhất</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $bestSellingUrl }}')">Bán Chạy</button>
                        @endif

                        <!-- Price classification -->
                        <div class="select-input">
                            <span class="select-input__label">Giá</span>
                            <i class="select-input__icon fa-solid fa-angle-down"></i>

                            <!-- List options -->
                            <ul class="select-input__list">
                                @if(isset($selectedCategory))
                                <!-- Có category id -->
                                <li class="select-input__item">
                                    <a href="{{ route('products.by.category', ['category' => $selectedCategory, 'sort' => 'percent_asc']) }}" class="select-input__link">Phần trăm giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('products.by.category', ['category' => $selectedCategory, 'sort' => 'percent_desc']) }}" class="select-input__link">Phần trăm giảm: Cao đến thấp</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('products.by.category', ['category' => $selectedCategory, 'sort' => 'price_asc']) }}" class="select-input__link">Giá đã giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('products.by.category', ['category' => $selectedCategory, 'sort' => 'price_desc']) }}" class="select-input__link">Giá đã giảm: Cao đến thấp</a>
                                </li>
                                @else
                                <!-- Không có category id -->
                                <li class="select-input__item">
                                    <a href="{{ route('user.product', ['sort' => 'percent_asc']) }}" class="select-input__link">Phần trăm giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('user.product', ['sort' => 'percent_desc']) }}" class="select-input__link">Phần trăm giảm: Cao đến thấp</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('user.product', ['sort' => 'price_asc']) }}" class="select-input__link">Giá đã giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('user.product', ['sort' => 'price_desc']) }}" class="select-input__link">Giá đã giảm: Cao đến thấp</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endif


                    <div class="home-product">

                        <div class="grid__row">
                            @if($products->isEmpty())
                            <h1 style="padding: 0px 100px 100px;">Không tìm thấy sản phẩm nào!</h1>
                            @else

                            <!-- Product item -->
                            @foreach($products as $product)
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
                            @endif
                        </div>
                    </div>
                    <!-- Hiển thị số trang theo số thứ tự -->
                    <div class="home-pagination">
                        @for ($i = 1; $i <= $totalPages; $i++)<a href="{{ route('product.search', ['query' => request()->input('query'), 'page' => $i, 'sort' => request()->input('sort')]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                            @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- App container -->
    <div class="app__container">
        <div class="grid">
            <div class="grid__row app__content">
                <div class="grid__column-2">
                    <nav class="manager">
                        <h3 class="manager__heading">{{ $title }}</h3>
                        <ul class="manager-list">
                            <li class="manager-item">
                                <a href="{{ route('guest.product') }}" class="manager-item__link">Tất cả sản phẩm</a>
                            </li>
                            @foreach ($categories as $category)
                            <li class="manager-item">
                                <a href="{{ route('guest.products.by.category', ['category' => $category->id]) }}" class="manager-item__link">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                <div class="grid__column-10">
                    @if(!$products->isEmpty())
                    <div class="home-filter">
                        @if(isset($selectedCategory))
                        @php
                        $popularUrl = route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'popular']);
                        $newestUrl = route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'newest']);
                        $bestSellingUrl = route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'best_selling']);
                        @endphp
                        <span class="home-filter__label">Sắp xếp theo</span>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $popularUrl }}')">Yêu Thích</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $newestUrl }}')">Mới nhất</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $bestSellingUrl }}')">Bán chạy</button>
                        @else
                        @php
                        $popularUrl = route('guest.product', ['sort' => 'popular']);
                        $newestUrl = route('guest.product', ['sort' => 'newest']);
                        $bestSellingUrl = route('guest.product', ['sort' => 'best_selling'])
                        @endphp
                        <span class="home-filter__label">Sắp xếp theo</span>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $popularUrl }}')">Yêu Thích</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $newestUrl }}')">Mới Nhất</button>
                        <button class="home-filter__btn btn" onclick="navigateTo('{{ $bestSellingUrl }}')">Bán Chạy</button>
                        @endif

                        <!-- Price classification -->
                        <div class="select-input">
                            <span class="select-input__label">Giá</span>
                            <i class="select-input__icon fa-solid fa-angle-down"></i>

                            <!-- List options -->
                            <ul class="select-input__list">
                                @if(isset($selectedCategory))
                                <!-- Có category id -->
                                <li class="select-input__item">
                                    <a href="{{ route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'percent_asc']) }}" class="select-input__link">Phần trăm giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'percent_desc']) }}" class="select-input__link">Phần trăm giảm: Cao đến thấp</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'price_asc']) }}" class="select-input__link">Giá đã giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('guest.products.by.category', ['category' => $selectedCategory, 'sort' => 'price_desc']) }}" class="select-input__link">Giá đã giảm: Cao đến thấp</a>
                                </li>
                                @else
                                <!-- Không có category id -->
                                <li class="select-input__item">
                                    <a href="{{ route('guest.product', ['sort' => 'percent_asc']) }}" class="select-input__link">Phần trăm giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('guest.product', ['sort' => 'percent_desc']) }}" class="select-input__link">Phần trăm giảm: Cao đến thấp</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('guest.product', ['sort' => 'price_asc']) }}" class="select-input__link">Giá đã giảm: Thấp đến cao</a>
                                </li>
                                <li class="select-input__item">
                                    <a href="{{ route('guest.product', ['sort' => 'price_desc']) }}" class="select-input__link">Giá đã giảm: Cao đến thấp</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endif


                    <div class="home-product">

                        <div class="grid__row">
                            @if($products->isEmpty())
                            <h1 style="padding: 0px 100px 100px;">Không tìm thấy sản phẩm nào!</h1>
                            @else

                            <!-- Product item -->
                            @foreach($products as $product)
                            <div class="grid__column-2-4">
                                <a class="home-product-item" href="{{ route('guest.detail', ['id' => $product->id]) }}">
                                    @php
                                    $imageUrl = asset('assets/img/' . $product->image);
                                    $newPrice = $product->price - ($product->price * $product->percent_discount / 100);
                                    $isFavorited = false;
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
                            @endif
                        </div>
                    </div>
                    <!-- Hiển thị số trang theo số thứ tự -->
                    <div class="home-pagination">
                        @for ($i = 1; $i <= $totalPages; $i++)<a href="{{ route('guest.product.search', ['query' => request()->input('query'), 'page' => $i, 'sort' => request()->input('sort')]) }}" class="{{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                            @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection