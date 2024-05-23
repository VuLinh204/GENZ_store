@extends('users.admin.layout.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('admins/category/index/list.css') }}">
@endsection

@section('js')
    <script src="{{ asset('/admins/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('admins/category/index/list.js') }}"></script>
@endsection
<!--Container-->
@section('search')
    <div class="header-left mb-5">
        <div class="header-search">
            <form action="{{ route('admin.users.index') }}" method="GET">
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

            @if (session('error'))
                <div class='alert alert-error alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    {{ session('error') }}
                </div>
            @endif



            <div class="pull-right mt-5">
                <a href="{{ route('admin.category.create') }}" class="add_category"><i class="fa-solid fa-square-plus"></i>
                    ADD</a>
            </div>
        </div>

        <table class="category-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Khách Hàng</th>
                    <th>Email</th>
                    <th>Action</th>

                </tr>
            </thead>
            @if ($users->isEmpty())
                <tr>
                    <td colspan="4">Không có khách hàng nào khớp với từ khóa "{{ $keyword ?? '' }}".</td>
                </tr>
            @else
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->is_locked)
                                <form action="{{ route('admin.customers.unlock', $user->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning">Mở khóa</button>
                                </form>
                            @else
                                <form action="{{ route('admin.customers.lock', $user->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Khóa</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

@endsection
