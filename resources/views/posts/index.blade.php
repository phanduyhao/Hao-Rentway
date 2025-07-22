@extends('layout.layout')
@section('content')
    <style>
        .form-check-input[type=radio] {
            width: 25px;
            height: 25px;
        }

        .form-check-label {
            font-size: 16px;
        }

        #loading.show {
            display: flex;
            /* Khi có class show mới hiện và dùng flex */
        }
    </style>
    <!-- ============================ Page Title Start================================== -->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">{{ $title }}</h2>
                    <span class="ipn-subtitle">{{ __('post.subtitle_full_post') }}</span>
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
                    <form id="form-dang-tin" class="form-baidang" method="POST" action="{{ route('dangbai') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="submit-page" style="line-height: 3rem">
                            <!-- Basic Information -->
                            <div class="form-submit">
                                <h3>{{ __('post.info_basic') }}</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label class="d-flex align-items-center gx-2"> <input type="checkbox"
                                                    class="form-check-input mt-0 me-2" id="isVip"
                                                    style="margin-left: 5px;" name="isVip">
                                                <span>{{ __('listPost.post_vip') }}</span></label>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> <span class="text-danger">* ( VIETNAMESE)</span>
                                                {{ __('post.property_title') }} <span class="tip-topdata"
                                                    data-tip="{{ __('post.property_title') }}"><i
                                                        class="fa-solid fa-info"></i></span></label>
                                            <input type="text" class="form-control input-field" name="title"
                                                data-require='{{ __('post.required_title') }}'>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> <span class="text-danger">* ( ENGLISH)</span>
                                                {{ __('post.property_title') }}<span class="tip-topdata"
                                                    data-tip="{{ __('post.property_title') }}"><i
                                                        class="fa-solid fa-info"></i></span></label>
                                            <input type="text" class="form-control input-field" name="title_en"
                                                data-require='{{ __('post.required_title') }}'>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('post.broker') }}</label>
                                            <select id="mamoigioi" class="form-control" name="mamoigioi">
                                                <option value="">{{ __('post.select_broker') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('common.model') }}</label>
                                            <select id="mohinh" class="form-control" name="mohinh">
                                                <option value="thue">{{ __('common.model.rent') }}</option>
                                                <option value="ban">{{ __('common.model.sale') }}</option>
                                                <option value="chuyennhuong">{{ __('common.model.transfer') }}</option>
                                                <option value="oghep">{{ __('common.model.roommate') }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('post.property_type') }}</label>

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
                                                    <option value="{{ $loainhadat->id }}">
                                                        {{ __('common.property_type.' . $propertyTypeMap[$loainhadat->slug]) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label class="d-flex align-items-center fw-bold text-danger">
                                                {{ __('common.price') }} (
                                                <input type="checkbox" class="form-check-input mt-0 me-2"
                                                    id="priceNegotiable" style="margin-left: 5px;">
                                                <span>{{ __('post.price_negotiable') }}</span>
                                                )
                                            </label>
                                            <div class="input-group">
                                                <input type="text" id="priceInput" class="form-control"
                                                    placeholder="VD: 1.5 ">
                                                <select id="priceUnit" class="form-select" style="max-width: 300px;">
                                                    <option value="1000000">{{ __('common.million') }} </option>
                                                    <option value="1000">{{ __('common.thousand') }} </option>
                                                    <option value="1000000000">{{ __('common.billion') }} </option>
                                                </select>
                                            </div>

                                            <!-- Hiển thị kết quả -->
                                            <div class="text-danger">
                                                <b>{{ __('post.real_price') }}: <span id="priceResult">0</span> <span
                                                        id="priceUnitLabel"></span></b>
                                            </div>

                                            <!-- Hidden input gửi lên server -->
                                            <input type="hidden" name="price" id="priceReal">

                                        </div>
                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> {{ __('common.unit') }} </label>
                                            <select id="unit" class="form-control" name="unit">
                                                <option value="thang">/ {{ __('common.month') }} </option>
                                                <option value="ngay">/ {{ __('common.day') }} </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> {{ __('common.acreage') }} </label>
                                            <input type="text" class="form-control" name="area" placeholder="m2">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> <span id="label-so-tang"></span></label>
                                            <input type="number" class="form-control" id="input-so-tang"
                                                name="tongsotang" value="">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label><span id="label-so-phong"> {{ __('post.total_room') }}</span></label>
                                            <input type="number" class="form-control " id="input-so-phong"
                                                name="tongsophong" value="" data-require="Mời nhập tổng số phòng">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('post.profit') }}</label>
                                            <input type="number" class="form-control" placeholder="%" name="hoahong"
                                                value="">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> {{ __('post.number_months_deposit') }}</label>
                                            <input type="number" class="form-control "
                                                data-require="Mời nhập tháng đặt cọc" name="thangdatcoc" value="">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> {{ __('post.number_months_prepaid') }}</label>
                                            <input type="number" class="form-control "
                                                data-require="Mời nhập tháng trả trước" name="thangtratruoc"
                                                value="">
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label> {{ __('common.amount_bedroom') }}</label>
                                            <input type="number" class="form-control " name="bedrooms" value=""
                                                data-require='Mời nhập số phòng ngủ'>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12" id="bathroom-field">
                                            <label> {{ __('common.amount_bathroom') }}</label>
                                            <input type="number" class="form-control " name="bathrooms" value=""
                                                data-require='Mời nhập số phòng tắm'>
                                        </div>

                                        <div class="form-group col-md-3 col-sm-4 col-12">
                                            <label>{{ __('post.contract_type') }}</label>
                                            <select id="loaihopdong" class="form-control" name="hopdong">
                                                <option value="">{{ __('post.select_contract_type') }}</option>
                                                <option value="1thang">{{ __('post.1_5_month') }}</option>
                                                <option value="6thang">{{ __('post.6_months') }}</option>
                                                <option value="1nam">{{ __('post.1_year') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gallery -->
                            <h5 class="text-danger">{{ __('post.note_max') }}</h5>
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
                                            <div id="previewContainer" class="preview-container"></div>
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
                                                    <p>{{ __('post.click_to_video') }} </p>
                                                    <input type="file" id="videoInput" name="videos[]"
                                                        accept="video/*" multiple hidden>
                                                </div>
                                            </div>

                                            <div id="videoPreviewContainer" class="preview-container"></div>
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
                                                <option value="Vietnam">{{ __('common.country.vietnam') }} </option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Thailand">{{ __('common.country.thailand') }} </option>
                                                <option value="Campuchia">Campuchia</option>
                                            </select>
                                        </div>

                                        <!-- Tỉnh -->
                                        <div class="form-group col-md-2 col-12">
                                            <div>
                                                <label class="text-nowrap"> <span class="text-danger">*</span>
                                                    {{ __('common.province_city') }} </label>
                                                <select id="province" class="form-control input-field" name="province"
                                                    data-require='Mời chọn tỉnh thành'>
                                                    <option value="">{{ __('common.select_province_city') }}
                                                    </option>
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
                                                    <option value="">{{ __('common.select_district') }} </option>
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
                                                    <option value="">{{ __('common.select_ward') }}</option>
                                                </select>
                                                <input type="hidden" name="ward_name" id="ward_name">
                                            </div>
                                            <button type="button" id="add-ward"
                                                class="btn btn-sm btn-success">{{ __('post.add_ward') }}</button>

                                        </div>

                                        <!-- Đường/ Phố -->
                                        <div class="form-group col-md-4 col-12">
                                            <label><span class="text-danger">*</span>{{ __('common.street') }}</label>
                                            <input type="text" id="street" class="form-control input-field"
                                                placeholder="{{ __('common.enter_street') }}" name="address"
                                                data-require='Mời nhập tên đường phố'>
                                        </div>

                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="Longitude" id="Longitude">
                                    </div>
                                </div>
                            </div>


                            {{-- <iframe class="d-none" id="mapFrame" width="100%" height="400" style="border:0;" 
                allowfullscreen="" loading="lazy"></iframe> --}}
                            {{-- <div id="map" class="d-none" style="width: 100%; height: 400px;"></div> --}}

                            <!-- Detailed Information -->
                            <div class="form-submit mt-4">
                                <h3>{{ __('post.detail_info') }}</h3>
                                <div class="submit-section">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>{{ __('post.description') }} <span class="text-danger">( VIETNAMESE
                                                    )</span></label>
                                            <textarea id="description_post" class="form-control h-120 description_post ckeditor" name="description"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>{{ __('post.description') }} <span class="text-danger">( ENGLISH
                                                    )</span></label>
                                            <textarea id="description_post_en" class="form-control h-120 description_post ckeditor" name="description_en"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('common.house_direction') }}</label>
                                            @include('component.house_direction', ['selectedValue' => ''])

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>{{ __('common.balcony') }}</label>
                                            <div class="d-flex">
                                                <div class="form-check me-3 d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="huongbancong" id="balcony-yes" value="1">
                                                    <label class="form-check-label" for="balcony-yes">
                                                        {{ __('common.yes') }}
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input class="form-check-input me-2" type="radio"
                                                        name="huongbancong" id="balcony-no" value="0">
                                                    <label class="form-check-label" for="balcony-no">
                                                        {{ __('common.no') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group col-md-12" id="list-thiet-bi">
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
                                                                name="thietbis[{{ $thietbi->id }}]" checked
                                                                type="checkbox" value="{{ $thietbi->title }}"
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
                                                value="{{ Auth::user()->name }}" data-require='Mời nhập danh thiếp'>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label> <span class="text-danger">*</span> Email</label>
                                            <input type="text" class="form-control input-field" name="email_contact"
                                                value="{{ Auth::user()->email }}" data-require='Mời nhập email'>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label> <span
                                                    class="text-danger">*</span>{{ __('common.phone_number') }}</label>
                                            <input type="text" class="form-control input-field" name="phone_contact"
                                                value="{{ Auth::user()->phone }}" data-require='Mời nhập số điện thoại'>
                                        </div>
                                        @if (Auth::user()->role != 'admin')
                                            <div class="form-group col-md-4">
                                                <label>{{ __('common.contact_type') }}</label>
                                                <select id="loailienhe" class="form-control" name="loailienhe">
                                                    <option value="moigioi"
                                                        {{ Auth::user()->role == 'moigioi' ? 'selected' : '' }}>
                                                        {{ __('common.broker') }}
                                                    </option>
                                                    <option value="chunha"
                                                        {{ Auth::user()->role == 'chunha' ? 'selected' : '' }}>
                                                        {{ __('common.homeowner') }}
                                                    </option>
                                                    <option value="nhanvien"
                                                        {{ Auth::user()->role == 'nhanvien' ? 'selected' : '' }}>
                                                        {{ __('common.staff') }}
                                                    </option>
                                                    <option value="user"
                                                        {{ Auth::user()->role == 'user' ? 'selected' : '' }}>
                                                        {{ __('common.guest') }}
                                                    </option>
                                                </select>
                                            </div>
                                        @endif

                                        <div class="form-group col-md-4">
                                            <label>Telegram</label>
                                            <input type="text" value="{{ Auth::user()->link_tele }}"
                                                class="form-control" name="link_tele">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Zalo</label>
                                            <input type="text" value="{{ Auth::user()->link_zalo }}"
                                                class="form-control" name="link_zalo">
                                        </div>
                                        {{-- <div class="form-group col-md-4">
                                <label>Facebook</label>
                                <input type="text" class="form-control" name="facebook">
                            </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-lg-12 col-md-12">
                                <button id="btn-post" type="button"
                                    class="btn btn-primary fw-medium px-5">{{ __('post.post') }}</button>
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
                                                    id="addProvinceBtn">Lưu</button>
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
        <div id="loading"
            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
            <div class="w-100 d-flex align-items-center justify-content-center position-absolute top-0 bottom-0">
                <div style="padding:20px; background:#fff; border-radius:5px; font-weight:bold; font-size:18px;">
                    {{ __('post.loading_post') }}
                </div>
            </div>
        </div>

    </section>
    <script>
       
        document.addEventListener("DOMContentLoaded", function() {
            const priceInput = document.getElementById("priceInput");
            const priceUnit = document.getElementById("priceUnit");
            const priceResult = document.getElementById("priceResult");
            const priceUnitLabel = document.getElementById("priceUnitLabel");

            // const unitLabels = {
            //     1000: '(nghìn)',
            //     1000000: '(triệu)',
            //     1000000000: '(tỷ)'
            // };

            function updateRealPrice() {
                let raw = priceInput.value.trim();
                raw = raw.replace(',', '.').replace(/[^0-9.]/g, '');

                const base = parseFloat(raw);
                const multiplier = parseInt(priceUnit.value);

                if (!isNaN(base)) {
                    const realValue = base * multiplier;

                    // Hiển thị giá formatted
                    priceResult.textContent = realValue.toLocaleString('vi-VN');
                    // priceUnitLabel.textContent = unitLabels[multiplier] || '';

                    // Gán giá trị thực tế vào input hidden
                    priceReal.value = realValue;
                } else {
                    priceResult.textContent = '0';
                    priceUnitLabel.textContent = '';

                    // Nếu không hợp lệ thì để rỗng
                    priceReal.value = '';
                }
            }


            priceInput.addEventListener("input", updateRealPrice);
            priceUnit.addEventListener("change", updateRealPrice);

            updateRealPrice(); // khởi tạo ban đầu nếu có sẵn
        });
    </script>
    <script>
        // Function để kiểm tra dữ liệu trước khi gửi
        document.getElementById('btn-post').addEventListener('click', function(e) {
            e.preventDefault(); // Ngừng submit form để kiểm tra trùng lặp

            // Lấy dữ liệu từ các trường nhập liệu
            const price = document.getElementById('priceReal').value;
            const model = document.getElementById('mohinh').value;
            const propertyType = document.getElementById('ptypes').value;
            const country = document.getElementById('country').value;
            const province = document.getElementById('province').value;
            const district = document.getElementById('district').value;
            const ward = document.getElementById('ward').value;
            const street = document.getElementById('street').value;

            // // Gửi yêu cầu AJAX tới server để kiểm tra trùng lặp
            fetch('/check-duplicate-post', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Đảm bảo gửi token CSRF nếu cần
                    },
                    body: JSON.stringify({
                        price: price,
                        model: model,
                        propertyType: propertyType,
                        country: country,
                        province: province,
                        district: district,
                        ward: ward,
                        street: street
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        const isConfirmed = confirm(
                            'Đã có bài đăng trùng "Mô hình / Loại nhà đất / Giá / Địa chỉ" trên hệ thống. Bạn có chắc chắn muốn đăng bài này không?'
                        );

                        if (isConfirmed) {
                            // Nếu người dùng nhấn OK, gửi form
                            console.log('Form sẽ được gửi');
                            $('.form-baidang').submit(); // Gửi form sau khi xác nhận
                        } else {
                            // Nếu người dùng nhấn Cancel, không làm gì cả
                            console.log('Người dùng đã hủy, không gửi form');
                        }
                    } else {
                        // Nếu không có trùng, tiếp tục submit form
                        $('.form-baidang').submit();
                    }
                })
                .catch(error => console.error('Lỗi kiểm tra:', error));
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
@endsection
