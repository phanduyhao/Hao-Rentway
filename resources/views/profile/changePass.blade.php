@extends('layout.layout')
@section('content')
    <!-- End Navigation -->
    <div class="clearfix"></div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->
    
    <!-- ============================ Page Title Start================================== -->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    
                    <h2 class="ipt-title">{{ __('common.profile') }}!</h2>
                    <span class="ipn-subtitle">{{ __('common.your_profile') }}!</span>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->
    
    <!-- ============================ User Dashboard ================================== -->
    <section class="bg-light">
        <div class="container-fluid">
        
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="filter_search_opt">
                        <a href="javascript:void(0);" onclick="openFilterSearch()" class="btn btn-dark full-width mb-4">Menu<i class="fa-solid fa-bars ms-2"></i></a>
                    </div>
                </div>
            </div>
                        
            <div class="row">
                
                <div class="col-lg-2 col-md-12">
                    
                    <div class="simple-sidebar sm-sidebar" id="filter_search">
                        
                        <div class="search-sidebar_header">
                            <h4 class="ssh_heading">Close Filter</h4>
                            <button onclick="closeFilterSearch()" class="w3-bar-item w3-button w3-large"><i class="fa-regular fa-circle-xmark fs-5 text-muted-2"></i></button>
                        </div>
                        
                        <div class="sidebar-widgets">
                            <div class="dashboard-navbar">
                                <div class="fr-grid-thumb mx-auto text-center mt-5 mb-0">
                                    <a href="agent-page.html" class="d-inline-flex p-1 circle border">
                                        <img src="{{Auth::user()->avatar}}" width="150" class="img-fluid circle object-fit-cover" alt="" style="height: 150px" />
                                    </a>
                                </div>
                                <div class="d-user-avater mt-0">
                                    <h4>{{Auth::user()->name}}</h4>
                                    <span>{{Auth::user()->email}}</span>
                                    @if(Auth::user()->role != 'admin')
                                    <div class="rounded-3 text-white mt-3 p-2" style="background: #000000b0">
                                        <h4 class="mt-0 text-white">xếp hạng tài khoản</h4>
                                        @php
                                            $stars = 1; // Mặc định là 1 sao
                                            if ($tongBaidang >= 50) {
                                                $stars = 5;
                                            } elseif ($tongBaidang > 19) {
                                                $stars = 4;
                                            } elseif ($tongBaidang > 9) {
                                                $stars = 3;
                                            } elseif ($tongBaidang > 4) {
                                                $stars = 2;
                                            }
                                        @endphp
                                        
                                        @for($i = 1; $i <= $stars; $i++)
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        @endfor
                                    </div>
                                @endif
                                </div>
                                
                                <div class="d-navigation">
                                    <ul>
                                        <li class=""><a href="{{route('profile.index')}}"><i class="fa-solid fa-gauge"></i>Tổng quát</a></li>
                                        <li><a href="{{route('profile.listBaidang')}}"><i class="fa-solid fa-address-card"></i>Danh sách bài đăng</a></li>
                                        <li class="active"><a href="{{route('showChangePass')}}"><i class="fa-solid fa-unlock"></i>Thay đổi mật khẩu</a></li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-lg-10 col-md-12">
                    <div class="dashboard-wraper">
                    
                        <!-- Basic Information -->
                        <form action="{{ route('changePass') }}" method="post" class="form-change-password" id="form-change-password">
                            @csrf
                            <h4>Thay đổi mật khẩu</h4>
                            <div class="submit-section">
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-6">
                                        <label>Mật khẩu cũ</label>
                                        <input type="password" class="form-control input-field" data-require="Mời nhập mật khẩu cũ!" name="old_password" required>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Mật khẩu mới</label>
                                        <input type="password" class="form-control input-field" data-require="Mời nhập mật khẩu mới!" name="new_password" required>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Xác nhận mật khẩu</label>
                                        <input type="password" class="form-control input-field" data-require="Hãy xác nhận lại mật khẩu!" name="new_password_confirmation" required>
                                        <span class="error-message text-danger"></span>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12">
                                        <button class="btn btn-primary px-5 rounded" type="submit">Lưu lại</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
       

    </script>
@endsection