@extends('main')

@section('content')
<!-- sidebar -->
@if($currentUser)
<!-- App container -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column-2">
                <nav class="manager">
                    <h3 class="manager__heading">{{ $title }}</h3>
                </nav>
            </div>
            @php
            $newPrice = $product->price - ($product->price * $product->percent_discount / 100);
            @endphp

            <div class="grid__column-10">
                <!-- content -->
                <section class="product-section">
                    <div class="product-container">
                        <div class="product-row">
                            <div class="product-image">
                                <img src="{{ asset('assets/img/' . $product->image) }}" alt="Product Image">
                            </div>
                            <div class="product-details">
                                <h1 class="product-title">{{ $product->name }}</h1>
                                <div class="product-prices">
                                    <span class="product-price-old">
                                        <h6>₫</h6>{{ number_format($product->price) }}
                                    </span>
                                    <span class="product-price-new">
                                        <h3>₫{{ number_format($newPrice) }}</h3>
                                    </span>
                                </div>
                                <p class="product-description">{{ $product->description }}</p>
                                <div class="product-actions">
                                    <form method="POST" class="product-actions-form" action="{{ route('user.cart.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="quantity-input">
                                            <button type="button" class="quantity-decrement" onclick="decrementQuantity()">-</button>
                                            <input class="product-quantity" type="text" value="1" name="quantity" min="1" id="product-quantity">
                                            <button type="button" class="quantity-increment" onclick="incrementQuantity()">+</button>
                                        </div>

                                        <!-- Size Buttons -->
                                        <div class="size-options">
                                            @foreach($product->size ?? [] as $size)
                                            <button type="button" class="size-btn" data-size="{{ $size }}">{{ $size }}</button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="selected_size" id="selected_size">

                                        <!-- Color Buttons -->
                                        <div class="color-options">
                                            @foreach($product->color ?? [] as $color)
                                            <button type="button" class="color-btn" data-color="{{ $color }}">{{ $color }}</button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="selected_color" id="selected_color">

                                        <button type="submit" class="btn product-add-to-cart" onclick="return addToCart()">Thêm Vào Giỏ Hàng</button>
                                    </form>
                                    <hr>
                                    <div class="favorite">
                                        <button type="submit" class="favorite__btn" id="favorited">
                                            <svg width="25" height="20" class="vgMiJB">
                                                <path d="M19.469 1.262c-5.284-1.53-7.47 4.142-7.47 4.142S9.815-.269 4.532 1.262C-1.937 3.138.44 13.832 12 19.333c11.559-5.501 13.938-16.195 7.469-18.07z" stroke="#FF424F" stroke-width="1.5" fill="#FF424F" fill-rule="evenodd" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                        <button type="submit" class="favorite__btn" id="not_favorited">
                                            <svg width="25" height="20" class="vgMiJB">
                                                <path d="M19.469 1.262c-5.284-1.53-7.47 4.142-7.47 4.142S9.815-.269 4.532 1.262C-1.937 3.138.44 13.832 12 19.333c11.559-5.501 13.938-16.195 7.469-18.07z" stroke="#FF424F" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                        <div class="favorite__qty">({{ $product->favorite_count }}) Đã Thích</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <br>
                <!-- related-products -->
                <section class="related-products">
                    <div class="container">
                        <h2 class="related-products__title">Related products</h2>

                        <div class="related-products-slider">
                            @foreach($relatedProducts as $row)
                            <div class="grid__column-2-4">
                                <!-- Nội dung sản phẩm liên quan -->
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
                <!-- Comment -->
                <div class="container mt-5">
                    <div class="d-flex justify-content-center row">
                        <div class="col-md-8">
                            <div class="d-flex flex-column comment-section">
                                @auth
                                <div class="bg-light p-2 mb-2">
                                    <form id="commentForm" action="{{ route('products.comments', ['product' => $product]) }}" method="POST">
                                        @csrf
                                        <div class="d-flex flex-row align-items-start">
                                            <!-- <img class="rounded-circle1" src="{{ auth()->user()->image }}"> -->
                                            <textarea class="form-control ml-1 shadow-none textarea" name="body" id="commentBody" placeholder="Viết bình luận của bạn..."></textarea>
                                        </div>
                                        <div class="mt-2 text-right">
                                            <button class="btn btn-primary btn-sm shadow-none" type="submit">Bình luận</button>
                                            <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button" onclick="cancelComment()">Hủy</button>
                                        </div>
                                    </form>
                                </div>
                                @endauth

                                @foreach ($product->comments as $comment)
                                <div class="comment bg-white p-2" id="comment-{{ $comment->id }}">
                                    <div class="d-flex flex-row user-info">
                                        <img class="rounded-circle" src="{{ $comment->image }}" width="40">
                                        <div class="d-flex flex-column justify-content-start">
                                            <span class="d-block font-weight-bold name">{{ $comment->user->name }}</span>
                                            <span class="date text-black-50">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div style="margin-left: 5px;">
                                        <p id="comment-text-{{ $comment->id }}" class="comment-text">{{ $comment->body }}</p>
                                    </div>

                                    @auth
                                    @if(Auth::id() === $comment->user_id)
                                    <!-- Nút xóa -->
                                    <form id="deleteForm-{{ $comment->id }}" action="{{ route('comments.delete', $comment) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteComment('{{ $comment->id }}')">Xóa</button>
                                    </form>
                                    @endif
                                    @endauth
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ajax (Favorite) -->
<script>
    $(document).ready(function() {
        if ("{{ $favorite?->is_favorite }}" === '1') {
            $("#favorited").show();
        } else {
            $("#not_favorited").show();
        }

        function onToggle() {
            $.ajax({
                url: "/user/detail/toggleFavorite/{{$product->id}}",
                type: "post",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    var currentCount = parseInt($(".favorite__qty").text().match(/\d+/)[0]);
                    if (res.isFav) {
                        $("#favorited").show();
                        $("#not_favorited").hide();
                        $(".favorite__qty").text("(" + (currentCount + 1) + ") Đã Thích");
                    } else {
                        $("#favorited").hide();
                        $("#not_favorited").show();
                        $(".favorite__qty").text("(" + (currentCount - 1) + ") Đã Thích");
                    }
                },

            })
        }

        $("#favorited").click(onToggle)
        $("#not_favorited").click(onToggle)

    })
