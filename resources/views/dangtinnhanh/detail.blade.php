@extends('layout.layout') <!-- Giả sử bạn đang sử dụng layout.blade.php làm bố cục chung -->

@section('content')
    <!-- ============================ Page Title Start ================================== -->
    <div class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title">{{ $title }}</h2>
                    <span class="ipn-subtitle">{{ __('post.detail_quick_post') }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Page Title End ================================== -->

    <!-- ============================ Listing Start ================================== -->
    <section class="gray-simple min">
        <div class="container">
            <div class="row">

                <!-- property main detail -->
                <div class="col-lg-8 col-md-12 col-sm-12">

                    <div class="property_block_wrap style-2">

                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo1" aria-controls="clTwo1"
                                href="javascript:void(0);" aria-expanded="true">
                                <h4 class="property_block_title">{{ __('common.address') }}</h4>
                            </a>
                        </div>
                        <div id="clTwo1" class="panel-collapse collapse show">
                            <div class="block-body">
                                <ul class="deatil_features">
                                    {{ $baidang->address }}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Single Block Wrap -->
                    <div class="property_block_wrap style-2">

                        <div class="property_block_wrap_header">
                            <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo" aria-controls="clTwo"
                                href="javascript:void(0);" aria-expanded="true">
                                <h4 class="property_block_title">{{ __('common.detail') }}</h4>
                            </a>
                        </div>
                        <div id="clTwo" class="panel-collapse collapse show">
                            <div class="block-body">
                                {!! $baidang->description !!}
                            </div>
                        </div>
                    </div>

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
                                    @foreach(json_decode($baidang->images, true) ?? [] as $image)
                                    <li>
                                        <a href="{{ $image }}" class="mfp-gallery" data-discover="true"><img src="{{ $image }}" class="img-custom mx-auto  " alt=""/></a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- property Sidebar -->
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="details-sidebar">
                        <!-- Agent Detail -->
                        <div class="sides-widget border rounded shadow-sm p-3 bg-white">
                            <h3 class="fw-bold bg-warning py-2 rounded-3 text-center">
                                <a href="#" class="text-decoration-none">{{ __('common.poster') }}</a>
                            </h3>

                            <div class="sides-widget-body text-center">
                                <!-- Email -->
                                <div class="contact-item my-2 p-2 bg-light rounded">
                                    <strong>{{ __('common.name') }}:</strong>
                                    <a href="#" class="text-dark fw-semibold">
                                        {{ $baidang->name }}
                                    </a>
                                </div>
                                <div class="contact-item my-2 p-2 bg-light rounded">
                                    <strong>Email:</strong>
                                    <a href="mailto:{{ $baidang->email }}" class="text-dark fw-semibold">
                                        {{ $baidang->email }}
                                    </a>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="contact-item my-2 p-2 bg-light rounded">
                                    <strong>{{ __('common.phone_number') }}:</strong>
                                    <a href="tel:{{ $baidang->phone }}" class="text-dark fw-semibold">
                                        {{ $baidang->phone }}
                                    </a>
                                </div>

                                <!-- Zalo -->

                                <!-- Facebook -->

                                <!-- Telegram -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ============================ Listing End ================================== -->
@endsection
