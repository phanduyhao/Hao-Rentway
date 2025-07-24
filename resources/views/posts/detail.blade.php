@extends('layout.layout')
@section('content')
    <!-- End Navigation -->
    <div class="clearfix"></div>


    <!-- ============================================================== -->
    <!-- Top header  -->
    <!-- ============================================================== -->


    <!-- ============================ Hero Banner  Start================================== -->
    <div class="featured_slick_gallery gray">
        <div class="featured_slick_gallery-slide overflow-hidden">
            @foreach (json_decode($baidang->images, true) ?? [] as $image)
                <div class="featured_slick_padd">
                    <a href="{{ $image }}" class="mfp-gallery">
                        <img src="{{ $image }}" class="img-detail mx-auto" alt="" />
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ============================ Hero Banner End ================================== -->

    <!-- ============================ Property Header Info Start================================== -->
    <section class="gray-simple rtl p-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11 col-md-12">

                    <div class="property_block_wrap style-3 position-relative pt-md-0 pb-5 mt-0">
                        @guest
                        @else
                            @if ((Auth::check() && Auth::user()->role == 'admin') || Auth::user()->role == 'nhanvien')
                                <div class="position-absolute bottom-0 end-0 z-1 mt-2">
                                    <a href="{{ route('baidang.edit', $baidang->slug) }}"
                                        class="bg-warning rounded text-white p-2 me-3">
                                        Chỉnh sửa
                                    </a>
                                    <form class="mt-2 d-inline " action="{{ route('baidang.destroyDetail', $baidang->id) }}"
                                        method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="border-0 bg-danger rounded text-white px-2 py-1">Xóa</button>
                                    </form>
                                </div>
                            @endif
                        @endguest
                        <div class="d-lg-block d-none pbw-flex-1">
                            <div class="pbw-flex-thumb p-4">
                                <img src="{{ $baidang->thumb }}" class="img-fluid thumb-baidang" alt="" />
                            </div>
                        </div>

                        <div class="pbw-flex">

                            <div class="prt-detail-title-desc">
                                <div>
                                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'nhanvien'))
                                        <span class="label bg-success fw-bold me-2">
                                            {{ __('post.broker') }}: {{ $baidang->mamoigioi }}
                                        </span>
                                    @endif
                                    <span class="label bg-danger fw-bold me-2">
                                        {{ $baidang->mabaidang }}
                                    </span>
                                    <span class="label bg-light-success text-success prt-type me-2 fw-bold fw-bold">
                                        @php
                                            $moHinhMap = [
                                                'thue' => __('common.model.rent'),
                                                'ban' => __('common.model.sale'),
                                                'chuyennhuong' => __('common.model.transfer'),
                                                'oghep' => __('common.model.roommate'),
                                            ];
                                        @endphp

                                        {{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}
                                    </span>
                                    <span class="label bg-light-purple text-purple fw-bold property-cats fw-bold">
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
                                        {{ __('common.property_type.' . ($propertyTypeMap[$baidang->nhadat->slug] ?? 'unknown')) }}
                                    </span>
                                </div>

                                <h3 class="mt-3 listing-name">
                                    @if (App::getLocale() === 'vi')
                                        {!! $baidang->title !!}
                                    @else
                                        {!! $baidang->title_en ?? $baidang->title !!}
                                    @endif
                                </h3>
                                <span>
                                    @php
                                        $Quocgia = [
                                            'Vietnam' => __('common.country.vietnam'),
                                            'Philippines' => 'Philippines',
                                            'Thailand' => __('common.country.thailand'),
                                            'Campuchia' => 'Campuchia',
                                        ];
                                    @endphp
                                    <img src="/temp/images/location.png" width="15px" alt="">
                                    @if (isset($baidang->address) &&
                                            isset($baidang->address->ward) &&
                                            isset($baidang->address->ward->district) &&
                                            isset($baidang->address->ward->district->province))
                                        @php
                                            // Khởi tạo một mảng để lưu các phần có giá trị của địa chỉ
                                            $addressParts = [];

                                            // Thêm các phần vào mảng nếu chúng có giá trị
                                            if (!empty($baidang->address->street)) {
                                                $addressParts[] = $baidang->address->street;
                                            }
                                            if (!empty($baidang->address->ward->name)) {
                                                $addressParts[] = $baidang->address->ward->name;
                                            }
                                            if (!empty($baidang->address->ward->district->name)) {
                                                $addressParts[] = $baidang->address->ward->district->name;
                                            }
                                            if (!empty($baidang->address->ward->district->province->name)) {
                                                $addressParts[] = $baidang->address->ward->district->province->name;
                                            }

                                            // Kiểm tra nếu quốc gia có tồn tại
                                            $country = isset($baidang->address->ward->district->province->country)
                                                ? $Quocgia[$baidang->address->ward->district->province->country] ??
                                                    'Không có quốc gia'
                                                : 'Không có quốc gia';
                                            $addressParts[] = $country;

                                            // Kết hợp các phần của địa chỉ lại với nhau, ngăn cách bằng dấu phẩy nếu có phần không rỗng
                                            $fullAddress = implode(', ', $addressParts);

                                            // In ra địa chỉ đầy đủ
                                            echo $fullAddress;
                                        @endphp
                                    @endif


                                </span>
                                @php
                                    $country = strtolower(
                                        $baidang->address->ward->district->province->country ?? 'vietnam',
                                    );
                                    $formattedPrice = '';

                                    if ($baidang->price) {
                                        switch ($country) {
                                            case 'vietnam':
                                                $formattedPrice = number_format($baidang->price, 0, ',', '.') . ' ₫';
                                                break;
                                            case 'philippines':
                                                $formattedPrice = '₱' . number_format($baidang->price, 2, '.', ',');
                                                break;
                                            case 'thailand':
                                                $formattedPrice = '฿' . number_format($baidang->price, 2, '.', ',');
                                                break;
                                            case 'campuchia':
                                                $formattedPrice = '៛' . number_format($baidang->price, 0, ',', '.');
                                                break;
                                            default:
                                                $formattedPrice =
                                                    number_format($baidang->price, 2) . ' (unknown currency)';
                                        }

                                        if ($baidang->mohinh == 'thue') {
                                            $formattedPrice;
                                        }
                                    } else {
                                        $formattedPrice = __('post.price_negotiable');
                                    }
                                @endphp

                                <h3 class="prt-price-fix text-primary mt-2">
                                    {{ $formattedPrice }}/
                                    {{ $baidang->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                </h3>

                                <div class="list-fx-features">
                                    <div class="listing-card-info-icon">
                                        <div class="inc-fleat-icon me-1"><img src="/temp/assets/img/bed.svg" width="20"
                                                alt=""></div>{{ $baidang->bedrooms }} {{ __('common.bedroom') }}
                                    </div>
                                    <div class="listing-card-info-icon">
                                        <div class="inc-fleat-icon me-1"><img src="/temp/assets/img/bathtub.svg"
                                                width="20" alt=""></div>{{ $baidang->bathrooms }}
                                        {{ __('common.bathroom') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Property Header Info Start================================== -->


    <!-- ============================ Property Detail Start ================================== -->
    <section class="gray-simple min">
        <div class="container">
            <div class="row">

                <!-- property main detail -->
                <div class="col-lg-8 col-md-12 col-sm-12">

                    <!-- Single Block Wrap -->
                    <div class="property_block_wrap style-2">
                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#features" data-bs-target="#clOne"
                                aria-controls="clOne" href="javascript:void(0);" aria-expanded="false">
                                <h4 class="property_block_title">{{ __('common.details_features') }}</h4>
                            </a>
                        </div>
                        <div id="clOne" class="panel-collapse collapse show" aria-labelledby="clOne">
                            <div class="block-body pb-0">
                                <ul class="deatil_features">
                                    @php
                                        $moHinhMap = [
                                            'ban' => 'sale',
                                            'thue' => 'rent',
                                            'chuyennhuong' => 'transfer',
                                            'oghep' => 'roommate',
                                        ];
                                    @endphp

                                    <li>
                                        <strong>{{ __('common.model') }}:</strong>
                                        {{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}
                                    </li>
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
                                    <li>
                                        <strong>{{ __('common.property_type') }}:</strong>
                                        {{ __('common.property_type.' . ($propertyTypeMap[$baidang->nhadat->slug] ?? 'unknown')) }}
                                    </li>


                                    <li>
                                        <strong>{{ __('common.acreage') }}:</strong>
                                        {{ number_format($baidang->dientich, 0, ',', '.') }} m<sup>2</sup>
                                    </li>

                                    <li>
                                        <strong>{{ __('common.deposit_months') }}:</strong>
                                        {{ $baidang->baidangchitiet->thangdatcoc ?? '' }}
                                    </li>

                                    <li>
                                        <strong>{{ __('common.prepaid_months') }}:</strong>
                                        {{ $baidang->baidangchitiet->thangtratruoc ?? '' }}
                                    </li>

                                    @if ($baidang->huongnha)
                                        @php
                                            $huongMappings = [
                                                'dong' => __('common.east'),
                                                'tay' => __('common.west'),
                                                'nam' => __('common.south'),
                                                'bac' => __('common.north'),
                                                'dongbac' => __('common.northeast'),
                                                'dongnam' => __('common.southeast'),
                                                'taybac' => __('common.northwest'),
                                                'taynam' => __('common.southwest'),
                                                'tay_tu_trach' => __('common.southwest'),
                                                'dong_tu_trach' => __('common.southwest'),
                                                'be_boi' => __('common.swimming_pool'),
                                                'ngoai_troi' => __('common.outdoor'),
                                                'duong' => __('common.street_view'),
                                            ];
                                        @endphp
                                        <li>
                                            <strong>{{ __('common.house_direction') }}:</strong>
                                            {{ $huongMappings[$baidang->huongnha] ?? __('common.unknown') }}
                                        </li>
                                    @endif

                                    @if (!is_null($baidang->huongbancong))
                                        <li>
                                            <strong>{{ __('common.balcony') }}:</strong>
                                            {{ $baidang->huongbancong == 1 ? __('common.yes') : __('common.no') }}
                                        </li>
                                    @endif

                                    @if ($baidang->baidangchitiet && $baidang->baidangchitiet->sophong)
                                        <li>
                                            <strong>
                                                {{ Str::contains(Str::lower($baidang->nhadat->title), 'chung cư')
                                                    ? __('common.room')
                                                    : __('common.total_rooms') }}
                                            </strong>
                                            {{ $baidang->baidangchitiet->sophong }}
                                        </li>
                                    @endif

                                    @if ($baidang->baidangchitiet && $baidang->baidangchitiet->sotang)
                                        <li>
                                            <strong>
                                                {{ Str::contains(Str::lower($baidang->nhadat->title), 'chung cư') ? __('post.floor') : __('post.amount_floor') }}
                                            </strong>
                                            {{ $baidang->baidangchitiet->sotang }}
                                        </li>
                                    @endif

                                    <li>
                                        <strong>{{ __('common.bedroom') }}:</strong>
                                        {{ $baidang->bedrooms }}
                                    </li>

                                    <li>
                                        <strong>{{ __('common.bathroom') }}:</strong>
                                        {{ $baidang->bathrooms }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>


                    {{-- <div class="property_block_wrap style-2">

                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo1" aria-controls="clTwo1"
                                href="javascript:void(0);" aria-expanded="true">
                                <h4 class="property_block_title">{{ __('common.service_interior') }}</h4>
                            </a>
                        </div>
                        <div id="clTwo1" class="panel-collapse collapse show">
                            <div class="block-body">
                                <ul class="deatil_features">
                                    @php
                                        $tienIchMap = [
                                            'Điều hòa' => __('common.amenities.air_conditioner'),
                                            'Tủ quần áo' => __('common.amenities.wardrobe'),
                                            'Nóng lạnh' => __('common.amenities.water_heater'),
                                            'Tủ lạnh' => __('common.amenities.fridge'),
                                            'Ti vi' => __('common.amenities.tv'),
                                            'Máy giặt' => __('common.amenities.washing_machine'),
                                            'Bảo vệ' => __('common.amenities.security'),
                                            'Bãi đỗ xe' => __('common.amenities.parking'),
                                            'Internet' => __('common.amenities.internet'),
                                            'Dọn vệ sinh' => __('common.amenities.cleaning'),
                                            'Bếp ga' => __('common.amenities.gas_stove'),
                                        ];
                                    @endphp

                                    @foreach (json_decode($baidang->thietbis, true) ?? [] as $thietbi)
                                        <li>
                                            <img src="{{ $thietbi['icon'] }}" width="20" alt="">
                                            <b>{{ $tienIchMap[$thietbi['name']] ?? $thietbi['name'] }}</b>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    <!-- Single Block Wrap -->
                    <div class="property_block_wrap style-2">

                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo" aria-controls="clTwo"
                                href="javascript:void(0);" aria-expanded="true">
                                <h4 class="property_block_title">Description</h4>
                            </a>
                        </div>
                        <div id="clTwo" class="panel-collapse collapse show">
                            <div class="block-body">
                                @if (App::getLocale() === 'vi')
                                    {!! $baidang->description !!}
                                @else
                                    {!! $baidang->description_en ?? $baidang->description !!}
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- <!-- Single Block Wrap -->
                    <div class="property_block_wrap style-2">
                        
                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#loca"  data-bs-target="#clSix" aria-controls="clSix" href="javascript:void(0);" aria-expanded="true" class="collapsed"><h4 class="property_block_title">Location</h4></a>
                        </div>
                        
                        <div id="clSix" class="panel-collapse collapse">
                            <div class="block-body">
                                <div class="map-container">
                                    <div id="map" class="d-none" style="width: 100%; height: 400px;" data-longitude="{{$baidang->address->longitude}}" data-latitude="{{$baidang->address->latitude}}"></div>

                                </div>

                            </div>
                        </div>
                        
                    </div> --}}

                    <!-- Single Block Wrap -->
                    <div class="property_block_wrap style-2">

                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#clSev" data-bs-target="#clSev" aria-controls="clOne"
                                href="javascript:void(0);" aria-expanded="true" class="collapsed">
                                <h4 class="property_block_title">Gallery</h4>
                            </a>
                        </div>

                        <div id="clSev" class="panel-collapse collapse show">
                            <div class="block-body">
                                <ul class="list-gallery-inline">
                                    @foreach (json_decode($baidang->images, true) ?? [] as $image)
                                        <li>
                                            <a href="{{ $image }}" class="mfp-gallery" data-discover="true"><img
                                                    src="{{ $image }}" class="img-custom mx-auto  "
                                                    alt="" /></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="property_block_wrap style-2">

                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#video" data-bs-target="#video"
                                aria-controls="clOne" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                                <h4 class="property_block_title">Videos</h4>
                            </a>
                        </div>

                        <div id="video" class="panel-collapse collapse show px-4">
                            <div id="videoPreviewContainer" class="preview-container"
                                data-videos="{{ json_encode($baidang->videos ?? []) }}">
                                @foreach (json_decode($baidang->videos, true) ?? [] as $video)
                                    <div class="video-wrapper"
                                        style="display:inline-block; position: relative; margin-right: 10px; margin-bottom: 10px;">
                                        <video controls width="200"
                                            style="display:block; border:1px solid #ccc; border-radius:4px; object-fit: cover;">
                                            <source src="{{ asset($video) }}" type="video/mp4">
                                            Trình duyệt của bạn không hỗ trợ thẻ video.
                                        </video>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <!-- property Sidebar -->
                <div class="col-lg-4 col-md-12 col-sm-12">
                    @if (
                        (Auth::check() && $baidang->user_id == Auth::id()) ||
                            (Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->role == 'nhanvien')))
                        <div class="details-sidebar">
                            <!-- Agent Detail -->
                            <div class="sides-widget border rounded shadow-sm p-3 bg-white">
                                <div class="sides-widget-header text-center py-0 rounded py-1">
                                    <div class="agent-photo ">
                                        <img src="{{ optional($baidang->user)->avatar ?? '/temp/images/user.png' }}"
                                            width="100" height="100" class="rounded-circle border" alt="Avatar">
                                    </div>
                                    @php
                                        $roleMappings = [
                                            'user' => __('common.guest'),
                                            'admin' => __('common.admin'),
                                            'chunha' => __('common.landlord'),
                                            'moigioi' => __('common.agent'),
                                            'nhanvien' => __('common.staff'),
                                        ];
                                    @endphp
                                    <div class="sides-widget-details">
                                        <h3 class="fw-bold text-primary">
                                            <a href="#"
                                                class="text-decoration-none">{{ optional($baidang->lienhe)->agent_name ?? optional($baidang->user)->name }}</a>
                                        </h3>
                                        <p>{{ $roleMappings[$baidang->User->role] ?? 'Không xác định' }}</p>
                                    </div>
                                </div>

                                <div class="sides-widget-body text-center">
                                    <!-- Email -->
                                    @if (optional($baidang->lienhe)->email)
                                        <div class="contact-item my-2 p-2 bg-light rounded">
                                            <strong>Email:</strong>
                                            <a href="mailto:{{ $baidang->lienhe->email }}" class="text-dark fw-semibold">
                                                {{ $baidang->lienhe->email }}
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Số điện thoại -->
                                    @if (optional($baidang->lienhe)->phone)
                                        <div class="contact-item my-2 p-2 bg-light rounded">
                                            <strong>{{ __('common.phone_number') }}:</strong>
                                            <a href="tel:{{ $baidang->lienhe->phone }}" class="text-dark fw-semibold">
                                                {{ $baidang->lienhe->phone }}
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Zalo -->
                                    @if (optional($baidang->lienhe)->zalo_link)
                                        <a href="{{ $baidang->lienhe->zalo_link }}"
                                            class="btn btn-outline-primary w-100 my-2 py-2 fw-bold d-flex align-items-center justify-content-center"
                                            target="_blank">
                                            <img src="/temp/images/zalo.png" alt="Zalo" width="25"
                                                class="me-2"> Chat Zalo
                                        </a>
                                    @endif

                                    <!-- Facebook -->
                                    @if (optional($baidang->lienhe)->facebook)
                                        <a href="{{ $baidang->lienhe->facebook }}"
                                            class="btn btn-outline-primary w-100 my-2 py-2 fw-bold d-flex align-items-center justify-content-center"
                                            target="_blank">
                                            <img src="/temp/images/facebook.png" alt="Facebook" width="25"
                                                class="me-2"> Facebook
                                        </a>
                                    @endif

                                    <!-- Telegram -->
                                    @if (optional($baidang->lienhe)->telegram)
                                        <a href="{{ $baidang->lienhe->telegram }}"
                                            class="btn btn-outline-info w-100 my-2 py-2 fw-bold d-flex align-items-center justify-content-center"
                                            target="_blank">
                                            <img src="/temp/images/telegram.png" alt="Telegram" width="25"
                                                class="me-2"> Telegram
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="sidebar-widgets">

                                <h4>{{ __('common.near_post') }}</h4>

                                <div class="sidebar_featured_property">
                                    @foreach ($baidangnews as $item)
                                        <!-- List Sibar Property -->
                                        <div class="sides_list_property">
                                            <div class="sides_list_property_thumb">
                                                <img src="{{ $item->thumb }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="sides_list_property_detail">
                                                <h4 class="mb-2 listing-name"><a
                                                        href="{{ route('baidangDetail', $item->slug) }}">{{ $item->title }}</a>
                                                </h4>
                                                <span><i class="fa-solid fa-location-dot"></i>
                                                    @if (isset($item->address))
                                                        {{ $item->address->street ??
                                                            '' .
                                                                ($item->address->ward->name ? ', ' . $item->address->ward->name : '') .
                                                                ($item->address->ward->district->name ? ', ' . $item->address->ward->district->name : '') .
                                                                ($item->address->ward->district->province->name ? ', ' . $item->address->ward->district->province->name : '') .
                                                                ', ' .
                                                                ($item->address->ward->district->province->country
                                                                    ? $Quocgia[$item->address->ward->district->province->country]
                                                                    : 'Không có quốc gia') }}
                                                    @endif
                                                </span>
                                                <div class="lists_property_price">
                                                    <div class="lists_property_types">
                                                        <div class="property_types_vlix sale fw-bold border">
                                                            @php
                                                                $moHinhMap = [
                                                                    'thue' => __('common.model.rent'),
                                                                    'ban' => __('common.model.sale'),
                                                                    'chuyennhuong' => __('common.model.transfer'),
                                                                    'oghep' => __('common.model.roommate'),
                                                                ];
                                                            @endphp
                                                            {{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}</div>
                                                    </div>
                                                    <div class="lists_property_price_value">
                                                        @if ($item->price == null)
                                                            <h6>{{ __('post.price_negotiable') }}</h6>
                                                        @else
                                                            @php
                                                                $country = strtolower(
                                                                    $item->address->ward->district->province->country ??
                                                                        'vietnam',
                                                                );
                                                                $formattedPrice = '';

                                                                switch ($country) {
                                                                    case 'vietnam':
                                                                        $formattedPrice =
                                                                            number_format($item->price, 0, ',', '.') .
                                                                            ' ₫';
                                                                        break;
                                                                    case 'philippines':
                                                                        $formattedPrice =
                                                                            '₱' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'thailand':
                                                                        $formattedPrice =
                                                                            '฿' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'campuchia':
                                                                        $formattedPrice =
                                                                            '៛' .
                                                                            number_format($item->price, 0, ',', '.');
                                                                        break;
                                                                    default:
                                                                        $formattedPrice =
                                                                            number_format($item->price, 2) .
                                                                            ' (unknown currency)';
                                                                }
                                                            @endphp

                                                            <h6 class="listing-info-price-4 mb-0">
                                                                {{ $formattedPrice }}
                                                                @if ($item->mohinh != 'ban')
                                                                    /
                                                                    {{ $item->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                                                @endif
                                                            </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sidebar-widgets">

                                <h4>{{ __('listPost.post_vip') }}</h4>

                                <div class="sidebar_featured_property">
                                    @foreach ($baidanghots as $item)
                                        <!-- List Sibar Property -->
                                        <div class="sides_list_property">
                                            <div class="sides_list_property_thumb">
                                                <img src="{{ $item->thumb }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="sides_list_property_detail">
                                                <h4 class="mb-2 listing-name"><a
                                                        href="{{ route('baidangDetail', $item->slug) }}">{{ $item->title }}</a>
                                                </h4>
                                                <span><i class="fa-solid fa-location-dot"></i>
                                                    @if (isset($item->address))
                                                        {{ $item->address->street ??
                                                            '' .
                                                                ($item->address->ward->name ? ', ' . $item->address->ward->name : '') .
                                                                ($item->address->ward->district->name ? ', ' . $item->address->ward->district->name : '') .
                                                                ($item->address->ward->district->province->name ? ', ' . $item->address->ward->district->province->name : '') .
                                                                ', ' .
                                                                ($item->address->ward->district->province->country
                                                                    ? $Quocgia[$item->address->ward->district->province->country]
                                                                    : 'Không có quốc gia') }}
                                                    @endif
                                                </span>
                                                <div class="lists_property_price">
                                                    <div class="lists_property_types">
                                                        <div class="property_types_vlix sale fw-bold border">
                                                            @php
                                                                $moHinhMap = [
                                                                    'thue' => __('common.model.rent'),
                                                                    'ban' => __('common.model.sale'),
                                                                    'chuyennhuong' => __('common.model.transfer'),
                                                                    'oghep' => __('common.model.roommate'),
                                                                ];
                                                            @endphp
                                                            {{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}</div>
                                                    </div>
                                                    <div class="lists_property_price_value">
                                                        @if ($item->price == null)
                                                            <h6>{{ __('post.price_negotiable') }}</h6>
                                                        @else
                                                            @php
                                                                $country = strtolower(
                                                                    $item->address->ward->district->province->country ??
                                                                        'vietnam',
                                                                );
                                                                $formattedPrice = '';

                                                                switch ($country) {
                                                                    case 'vietnam':
                                                                        $formattedPrice =
                                                                            number_format($item->price, 0, ',', '.') .
                                                                            ' ₫';
                                                                        break;
                                                                    case 'philippines':
                                                                        $formattedPrice =
                                                                            '₱' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'thailand':
                                                                        $formattedPrice =
                                                                            '฿' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'campuchia':
                                                                        $formattedPrice =
                                                                            '៛' .
                                                                            number_format($item->price, 0, ',', '.');
                                                                        break;
                                                                    default:
                                                                        $formattedPrice =
                                                                            number_format($item->price, 2) .
                                                                            ' (unknown currency)';
                                                                }
                                                            @endphp

                                                            <h6 class="listing-info-price-4 mb-0">
                                                                {{ $formattedPrice }}
                                                                @if ($item->mohinh != 'ban')
                                                                    /
                                                                    {{ $item->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                                                @endif
                                                            </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="details-sidebar">
                            <!-- Agent Detail -->
                            <div class="sides-widget border rounded shadow-sm p-3 bg-white">
                                <div class="sides-widget-header text-center py-0 rounded py-3 justify-content-center">
                                    <div class="sides-widget-details text-center p-0">
                                        <h3 class="fw-bold text-primary m-0">
                                            <a href="#"
                                                class="text-decoration-none">{{ __('post.contact_info') }}</a>
                                        </h3>
                                    </div>
                                </div>

                                <div class="sides-widget-body text-center">
                                    <!-- Email -->
                                    @if (optional($baidang->lienhe)->email)
                                        <div class="contact-item my-2 p-2 bg-light rounded">
                                            <strong>Email:</strong>
                                            <a href="mailto:{{ $settings['email'] }}" class="text-dark fw-semibold">
                                                {{ $settings['email'] }}
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Số điện thoại -->
                                    <div class="contact-item my-2 p-2 bg-light rounded">
                                        <strong>{{ __('common.phone_number') }}:</strong>
                                        <a href="tel:{{ $settings['phone'] }}" class="text-dark fw-semibold">
                                            {{ $settings['phone'] }}
                                        </a>
                                    </div>
                                    <!-- Facebook -->
                                    <a href="{{ $settings['link_fb'] }}"
                                        class="btn btn-outline-primary w-100 my-2 py-2 fw-bold d-flex align-items-center justify-content-center"
                                        target="_blank">
                                        <img src="/temp/images/facebook.png" alt="Facebook" width="25"
                                            class="me-2"> Facebook
                                    </a>

                                    <!-- Telegram -->
                                    <a href="{{ $settings['link_telegram'] }}"
                                        class="btn btn-outline-info w-100 my-2 py-2 fw-bold d-flex align-items-center justify-content-center"
                                        target="_blank">
                                        <img src="/temp/images/telegram.png" alt="Telegram" width="25"
                                            class="me-2"> Telegram
                                    </a>
                                </div>
                            </div>
                            <!-- Chia sẻ qua mạng xã hội -->
                            <div class="my-3 d-flex flex-wrap gap-2">
                                <!-- Facebook Share -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                                    target="_blank" class="btn btn-sm btn-primary fw-bold d-flex align-items-center">
                                    <i class="fab fa-facebook-f me-2"></i> Share Facebook
                                </a>

                                <!-- Zalo Share (qua link Zalo API) -->
                                <a href="https://zalo.me/share?url={{ urlencode(Request::url()) }}" target="_blank"
                                    class="btn btn-sm bg-white border fw-bold d-flex align-items-center">
                                    <img src="/temp/images/zalo.png" alt="Zalo" width="20" class="me-2"> Share
                                    Zalo
                                </a>

                                <!-- Telegram Share -->
                                <a href="https://t.me/share/url?url={{ urlencode(Request::url()) }}" target="_blank"
                                    class="btn btn-sm btn-info fw-bold d-flex align-items-center">
                                    <i class="fab fa-telegram-plane me-2"></i> Share Telegram
                                </a>
                            </div>
                            <div class="sidebar-widgets">

                                <h4>{{ __('common.near_post') }}</h4>

                                <div class="sidebar_featured_property">
                                    @foreach ($baidangnews as $item)
                                        <!-- List Sibar Property -->
                                        <div class="sides_list_property">
                                            <div class="sides_list_property_thumb">
                                                <img src="{{ $item->thumb }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="sides_list_property_detail">
                                                <h4 class="mb-2 listing-name"><a
                                                        href="{{ route('baidangDetail', $item->slug) }}">{{ $item->title }}</a>
                                                </h4>
                                                <span><i class="fa-solid fa-location-dot"></i>
                                                    @if (isset($item->address))
                                                        {{ $item->address->street ??
                                                            '' .
                                                                ($item->address->ward->name ? ', ' . $item->address->ward->name : '') .
                                                                ($item->address->ward->district->name ? ', ' . $item->address->ward->district->name : '') .
                                                                ($item->address->ward->district->province->name ? ', ' . $item->address->ward->district->province->name : '') .
                                                                ', ' .
                                                                ($item->address->ward->district->province->country
                                                                    ? $Quocgia[$item->address->ward->district->province->country]
                                                                    : 'Không có quốc gia') }}
                                                    @endif
                                                </span>
                                                <div class="lists_property_price">
                                                    <div class="lists_property_types">
                                                        <div class="property_types_vlix sale  fw-bold border text-nowrap">
                                                            @php
                                                                $moHinhMap = [
                                                                    'thue' => __('common.model.rent'),
                                                                    'ban' => __('common.model.sale'),
                                                                    'chuyennhuong' => __('common.model.transfer'),
                                                                    'oghep' => __('common.model.roommate'),
                                                                ];
                                                            @endphp
                                                            {{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}</div>
                                                    </div>
                                                    <div class="lists_property_price_value">
                                                        @if ($item->price == null)
                                                            <h6>{{ __('post.price_negotiable') }}</h6>
                                                        @else
                                                            @php
                                                                $country = strtolower(
                                                                    $item->address->ward->district->province->country ??
                                                                        'vietnam',
                                                                );
                                                                $formattedPrice = '';

                                                                switch ($country) {
                                                                    case 'vietnam':
                                                                        $formattedPrice =
                                                                            number_format($item->price, 0, ',', '.') .
                                                                            ' ₫';
                                                                        break;
                                                                    case 'philippines':
                                                                        $formattedPrice =
                                                                            '₱' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'thailand':
                                                                        $formattedPrice =
                                                                            '฿' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'campuchia':
                                                                        $formattedPrice =
                                                                            '៛' .
                                                                            number_format($item->price, 0, ',', '.');
                                                                        break;
                                                                    default:
                                                                        $formattedPrice =
                                                                            number_format($item->price, 2) .
                                                                            ' (unknown currency)';
                                                                }
                                                            @endphp

                                                            <h6 class="listing-info-price-4 mb-0">
                                                                {{ $formattedPrice }}
                                                                @if ($item->mohinh != 'ban')
                                                                    /
                                                                    {{ $item->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                                                @endif
                                                            </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="sidebar-widgets mt-3">

                                <h4>{{ __('listPost.post_vip') }}</h4>

                                <div class="sidebar_featured_property">
                                    @foreach ($baidanghots as $item)
                                        <!-- List Sibar Property -->
                                        <div class="sides_list_property">
                                            <div class="sides_list_property_thumb">
                                                <img src="{{ $item->thumb }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="sides_list_property_detail">
                                                <h4 class="mb-2 listing-name"><a
                                                        href="{{ route('baidangDetail', $item->slug) }}">{{ $item->title }}</a>
                                                </h4>
                                                <span><i class="fa-solid fa-location-dot"></i>
                                                    @if (isset($item->address))
                                                        {{ $item->address->street ??
                                                            '' .
                                                                ($item->address->ward->name ? ', ' . $item->address->ward->name : '') .
                                                                ($item->address->ward->district->name ? ', ' . $item->address->ward->district->name : '') .
                                                                ($item->address->ward->district->province->name ? ', ' . $item->address->ward->district->province->name : '') .
                                                                ', ' .
                                                                ($item->address->ward->district->province->country
                                                                    ? $Quocgia[$item->address->ward->district->province->country]
                                                                    : 'Không có quốc gia') }}
                                                    @endif
                                                </span>
                                                <div class="lists_property_price">
                                                    <div class="lists_property_types">
                                                        <div class="property_types_vlix sale  fw-bold border text-nowrap">
                                                            @php
                                                                $moHinhMap = [
                                                                    'thue' => __('common.model.rent'),
                                                                    'ban' => __('common.model.sale'),
                                                                    'chuyennhuong' => __('common.model.transfer'),
                                                                    'oghep' => __('common.model.roommate'),
                                                                ];
                                                            @endphp
                                                            {{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}</div>
                                                    </div>
                                                    <div class="lists_property_price_value">
                                                        @if ($item->price == null)
                                                            <h6>{{ __('post.price_negotiable') }}</h6>
                                                        @else
                                                            @php
                                                                $country = strtolower(
                                                                    $item->address->ward->district->province->country ??
                                                                        'vietnam',
                                                                );
                                                                $formattedPrice = '';

                                                                switch ($country) {
                                                                    case 'vietnam':
                                                                        $formattedPrice =
                                                                            number_format($item->price, 0, ',', '.') .
                                                                            ' ₫';
                                                                        break;
                                                                    case 'philippines':
                                                                        $formattedPrice =
                                                                            '₱' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'thailand':
                                                                        $formattedPrice =
                                                                            '฿' .
                                                                            number_format($item->price, 2, '.', ',');
                                                                        break;
                                                                    case 'campuchia':
                                                                        $formattedPrice =
                                                                            '៛' .
                                                                            number_format($item->price, 0, ',', '.');
                                                                        break;
                                                                    default:
                                                                        $formattedPrice =
                                                                            number_format($item->price, 2) .
                                                                            ' (unknown currency)';
                                                                }
                                                            @endphp

                                                            <h6 class="listing-info-price-4 mb-0">
                                                                {{ $formattedPrice }}
                                                                @if ($item->mohinh != 'ban')
                                                                    /
                                                                    {{ $item->unit == 'ngay' ? __('common.day') : __('common.month') }}
                                                                @endif
                                                            </h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
    <!-- ============================ Property Detail End ================================== -->
    </div>
    <!-- ============================================================== -->
@endsection
