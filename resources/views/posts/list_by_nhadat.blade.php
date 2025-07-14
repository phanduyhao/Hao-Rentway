@extends('layout.layout')
@section('content')
    <!-- ============================ All Property ================================== -->
    <section class="gray-simple">
        <div class="container">

            <div class="shorting-right">
                <form method="GET" action="{{ route('posts.list') }}" class="shorting-by border rounded" id="sort-form">
                    @csrf

                    {{-- Duy trì tất cả các query params trước đó (trừ shorty để tránh trùng lặp) --}}
                    @foreach (request()->query() as $key => $value)
                        @if ($key != 'shorty')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <select id="shorty" name="shorty" class="form-control rounded"
                        onchange="document.getElementById('sort-form').submit();">
                        <option value="">{{ __('listPost.sort_by') }}</option>
                        <option value="1" {{ request('shorty') == '1' ? 'selected' : '' }}>
                            {{ __('listPost.low_to_high') }}
                        </option>
                        <option value="2" {{ request('shorty') == '2' ? 'selected' : '' }}>
                            {{ __('listPost.high_to_low') }}
                        </option>
                        <option value="3" {{ request('shorty') == '3' ? 'selected' : '' }}>
                            {{ __('listPost.newest') }}
                        </option>
                    </select>
                </form>
            </div>
            {{-- <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="filter_search_opt">
                    <a href="javascript:void(0);" class="btn btn-dark full-width mb-4" onclick="openFilterSearch()">
                        <span class="svg-icon text-light svg-icon-2hx me-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor"></path>
                            </svg>
                        </span> Mở bộ lọc
                    </a>
                </div>
            </div>
        </div> --}}
            <div class="row">

                <!-- property Sidebar -->
                <div class="col-lg-4 col-md-12 col-sm-12">

                    <div class="simple-sidebar sm-sidebar" id="filter_search" style="left:0;">

                        <div class="search-sidebar_header">
                            <h4 class="ssh_heading">Close Filter</h4>
                            <button onclick="closeFilterSearch()" class="w3-bar-item w3-button w3-large"><i
                                    class="fa-regular fa-circle-xmark fs-5 text-muted-2"></i></button>
                        </div>

                        <!-- Find New Property -->
                        <div class="sidebar-widgets">

                            <div class="search-inner p-0">

                                <div class="filter-search-box">
                                    <form method="get" method="GET"
                                        action="{{ route('listByNhadat', ['slug' => $slugCurrent]) }}" class="form-group">
                                        @csrf
                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded-3 ps-5" name="ten_baidang"
                                                placeholder="{{ __('common.search_name_id') }}">
                                            <div class="position-absolute top-50 start-0 translate-middle-y ms-2">
                                                <span class="svg-icon text-primary svg-icon-2hx">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                                            height="2" rx="1"
                                                            transform="rotate(45 17.0365 15.1223)" fill="currentColor">
                                                        </rect>
                                                        <path
                                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <button class="btn btn-dark position-absolute top-0 end-0">
                                                {{ __('common.search') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="position-relative">
                                    <div
                                        class="verifyd-prt-block flex-fill full-width my-1 me-1 d-flex align-items-center justify-content-between gx-2">
                                        <div
                                            class="d-flex align-items-center justify-content-center justify-content-between border rounded-3 px-2 py-3 w-100">
                                            <div class="eliok-cliops d-flex align-items-center">
                                                <span class="svg-icon text-success svg-icon-2hx">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                </span><span
                                                    class="text-muted-2 fw-medium me-3 text-nowrap">{{ __('listPost.post_vip') }}</span>
                                            </div>
                                            <div
                                                class="form-check form-switch d-flex justify-content-center gx-2 m-0 align-items-center">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked"
                                                    {{ request('isVip') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mt-3 ">
                                        <button type="button" class="open-modal btn btn-white border fw-bold"
                                            data-bs-toggle="modal" data-bs-target="#filterModal">
                                            <img src="/temp/images/filter.png" width="30px" alt="">
                                            <span>{{ __('listPost.filter') }}</span>
                                        </button>
                                        <button type="button" class="btn btn-secondary text-nowrap float-end"
                                            onclick="window.location.href='{{ route('listByNhadat', ['slug' => $slugCurrent]) }}'">{{ __('listPost.reset') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-sticky" style="top:15%">
                        @include('component.categories')
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 list-layout">
                    <div class="row justify-content-center g-4">
                        <!-- Single Property -->
                        @foreach ($list_baidangs as $item)
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="property-listing list_view style_new row mx-auto">
                                    <div class="col-md-6 col-12">
                                        <div class="listing-img-wrapper position-relative">
                                            <div class="position-absolute top-0 left-0 ms-3 mt-3 z-1">
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
                                                                    class="img-fluid img-custom mx-auto rounded-4"
                                                                    alt="" /></a></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @guest
                                        @else
                                            @if ((Auth::check() && Auth::user()->role == 'admin') || Auth::user()->role == 'nhanvien')
                                                <select
                                                    class="position-absolute top-0 start-0 z-1 status-select bg-info text-white"
                                                    data-id="{{ $item->id }}">
                                                    <option value="cosan" {{ $item->status == 'cosan' ? 'selected' : '' }}>Có
                                                        sẵn</option>
                                                    <option value="dathue" {{ $item->status == 'dathue' ? 'selected' : '' }}>
                                                        Đã thuê</option>
                                                    <option value="hethan" {{ $item->status == 'hethan' ? 'selected' : '' }}>
                                                        Đã bán</option>
                                                </select>
                                                <div class="position-absolute top-0 end-0 z-1 d-flex">
                                                    <a href="{{ route('baidang.edit', $item->slug) }}"
                                                        class="label bg-warning text-light d-inline-flex align-items-center justify-content-center p-1">
                                                        <img src="/temp/images/edit.png" width="16px" alt="">
                                                    </a>
                                                    <form class="d-inline" action="{{ route('baidang.destroy', $item->id) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
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

                                    <div class="col-md-6 col-12">
                                        <div class="list_view_flex">
                                            <div class="listing-detail-wrapper mt-1">
                                                <div class="listing-short-detail-wrap">
                                                    <div class="_card_list_flex mb-2">
                                                        <div class="_card_flex_01 d-flex align-items-center">
                                                            <span
                                                                class="label bg-light-purple text-purple fw-bold">{{ $item->mohinh == 'thue' ? __('common.model.rent') : __('common.model.sale') }}</span>
                                                        </div>
                                                        <div class="_card_flex_last">
                                                            @if ($item->price == null)
                                                                <h6>{{ __('post.price_negotiable') }}</h6>
                                                            @else
                                                                @php
                                                                    $country = strtolower(
                                                                        $item->address->ward->district->province
                                                                            ->country ?? 'vietnam',
                                                                    );
                                                                    $formattedPrice = '';

                                                                    switch ($country) {
                                                                        case 'vietnam':
                                                                            $formattedPrice =
                                                                                number_format(
                                                                                    $item->price,
                                                                                    0,
                                                                                    ',',
                                                                                    '.',
                                                                                ) . ' ₫';
                                                                            break;
                                                                        case 'philippines':
                                                                            $formattedPrice =
                                                                                '₱' .
                                                                                number_format(
                                                                                    $item->price,
                                                                                    2,
                                                                                    '.',
                                                                                    ',',
                                                                                );
                                                                            break;
                                                                        case 'thailand':
                                                                            $formattedPrice =
                                                                                '฿' .
                                                                                number_format(
                                                                                    $item->price,
                                                                                    2,
                                                                                    '.',
                                                                                    ',',
                                                                                );
                                                                            break;
                                                                        case 'campuchia':
                                                                            $formattedPrice =
                                                                                '៛' .
                                                                                number_format(
                                                                                    $item->price,
                                                                                    0,
                                                                                    ',',
                                                                                    '.',
                                                                                );
                                                                            break;
                                                                        default:
                                                                            $formattedPrice =
                                                                                number_format($item->price, 2) .
                                                                                ' (unknown currency)';
                                                                    }
                                                                @endphp

                                                                <h6 class="listing-info-price text-primary fs-4 mb-0">
                                                                    {{ $formattedPrice }}
                                                                    @if ($item->mohinh != 'ban')
                                                                        / {{ $item->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                                                    @endif
                                                                </h6>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="_card_list_flex">
                                                        <div class="_card_flex_01">
                                                            <h4 class="listing-name mt-2"><a
                                                                    href="{{ route('baidangDetail', $item->slug) }}"
                                                                    class="prt-link-detail mt-3">
                                                                    @if (App::getLocale() === 'vi')
                                                                        {!! $item->title !!}
                                                                    @else
                                                                        {!! $item->title_en ?? $item->title !!}
                                                                    @endif
                                                                </a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $Quocgia = [
                                                            'Vietnam' => 'Việt Nam',
                                                            'Philippines' => 'Philippines',
                                                            'Thailand' => 'Thái Lan',
                                                            'Campuchia' => 'Campuchia',
                                                        ];
                                                    @endphp
                                                    <span class="truncate-text">
                                                        <img src="/temp/images/location.png" width="15px"
                                                            alt="">
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
                                                                    $addressParts[] =
                                                                        $item->address->ward->district->name;
                                                                }
                                                                if (
                                                                    !empty(
                                                                        $item->address->ward->district->province->name
                                                                    )
                                                                ) {
                                                                    $addressParts[] =
                                                                        $item->address->ward->district->province->name;
                                                                }

                                                                // Kiểm tra nếu quốc gia có tồn tại
                                                                $country = isset(
                                                                    $item->address->ward->district->province->country,
                                                                )
                                                                    ? $Quocgia[
                                                                            $item->address->ward->district->province
                                                                                ->country
                                                                        ] ?? 'Không có quốc gia'
                                                                    : 'Không có quốc gia';
                                                                $addressParts[] = $country;

                                                                // Kết hợp các phần của địa chỉ lại với nhau, ngăn cách bằng dấu phẩy nếu có phần không rỗng
                                                                $fullAddress = implode(', ', $addressParts);

                                                                // In ra địa chỉ đầy đủ
                                                                echo $fullAddress;
                                                            @endphp
                                                        @endif


                                                    </span>
                                                </div>
                                            </div>

                                            <div class="price-features-wrapper">
                                                <div
                                                    class="list-fx-features d-flex align-items-center justify-content-between">
                                                    <div class="listing-card d-flex align-items-center">
                                                        <div class="square--30 text-muted-2 fs-sm circle gray-simple me-2">
                                                            <img src="/temp/assets/img/bed.svg" width="20"
                                                                alt="">
                                                        </div><span class="text-muted-2">{{ $item->bedrooms }}
                                                            {{ __('common.bedroom') }}</span>
                                                    </div>
                                                    <div class="listing-card d-flex align-items-center">
                                                        <div class="square--30 text-muted-2 fs-sm circle gray-simple me-2">
                                                            <img src="/temp/assets/img/bathtub.svg" width="20"
                                                                alt="">
                                                        </div><span class="text-muted-2">{{ $item->bathrooms }}
                                                            {{ __('common.bathroom') }}</span>
                                                    </div>
                                                    <div class="listing-card d-flex align-items-center">
                                                        <div class="square--30 text-muted-2 fs-sm circle gray-simple me-2">
                                                            <i class="fa-solid fa-building-shield fs-sm"></i>
                                                        </div><span class="text-muted-2">{{ $item->dientich }}
                                                            m<sub>2</sub></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="listing-detail-footer text-end">
                                                <div class="footer-flex d-flex justify-content-between">
                                                    <div class="d-flex flex-column align-items-start fw-bold">
                                                        @if ($item->baidangchitiet && $item->baidangchitiet->thangdatcoc)
                                                            <span>Đặt cọc: {{ $item->baidangchitiet->thangdatcoc }} tháng
                                                            </span>
                                                        @endif

                                                        @if ($item->baidangchitiet && $item->baidangchitiet->thangtratruoc)
                                                            <span>Trả trước: {{ $item->baidangchitiet->thangtratruoc }}
                                                                tháng </span>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="sides-widget-body text-center p-0 border-top ">   
                                <div class="sides-widget-header text-center py-2 justify-content-between align-items-center bg-light">
                                   <div class="d-flex align-items-center">
                                        <div class="agent-photo">
                                            <img src="{{ optional($item->user)->avatar ?? '/temp/images/user.png' }}" width="40" height="40" alt="Avatar">
                                        </div>
                                        
                                        <div class="">
                                            <h4 class="text-truncate text-dark mb-0 ms-3" style="max-width: 200px;">
                                                <a href="#">{{ optional($item->lienhe)->agent_name ?? optional($item->user)->name }}</a>
                                            </h4>
                                        </div>
                                   </div>
                                </div>       
                            </div> --}}
                                </div>
                            </div>
                        @endforeach
                        <!-- End Single Property -->
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <ul class="pagination p-center">
                                {{ $list_baidangs->appends(request()->query())->links() }}
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- ============================ All Property ================================== -->
    <!-- Modal Lọc Bài Đăng -->
    <div class="modal align-items-center justify-content-center h-100" id="filterModal" style="display: none;">
        <div style="max-width: 1024px" class="py-5 h-100">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Lọc Bài Đăng</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <form action="{{ route('posts.list') }}" method="GET">
                        <div class="row">
                            <!-- Quốc gia -->
                            <div class="form-group col-md-2 col-12 mb-5">
                                <label><span class="text-danger">*</span> {{ __('common.country') }} </label>
                                <select id="country" class="form-control input-field" name="country"
                                    data-require="Mời chọn quốc gia">
                                    <option value="">{{ __('common.select_country') }} </option>
                                    <option value="Vietnam" {{ request('country') == 'Vietnam' ? 'selected' : '' }}>Việt
                                        Nam</option>
                                    <option value="Philippines"
                                        {{ request('country') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                    <option value="Thailand" {{ request('country') == 'Thailand' ? 'selected' : '' }}>Thái
                                        Lan</option>
                                    <option value="Campuchia" {{ request('country') == 'Campuchia' ? 'selected' : '' }}>
                                        Campuchia</option>
                                </select>
                            </div>

                            <!-- Tỉnh / Thành phố -->
                            <div class="form-group col-md-2 col-12 mb-5">
                                <label class="text-nowrap"><span class="text-danger">*</span>
                                    {{ __('common.province_city') }} </label>
                                <select id="province" class="form-control input-field" name="province"
                                    data-require="Mời chọn tỉnh thành">
                                    @if (request('province') && request('province_name'))
                                        <option value="{{ request('province') }}" selected>{{ request('province_name') }}
                                        </option>
                                    @else
                                        <option value="">{{ __('common.select_province_city') }} </option>
                                    @endif
                                </select>
                                <input type="hidden" name="province_name" id="province_name"
                                    value="{{ request('province_name') }}">

                            </div>

                            <!-- Quận / Huyện -->
                            <div class="form-group col-md-2 col-12 mb-5">
                                <label><span class="text-danger">*</span> {{ __('common.district') }} </label>
                                <select id="district" class="form-control input-field" name="districts"
                                    data-require="Mời chọn quận huyện" {{ request('districts') ? '' : 'disabled' }}>
                                    @if (request('districts') && request('district_name'))
                                        <option value="{{ request('districts') }}" selected>
                                            {{ request('district_name') }}</option>
                                    @else
                                        <option value="">{{ __('common.select_district') }} </option>
                                    @endif
                                </select>
                                <input type="hidden" name="district_name" id="district_name"
                                    value="{{ request('district_name') }}">

                            </div>

                            <!-- Phường / Xã -->
                            <div class="form-group col-md-2 col-12 mb-5">
                                <label><span class="text-danger">*</span> {{ __('common.ward') }} </label>
                                <select id="ward" class="form-control input-field" name="wards"
                                    data-require="Mời chọn phường xã" {{ request('wards') ? '' : 'disabled' }}>
                                    @if (request('wards') && request('ward_name'))
                                        <option value="{{ request('wards') }}" selected>{{ request('ward_name') }}
                                        </option>
                                    @else
                                        <option value="">{{ __('common.select_ward') }}</option>
                                    @endif
                                </select>
                                <input type="hidden" name="ward_name" id="ward_name"
                                    value="{{ request('ward_name') }}">

                            </div>

                            <!-- Đường / Phố -->
                            <div class="form-group col-md-4 col-12">
                                <label>{{ __('common.street') }}</label>
                                <input type="text" id="street" class="form-control"
                                    placeholder="{{ __('common.enter_street') }}" name="address"
                                    value="{{ request('address') }}">
                            </div>

                            <!-- Tọa độ (ẩn nếu có dùng bản đồ hoặc lưu vị trí) -->
                            <input type="hidden" name="latitude" id="latitude" value="{{ request('latitude') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ request('longitude') }}">
                        </div>

                        <div class="row g-3 py-4 ">
                            <div class="col-md-4 mb-5">
                                <label for="author" class="form-label">{{ __('common.poster') }} </label>
                                <select id="author" class="form-control" name="author">
                                    <option value="">{{ __('common.select_poster') }} </option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->name }}"
                                            {{ request('author') == $user->name ? 'selected' : '' }}>{{ $user->name }}
                                        </option>
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
                                @php
                                    $priceMin = request('price_min');
                                    $priceMax = request('price_max');

                                    $priceMinUnit = 1000000; // default triệu
                                    $priceMaxUnit = 1000000;

                                    if ($priceMin !== null) {
                                        if ($priceMin < 1000000) {
                                            $priceMinUnit = 1000;
                                        } elseif ($priceMin >= 1000000000) {
                                            $priceMinUnit = 1000000000;
                                        }
                                    }

                                    if ($priceMax !== null) {
                                        if ($priceMax < 1000000) {
                                            $priceMaxUnit = 1000;
                                        } elseif ($priceMax >= 1000000000) {
                                            $priceMaxUnit = 1000000000;
                                        }
                                    }

                                    $priceMinDisplay = $priceMin
                                        ? number_format($priceMin / $priceMinUnit, 2, '.', '')
                                        : '';
                                    $priceMaxDisplay = $priceMax
                                        ? number_format($priceMax / $priceMaxUnit, 2, '.', '')
                                        : '';
                                @endphp

                                <label class="text-danger form-label">{{ __('common.price') }} </label>
                                <div class="input-group mb-2">
                                    <!-- Nhập giá từ -->
                                    <input style="max-width:100px" type="text" class="form-control"
                                        id="priceMinDisplay" value="{{ $priceMinDisplay }}">
                                    <select class="form-select" id="priceMinUnit" style="font-size:14px">
                                        <option value="1000" {{ $priceMinUnit == 1000 ? 'selected' : '' }}>
                                            {{ __('common.thousand') }}
                                        </option>
                                        <option value="1000000" {{ $priceMinUnit == 1000000 ? 'selected' : '' }}>
                                            {{ __('common.million') }}
                                        </option>
                                        <option value="1000000000" {{ $priceMinUnit == 1000000000 ? 'selected' : '' }}>
                                            {{ __('common.billion') }}
                                        </option>
                                    </select>
                                    <span class="input-group-text border-0 bg-white">–</span>

                                    <!-- Nhập giá đến -->

                                    <input style="max-width:100px" type="text" class="form-control"
                                        id="priceMaxDisplay" value="{{ $priceMaxDisplay }}">
                                    <select class="form-select" id="priceMaxUnit" style="font-size:14px">
                                        <option value="1000" {{ $priceMaxUnit == 1000 ? 'selected' : '' }}>
                                            {{ __('common.thousand') }}
                                        </option>
                                        <option value="1000000" {{ $priceMaxUnit == 1000000 ? 'selected' : '' }}>
                                            {{ __('common.million') }}
                                        </option>
                                        <option value="1000000000" {{ $priceMaxUnit == 1000000000 ? 'selected' : '' }}>
                                            {{ __('common.billion') }}
                                        </option>
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
                                        placeholder="{{ __('common.from') }} " value="{{ request('area_min') }}">
                                    <span class="input-group-text">-</span>
                                    <input type="number" class="form-control" name="area_max" placeholder="to"
                                        value="{{ request('area_max') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="bedrooms" class="form-label">{{ __('common.bedroom') }}</label>
                                <input type="number" class="form-control" id="bedrooms" name="bedrooms"
                                    value="{{ request('bedrooms') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="bathrooms" class="form-label">{{ __('common.bathroom') }}</label>
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms"
                                    value="{{ request('bathrooms') }}">
                            </div>
                            <div class="form-group col-md-3 mt-4">
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
                            <div class="form-group col-md-3 mt-4">
                                <label>{{ __('common.house_direction') }}</label>
                                @include('component.house_direction', [
                                    'selectedValue' => request()->query('huongnha', '') ?: $selectedValue,
                                ])

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="window.location.href='{{ route('posts.list') }}'">{{ __('listPost.reset') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('listPost.filter') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('shorty').addEventListener('change', function() {
            this.form.submit(); // Gửi form khi thay đổi
        });
        document.getElementById("flexSwitchCheckChecked").addEventListener("change", function() {
            let isVip = this.checked ? 1 : 0; // Nếu checked thì = 1, ngược lại = 0
            let searchParams = new URLSearchParams(window.location.search);

            if (isVip) {
                searchParams.set("isVip", 1); // Thêm isVip vào URL
            } else {
                searchParams.delete("isVip"); // Xóa nếu không chọn VIP
            }

            window.location.search = searchParams.toString(); // Load lại trang với URL mới
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countrySelect = document.getElementById("country");
            const provinceSelect = document.getElementById("province");
            const districtSelect = document.getElementById("district");
            const wardSelect = document.getElementById("ward");
            const streetInput = document.getElementById("street");
            const provinceNameInput = document.getElementById("province_name");
            const districtNameInput = document.getElementById("district_name");
            const wardNameInput = document.getElementById("ward_name");

            const countryData = {
                "Vietnam": "https://provinces.open-api.vn/api/p/",
                "Philippines": "https://psgc.gitlab.io/api/provinces.json",
                "Thailand": "https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province.json"
            };

            // Tự động cập nhật province, district, ward khi trang load
            function updateLocationFields() {
                const country = countrySelect.value; // Lấy giá trị quốc gia từ DB
                const provinceCode = provinceSelect.value; // Lấy giá trị tỉnh từ DB
                const districtCode = districtSelect.value; // Lấy giá trị quận từ DB

                // Gọi API để cập nhật province, district và ward
                if (country) {
                    updateProvince(country);
                }

                if (provinceCode) {
                    updateDistrict(provinceCode, country);
                }

                if (districtCode) {
                    updateWard(districtCode, country);
                }
            }

            // Cập nhật danh sách các tỉnh
            function updateProvince(country) {
                if (!country) return;

                fetch(`/getProvince/${country}`)
                    .then(response => response.json())
                    .then(data => {
                        // provinceSelect.innerHTML = '<option value="">{{ __('common.select_province_city') }} </option>';
                        if (Array.isArray(data)) {
                            data.forEach(province => {
                                const option = document.createElement("option");
                                option.value = province.code;
                                option.textContent = province.name;
                                provinceSelect.appendChild(option);
                            });
                        }
                    })
                    .catch(error => {
                        console.error("❌ Lỗi khi gọi API tỉnh:", error);
                    });
            }

            // Cập nhật danh sách các quận/huyện
            function updateDistrict(provinceCode, country) {
                if (!provinceCode || !country) return;

                fetch(`/getDistrict/${provinceCode}/${country}`)
                    .then(response => response.json())
                    .then(data => {
                        // districtSelect.innerHTML = '<option value="">{{ __('common.select_district') }} </option>';
                        if (Array.isArray(data)) {
                            data.forEach(district => {
                                const option = document.createElement("option");
                                option.value = district.code;
                                option.textContent = district.name;
                                districtSelect.appendChild(option);
                            });
                            districtSelect.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error("❌ Lỗi khi gọi API quận/huyện:", error);
                    });
            }

            // Cập nhật danh sách các phường/xã
            function updateWard(districtCode, country) {
                if (!districtCode || !country) return;

                // if (country === "Vietnam") {
                //     // Gọi API lấy danh sách phường/xã cho Việt Nam
                //     fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                //         .then(response => response.json())
                //         .then(data => {
                //             if (data.wards) {
                //                 // wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                //                 data.wards.forEach(ward => {
                //                     const option = document.createElement("option");
                //                     option.value = ward.code;
                //                     option.textContent = ward.name;
                //                     wardSelect.appendChild(option);
                //                 });
                //                 wardSelect.disabled = false;
                //             } else {
                //                 console.error("⚠ Dữ liệu API không đúng định dạng:", data);
                //             }
                //         })
                //         .catch(error => {
                //             console.error("❌ Lỗi khi gọi API phường/xã:", error);
                //         });
                // } else {
                    // Gửi request đến backend để lấy danh sách Ward
                    fetch(`/getWard/${districtCode}/${country}`)
                        .then(response => response.json())
                        .then(data => {
                            // wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
                            if (Array.isArray(data)) {
                                data.forEach(ward => {
                                    const option = document.createElement("option");
                                    option.value = ward.code;
                                    option.textContent = ward.name;
                                    wardSelect.appendChild(option);
                                });
                                wardSelect.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error("❌ Lỗi khi gọi route getWard:", error);
                        });
                // }
            }

            // Gọi hàm cập nhật khi trang load
            updateLocationFields();
        });
    </script>
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
