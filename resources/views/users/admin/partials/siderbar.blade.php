<div class="right-sidebar">
    <div class="sidebar-title">
        <h3 class="weight-600 font-16 text-blue">
            Layout Settings
            <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
        </h3>
        <div class="close-sidebar" data-toggle="right-sidebar-close">
            <i class="icon-copy ion-close-round"></i>
        </div>
    </div>
    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content">
            <h4 class="weight-600 font-18 pb-10">Header Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
            </div>
        </div>
    </div>
</div>

<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('admin.home') }}" style="width: 150px">
            <a href="{{ route('admin.home') }}">
                <i class="fa-brands fa-shopify fa-2xl" style="color: #74C0FC; font-size: 1em;"></i>
                <svg class="header__logo-img" viewBox="0 0 200 50">
                    <text x="12" y="40" font-family="Arial, sans-serif" font-size="34px" fill="#74C0FC">GenZ
                        Store</text>
                </svg>
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="{{ route('admin.home') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.category.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-calendar4-week"></span><span class="mtext">Category</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.product.index') }}" class="dropdown-toggle no-arrow">

                        <span class="micon"> <i class="fa-solid fa-shirt"></i></span><span class="mtext">Product</span>

                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.slider.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"> <i class="fa-solid fa-sliders"></i></span><span class="mtext">Slider</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.vouchers.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"> <i class="fa-solid fa-ticket"></i></span><span class="mtext">Voucher</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"> <i class="fa-regular fa-circle-user"></i></span><span class="mtext">User</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>