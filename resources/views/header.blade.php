<header class="header">
    <div class="grid">
        @if($currentUser)
        <nav class="header__navbar">
            <ul class="header__navbar-list">
                <li class="header__navbar-item header__navbar-item--has-qr header__navbar-item--separate">
                    Vào cửa hàng trên ứng dụng GenZ Store
                    <!-- Header qr code -->
                    <div class="header__qr">
                        <img src="{{ asset('assets/img/qr_code.png') }}" alt="QR code" class="header__qr-img">
                        <div class="header__qr-apps">
                            <a href="#" class="header__qr-link">
                                <img src="{{ asset('assets/img/google_play.png') }}" alt="Google Play" class="header__qr-download-img">
                            </a>
                            <a href="#" class="header__qr-link">
                                <img src="{{ asset('assets/img/app_store.png') }}" alt="App Store" class="header__qr-download-img">
                            </a>
                        </div>
                    </div>
                </li>
                <li class="header__navbar-item">
                    <span class="header__navbar-title--no-pointer">Kết nối</span>
                    <a href="https://www.facebook.com/finn.264/" class="header__navbar-icon-link">
                        <i class="header__navbar--icon fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/im.vulinh__/" class="header__navbar-icon-link">
                        <i class="header__navbar--icon fa-brands fa-instagram"></i>
                    </a>
                </li>
            </ul>
            <ul class="header__navbar-list">
                <li class="header__navbar-item header__navbar-item--has-notify">
                    <a href="#" class="header__navbar-item-link">
                        <i class="header__navbar-icon far fa-bell"></i>
                        Thông báo
                    </a>
                    <div class="header__notify">
                        <header class="header__notify-header">
                            <h3>Thông báo mới nhận</h3>
                        </header>
                        <ul class="header__notify-list">
                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/d10b37e9760f46a24e0c172bd85ec83d" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name"> Áo Thun Tay Ngắn Màu Trơn Thời Trang Xuân Hè Dễ Phối Đồ Cho Nam</span>
                                        <span class="header__notify-description">Áo thun Nam Local Brand Chính Hãng </span>
                                    </div>
                                </a>
                            </li>

                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/b000cb839bc942e82c6f8b626a2aa26b" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name"> Áo Sơ Mi Tay Ngắn Màu Trơn </span>
                                        <span class="header__notify-description">Phong Cách Nhật Bản Thời Trang Mùa Hè Cho Nam</span>
                                    </div>
                                </a>
                            </li>

                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/2f13f79c90ee1712cdd19a5bb26f3790" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name"> Áo Khoác Dù Form Rộng Unisex Thêu Cao Cấp</span>
                                        <span class="header__notify-description"> Áo Khoác Nam Nữ Local Brand Chính Hãng Cinder Jacket Enjoy, hợp thời trang hiện đại</span>
                                    </div>
                                </a>
                            </li>

                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/sg-11134201-23020-hgxz41shdhnve0" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name">Áo thun Nam tay lỡ họa tiết in Bullet mềm mại </span>
                                        <span class="header__notify-description">by Lallee.Design Áo phông dáng đứng chất vải Cotton dày dặn</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <footer class="header__notify-footer">
                            <a href="#" class="header__notify-footer-btn">Xem tất cả</a>
                        </footer>
                    </div>
                </li>
                <li class="header__navbar-item">
                    <a href="#" class="header__navbar-item-link">
                        <i class="header__navbar-icon fa-regular fa-circle-question"></i>
                        Trợ giúp
                    </a>
                </li>
                <li class="header__navbar-item header__navbar-user">
                    @php
                    $imageUrl = asset('assets/img/' . $currentUser->customer->image);
                    @endphp
                    <div class="header__navbar-user-img" style="background-image: url('{{ $imageUrl }}');"></div>
                    <span class="header__navbar-user-name"> {{ $currentUser->name }}</span>
                    <ul class="header__navbar-user-menu">
                        <li class="header__navbar-user-item">
                            <a href="{{route('user.profile', ['id' => $currentUser->id])}}">Tài Khoản Của Tôi</a>
                        </li>
                        <li class="header__navbar-user-item">
                            <a href="{{route('user.password', ['id' => $currentUser->id])}}">Mật Khẩu</a>
                        </li>
                        <li class="header__navbar-user-item">
                            <a href="{{route('user.purchase')}}">Đơn Mua</a>
                        </li>
                        <li class="header__navbar-user-item">
                            <a href="{{route('user.voucher')}}">Mã Giảm Giá</a>
                        </li>
                        <li class="header__navbar-user-item">
                            <a href="/signout">Đăng Xuất</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- <i id="menu__bar-out" class="fa-solid fa-bars menu__bar-icon">
            <a href="#">
            </a>
        </i> -->

        <!-- Header with search -->
        <div class="header-with-search">
            <div class="header__logo-img" id="header__logo-out">
                <a href="{{route('user.home')}}" class="header__logo-link">
                    <i class="fa-brands fa-shopify fa-2xl" style="color: #74C0FC; font-size: 3em;"></i>
                    <svg class="header__logo-img" viewBox="0 0 200 50">
                        <text x="12" y="40" font-family="Arial, sans-serif" font-size="36" fill="#74C0FC">GenZ Store</text>
                    </svg>
                </a>
            </div>


            <div class="header__search">
                <div class="header__search-input-wrap">
                    <form action="{{ route('product.search') }}" method="GET">
                        <input type="text" name="query" class="header__search-input" placeholder="Nhập để tìm kiếm sản phẩm">

                        <!-- Search history -->
                        <div class="header__search-history">
                            <h3 class="header__search-history-heading">Lịch sử tìm kiếm</h3>
                            <ul class="header__search-history-list">
                                @if(session()->has('search_history') && !empty(session('search_history')))
                                @foreach(session('search_history') as $query)
                                <li class="header__search-history-item"><a href="#">{{ $query }}</a>
                                    <button class="header__search-history-remove">X</button>
                                </li>
                                @endforeach
                                @else
                                <li class="header__search-history-item">Không có lịch sử tìm kiếm.</li>
                                @endif
                            </ul>
                        </div>

                </div>
                <div class="header__search-select">
                    <span class="header__search-select-label">Trong shop</span>
                    <i class="header__search-select-icon fa-solid fa-angle-down"></i>

                    <ul class="header__search-option">
                        <li class="header__search-option-item header__search-option-item--active">
                            <span>Trong shop</span>
                            <i class="fa-solid fa-check"></i>
                        </li>
                        <li class="header__search-option-item">
                            <span>Ngoài shop</span>
                            <i class="fa-solid fa-check"></i>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="header__search-btn">
                    <i class="header__search-btn-icon fa-solid fa-magnifying-glass"></i>
                </button>
                </form>
            </div>

            <!-- Cart layout -->
            <div class="header__cart">
                <a class="header__cart-click" href="{{ route('user.cart') }}">
                    <div class="header__cart-wrap">
                        <i class="header__cart-icon fa-solid fa-cart-shopping"></i>
                        <span class="header__cart-notice">{{ $carts->count() }}</span>

                        <!-- No cart: header__cart-list--no-cart -->
                        <div class="header__cart-list">
                            @if($carts->isEmpty())
                            <img src="{{ asset('assets/img/no-cart.webp') }}" alt="" class="header__cart-no-cart-img">
                            @else
                            <h4 class="header__cart-heading">Sản phẩm trong giỏ hàng</h4>
                            <ul class="header__cart-list-item">
                                <!--Cart item-->
                                @foreach($carts as $cart)
                                @php
                                $newPrice = $cart->product->price - ($cart->product->price * $cart->product->percent_discount / 100);
                                @endphp
                                <li class="header__cart-item">
                                    <a href="{{ route('user.detail', ['id' => $cart->product->id]) }}">
                                        <img src="{{ asset('assets/img/' . $cart->product->image) }}" alt="" class="header__cart-img">
                                    </a>
                                    <div class="header__cart-item-info">
                                        <div class="header__cart-item-head">
                                            <h5 class="header__cart-item-name"><a href="{{ route('user.detail', ['id' => $cart->product->id]) }}">{{ $cart->product->name }}</a></h5>
                                            <div class="header__cart-item-price-wrap">
                                                <span class="header__cart-item-price">{{ number_format($newPrice) }}đ</span>
                                                <span class="header__cart-item-multiply">x</span>
                                                <span class="header__cart-item-qnt">{{ $cart->quantity }}</span>
                                            </div>
                                        </div>
                                        <div class="header__cart-item-body">
                                            <span class="header__cart-item-description">Phân loại: {{ $cart->product->category }}</span>
                                            <!-- Button remove product -->
                                            <form action="{{ route('user.cart.remove', ['cartId' => $cart->id]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="header__cart-item-remove">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                <a href="{{ route('user.cart') }}" class="header__cart-view-cart btn btn--primary">Xem giỏ hàng</a>
                            </ul>
                            @endif
                        </div>


                    </div>

                </a>
            </div>

        </div>

        <!-- Guest -->
        @else
        <nav class="header__navbar">
            <ul class="header__navbar-list">
                <li class="header__navbar-item header__navbar-item--has-qr header__navbar-item--separate">
                    Vào cửa hàng trên ứng dụng GenZ Store
                    <!-- Header qr code -->
                    <div class="header__qr">
                        <img src="{{ asset('assets/img/qr_code.png') }}" alt="QR code" class="header__qr-img">
                        <div class="header__qr-apps">
                            <a href="#" class="header__qr-link">
                                <img src="{{ asset('assets/img/google_play.png') }}" alt="Google Play" class="header__qr-download-img">
                            </a>
                            <a href="#" class="header__qr-link">
                                <img src="{{ asset('assets/img/app_store.png') }}" alt="App Store" class="header__qr-download-img">
                            </a>
                        </div>
                    </div>
                </li>
                <li class="header__navbar-item">
                    <span class="header__navbar-title--no-pointer">Kết nối</span>
                    <a href="https://www.facebook.com/finn.264/" class="header__navbar-icon-link">
                        <i class="header__navbar--icon fa-brands fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/im.vulinh__/" class="header__navbar-icon-link">
                        <i class="header__navbar--icon fa-brands fa-instagram"></i>
                    </a>
                </li>
            </ul>
            <ul class="header__navbar-list">
                <li class="header__navbar-item header__navbar-item--has-notify">
                    <a href="#" class="header__navbar-item-link">
                        <i class="header__navbar-icon far fa-bell"></i>
                        Thông báo
                    </a>
                    <div class="header__notify">
                        <header class="header__notify-header">
                            <h3>Thông báo mới nhận</h3>
                        </header>
                        <ul class="header__notify-list">
                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/d10b37e9760f46a24e0c172bd85ec83d" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name"> Áo Thun Tay Ngắn Màu Trơn Thời Trang Xuân Hè Dễ Phối Đồ Cho Nam</span>
                                        <span class="header__notify-description">Áo thun Nam Local Brand Chính Hãng </span>
                                    </div>
                                </a>
                            </li>

                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/b000cb839bc942e82c6f8b626a2aa26b" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name"> Áo Sơ Mi Tay Ngắn Màu Trơn </span>
                                        <span class="header__notify-description">Phong Cách Nhật Bản Thời Trang Mùa Hè Cho Nam</span>
                                    </div>
                                </a>
                            </li>

                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/2f13f79c90ee1712cdd19a5bb26f3790" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name"> Áo Khoác Dù Form Rộng Unisex Thêu Cao Cấp</span>
                                        <span class="header__notify-description"> Áo Khoác Nam Nữ Local Brand Chính Hãng Cinder Jacket Enjoy, hợp thời trang hiện đại</span>
                                    </div>
                                </a>
                            </li>

                            <li class="header__notify-item header__notify-item--viewed">
                                <a href="#" class="header__notify-link">
                                    <img src="https://cf.shopee.vn/file/sg-11134201-23020-hgxz41shdhnve0" alt="" class="header__notify-img">
                                    <div class="header__notify-info">
                                        <span class="header__notify-name">Áo thun Nam tay lỡ họa tiết in Bullet mềm mại </span>
                                        <span class="header__notify-description">by Lallee.Design Áo phông dáng đứng chất vải Cotton dày dặn</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <footer class="header__notify-footer">
                            <a href="#" class="header__notify-footer-btn">Xem tất cả</a>
                        </footer>
                    </div>
                </li>
                <li class="header__navbar-item">
                    <a href="#" class="header__navbar-item-link">
                        <i class="header__navbar-icon fa-regular fa-circle-question"></i>
                        Trợ giúp
                    </a>
                </li>
                <li class="header__navbar-item header__navbar-item--strong header__navbar-item--separate">
                    <a href="{{ route('users.signup') }}" class="header__navbar-item-link">
                        Đăng ký
                    </a>
                </li>
                <li class="header__navbar-item header__navbar-item--strong">
                    <a href="{{ route('users.signin') }}" class="header__navbar-item-link">
                        Đăng nhập
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Header with search -->
        <div class="header-with-search">
            <div class="header__logo-img" id="header__logo-out">
                <a href="{{route('guest.home')}}" class="header__logo-link">
                    <i class="fa-brands fa-shopify fa-2xl" style="color: #74C0FC; font-size: 3em;"></i>
                    <svg class="header__logo-img" viewBox="0 0 200 50">
                        <text x="12" y="40" font-family="Arial, sans-serif" font-size="36" fill="#74C0FC">GenZ Store</text>
                    </svg>
                </a>
            </div>


            <div class="header__search">
                <div class="header__search-input-wrap">
                    <form action="{{ route('guest.product.search') }}" method="GET">
                        <input type="text" name="query" class="header__search-input" placeholder="Nhập để tìm kiếm sản phẩm">

                        <!-- Search history -->
                        <div class="header__search-history">
                            <h3 class="header__search-history-heading">Lịch sử tìm kiếm</h3>
                            <ul class="header__search-history-list">
                                @if(session()->has('search_history') && !empty(session('search_history')))
                                @foreach(session('search_history') as $query)
                                <li class="header__search-history-item"><a href="#">{{ $query }}</a>
                                    <button class="header__search-history-remove">X</button>
                                </li>
                                @endforeach
                                @else
                                <li class="header__search-history-item">Không có lịch sử tìm kiếm.</li>
                                @endif
                            </ul>
                        </div>

                </div>
                <div class="header__search-select">
                    <span class="header__search-select-label">Trong shop</span>
                    <i class="header__search-select-icon fa-solid fa-angle-down"></i>

                    <ul class="header__search-option">
                        <li class="header__search-option-item header__search-option-item--active">
                            <span>Trong shop</span>
                            <i class="fa-solid fa-check"></i>
                        </li>
                        <li class="header__search-option-item">
                            <span>Ngoài shop</span>
                            <i class="fa-solid fa-check"></i>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="header__search-btn">
                    <i class="header__search-btn-icon fa-solid fa-magnifying-glass"></i>
                </button>
                </form>
            </div>

            <!-- Cart layout -->
            <div class="header__cart">
                <a class="header__cart-click" href="{{ route('users.signin') }}">
                    <div class="header__cart-wrap">
                        <i class="header__cart-icon fa-solid fa-cart-shopping"></i>
                        <span class="header__cart-notice">0</span>

                        <!-- No cart: header__cart-list--no-cart -->
                        <div class="header__cart-list">
                            <img src="{{ asset('assets/img/no-cart.webp') }}" alt="" class="header__cart-no-cart-img">
                        </div>
                    </div>

                </a>
            </div>

        </div>
        @endif
    </div>

</header>
