@extends('layout.layout')
@section('content')
    <!-- ============================ Page Title Start================================== -->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">{{ $title }} </h2>
                    <span class="ipn-subtitle">{{ __('post.subtitle_edit_post') }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Submit Property Start ================================== -->
    <section class="gray-simple">
        <div class="container">
            <!-- row Start -->

            <!-- /row -->

            <div class="row">
                <!-- Submit Form -->
                <div class="col-lg-12 col-md-12">
                    <form id="form-capnhat-tin" class="form-baidang" method="POST"
                        action="{{ route('updateBaidang', $baidang->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="submit-page" style="line-height: 3rem">
                            <!-- Basic Information -->
                            <div class="form-submit">
                                <h3>{{ __('post.info_basic') }}</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="d-flex align-items-center gx-2">
                                                <input type="checkbox" class="form-check-input mt-0 me-2" id="isVip"
                                                    name="isVip" {{ $baidang->isVip ? 'checked' : '' }}>
                                                <span>{{ __('listPost.post_vip') }}</span>
                                            </label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> <span class="text-danger">*</span> {{ __('profile.post_code') }}</label>
                                            <input type="text" class="form-control input-field" name="mabaidang"
                                                value="{{ $baidang->mabaidang }}" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> <span class="text-danger">* ( VIETNAMESE )</span>
                                                {{ __('post.property_title') }}</label>
                                            <input type="text" class="form-control input-field" name="title"
                                                value="{{ $baidang->title }}" required>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> <span class="text-danger">* ( ENGLISH )</span>
                                                {{ __('post.property_title') }}</label>
                                            <input type="text" class="form-control input-field" name="title_en"
                                                value="{{ $baidang->title_en }}" required>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('common.model') }}</label>
                                            <select id="mohinh" class="form-control" name="mohinh">
                                                <option value="thue" {{ $baidang->mohinh == 'thue' ? 'selected' : '' }}>
                                                    {{ __('common.model.rent') }}</option>
                                                <option value="ban" {{ $baidang->mohinh == 'ban' ? 'selected' : '' }}>
                                                    {{ __('common.model.sale') }}
                                                </option>
                                                <option value="chuyennhuong"
                                                    {{ $baidang->mohinh == 'chuyennhuong' ? 'selected' : '' }}>
                                                    {{ __('common.model.transfer') }}
                                                </option>
                                                <option value="oghep" {{ $baidang->mohinh == 'oghep' ? 'selected' : '' }}>
                                                    {{ __('common.model.roommate') }}p</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('common.property_type') }}</label>
                                            <select id="ptypes" class="form-control" name="loainhadat_id">
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

                                                @foreach ($loainhadats as $loainhadat)
                                                    <option value="{{ $loainhadat->id }}"
                                                        {{ $baidang->loainhadat_id == $loainhadat->id ? 'selected' : '' }}>
                                                        {{ __('common.property_type.' . $propertyTypeMap[$loainhadat->slug]) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label class="d-flex align-items-center">
                                                {{ __('common.price') }} (
                                                <input type="checkbox" class="form-check-input mt-0 me-2"
                                                    id="priceNegotiable" {{ $baidang->price == 0 ? 'checked' : '' }}>
                                                <span>{{ __('post.price_negotiable') }}</span>
                                                )
                                            </label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="{{ $baidang->price }}">
                                        </div>
                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> {{ __('common.unit') }} </label>
                                            <select id="unit" class="form-control" name="unit">
                                                <option value="ngay" {{ $baidang->unit == 'ngay' ? 'selected' : '' }}>/
                                                    {{ __('common.day') }} </option>
                                                <option value="thang" {{ $baidang->unit == 'thang' ? 'selected' : '' }}>/
                                                    {{ __('common.month') }} </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> <span class="text-danger">*</span>{{ __('common.acreage') }} </label>
                                            <input type="text" class="form-control" name="area"
                                                value="{{ $baidang->dientich }}" placeholder="m2" required>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> <span class="text-danger">*</span> {{ __('post.total_room') }}</label>
                                            <input type="number" class="form-control input-field" name="tongsophong"
                                                value="{{ $baidang->baidangchitiet->sophong }}" required>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label><span id="label-so-tang"></span></label>
                                            <input type="number" class="form-control" name="tongsotang"
                                                value="{{ $baidang->baidangchitiet->sotang }}">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('post.profit') }}</label>
                                            <input type="number" class="form-control" name="hoahong"
                                                value="{{ $baidang->baidangchitiet->hoahong }}">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label><span class="text-danger">*</span>
                                                {{ __('post.number_months_deposit') }}</label>
                                            <input type="number" class="form-control input-field" name="thangdatcoc"
                                                value="{{ $baidang->baidangchitiet->thangdatcoc }}" required>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label><span class="text-danger">*</span>
                                                {{ __('post.number_months_prepaid') }}</label>
                                            <input type="number" class="form-control input-field" name="thangtratruoc"
                                                value="{{ $baidang->baidangchitiet->thangtratruoc }}" required>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> <span class="text-danger">*</span>
                                                {{ __('common.amount_bedroom') }}</label>
                                            <input type="number" class="form-control input-field" name="bedrooms"
                                                value="{{ $baidang->bedrooms }}" required>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> <span class="text-danger">*</span>
                                                {{ __('common.amount_bathroom') }}</label>
                                            <input type="number" class="form-control input-field" name="bathrooms"
                                                value="{{ $baidang->bathrooms }}" required>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('post.contract_type') }}</label>
                                            <select id="loaihopdong" class="form-control" name="hopdong">
                                                <option value="">{{ __('post.select_contract_type') }}</option>
                                                <option value="1thang"
                                                    {{ $baidang->baidangchitiet->hopdong == '1thang' ? 'selected' : '' }}>
                                                    {{ __('post.1_5_month') }}</option>
                                                <option value="6thang"
                                                    {{ $baidang->baidangchitiet->hopdong == '6thang' ? 'selected' : '' }}>
                                                    {{ __('post.6_months') }}</option>
                                                <option value="1nam"
                                                    {{ $baidang->baidangchitiet->hopdong == '1 nam' ? 'selected' : '' }}>
                                                    {{ __('post.1_year') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="text-danger">{{ __('post.note_max') }}</h5>

                            <!-- Gallery -->
                            <div class="form-submit">
                                <h3>{{ __('post.images_library') }}</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div id="imageUpload" class="upload-box">
                                                <div class="upload-area">
                                                    <i class="fa-solid fa-images upload-icon"></i>
                                                    <p>{{ __('post.note_upload') }}</p>
                                                    <input type="file" id="imageInput" name="image[]"
                                                        accept="image/*" multiple hidden>
                                                </div>
                                            </div>
                                            <div id="previewContainer" class="preview-container"
                                                data-images="{{ json_encode($baidang->images ?? []) }}">
                                                @foreach (json_decode($baidang->images, true) ?? [] as $image)
                                                    <div class="image-preview">
                                                        <img src="{{ is_array($image) ? $image['image'] : $image }}"
                                                            alt="">
                                                        <span class="remove-btn"
                                                            data-image-url="{{ is_array($image) ? $image['image'] : $image }}">×</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <input type="hidden" name="images" id="images">
                                            <input type="hidden" name="Thumb" id="Thumb">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-submit">
                                <h3>Video</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div id="videoUploadBox" class="upload-box">
                                                <div class="upload-area">
                                                    <i class="fa-solid fa-video upload-icon"></i>
                                                    <p>{{ __('post.click_to_video') }}</p>
                                                    <input type="file" id="videoInput" name="videos[]"
                                                        accept="video/*" multiple hidden>
                                                </div>
                                            </div>
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
                                                        <button
                                                            data-video-url="{{ is_array($video) ? $video['video'] : $video }}"
                                                            class="btn btn-danger btn-sm btn-delete-video"
                                                            style="position: absolute; top: 5px; right: 5px; padding: 2px 6px; font-size: 12px;">
                                                            Xóa
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- <input type="file" id="videoInput" name="videos[]" accept="video/*" multiple hidden> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Location -->
                            <div class="form-submit">
                                <h3>{{ __('common.address') }}</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <!-- Quốc gia -->
                                        <div class="form-group col-md-2 col-12">
                                            <label> <span class="text-danger">*</span> {{ __('common.country') }} </label>
                                            <select id="country" class="form-control input-field" name="country"
                                                data-require='Mời chọn quốc gia'>
                                                <option value="">{{ __('common.select_country') }} </option>
                                                <option value="Vietnam"
                                                    {{ $baidang->address->ward->district->province->country == 'Vietnam' ? 'selected' : '' }}>
                                                    {{ __('common.country.vietnam') }} </option>
                                                <option value="Philippines"
                                                    {{ $baidang->address->ward->district->province->country == 'Philippines' ? 'selected' : '' }}>
                                                    Philippines</option>
                                                <option value="Thailand"
                                                    {{ $baidang->address->ward->district->province->country == 'Thailand' ? 'selected' : '' }}>
                                                    {{ __('common.country.thailand') }} </option>
                                                <option value="Campuchia"
                                                    {{ $baidang->address->ward->district->province->country == 'Campuchia' ? 'selected' : '' }}>
                                                    Campuchia</option>
                                            </select>
                                        </div>

                                        <!-- Tỉnh -->
                                        <div class="form-group col-md-2 col-12">
                                            <div>
                                                <label class="text-nowrap"> <span class="text-danger">*</span>
                                                    {{ __('common.province_city') }} </label>
                                                <select id="province" class="form-control input-field" name="province"
                                                    data-require='Mời chọn tỉnh thành'>
                                                    <option
                                                        value="{{ $baidang->address->ward->district->province->code }}">
                                                        {{ $baidang->address->ward->district->province->name }}</option>
                                                </select>
                                                <input type="hidden" name="province_name" id="province_name">
                                            </div>
                                            <button type="button" id="add-province"
                                                class="btn btn-sm btn-success">{{ __('post.add_province') }}</button>
                                        </div>

                                        <!-- Huyện -->
                                        <div class="form-group col-md-2 col-12">
                                            <div>
                                                <label> <span class="text-danger">*</span> {{ __('common.district') }}
                                                </label>
                                                <select id="district" class="form-control input-field" disabled
                                                    name="districts" data-require='Mời chọn quận huyện'>
                                                    <option value="{{ $baidang->address->ward->district->code }}">
                                                        {{ $baidang->address->ward->district->name }}</option>
                                                </select>
                                                <input type="hidden" name="district_name" id="district_name">
                                            </div>
                                            <button type="button" id="add-district"
                                                class="btn btn-sm btn-success">{{ __('post.add_district') }}</button>

                                        </div>

                                        <!-- Xã -->
                                        <div class="form-group col-md-2 col-12">
                                            <div>
                                                <label> <span class="text-danger">*</span> {{ __('common.ward') }}
                                                </label>
                                                <select id="ward" class="form-control input-field" disabled
                                                    name="wards" data-require='Mời chọn phường xã'>
                                                    <option value="{{ $baidang->address->ward->code }}">
                                                        {{ $baidang->address->ward->name }}</option>
                                                </select>
                                                <input type="hidden" name="ward_name" id="ward_name">
                                            </div>
                                            <button type="button" id="add-ward"
                                                class="btn btn-sm btn-success">{{ __('post.add_ward') }}</button>

                                        </div>

                                        <!-- Đường/ Phố -->
                                        <div class="form-group col-md-4 col-12">
                                            <label>{{ __('common.street') }}</label>
                                            <input type="text" id="street" class="form-control"
                                                placeholder="{{ __('common.enter_street') }}" name="address"
                                                value="{{ $baidang->address->street }}">
                                        </div>

                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="Longitude" id="Longitude">
                                    </div>
                                </div>
                            </div>

                            {{-- <iframe class="d-none" id="mapFrame" width="100%" height="400" style="border:0;" 
                allowfullscreen="" loading="lazy"></iframe> --}}
                            <div id="map" class="d-none" style="width: 100%; height: 400px;"></div>


                            <!-- Detailed Information -->
                            <div class="form-submit mt-4">
                                <h3>{{ __('post.detail_info') }}</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{ __('post.description') }} <span class="text-danger">( VIETNAMESE
                                                    )</span></label>
                                            <textarea id="description_post" class="form-control h-120 description_post ckeditor" name="description">{{ $baidang->description }}</textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>{{ __('post.description') }} <span class="text-danger">( ENGLISH
                                                    )</span></label>
                                            <textarea id="description_post_en" class="form-control h-120 description_post ckeditor" name="description_en">{{ $baidang->description_en }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>{{ __('common.house_direction') }}</label>
                                            @include('component.house_direction', [
                                                'selectedValue' => $baidang->huongnha,
                                            ])

                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>{{ __('common.balcony') }}</label>
                                            <div class="d-flex">
                                                <div class="form-check me-3 d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="huongbancong" id="balcony-yes" value="1"
                                                        {{ isset($baidang) && $baidang->huongbancong == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="balcony-yes">
                                                        {{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="huongbancong" id="balcony-no" value="0"
                                                        {{ isset($baidang) && $baidang->huongbancong == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="balcony-no">
                                                        {{ __('common.no') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        @php
                                            // Lấy danh sách thiết bị đã chọn từ dữ liệu bài đăng (chuyển JSON thành mảng)
                                            $selectedThietBis = json_decode($baidang->thietbis ?? '[]', true);
                                            $selectedThietBiNames = array_column($selectedThietBis, 'name'); // Lấy danh sách tên
                                        @endphp

                                        {{-- <div class="form-group col-md-12">
                                            <label>{{ __('post.device_service') }}</label>
                                            <div class="o-features">
                                                <ul class="no-ul-list third-row">
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

                                                    @foreach ($thietbis as $thietbi)
                                                        @php
                                                            // Kiểm tra nếu thiết bị có trong danh sách đã chọn
                                                            $isChecked = in_array(
                                                                $thietbi->title,
                                                                $selectedThietBiNames ?? [],
                                                            );
                                                        @endphp
                                                        <li class="d-flex align-items-center gap-2">
                                                            <input id="{{ $thietbi->id }}" class="form-check-input"
                                                                name="thietbis[{{ $thietbi->id }}]" type="checkbox"
                                                                value="{{ $thietbi->title }}"
                                                                {{ $isChecked ? 'checked' : '' }}>

                                                            <input type="hidden"
                                                                name="icon_thietbi[{{ $thietbi->id }}]"
                                                                value="{{ $thietbi->icon }}">

                                                            <div>
                                                                @if ($thietbi->icon != null)
                                                                    <img src="{{ $thietbi->icon }}" width="30px"
                                                                        alt="">
                                                                @endif
                                                                <label for="{{ $thietbi->id }}"
                                                                    class="form-check-label">
                                                                    {{ $tienIchMap[$thietbi->title] ?? $thietbi->title }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="form-submit">
                                <h3>{{ __('post.contact_info') }}</h3>
                                <div class="submit-section">
                                    <div class="row">

                                        <div class="form-group col-md-4">
                                            <label> <span class="text-danger">*</span> {{ __('common.name') }}</label>
                                            <input type="text" class="form-control input-field" name="name_contact"
                                                value="{{ $baidang->lienhe->agent_name }}"
                                                data-require='Mời nhập danh thiếp'>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label> <span class="text-danger">*</span> Email</label>
                                            <input type="text" class="form-control input-field" name="email_contact"
                                                value="{{ $baidang->lienhe->email }}" data-require='Mời nhập email'>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label> <span
                                                    class="text-danger">*</span>{{ __('common.phone_number') }}</label>
                                            <input type="text" class="form-control input-field" name="phone_contact"
                                                value="{{ $baidang->lienhe->phone }}"
                                                data-require='Mời nhập số điện thoại'>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Link Facebook</label>
                                            <input type="text" class="form-control" name="facebook"
                                                value="{{ $baidang->lienhe->facebook }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Link Telegram</label>
                                            <input type="text" class="form-control" name="telegram"
                                                value="{{ $baidang->lienhe->telegram }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-12 col-md-12">
                                <button class="btn btn-primary fw-medium px-5" type="submit">Cập nhật</button>
                            </div>
                            <!-- Modal Thêm Tỉnh -->
                            <div class="modal" id="addProvinceModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('post.add_province') }}</h5>
                                            <button type="button" class="close fs-4 bg-transparent py-0 px-2 rounded"
                                                data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addProvinceForm">
                                                <div class="form-group">
                                                    <label for="provinceName">{{ __('post.name_province') }}</label>
                                                    <input type="text" class="form-control" id="provinceName"
                                                        name="provinceName" required>
                                                </div>
                                                <button type="button" class="btn btn-primary"
                                                    id="addProvinceBtn">{{ __('post.save') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Thêm Quận/Huyện -->
                            <div class="modal" id="addDistrictModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('post.add_district') }}</h5>
                                            <button type="button" class="close fs-4 bg-transparent py-0 px-2 rounded"
                                                data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addDistrictForm">
                                                <div class="form-group">
                                                    <label for="districtName">{{ __('post.name_district') }}</label>
                                                    <input type="text" class="form-control" id="districtName"
                                                        name="districtName" required>
                                                </div>
                                                <button type="button" class="btn btn-primary"
                                                    id="addDistrictBtn">{{ __('post.save') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Thêm Phường/Xã -->
                            <div class="modal" id="addWardModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('post.add_ward') }}</h5>
                                            <button type="button" class="close fs-4 bg-transparent py-0 px-2 rounded"
                                                data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addWardForm">
                                                <div class="form-group">
                                                    <label for="wardName">{{ __('post.name_ward') }}</label>
                                                    <input type="text" class="form-control" id="wardName"
                                                        name="wardName" required>
                                                </div>
                                                <button type="button" class="btn btn-primary"
                                                    id="addWardBtn">{{ __('post.save') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Submit Property End ================================== -->
@endsection

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
        const ptypesSelect = document.getElementById('ptypes');
        const areaInput = document.querySelector('input[name="area"]');
        const floorInput = document.querySelector('input[name="tongsotang"]');
        const totalRoomsInput = document.querySelector('input[name="tongsophong"]');
        const bedroomsInput = document.querySelector('input[name="bedrooms"]');
        const bathroomsInput = document.querySelector('input[name="bathrooms"]');
        const contractTypeSelect = document.getElementById('loaihopdong');
        const balconyYesRadio = document.getElementById('balcony-yes');
        const balconyNoRadio = document.getElementById('balcony-no');
        const amenitiesCheckboxes = document.getElementById('list-thiet-bi');
        const labelSoTang = document.getElementById('label-so-tang');
        const houseDirectionSelect = document.getElementById('house_direction');

        // Hàm kiểm tra và hiển thị các trường
        function checkFieldsVisibility() {
            const mohinh = mohinhSelect.value;
            const ptypes = ptypesSelect.value;

            // Hiển thị/ẩn các trường dựa trên lựa chọn
            // Diện tích (Bán)
            if (mohinh === 'ban') {
                areaInput.parentElement.style.display = 'block';
            } else {
                areaInput.parentElement.style.display = 'none';
            }

            // Cập nhật text của nhãn "Số tầng"
            if (ptypes === '6' || ptypes === '4') {
                labelSoTang.textContent = '{{ __('post.floor') }}';
            } else {
                labelSoTang.textContent = '{{ __('post.amount_floor') }}';
            }

            // Số tầng (bao nhiêu tầng) (Bán, Cho thuê, San nhượng - Các loại tài sản trừ căn hộ)
            if (ptypes !== '6' && ptypes !== '4') {
                totalRoomsInput.parentElement.style.display = 'block';
                bathroomsInput.parentElement.style.display = 'block';
            } else {
                bathroomsInput.parentElement.style.display = 'none';
                totalRoomsInput.parentElement.style.display = 'none';
            }

            // Số tháng đặt cọc (Cho thuê)
            if (mohinh === 'thue') {
                document.querySelector('input[name="thangdatcoc"]').parentElement.style.display = 'block';
            } else {
                document.querySelector('input[name="thangdatcoc"]').parentElement.style.display = 'none';
            }

            // Số tháng trả trước (Cho thuê)
            if (mohinh === 'thue') {
                document.querySelector('input[name="thangtratruoc"]').parentElement.style.display = 'block';
            } else {
                document.querySelector('input[name="thangtratruoc"]').parentElement.style.display = 'none';
            }

            // Thời hạn hợp đồng (Cho thuê - Tất cả loại tài sản)
            if (mohinh === 'thue') {
                contractTypeSelect.parentElement.style.display = 'block';
            } else {
                contractTypeSelect.parentElement.style.display = 'none';
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

            // Ban công (Bán/Cho thuê/San nhượng - Căn hộ)
            if ((mohinh === 'ban' || mohinh === 'thue' || mohinh === 'chuyennhuong') && ptypes ===
                'can-ho-chung-cu') {
                balconyYesRadio.parentElement.style.display = 'flex';
                balconyNoRadio.parentElement.style.display = 'flex';
            } else {
                balconyYesRadio.parentElement.style.display = 'none';
                balconyNoRadio.parentElement.style.display = 'none';
            }

            // Thiết bị nội thất (Cho thuê)
            if (mohinh === 'thue') {
                document.querySelector('div.o-features').style.display = 'block';
            } else {
                document.querySelector('div.o-features').style.display = 'none';
            }
        }

        // Lắng nghe sự kiện thay đổi lựa chọn
        mohinhSelect.addEventListener('change', checkFieldsVisibility);
        ptypesSelect.addEventListener('change', checkFieldsVisibility);

        // Kiểm tra hiển thị ban đầu
        checkFieldsVisibility();
    });
</script>
