@extends('users.admin.layout.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('admins/slider/index/list.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admins/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('admins/slider/index/list.js') }}"></script>
@endsection

<!--Container-->
@section('search')
    <div class="header-left mb-5">
        <div class="header-search">
            <form action="{{ route('admin.slider.index') }}" method="GET">
                <div class="form-group mb-0">
                    <i class="dw dw-search2 search-icon"></i>
                    <input type="text" class="form-control search-input" name="keyword" value="{{ $keyword ?? '' }}"
                        placeholder="Tìm kiếm" />
                </div>
            </form>
        </div>
    </div>
@endsection
@section('content')
    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-20">
            <div class="pull-left">
                <h4 class="text-blue h4">{{ $title }}</h4>
            </div>

            @if (session('success'))
                <div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="pull-right mt-5">
                <a href="{{ route('admin.slider.create') }}" class="add_product"><i class="fa-solid fa-square-plus"></i>
                    ADD</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tên Slider</th>
                        <th scope="col">Mô Tả Slider</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($sliders->isEmpty())
                        <tr>
                            <td colspan="5">Không có slider nào khớp với từ khóa "{{ $keyword ?? '' }}".</td>
                        </tr>
                    @else
                        @foreach ($sliders as $slider)
                            <tr>
                                <th scope="row">{{ $slider->id }}</th>
                                <td>{{ $slider->name }}</td>
                                <td>{!!$slider->description !!}</td>
                                <td><img class="img-fluid" src="{{ asset('assets/img') . '/' . $slider->img_name }}" alt=""></td>
                                <td>
                                    <a href="{{ route('admin.slider.edit', ['id' => $slider->id]) }}" class="btn-edit"><i
                                            class="fas fa-edit"></i></a>
                                    <a href="" class="btn-delete"
                                        data-url="{{ route('admin.slider.delete', ['id' => $slider->id]) }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <!-- You can add content here if needed -->
        </div>
        <div class="col-sm-12 col-md-7">
            @php
                $total_pages = $sliders->lastPage(); // Tổng số trang
                $current_page = $sliders->currentPage(); // Trang hiện tại

                // Xác định phạm vi trang hiển thị
                $start_page = max(1, $current_page - 2); // Trang bắt đầu
                $end_page = min($total_pages, $current_page + 2); // Trang kết thúc

                // Điều chỉnh nếu phạm vi quá hẹp
                if ($end_page - $start_page < 4) {
                    if ($start_page > 1) {
                        $start_page = max(1, $end_page - 4); // Đảm bảo có ít nhất 5 trang
                    }
                    if ($end_page < $total_pages) {
                        $end_page = min($total_pages, $start_page + 4);
                    }
                }
            @endphp

            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                @if ($sliders->hasPages())
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        @if ($sliders->onFirstPage())
                            <li class="paginate_button page-item previous disabled"><span class="page-link"><i
                                        class="ion-chevron-left"></i></span></li>
                        @else
                            <li class="paginate_button page-item previous"><a href="{{ $sliders->previousPageUrl() }}"
                                    aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" class="page-link"><i
                                        class="ion-chevron-left"></i></a></li>
                        @endif

                        <!-- First page ellipsis -->
                        @if ($start_page > 1)
                            <li class="paginate_button page-item"><a href="{{ $sliders->url(1) }}"
                                    aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0"
                                    class="page-link">1</a></li>
                            @if ($start_page > 2)
                                <li class="paginate_button page-item"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        <!-- Pagination Elements -->
                        @for ($page = $start_page; $page <= $end_page; $page++)
                            @if ($page == $current_page)
                                <li class="paginate_button page-item active"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="paginate_button page-item"><a href="{{ $sliders->url($page) }}"
                                        aria-controls="DataTables_Table_0" data-dt-idx="{{ $page }}" tabindex="0"
                                        class="page-link">{{ $page }}</a></li>
                            @endif
                        @endfor

                        <!-- Last page ellipsis -->
                        @if ($end_page < $total_pages)
                            @if ($end_page < $total_pages - 1)
                                <li class="paginate_button page-item"><span class="page-link">...</span></li>
                            @endif
                            <li class="paginate_button page-item"><a href="{{ $sliders->url($total_pages) }}"
                                    aria-controls="DataTables_Table_0" data-dt-idx="{{ $total_pages }}" tabindex="0"
                                    class="page-link">{{ $total_pages }}</a></li>
                        @endif

                        <!-- Next Page Link -->
                        @if ($products->hasMorePages())
                            <li class="paginate_button page-item next"><a href="{{ $sliders->nextPageUrl() }}"
                                    aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" class="page-link"><i
                                        class="ion-chevron-right"></i></a></li>
                        @else
                            <li class="paginate_button page-item next disabled"><span class="page-link"><i
                                        class="ion-chevron-right"></i></span></li>
                        @endif
                    </ul>
                @endif
            </div>

        </div>
    </div>
@endsection
