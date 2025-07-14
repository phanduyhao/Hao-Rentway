@extends('layout.layout')

@section('content')
<!-- ============================ Page Title Start ================================== -->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h2 class="ipt-title">{{ $title }} </h2>
                <span class="ipn-subtitle">{{ __('post.subtitle_quick_post') }}</span>
            </div>
        </div>
    </div>
</div>
<!-- ============================ Page Title End ================================== -->

<!-- ============================ Submit Property Start ================================== -->
<section class="gray-simple">
    <div class="container">
        <!-- row Start -->
        <div class="row">
            <!-- Submit Form -->
            <div class="col-lg-12 col-md-12">
                <form id="quick-post-form" class="form-baidang" method="POST" action="{{route(name: 'baidangnhanh.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="submit-page">
                        <!-- Basic Information -->
                        <div class="form-submit">
                            <h3>{{ __('post.info_poster') }}</h3>
                            <div class="submit-section mt-4">
                                <div class="row">
                                   
                                    
                                    <div class="form-group col-sm-6 col-12">
                                        <label> <span class="text-danger">*</span> {{ __('common.name') }}</label>
                                        <input type="text" class="form-control input-field" name="name" required placeholder="{{ __('post.enter_name') }}" data-require='Mời nhập tên của bạn!'>
                                    </div>

                                    <div class="form-group col-sm-6 col-12">
                                        <label> <span class="text-danger">*</span> {{ __('common.phone_number') }}</label>
                                        <input type="text" class="form-control input-field" name="phone" required placeholder="{{ __('post.enter_phone') }}" data-require='Mời nhập số điện thoại!'>
                                    </div>
{{-- 
                                    <div class="form-group col-md-4 col-sm-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="Email" placeholder="{{ __('common.enter_email') }}">
                                    </div> --}}

                                    <div class="form-submit">
                                        <h3>{{ __('post.info_post') }}</h3>
                                        <div class="form-group col-12">
                                            <label> <span class="text-danger">*</span>{{ __('post.title') }}</label>
                                            <input type="text" class="form-control input-field" name="title" required placeholder="{{ __('post.enter_title') }}" data-require='Mời nhập tiêu đề bài đăng!'>
                                        </div>
                                        <div class="submit-section">
                                            <div class="row">
                                                <!-- Quốc gia -->
                                                <div class="form-group col-md-2 col-12">
                                                    <label> <span class="text-danger">*</span> {{ __('common.country') }} </label>
                                                    <select id="country" class="form-control input-field" name="country" data-require='Mời chọn quốc gia'>
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
                                                    <label class="text-nowrap"> <span class="text-danger">*</span> {{ __('common.province_city') }} </label>
                                                    <select id="province" class="form-control input-field" name="province" data-require='Mời chọn tỉnh thành'>
                                                        <option value="">{{ __('common.select_province_city') }} </option>
                                                    </select>
                                                    <input type="hidden" name="province_name" id="province_name">
                                                  </div>
                                                    {{-- <button type="button" id="add-province" class="btn btn-sm btn-success">Thêm mới tỉnh</button> --}}
                                                </div>
                                    
                                                <!-- Huyện -->
                                                <div class="form-group col-md-2 col-12">
                                                   <div>
                                                    <label> <span class="text-danger">*</span> {{ __('common.district') }} </label>
                                                    <select id="district" class="form-control input-field" disabled name="districts" data-require='Mời chọn quận huyện'>
                                                        <option value="">{{ __('common.select_district') }} </option>
                                                    </select>
                                                    <input type="hidden" name="district_name" id="district_name">
                                                   </div>
                                                    {{-- <button type="button" id="add-district" class="btn btn-sm btn-success">Thêm mới quận/huyện</button> --}}
                    
                                                </div>
                                    
                                                <!-- Xã -->
                                                <div class="form-group col-md-2 col-12">
                                                    <div>
                                                        <label> <span class="text-danger">*</span> {{ __('common.ward') }} </label>
                                                    <select id="ward" class="form-control input-field" disabled name="wards" data-require='Mời chọn phường xã'>
                                                        <option value="">{{ __('common.select_ward') }}</option>
                                                    </select>
                                                    <input type="hidden" name="ward_name" id="ward_name">
                                                    </div>
                                                    {{-- <button type="button" id="add-ward" class="btn btn-sm btn-success">Thêm mới phường/xã</button> --}}
                    
                                                </div>
                                    
                                                <!-- Đường/ Phố -->
                                                <div class="form-group col-md-4 col-12">
                                                    <label>{{ __('common.street') }}</label>
                                                    <input type="text" id="street" class="form-control" placeholder="{{ __('common.enter_street') }}" name="address">
                                                </div>
                                    
                                                <input type="hidden" name="latitude" id="latitude">
                                                <input type="hidden" name="Longitude" id="Longitude">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-12 col-12">
                                        <label> {{ __('post.detail_info') }}</label>
                                        <textarea id="description_post" class="form-control h-120 description_post ckeditor" name="description"></textarea>
                                    </div>
                                    
                                    <div class="form-submit">	
                                        <h3>{{ __('post.images_library') }}</h3>
                                        <div class="submit-section">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div id="imageUpload" class="upload-box">
                                                        <div class="upload-area">
                                                            <i class="fa-solid fa-images upload-icon"></i>
                                                            <p>{{ __('post.note_upload') }}</p>
                                                            <input type="file" id="imageInput" name="image[]" accept="image/*" multiple hidden>
                                                        </div>
                                                    </div>
                                                    <div id="previewContainer" class="preview-container"></div>
                                                    <input type="hidden" name="images" id="images">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary fw-medium px-5">{{ __('post.post') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /row End -->
    </div>
</section>
<!-- ============================ Submit Property End ================================== -->

@endsection