</script>

<!-- guest -->
@else
<!-- App container -->
<div class="app__container">
    <div class="grid">
        <div class="grid__row app__content">
            <div class="grid__column-2">
                <nav class="manager">
                    <h3 class="manager__heading">{{ $title }}</h3>
                </nav>
            </div>
            @php
            $newPrice = $product->price - ($product->price * $product->percent_discount / 100);
            @endphp

            <div class="grid__column-10">
                <!-- content -->
                <section class="product-section">
                    <div class="product-container">
                        <div class="product-row">
                            <div class="product-image">
                                <img src="{{ asset('assets/img/' . $product->image) }}" alt="Product Image">
                            </div>
                            <div class="product-details">
                                <h1 class="product-title">{{ $product->name }}</h1>
                                <div class="product-prices">
                                    <span class="product-price-old">
                                        <h6>₫</h6>{{ number_format($product->price) }}
                                    </span>
                                    <span class="product-price-new">
                                        <h3>₫{{ number_format($newPrice) }}</h3>
                                    </span>
                                </div>
                                <p class="product-description">{{ $product->description }}</p>
                                <div class="product-actions">
                                    <form method="POST" class="product-actions-form" action="{{ route('user.cart.store') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="quantity-input">
                                            <button type="button" class="quantity-decrement" onclick="decrementQuantity()">-</button>
                                            <input class="product-quantity" type="text" value="1" name="quantity" min="1" id="product-quantity">
                                            <button type="button" class="quantity-increment" onclick="incrementQuantity()">+</button>
                                        </div>

                                        <!-- Size Buttons -->
                                        <div class="size-options">
                                            @foreach($product->size ?? [] as $size)
                                            <button type="button" class="size-btn" data-size="{{ $size }}">{{ $size }}</button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="selected_size" id="selected_size">

                                        <!-- Color Buttons -->
                                        <div class="color-options">
                                            @foreach($product->color ?? [] as $color)
                                            <button type="button" class="color-btn" data-color="{{ $color }}">{{ $color }}</button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="selected_color" id="selected_color">

                                        <button type="submit" class="btn product-add-to-cart" onclick="return addToCart()">Thêm Vào Giỏ Hàng</button>
                                    </form>
                                    <hr>
                                    <div class="favorite">
                                        <button type="submit" class="favorite__btn" id="favorited">
                                            <svg width="25" height="20" class="vgMiJB">
                                                <path d="M19.469 1.262c-5.284-1.53-7.47 4.142-7.47 4.142S9.815-.269 4.532 1.262C-1.937 3.138.44 13.832 12 19.333c11.559-5.501 13.938-16.195 7.469-18.07z" stroke="#FF424F" stroke-width="1.5" fill="#FF424F" fill-rule="evenodd" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                        <button type="submit" class="favorite__btn" id="not_favorited">
                                            <svg width="25" height="20" class="vgMiJB">
                                                <path d="M19.469 1.262c-5.284-1.53-7.47 4.142-7.47 4.142S9.815-.269 4.532 1.262C-1.937 3.138.44 13.832 12 19.333c11.559-5.501 13.938-16.195 7.469-18.07z" stroke="#FF424F" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                        <div class="favorite__qty">({{ $product->favorite_count }}) Đã Thích</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <br>
                <!-- related-products -->
                <section class="related-products">
                    <div class="container">
                        <h2 class="related-products__title">Related products</h2>

                        <div class="related-products-slider">
                            @foreach($relatedProducts as $row)
                            <div class="grid__column-2-4">
                                <!-- Nội dung sản phẩm liên quan -->
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
                </section>
                <br>
                <!-- Comment -->
                <div class="container mt-5">
                    <div class="d-flex justify-content-center row">
                        <div class="col-md-8">
                            <div class="d-flex flex-column comment-section">
                                @foreach ($product->comments as $comment)
                                <div class="bg-white p-2" id="comment-{{ $comment->id }}">
                                    <div class="d-flex flex-row user-info">
                                        <img class="rounded-circle" src="{{ $comment->image }}" width="40">
                                        <div class="d-flex flex-column justify-content-start">
                                            <span class="d-block font-weight-bold name">{{ $comment->user->name }}</span>
                                            <span class="date text-black-50">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p id="comment-text-{{ $comment->id }}" class="comment-text">{{ $comment->body }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
