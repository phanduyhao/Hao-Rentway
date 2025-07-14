@extends('layout.layout')
@section('content')
    <!-- End Navigation -->
    <div class="clearfix"></div>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling"
        aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Compare & Selected Property</h5>
            <a href="#" data-bs-dismiss="offcanvas" aria-label="Close">
                <span class="svg-icon text-primary svg-icon-2hx">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                        <rect x="7" y="15.3137" width="12" height="2" rx="1"
                            transform="rotate(-45 7 15.3137)" fill="currentColor" />
                        <rect x="8.41422" y="7" width="12" height="2" rx="1"
                            transform="rotate(45 8.41422 7)" fill="currentColor" />
                    </svg>
                </span>
            </a>
        </div>
        <div class="offcanvas-body">
            <ul class="nav nav-pills sider_tab mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-compare-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-compare" type="button" role="tab" aria-controls="pills-compare"
                        aria-selected="true">Compare Property</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-saved-tab" data-bs-toggle="pill" data-bs-target="#pills-saved"
                        type="button" role="tab" aria-controls="pills-saved" aria-selected="false">Saved
                        Property</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-compare" role="tabpanel"
                    aria-labelledby="pills-compare-tab" tabindex="0">
                    <div class="sidebar_featured_property">

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-1.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Loss vengel New Apartment</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Sans Fransico</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix sale">For Sale</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$4,240</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-4.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Montreal Quriqe Apartment</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Liverpool, London</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix">For Rent</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$7,380</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-7.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Curmic Studio For Office</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Montreal, Canada</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix buy">For Buy</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$8,730</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-5.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Montreal Quebec City</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Sreek View, New
                                    York</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix">For Rent</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$6,240</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <a href="compare-property.html" class="btn btn-light-primary fw-medium full-width">View &
                                Compare</a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-saved" role="tabpanel" aria-labelledby="pills-saved-tab"
                    tabindex="0">
                    <div class="sidebar_featured_property">

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-2.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Loss vengel New Apartment</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Sans Fransico</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix sale">For Sale</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$4,240</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-3.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Montreal Quriqe Apartment</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Liverpool,
                                    London</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix">For Rent</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$7,380</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-4.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Curmic Studio For Office</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Montreal, Canada</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix buy">For Buy</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$8,730</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- List Sibar Property -->
                        <div class="sides_list_property p-2">
                            <div class="sides_list_property_thumb">
                                <img src="/temp/assets/img/p-27.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="sides_list_property_detail">
                                <h4><a href="single-property-1.html">Montreal Quebec City</a></h4>
                                <span class="text-muted-2"><i class="fa-solid fa-location-dot"></i>Sreek View, New
                                    York</span>
                                <div class="lists_property_price">
                                    <div class="lists_property_types">
                                        <div class="property_types_vlix">For Rent</div>
                                    </div>
                                    <div class="lists_property_price_value">
                                        <h4 class="text-primary">$6,240</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <a href="#" class="btn btn-light-primary fw-medium full-width">View & Compare</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->

    <!-- ============================ Page Title Start================================== -->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">

                    <h2 class="ipt-title">{{ __('common.login') }}</h2>
                    <span class="ipn-subtitle">{{ __('common.login_now') }}!</span>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Signup Form Start ================================== -->
    <section class="gray-simple">
        <div class="container">


            <!-- row Start -->
            <div class="row justify-content-center">

                <!-- Single blog Grid -->
                <div class="col-xl-7 col-lg-8 col-md-9">
                    <div class="card border-0 rounded-4 p-xl-4 p-lg-4 p-md-4 p-3">

                        <div class="simple-form">
                            <div class="form-header text-center mb-5">
                                <div class="effco-logo mb-2">
                                    <a class="d-flex align-items-center justify-content-center" href="/">
                                        <span class="svg-icon text-primary svg-icon-2hx">
                                            <svg width="90" height="90" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M15.8797 15.375C15.9797 15.075 15.9797 14.775 15.9797 14.475C15.9797 13.775 15.7797 13.075 15.4797 12.475C14.7797 11.275 13.4797 10.475 11.9797 10.475C11.7797 10.475 11.5797 10.475 11.3797 10.575C7.37971 11.075 4.67971 14.575 2.57971 18.075L10.8797 3.675C11.3797 2.775 12.5797 2.775 13.0797 3.675C13.1797 3.875 13.2797 3.975 13.3797 4.175C15.2797 7.575 16.9797 11.675 15.8797 15.375Z"
                                                    fill="currentColor" />
                                                <path opacity="0.3"
                                                    d="M20.6797 20.6749C16.7797 20.6749 12.3797 20.275 9.57972 17.575C10.2797 18.075 11.0797 18.375 11.9797 18.375C13.4797 18.375 14.7797 17.5749 15.4797 16.2749C15.6797 15.9749 15.7797 15.675 15.7797 15.375V15.2749C16.8797 11.5749 15.2797 7.47495 13.2797 4.07495L21.6797 18.6749C22.2797 19.5749 21.6797 20.6749 20.6797 20.6749ZM8.67972 18.6749C8.17972 17.8749 7.97972 16.975 7.77972 15.975C7.37972 13.575 8.67972 10.775 11.3797 10.375C7.37972 10.875 4.67972 14.375 2.57972 17.875C2.47972 18.075 2.27972 18.375 2.17972 18.575C1.67972 19.475 2.27972 20.475 3.27972 20.475H10.3797C9.67972 20.175 9.07972 19.3749 8.67972 18.6749Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                                <h4 class="fs-2">{{ __('common.login') }}</h4>
                            </div>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf <!-- Bắt buộc để bảo vệ CSRF -->

                                <div class="row">
                                    <!-- Nhập Email -->
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="login">{{ __('common.phone_number') }} / Username</label>
                                            <input type="text" class="form-control" name="login" id="login"
                                                placeholder="098XXXXXXX / Username"
                                                value="{{ old('login') }}" required>
                                            @error('login')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>

                                    <!-- Nhập Mật khẩu -->
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="password">Mật khẩu</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="*******" required>
                                            @error('password')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Nhớ mật khẩu & Quên mật khẩu -->
                                    <div class="form-group mb-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <!-- Checkbox "Nhớ mật khẩu" -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="remember"
                                                    name="remember">
                                                <label class="form-check-label"
                                                    for="remember">{{ __('common.remember_password') }}</label>
                                            </div>

                                            <!-- Link "Quên mật khẩu?" -->
                                            <div>
                                                <a href="{{ route('showForgotPass') }}"
                                                    class="link fw-medium">{{ __('common.pass_forgot') }}?</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Nút Đăng nhập -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary full-width fw-medium">
                                        {{ __('common.login') }} <i class="fa-solid fa-arrow-right-long ms-2"></i>
                                    </button>
                                </div>
                            </form>

                            <div>
                                <a href="{{ route('showRegister') }}"
                                    class="link fw-medium">{{ __('common.sign_up_here') }}</a>
                            </div>
                        </div>

                        <div class="modal-divider"><span>{{ __('common.or') }}</span></div>
                        <div class="social-login mb-3">
                            <ul class="d-block">
                                {{-- <li><a href="{{ route('facebook.login') }}" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li> --}}
                                <li class="w-100"><a href="{{ route('google.login') }}" class="btn connect-google"><i
                                            class="ti-google"></i>Google+</a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /row -->

        </div>

    </section>
    <!-- ============================ Footer Start ================================== -->
@endsection
