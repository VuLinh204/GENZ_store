@extends('users.admin.layout.admin')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Profile</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">Dashbord</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Profile
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p">
                <div class="profile-photo">
                    <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i
                            class="fa fa-pencil"></i></a>
                    <img src="{{ asset('assets/img' . '/' . $user->customer->image) }}" alt=""
                        class="avatar-photo img-fluid">
                    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('admin.profile/updateInformation') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body pd-5">
                                        <div class="img-container">
                                            <label for="img">Hình ảnh :</label>
                                            <input type="file" name="img" class="form-control-file">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
                <div class="profile-info">
                    <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                    <ul>
                        <li>
                            <span>Email Address:</span>
                            {{ $user->email }}
                        </li>
                        <li>
                            <span>Phone Number:</span>
                            {{ $user->customer->phone }}
                        </li>
                        <li>
                            <span>Address:</span>
                            {{ $user->customer->address }}
                        </li>
                    </ul>
                </div>
                <div class="profile-social">
                    <h5 class="mb-20 h5 text-blue">Social Links</h5>
                    <ul class="clearfix">
                        <li>
                            <a href="#" class="btn" data-bgcolor="#3b5998" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(59, 89, 152);"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                        </li>

                        <li>
                            <a href="#" class="btn" data-bgcolor="#007bb5" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);"><i
                                    class="fa-brands fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn" data-bgcolor="#f46f30" data-color="#ffffff"
                                style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i
                                    class="fa-brands fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#setting" role="tab"
                                    aria-selected="false">Settings</a>
                            </li>
                        </ul>
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
                        <div class="tab-content">
                            <!-- Setting Tab start -->
                            <div class="tab-pane fade height-100-p" id="setting" role="tabpanel">
                                <div class="profile-setting">
                                    <form action="{{ route('admin.profile/updateInformation') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <ul class="profile-edit-list row">
                                            <li class="weight-500 col-md-10">
                                                <h4 class="text-blue h5 mb-20">
                                                    Edit Your Personal Setting
                                                </h4>
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input class="form-control form-control-lg" name="name"
                                                        type="text" value="{{ $user->name }}">
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>Title</label>
                                                    <input class="form-control form-control-lg" type="text">
                                                </div> --}}
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input class="form-control form-control-lg" name="email"
                                                        type="email" value="{{ $user->email }}">
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label>Date of birth</label>
                                                    <input class="form-control form-control-lg date-picker"
                                                        type="text">
                                                </div> --}}
                                                {{-- <div class="form-group">
                                                    <label>Gender</label>
                                                    <div class="d-flex">
                                                        <div class="custom-control custom-radio mb-5 mr-20">
                                                            <input type="radio" id="customRadio4" name="customRadio"
                                                                class="custom-control-input">
                                                            <label class="custom-control-label weight-400"
                                                                for="customRadio4">Male</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-5">
                                                            <input type="radio" id="customRadio5" name="customRadio"
                                                                class="custom-control-input">
                                                            <label class="custom-control-label weight-400"
                                                                for="customRadio5">Female</label>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                {{-- <div class="form-group">
                                                    <label>Country</label>
                                                    <div class="dropdown bootstrap-select form-control form-control-lg">
                                                        <select class="selectpicker form-control form-control-lg"
                                                            data-style="btn-outline-secondary btn-lg" title="Not Chosen"
                                                            tabindex="-98">
                                                            <option class="bs-title-option" value=""></option>
                                                            <option>United States</option>
                                                            <option>India</option>
                                                            <option>United Kingdom</option>
                                                        </select><button type="button"
                                                            class="btn dropdown-toggle btn-outline-secondary btn-lg bs-placeholder"
                                                            data-toggle="dropdown" role="combobox"
                                                            aria-owns="bs-select-3" aria-haspopup="listbox"
                                                            aria-expanded="false" title="Not Chosen">
                                                            <div class="filter-option">
                                                                <div class="filter-option-inner">
                                                                    <div class="filter-option-inner-inner">Not Chosen</div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div class="dropdown-menu ">
                                                            <div class="inner show" role="listbox" id="bs-select-3"
                                                                tabindex="-1">
                                                                <ul class="dropdown-menu inner show" role="presentation">
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input class="form-control form-control-lg" name="phone"
                                                        type="text" value="{{ $user->customer->phone }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea class="form-control" name="address">{{ $user->customer->address }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Mật khẩu mới (để trống nếu không muốn thay
                                                        đổi)</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password_confirmation">Xác nhận mật khẩu mới</label>
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mb-5">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customCheck1-1">
                                                        <label class="custom-control-label weight-400"
                                                            for="customCheck1-1">I agree to receive notification
                                                            emails</label>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary"
                                                        value="Update Information">
                                                </div>
                                            </li>
                                            {{-- <li class="weight-500 col-md-6">
                                                <h4 class="text-blue h5 mb-20">
                                                    Edit Social Media links
                                                </h4>
                                                <div class="form-group">
                                                    <label>Facebook URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Twitter URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Linkedin URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Instagram URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Dribbble URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Dropbox URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Google-plus URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Pinterest URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Skype URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group">
                                                    <label>Vine URL:</label>
                                                    <input class="form-control form-control-lg" type="text"
                                                        placeholder="Paste your link here">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary"
                                                        value="Save &amp; Update">
                                                </div>
                                            </li> --}}
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            <!-- Setting Tab End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
