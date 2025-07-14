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
                                            <h4 class="mt-0 text-white">{{ __('profile.account_rank') }}</h4>
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
                                        <li class="active"><a href="{{route('profile.index')}}"><i class="fa-solid fa-gauge"></i>{{ __('profile.overview') }}</a></li>
                                        <li><a href="{{route('profile.listBaidang')}}"><i class="fa-solid fa-address-card"></i>{{ __('profile.post_list') }}</a></li>
                                        <li><a href="{{route('showChangePass')}}"><i class="fa-solid fa-unlock"></i>{{ __('profile.change_password') }}</a></li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="col-lg-10 col-md-12">
                    <div class="row">
                     
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <a href="/profile/list-baidang" class="dashboard-stat widget-1">
                                <div class="dashboard-stat-content"><h4>{{$tongBaidang}}</h4> <span class="mt-3 fw-bold text-dark">{{ __('profile.total_posts') }}</span></div>
                                <div class="dashboard-stat-icon "><i class="fa-solid fa-location-dot"></i></div>
                            </a>	
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <a href="/profile/list-baidang?search_duyet=approved" class="dashboard-stat widget-6">
                                <div class="dashboard-stat-content"><h4>{{$tongBaidangDuyet}}</h4> <span class="mt-3 fw-bold text-dark">{{ __('profile.approved_posts') }}</span></div>
                                <div class="dashboard-stat-icon"><i class="ti-user"></i></div>
                            </a>	
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <a href="/profile/list-baidang?search_duyet=pending" class="dashboard-stat widget-2">
                                <div class="dashboard-stat-content"><h4>{{$tongBaidangChoduyet}}</h4> <span class="mt-3 fw-bold text-dark">{{ __('profile.pending_posts') }}</span></div>
                                <div class="dashboard-stat-icon"><i class="ti-pie-chart"></i></div>
                            </a>	
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <a href="/profile/list-baidang?search_duyet=rejected"  class="dashboard-stat widget-4">
                                <div class="dashboard-stat-content"><h4>{{$tongBaidangHuy}}</h4> <span class="mt-3 fw-bold text-dark">{{ __('profile.rejected_posts') }}</span></div>
                                <div class="dashboard-stat-icon"><i class="fa-solid fa-location-dot"></i></div>
                            </a>	
                        </div>

                    </div>
            
                    <div class="dashboard-wraper">
                    
                        <!-- Basic Information -->
                        <div class="form-submit">	
                            <h4>{{ __('profile.personal_info') }}</h4>
                            <form method="POST" action="{{ route('profile.update',['user' => $user]) }}" enctype="multipart/form-data" class="submit-section mt-5">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group col-12">
                                            <div class="fr-grid-thumb mx-auto">
                                                <!-- Avatar Preview -->
                                                <label for="avatar-upload" class="d-inline-flex p-1 border cursor-pointer">
                                                    <img id="avatar-preview" src="{{ Auth::user()->avatar }}" width="300" class="img-fluid object-fit-cover" alt="" style="height: 300px; cursor: pointer;" />
                                                </label>
                                            
                                                <!-- Hidden File Input -->
                                                <input type="file" id="avatar-upload" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(event)" />
                                            
                                                <!-- Buttons -->
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('avatar-upload').click()">{{ __('profile.upload_image') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 col-12 row">
                                        <div class="form-group col-md-6">
                                            <label>{{ __('profile.name') }}</label>
                                            <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>{{ __('profile.phone') }}</label>
                                            <input type="text" class="form-control" name="phone" value="{{Auth::user()->phone}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('profile.role') }}</label>
                                            <input type="text" class="form-control" disabled value="{{Auth::user()->role}}">
                                        </div>
                                    </div>
                                    <div >
                                        <button class="btn btn-primary w-auto float-end" type="submit">{{ __('profile.update') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <!-- ============================ Call To Action End ================================== -->
    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
        </script>
@endsection