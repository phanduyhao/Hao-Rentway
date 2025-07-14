@extends('layout.layout')
@section('content')
<style>
     .gradient-text {
            font-weight: bold;
            background-image: linear-gradient(90deg, #ff0000, #ff3333, #ff6666, #ff9999, #ffcccc, #ff0000);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: gradient-move 3s linear infinite;
        }
        
        @keyframes gradient-move {
            100% {
                background-position: 0% center;
            }
            0% {
                background-position: 200% center;
            }
        }
</style>
    @php
        $showPost = false;
    @endphp
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

    <!-- ============================ Hero Banner  Start================================== -->
    <div class="image-cover hero-banner" style="background:#eff6ff url({{ $settings['banner'] }}) no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11 col-sm-12">
                    {{-- <img class="img-fluid" src="/images/banner.jpeg" alt=""> --}}
                    <div class="inner-banner-text text-center mb-md-4 mb-3">
                        <p class="fs-2 fw-bold text-black">{{ __('home.title') }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div><a class="fw-bold border bg-success p-2 rounded-3 text-white"
                                href="{{ route('postPage') }}">{{ __('common.post_full') }}</a></div>
                        <div><a class="fw-bold border bg-success p-2 rounded-3 text-white"
                                href="{{ route('baidangnhanh.index') }}">{{ __('common.quick_post') }}</a></div>
                    </div>
                    <div class="full-search-2 eclip-search italian-search hero-search-radius shadow-hard mt-3">
                        <div class="hero-search-content">
                            <form method="get" method="GET" action="{{ route('posts.list') }}" class="form-group">
                                @csrf
                                <div class="row justify-content-between">
                                    <div class="col-xl-9 col-lg-6 col-md-4 col-sm-12 p-md-0 elio">
                                        <div class="form-group border-start borders">
                                            <div class="position-relative">
                                                <input type="text" name="ten_baidang"
                                                    class="form-control border-0 ps-5"
                                                    placeholder="{{ __('common.search_name_id') }}">
                                                <div class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                    <span class="svg-icon text-primary svg-icon-2hx">
                                                        <svg width="25" height="25" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3"
                                                                d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                                fill="currentColor" />
                                                            <path
                                                                d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-dark full-width">{{ __('common.search') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="bg-white p-4 mt-4 border rounded-2">
                        <p class="fs-4 text-center fw-bold gradient-text">{{ __('home.title_search') }}</p>
                        <form action="{{ route('posts.list') }}" method="GET">
                            <!-- Phần địa chỉ: Luôn hiển thị -->
                            <div class="row">
                                <div class="form-group col-md-3 col-6 mt-3">
                                    <label><span class="text-danger">*</span> {{ __('common.country') }} </label>
                                    <select id="country" class="form-control" name="country">
                                        <option value="">{{ __('common.select_country') }} </option>
                                        <option value="Vietnam" {{ request('country') == 'Vietnam' ? 'selected' : '' }}>
                                            {{ __('common.country.vietnam') }} </option>
                                        <option value="Philippines"
                                            {{ request('country') == 'Philippines' ? 'selected' : '' }}>Philippines
                                        </option>
                                        <option value="Thailand" {{ request('country') == 'Thailand' ? 'selected' : '' }}>
                                            {{ __('common.country.thailand') }} </option>
                                        <option value="Campuchia"
                                            {{ request('country') == 'Campuchia' ? 'selected' : '' }}>Campuchia</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-6 mt-3">
                                    <label>{{ __('common.province_city') }} </label>
                                    <select id="province" class="form-control" name="province">
                                        <option value="">{{ __('common.select_province_city') }} </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-6 mt-3">
                                    <label>{{ __('common.district') }} </label>
                                    <select id="district" class="form-control" name="districts">
                                        <option value="">{{ __('common.select_district') }} </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-6 mt-3">
                                    <label>{{ __('common.ward') }} </label>
                                    <select id="ward" class="form-control" name="wards">
                                        <option value="">{{ __('common.select_ward') }} </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Collapse: các trường nâng cao -->
                            <div class="collapse" id="advancedFilter">
                                <div class="row g-3 pt-3">
                                    <!-- Các trường nâng cao bạn đã có: copy y nguyên như trước -->
                                    <div class="col-md-4 mb-4">
                                        <label for="author" class="form-label">{{ __('common.poster') }} </label>
                                        <select id="author" class="form-control" name="author">
                                            <option value="">{{ __('common.select_poster') }} </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->name }}"
                                                    {{ request('author') == $user->name ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                     <div class="col-md-4">
                                        <label for="date" class="form-label">{{ __('common.start_date') }} </label>
                                        <input type="date" class="form-control" id="date" name="start_date"
                                            value="{{ request('start_date') }}">
                                    </div>
                                      <div class="col-md-4">
                                        <label for="date" class="form-label">{{ __('common.end_date') }} </label>
                                        <input type="date" class="form-control" id="date" name="end_date"
                                            value="{{ request('end_date') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                            <label>{{ __('common.model') }}</label>
                                            <select id="mohinh" class="form-control mt-2" name="mohinh">
                                                <option value="thue">{{ __('common.model.rent') }}</option>
                                                <option value="ban">{{ __('common.model.sale') }}</option>
                                                <option value="chuyennhuong">{{ __('common.model.transfer') }}</option>
                                                <option value="oghep">{{ __('common.model.roommate') }}</option>
                                            </select>
                                        </div>
                                    <div class="form-group col-md-6">
                                        <label>{{ __('common.property_type') }} </label>
                                        <select class="form-control mt-2" id="loainhadat" name="loainhadat">
                                            <option value="">{{ __('common.select_property_type') }} </option>
                                            @foreach ($listnhadats as $loainhadat)
                                                <option value="{{ $loainhadat->id }}"
                                                    {{ request('loainhadat') == $loainhadat->id ? 'selected' : '' }}>
                                                    {{ $loainhadat->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-danger form-label">{{ __('common.price') }} </label>
                                        <div class="input-group mb-2">
                                            <!-- Nhập giá từ -->
                                            <input type="text" class="form-control" id="priceMinDisplay"
                                                style="max-width:80px"
                                                value="{{ request('price_min') ? number_format(request('price_min') / 1000, 2, '.', '') : '' }}">
                                            <select id="priceMinUnit" class="form-select"
                                                style="max-width: 100px; font-size:14px">
                                                <option value="1000"
                                                    {{ request()->has('price_min') && request('price_min') < 1000000 ? 'selected' : '' }}>
                                                    {{ __('common.thousand') }} </option>
                                                <option value="1000000"
                                                    {{ !request()->has('price_min') || (request('price_min') >= 1000000 && request('price_min') < 1000000000) ? 'selected' : '' }}>
                                                    {{ __('common.million') }} </option>
                                                <option value="1000000000"
                                                    {{ request()->has('price_min') && request('price_min') >= 1000000000 ? 'selected' : '' }}>
                                                    {{ __('common.billion') }} </option>
                                            </select>

                                            <span class="input-group-text border-0 bg-white">–</span>

                                            <!-- Nhập giá đến -->
                                            <input type="text" class="form-control" id="priceMaxDisplay"
                                                style="max-width:80px"
                                                value="{{ request('price_max') ? number_format(request('price_max') / 1000, 2, '.', '') : '' }}">
                                            <select id="priceMaxUnit" class="form-select"
                                                style="max-width: 100px; font-size:14px">
                                                <option value="1000"
                                                    {{ request()->has('price_max') && request('price_max') < 1000000 ? 'selected' : '' }}>
                                                    {{ __('common.thousand') }} </option>
                                                <option value="1000000"
                                                    {{ !request()->has('price_max') || (request('price_max') >= 1000000 && request('price_max') < 1000000000) ? 'selected' : '' }}>
                                                    {{ __('common.million') }} </option>
                                                <option value="1000000000"
                                                    {{ request()->has('price_max') && request('price_max') >= 1000000000 ? 'selected' : '' }}>
                                                    {{ __('common.billion') }} </option>
                                            </select>
                                        </div>

                                        <!-- Hidden inputs sẽ submit dữ liệu thực -->
                                        <input type="hidden" name="price_min" id="priceMin">
                                        <input type="hidden" name="price_max" id="priceMax">

                                        <!-- Hiển thị kết quả -->
                                        <small class="text-danger">
                                            {{ __('common.from') }} <span id="priceMinResult">0</span> <span
                                                id="priceMinLabel"></span>
                                            {{ __('common.to') }} <span id="priceMaxResult">0</span> <span
                                                id="priceMaxLabel"></span>
                                        </small>
                                    </div>

                                    <div class="col-md-6" id="area-form">
                                        <label class="form-label">{{ __('common.acreage') }} (m²)</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="area_min"
                                                placeholder="{{ __('common.from') }} "
                                                value="{{ request('area_min') }}">
                                            <span class="input-group-text">-</span>
                                            <input type="number" class="form-control" name="area_max"
                                                placeholder="{{ __('common.to') }} " value="{{ request('area_max') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>{{ __('common.bedroom') }}</label>
                                        <input type="number" class="form-control" name="bedrooms"
                                            value="{{ request('bedrooms') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>{{ __('common.bathroom') }}</label>
                                        <input type="number" class="form-control" name="bathrooms"
                                            value="{{ request('bathrooms') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>{{ __('common.balcony') }}</label>
                                        <div class="d-flex">
                                            <div class="form-check me-3 d-flex align-items-center">
                                                <input class="form-check-input me-2" type="radio" name="huongbancong"
                                                    id="balcony-yes" value="1">
                                                <label class="form-check-label" for="balcony-yes">
                                                    {{ __('common.yes') }}
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input me-2" type="radio" name="huongbancong"
                                                    id="balcony-no" value="0">
                                                <label class="form-check-label" for="balcony-no">
                                                    {{ __('common.no') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>{{ __('common.house_direction') }}</label>
                                        @include('component.house_direction', ['selectedValue' => ''])

                                    </div>
                                </div>
                            </div>

                            <!-- Nút submit -->
                            <div class="text-end mt-4 d-flex align-items-center gap-3 justify-content-end">
                                <!-- Nút lọc thêm -->
                                <a class="btn btn-link border bg-light" data-bs-toggle="collapse" href="#advancedFilter"
                                    role="button" aria-expanded="false" aria-controls="advancedFilter">
                                    🔍 {{ __('common.extend') }}
                                </a>
                                <button type="submit" class="btn btn-primary">{{ __('common.search') }}</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Hero Banner End ================================== -->
    <section class="bg-light">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-10 text-center">
                    <div class="sec-heading mss mx-auto">
                        <h2>{{ __('home.newest_listing') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                @foreach ($baidangnews as $item)
                    <!-- Single Property -->
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                        <div class="property-listing card border-0 rounded-3">

                            <div class="listing-img-wrapper p-3 pb-0">
                                <div class="position-relative">
                                    <div class=" position-absolute top-0 left-0 ms-3 mt-3 z-1">
                                        @if ($item->isVip)
                                            <div
                                                class="label bg-success text-light d-inline-flex align-items-center justify-content-center">
                                                <span class="svg-icon text-light svg-icon-2hx me-1 fw-bold">
                                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M14.854 11.321C14.7568 11.2282 14.6388 11.1818 14.4998 11.1818H14.3333V10.2272C14.3333 9.61741 14.1041 9.09378 13.6458 8.65628C13.1875 8.21876 12.639 8 12 8C11.361 8 10.8124 8.21876 10.3541 8.65626C9.89574 9.09378 9.66663 9.61739 9.66663 10.2272V11.1818H9.49999C9.36115 11.1818 9.24306 11.2282 9.14583 11.321C9.0486 11.4138 9 11.5265 9 11.6591V14.5227C9 14.6553 9.04862 14.768 9.14583 14.8609C9.24306 14.9536 9.36115 15 9.49999 15H14.5C14.6389 15 14.7569 14.9536 14.8542 14.8609C14.9513 14.768 15 14.6553 15 14.5227V11.6591C15.0001 11.5265 14.9513 11.4138 14.854 11.321ZM13.3333 11.1818H10.6666V10.2272C10.6666 9.87594 10.7969 9.57597 11.0573 9.32743C11.3177 9.07886 11.6319 8.9546 12 8.9546C12.3681 8.9546 12.6823 9.07884 12.9427 9.32743C13.2031 9.57595 13.3333 9.87594 13.3333 10.2272V11.1818Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                    Vip
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="position-absolute top-0 end-0 me-3 mt-3 z-1">
                                        <div
                                            class="label bg-danger text-light d-inline-flex align-items-center justify-content-center">
                                            <span class="svg-icon fw-bold ght svg-icon-2hx me-1">
                                                {{ $item->mabaidang }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="list-img-slide">
                                        <div class="clior">
                                            @foreach (json_decode($item->images, true) ?? [] as $image)
                                                <div><a href="{{ route('baidangDetail', $item->slug) }}"><img
                                                            src="{{ $image }}"
                                                            class="mx-auto img-custom rounded-4" alt="" /></a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @guest
                                @else
                                    @if ((Auth::check() && Auth::user()->role == 'admin') || Auth::user()->role == 'nhanvien')
                                        <select class="position-absolute top-0 start-0 z-1 status-select bg-info text-white "
                                            data-id="{{ $item->id }} ">
                                            <option value="cosan" {{ $item->status == 'cosan' ? 'selected' : '' }}>Có sẵn
                                            </option>
                                            <option value="dathue" {{ $item->status == 'dathue' ? 'selected' : '' }}>Đã thuê
                                            </option>
                                            <option value="hethan" {{ $item->status == 'hethan' ? 'selected' : '' }}>Đã bán
                                            </option>
                                        </select>
                                        <div class="position-absolute top-0 end-0 z-1 d-flex align-items-center">
                                            <a href="{{ route('baidang.edit', $item->slug) }}"
                                                class="label bg-warning text-light d-inline-flex align-items-center justify-content-center p-1">
                                                <img src="/temp/images/edit.png" width="16px" alt="">
                                            </a>
                                            <form class="d-inline" action="{{ route('baidang.destroy', $item->id) }}"
                                                method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-transparent border-0">
                                                    <img src="/temp/images/bin.png" width="24px" alt="">
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endguest
                            </div>

                            <div class="listing-caption-wrapper px-3 mt-2">
                                <div class="listing-detail-wrapper">
                                    <div class="listing-short-detail-wrap">
                                        <div class="listing-short-detail">
                                            <div class="d-flex align-items-center mb-1">
                                                <div>
                                                    @if (isset($item->address) &&
                                                            isset($item->address->ward) &&
                                                            isset($item->address->ward->district) &&
                                                            isset($item->address->ward->district->province) &&
                                                            $item->address->ward->district->province->country == 'Vietnam')
                                                        <span
                                                            class="label bg-light-danger text-danger fw-bold property-cats me-2">
                                                            {{ $item->address->ward->district->province->country }}
                                                        </span>
                                                    @elseif(isset($item->address) &&
                                                            isset($item->address->ward) &&
                                                            isset($item->address->ward->district) &&
                                                            isset($item->address->ward->district->province) &&
                                                            $item->address->ward->district->province->country == 'Philippines')
                                                        <span
                                                            class="label bg-light-info text-info fw-bold property-cats me-2">
                                                            {{ $item->address->ward->district->province->country }}
                                                        </span>
                                                    @elseif(isset($item->address) &&
                                                            isset($item->address->ward) &&
                                                            isset($item->address->ward->district) &&
                                                            isset($item->address->ward->district->province) &&
                                                            $item->address->ward->district->province->country == 'Thailand')
                                                        <span
                                                            class="label bg-light-warning text-warning fw-bold property-cats me-2">
                                                            {{ $item->address->ward->district->province->country }}
                                                        </span>
                                                    @elseif(isset($item->address) &&
                                                            isset($item->address->ward) &&
                                                            isset($item->address->ward->district) &&
                                                            isset($item->address->ward->district->province) &&
                                                            $item->address->ward->district->province->country == 'Campuchia')
                                                        <span
                                                            class="label bg-light-danger text-danger fw-bold property-cats me-2">
                                                            {{ $item->address->ward->district->province->country }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="label bg-light-secondary text-secondary fw-bold property-cats me-2">
                                                            Không có quốc gia
                                                        </span>
                                                    @endif
                                                    <span
                                                        class="label bg-light-success text-success prt-type me-2 fw-bold">
                                                        @php
                                                            $moHinhMap = [
                                                                'thue' => __('common.model.rent'),
                                                                'ban' => __('common.model.sale'),
                                                                'chuyennhuong' => __('common.model.transfer'),
                                                                'oghep' => __('common.model.roommate'),
                                                            ];
                                                        @endphp

                                                        {{ $moHinhMap[$item->mohinh] ?? 'Không xác định' }}
                                                    </span>
                                                    <span class="label bg-light-purple text-purple fw-bold property-cats">
                                                        @php
                                                            $propertyTypeMap = [
                                                                'can-ho-chung-cu' => 'apartment',
                                                                'nha-dan' => 'private_house',
                                                                'phong-tro' => 'rental_room',
                                                                'biet-thu' => 'villa',
                                                                'khach-san' => 'hotel',
                                                                'van-phong-cong-ty' => 'office',
                                                                'mat-bang-kinh-doanh' => 'business',
                                                            ];
                                                        @endphp
                                                        {{ __('common.property_type.' . ($propertyTypeMap[$item->nhadat->slug] ?? 'unknown')) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <h4 class="listing-name fw-semibold fs-6 my-2">
                                                <a href="{{ route('baidangDetail', $item->slug) }}"
                                                    class="prt-link-detail">
                                                    @if (App::getLocale() === 'vi')
                                                        {!! $item->title !!}
                                                    @else
                                                        {!! $item->title_en ?? $item->title !!}
                                                    @endif
                                                </a>

                                            </h4>
                                            <div class="prt-location text-muted-2 truncate-text">
                                                <span class="svg-icon svg-icon-2hx">
                                                    <svg width="18" height="18" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M18.0624 15.3453L13.1624 20.7453C12.5624 21.4453 11.5624 21.4453 10.9624 20.7453L6.06242 15.3453C4.56242 13.6453 3.76242 11.4453 4.06242 8.94534C4.56242 5.34534 7.46242 2.44534 11.0624 2.04534C15.8624 1.54534 19.9624 5.24534 19.9624 9.94534C20.0624 12.0453 19.2624 13.9453 18.0624 15.3453Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M12.0624 13.0453C13.7193 13.0453 15.0624 11.7022 15.0624 10.0453C15.0624 8.38849 13.7193 7.04535 12.0624 7.04535C10.4056 7.04535 9.06241 8.38849 9.06241 10.0453C9.06241 11.7022 10.4056 13.0453 12.0624 13.0453Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>

                                                @php
                                                    $Quocgia = [
                                                        'Vietnam' => 'Việt Nam',
                                                        'Philippines' => 'Philippines',
                                                        'Thailand' => 'Thái Lan',
                                                        'Campuchia' => 'Campuchia',
                                                    ];
                                                @endphp

                                                @if (isset($item->address) &&
                                                        isset($item->address->ward) &&
                                                        isset($item->address->ward->district) &&
                                                        isset($item->address->ward->district->province))
                                                    @php
                                                        // Khởi tạo một mảng để lưu các phần có giá trị của địa chỉ
                                                        $addressParts = [];

                                                        // Thêm các phần vào mảng nếu chúng có giá trị
                                                        if (!empty($item->address->street)) {
                                                            $addressParts[] = $item->address->street;
                                                        }
                                                        if (!empty($item->address->ward->name)) {
                                                            $addressParts[] = $item->address->ward->name;
                                                        }
                                                        if (!empty($item->address->ward->district->name)) {
                                                            $addressParts[] = $item->address->ward->district->name;
                                                        }
                                                        if (!empty($item->address->ward->district->province->name)) {
                                                            $addressParts[] =
                                                                $item->address->ward->district->province->name;
                                                        }

                                                        // Kiểm tra nếu quốc gia có tồn tại
                                                        $country = isset(
                                                            $item->address->ward->district->province->country,
                                                        )
                                                            ? $Quocgia[
                                                                    $item->address->ward->district->province->country
                                                                ] ?? 'Không có quốc gia'
                                                            : 'Không có quốc gia';
                                                        $addressParts[] = $country;

                                                        // Kết hợp các phần của địa chỉ lại với nhau, ngăn cách bằng dấu phẩy nếu có phần không rỗng
                                                        $fullAddress = implode(', ', $addressParts);

                                                        // In ra địa chỉ đầy đủ
                                                        echo $fullAddress;
                                                    @endphp
                                                @endif


                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="price-features-wrapper d-flex align-items-center justify-content-between my-4">
                                    <div class="listing-short-detail-flex">
                                        <h6 class="listing-card-info-price text-primary ps-0 m-0">
                                            @if ($item->price == null)
                                                <span>{{ __('post.price_negotiable') }}</span>
                                            @else
                                                @php
                                                    $country = strtolower(
                                                        $item->address->ward->district->province->country ?? 'vietnam',
                                                    );
                                                    $formattedPrice = '';

                                                    switch ($country) {
                                                        case 'vietnam':
                                                            $formattedPrice =
                                                                number_format($item->price, 0, ',', '.') . ' ₫';
                                                            break;
                                                        case 'philippines':
                                                            $formattedPrice =
                                                                '₱' . number_format($item->price, 2, '.', ',');
                                                            break;
                                                        case 'thailand':
                                                            $formattedPrice =
                                                                '฿' . number_format($item->price, 2, '.', ',');
                                                            break;
                                                        case 'campuchia':
                                                            $formattedPrice =
                                                                '៛' . number_format($item->price, 0, ',', '.');
                                                            break;
                                                        default:
                                                            $formattedPrice =
                                                                number_format($item->price, 2) . ' (unknown currency)';
                                                    }
                                                @endphp

                                                <h6 class="listing-info-price text-primary fs-4 mb-0">
                                                    {{ $formattedPrice }}
                                                    @if ($item->mohinh != 'ban')
                                                        / {{ $item->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                                    @endif
                                                </h6>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="lst-detail-footer border-top py-2 px-3">
                                <div class="price-features-wrapper mb-3">
                                    <div class="list-fx-features d-flex align-items-center justify-content-between">
                                        <div class="listing-card d-flex align-items-center">
                                            <div class="square--30 text-muted-2 fs-sm circle gray-simple me-2"><img
                                                    src="/temp/assets/img/bed.svg" width="20" alt=""></div>
                                            <span class="text-muted-2">{{ $item->bedrooms }}
                                                {{ __('common.bedroom') }}</span>
                                        </div>
                                        <div class="listing-card d-flex align-items-center">
                                            <div class="square--30 text-muted-2 fs-sm circle gray-simple me-2"><img
                                                    src="/temp/assets/img/bathtub.svg" width="20" alt="">
                                            </div><span class="text-muted-2">{{ $item->bathrooms }}
                                                {{ __('common.bathroom') }}</span>
                                        </div>
                                        <div class="listing-card d-flex align-items-center">
                                            <div class="square--30 text-muted-2 fs-sm circle gray-simple me-2"><i
                                                    class="fa-solid fa-building-shield fs-sm"></i></div><span
                                                class="text-muted-2">{{ $item->dientich }} m<sub>2</sub></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <a href="{{ route('posts.list') }}"
                        class="btn btn-primary px-lg-5 rounded">{{ __('home.see_all') }}</a>
                </div>
            </div>

        </div>
    </section>
    <!-- ============================ Category Start ================================== -->
    <section>
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2>{{ __('home.discover_categories') }}</h2>
                    </div>
                </div>
            </div>

            {{-- <div class="row justify-content-center gx-3 gy-3">
                @foreach ($listnhadats as $item)
                    <div class="col-xl-2 col-3">
                        <div class="classical-cats-wrap">
                            <a class="classical-cats-boxs" href="{{ route('listByNhadat', ['slug' => $item->slug]) }}">
                                <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                    @if ($item->icon != null)
                                        <img src="{{ $item->icon }} " width="36" alt="">
                                    @else
                                        <i class="fa-solid fa-house"></i>
                                    @endif
                                </div>
                                <div class="">
                                    <span class="fw-semibold">{{ $item->title }}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div> --}}
            <div class="row justify-content-center gx-3 gy-3">
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/can-ho-chung-cu">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/can-ho-chung-cu.jpg " width="36" alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.office') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/nha-dan">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/nha-dan.jpg " width="36" alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.private_house') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/phong-tro">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/phong-tro.jpg " width="36" alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.rental_room') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/biet-thu">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/biet-thu.jpg " width="36" alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.villa') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/khach-san">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/khach-san.jpg " width="36" alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.hotel') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/van-phong-cong-ty">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/van-phong-cong-ty.jpg " width="36" alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.office') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-2 col-3">
                    <div class="classical-cats-wrap">
                        <a class="classical-cats-boxs" href="/posts/baidang/loai/mat-bang-kinh-doanh">
                            <div class="classical-cats-icon px-4 py-4 rounded bg-light-success text-success fs-2">
                                <img src="/temp/images/loainhadat/mat-bang-kinh-doanh.jpg " width="36"
                                    alt="">
                            </div>
                            <div class="">
                                <span class="fw-semibold">{{ __('common.property_type.business') }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!-- ============================ Category End ================================== -->

    <section class="pt-0">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center">
                        <h2>{{ __('home.find_best_location') }}</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-xl-4 g-md-3 g-4">

                <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                    <div class="location-property-wrap rounded-4 p-2">
                        <div class="location-property-thumb rounded-4">
                            <a
                                href="{{ route('posts.list', ['province' => '1', 'province_name' => 'Thành phố Hà Nội']) }}"><img
                                    src="/temp/images/general/hanoi.jpg" class="img-loction-custom" alt=""></a>
                        </div>
                        <div class="location-property-content">
                            <div class="lp-content-flex">
                                <h4 class="lp-content-title">Thủ đô Hà Nội</h4>

                            </div>
                            <div class="lp-content-right">
                                <a href="{{ route('posts.list', ['province' => '1']) }}" class="text-primary">
                                    <span class="svg-icon svg-icon-2hx">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                rx="5" fill="currentColor"></rect>
                                            <path
                                                d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                    <div class="location-property-wrap rounded-4 p-2">
                        <div class="location-property-thumb rounded-4">
                            <a
                                href="{{ route('posts.list', ['province' => '48', 'province_name' => 'Thành phố Đà Nẵng']) }}"><img
                                    src="/temp/images/general/danang.jpg" class="img-loction-custom" alt=""></a>
                        </div>
                        <div class="location-property-content">
                            <div class="lp-content-flex">
                                <h4 class="lp-content-title">Thành phố Đà Nẵng</h4>

                            </div>
                            <div class="lp-content-right">
                                <a href="{{ route('posts.list', ['province' => '48']) }}" class="text-primary">
                                    <span class="svg-icon svg-icon-2hx">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                rx="5" fill="currentColor"></rect>
                                            <path
                                                d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                    <div class="location-property-wrap rounded-4 p-2">
                        <div class="location-property-thumb rounded-4">
                            <a href="{{ route('posts.list', ['province' => '79']) }}"><img
                                    src="/temp/images/general/tphcm.jpg" class="img-loction-custom" alt=""></a>
                        </div>
                        <div class="location-property-content">
                            <div class="lp-content-flex">
                                <h4 class="lp-content-title">Thành phố Hồ Chí Minh</h4>

                            </div>
                            <div class="lp-content-right">
                                <a href="{{ route('posts.list', ['province' => '79']) }}" class="text-primary">
                                    <span class="svg-icon svg-icon-2hx">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                rx="5" fill="currentColor"></rect>
                                            <path
                                                d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-4 col-6">
                    <div class="location-property-wrap rounded-4 p-2">
                        <div class="location-property-thumb rounded-4">
                            <a href="{{ route('posts.list', ['province' => '92']) }}"><img
                                    src="/temp/images/general/cantho.jpg" class="img-loction-custom" alt=""></a>
                        </div>
                        <div class="location-property-content">
                            <div class="lp-content-flex">
                                <h4 class="lp-content-title">Thành phố Cần Thơ</h4>

                            </div>
                            <div class="lp-content-right">
                                <a href="{{ route('posts.list', ['province' => '92']) }}" class="text-primary">
                                    <span class="svg-icon svg-icon-2hx">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                                rx="5" fill="currentColor"></rect>
                                            <path
                                                d="M11.9343 12.5657L9.53696 14.963C9.22669 15.2733 9.18488 15.7619 9.43792 16.1204C9.7616 16.5789 10.4211 16.6334 10.8156 16.2342L14.3054 12.7029C14.6903 12.3134 14.6903 11.6866 14.3054 11.2971L10.8156 7.76582C10.4211 7.3666 9.7616 7.42107 9.43792 7.87962C9.18488 8.23809 9.22669 8.72669 9.53696 9.03696L11.9343 11.4343C12.2467 11.7467 12.2467 12.2533 11.9343 12.5657Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <a href="{{ route('posts.list') }}"
                        class="btn btn-primary px-lg-5 rounded">{{ __('home.see_all') }}</a>
                </div>
            </div>

        </div>
    </section>

    <!-- ================================ All Property ========================================= -->

    <!-- ============================ All Featured Property ================================== -->

    {{-- 
<!-- ============================ Explore Featured Agents Start ================================== -->

<div class="clearfix"></div>
<!-- ============================ Explore Featured Agents End ================================== --> --}}


    <!-- ============================ Smart Testimonials ================================== -->
    <section class="gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center">
                        <h2>{{ __('home.good_review') }}</h2>
                        <p>{{ __('home.good_review_subtitle') }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-12 col-md-12">

                    <div class="smart-textimonials smart-center" id="smart-textimonials">

                        <!-- Đánh giá 1 -->
                        <div class="item">
                            <div class="item-box">
                                <div class="smart-tes-author">
                                    <div class="st-author-box">
                                        <div class="st-author-thumb">
                                            <div class="quotes bg-primary"><i class="fa-solid fa-quote-left"></i></div>
                                            <img src="/temp/images/usernam3.jpg" width="80" class="img-fluid"
                                                alt="" style="height: 80px; object-fit: cover;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-tes-content">
                                    <p>{{ __('home.nguyenvanhung.content') }}</p>
                                </div>

                                <div class="st-author-info">
                                    <h4 class="st-author-title">Nguyễn Văn Hùng</h4>
                                    <span class="st-author-subtitle">{{ __('home.nguyenvanhung.title') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Đánh giá 2 -->
                        <div class="item">
                            <div class="item-box">
                                <div class="smart-tes-author">
                                    <div class="st-author-box">
                                        <div class="st-author-thumb">
                                            <div class="quotes bg-success"><i class="fa-solid fa-quote-left"></i></div>
                                            <img src="/temp/images/usernam1.jpg" width="80" class="img-fluid"
                                                alt="" style="height: 80px; object-fit: cover;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-tes-content">
                                    <p>{{ __('home.phamquangdung.content') }}</p>
                                </div>

                                <div class="st-author-info">
                                    <h4 class="st-author-title">Phạm Quang Dũng</h4>
                                    <span class="st-author-subtitle">{{ __('home.phamquangdung.content') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Đánh giá 3 -->
                        <div class="item">
                            <div class="item-box">
                                <div class="smart-tes-author">
                                    <div class="st-author-box">
                                        <div class="st-author-thumb">
                                            <div class="quotes bg-purple"><i class="fa-solid fa-quote-left"></i></div>
                                            <img src="/temp/images/usernu2.jpg" class="img-fluid" alt="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-tes-content">
                                    <p>{{ __('home.tranminhthu.content') }}</p>
                                </div>

                                <div class="st-author-info">
                                    <h4 class="st-author-title">Trần Minh Thư</h4>
                                    <span class="st-author-subtitle">{{ __('home.tranminhthu.title') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Đánh giá 4 -->
                        <div class="item">
                            <div class="item-box">
                                <div class="smart-tes-author">
                                    <div class="st-author-box">
                                        <div class="st-author-thumb">
                                            <div class="quotes bg-seegreen"><i class="fa-solid fa-quote-left"></i></div>
                                            <img src="/temp/images/usernam2.jpg" width="80" class="img-fluid"
                                                alt="" style="height: 80px; object-fit: cover;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-tes-content">
                                    <p>{{ __('home.lehoangnam.content') }}.</p>
                                </div>

                                <div class="st-author-info">
                                    <h4 class="st-author-title">Lê Hoàng Nam</h4>
                                    <span class="st-author-subtitle">{{ __('home.lehoangnam.title') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Đánh giá 5 -->
                        <div class="item">
                            <div class="item-box">
                                <div class="smart-tes-author">
                                    <div class="st-author-box">
                                        <div class="st-author-thumb">
                                            <div class="quotes bg-danger"><i class="fa-solid fa-quote-left"></i></div>
                                            <img src="/temp/images/usernu1.jpg" width="80" class="img-fluid"
                                                alt="" style="height: 80px; object-fit: cover;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-tes-content">
                                    <p>{{ __('home.dangthutrang.content') }}</p>
                                </div>

                                <div class="st-author-info">
                                    <h4 class="st-author-title">Đặng Thu Trang</h4>
                                    <span class="st-author-subtitle">{{ __('home.dangthutrang.title') }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ============================ Smart Testimonials End ================================== -->

    <!-- ========================== Download App Section =============================== -->
    <section class="bg-light">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-7 col-md-12 col-sm-12 content-column">
                    <div class="content_block_2">
                        <div class="content-box">
                            <div class="sec-title light">
                                <p
                                    class="d-inline-flex align-items-center justify-content-center label bg-primary text-light">
                                    {{ __('home.download_app') }}</p>
                                <h2 class="fs-1 lh-base">{{ __('home.download_app_content') }}</h2>
                            </div>
                            <div class="btn-box clearfix mt-5">
                                <a href="index.html" class="download-btn play-store">
                                    <i class="fab fa-google-play"></i>
                                    <span>Downnload from</span>
                                    <h3>Google Play</h3>
                                </a>

                                <a href="index.html" class="download-btn app-store">
                                    <i class="fab fa-apple"></i>
                                    <span>Downnload from</span>
                                    <h3>App Store</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 col-sm-12 image-column">
                    <div class="image-box">
                        <figure class="image"><img src="/temp/assets/img/app.png" class="img-fluid" alt="">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mohinhSelect = document.getElementById('mohinh');
            const areaInput = document.getElementById('area-form');
            const bathroomsInput = document.querySelector('input[name="bathrooms"]');
            const houseDirectionSelect = document.getElementById('house_direction');
            const ptypesSelect = document.getElementById('loainhadat');
            // Hàm kiểm tra và hiển thị các trường
            function checkFieldsVisibility() {
                const mohinh = mohinhSelect.value;
                const ptypes = ptypesSelect.value;
            console.log(ptypes);

                // Hiển thị/ẩn các trường dựa trên lựa chọn
                // Diện tích (Bán)
                if (mohinh === 'ban') {
                    areaInput.style.display = 'block';
                } else {
                    areaInput.style.display = 'none';
                }
                if (ptypes !== '6' && ptypes !== '4') {
                    bathroomsInput.parentElement.style.display = 'block';
                } else {
                    bathroomsInput.parentElement.style.display = 'none';
                }

                // Xóa các lựa chọn hiện tại
                houseDirectionSelect.innerHTML = '';

                if (mohinh === 'thue') {
                    // Thêm các lựa chọn cho "Cho thuê"
                    houseDirectionSelect.innerHTML = `
                <option value="">{{ __('common.select_house_direction') }}</option>
                <option value="be_boi">{{ __('common.swimming_pool') }}</option>
                <option value="ngoai_troi">{{ __('common.outdoor') }}</option>
                <option value="duong">{{ __('common.street_view') }}</option>
            `;
                } else {
                    // Thêm các lựa chọn cho các loại giao dịch khác
                    houseDirectionSelect.innerHTML = `
                <option value="">{{ __('common.select_house_direction') }}</option>
                <option value="dong" >{{ __('common.east') }}</option>
                <option value="tay" >{{ __('common.west') }}</option>
                <option value="nam" >{{ __('common.south') }}</option>
                <option value="bac" >{{ __('common.north') }}</option>
                <option value="dongbac">{{ __('common.northeast') }}</option>
                <option value="dongnam" >{{ __('common.southeast') }}</option>
                <option value="taybac" >{{ __('common.northwest') }}</option>
                <option value="taynam" >{{ __('common.southwest') }}</option>
                <option value="dong_tu_trach" >{{ __('common.dong_tu_trach') }}</option>
                <option value="tay_tu_trach" >{{ __('common.tay_tu_trach') }}</option>
            `;
                }

            }

            // // Lắng nghe sự kiện thay đổi lựa chọn
            mohinhSelect.addEventListener('change', checkFieldsVisibility);
            ptypesSelect.addEventListener('change', checkFieldsVisibility);

            // // Kiểm tra hiển thị ban đầu
            checkFieldsVisibility();

        });
    </script>
@endsection
