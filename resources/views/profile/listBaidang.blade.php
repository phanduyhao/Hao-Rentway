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
                        <a href="javascript:void(0);" onclick="openFilterSearch()"
                            class="btn btn-dark full-width mb-4">Menu<i class="fa-solid fa-bars ms-2"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-2 col-md-12">

                    <div class="simple-sidebar sm-sidebar" id="filter_search">

                        <div class="search-sidebar_header">
                            <h4 class="ssh_heading">Close Filter</h4>
                            <button onclick="closeFilterSearch()" class="w3-bar-item w3-button w3-large"><i
                                    class="fa-regular fa-circle-xmark fs-5 text-muted-2"></i></button>
                        </div>

                        <div class="sidebar-widgets">
                            <div class="dashboard-navbar">
                                <div class="fr-grid-thumb mx-auto text-center mt-5 mb-0">
                                    <a href="agent-page.html" class="d-inline-flex p-1 circle border">
                                        <img src="{{ Auth::user()->avatar }}" width="150"
                                            class="img-fluid circle object-fit-cover" alt=""
                                            style="height: 150px" />
                                    </a>
                                </div>
                                <div class="d-user-avater mt-0">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <span>{{ Auth::user()->email }}</span>
                                    @if (Auth::user()->role != 'admin')
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

                                            @for ($i = 1; $i <= $stars; $i++)
                                                <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                            @endfor
                                        </div>
                                    @endif

                                </div>

                                <div class="d-navigation">
                                    <ul>
                                        <li><a href="{{ route('profile.index') }}"><i
                                                    class="fa-solid fa-gauge"></i>{{ __('profile.overview') }}</a></li>
                                        <li class="active"><a href="{{ route('profile.listBaidang') }}"><i
                                                    class="fa-solid fa-address-card"></i>{{ __('profile.post_list') }}</a>
                                        </li>
                                        <li><a href="{{ route('showChangePass') }}"><i
                                                    class="fa-solid fa-unlock"></i>{{ __('profile.change_password') }}</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-10 col-md-12">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h3 class="fw-bold text-primary py-3 mb-4">{{ $title }}</h3>
                        <div>
                            <form class="form-search" method="GET" action="">
                                @csrf
                                <div class="mb-3">
                                    <div class="row">
                                        {{-- <!-- Tìm kiếm theo tên người đăng -->
                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <input class="form-control shadow-none" type="text" name="search_user"
                                                placeholder="Tìm theo tên người đăng" value="{{ request()->search_user }}">
                                        </div>
                 --}}
                                        <!-- Tìm kiếm theo tên công ty -->
                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <input class="form-control shadow-none" type="text" name="search_title"
                                                placeholder="{{ __('profile.search_title') }}"
                                                value="{{ request()->search_title }}">
                                        </div>

                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <input class="form-control shadow-none" type="text" name="search_broker"
                                                placeholder="{{ __('post.broker') }}"
                                                value="{{ request()->search_broker }}">
                                        </div>

                                        <!-- Tìm kiếm theo tiêu đề công việc -->
                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <select class="form-control shadow-none" name="search_mohinh">
                                                <option value="">{{ __('profile.search_model') }}</option>
                                                <option value="thue"
                                                    {{ request()->search_mohinh == 'thue' ? 'selected' : '' }}>
                                                    {{ __('profile.model_thue') }}
                                                </option>
                                                <option value="ban"
                                                    {{ request()->search_mohinh == 'ban' ? 'selected' : '' }}>
                                                    {{ __('profile.model_ban') }}
                                                </option>
                                                <option value="chuyennhuong"
                                                    {{ request()->search_mohinh == 'chuyennhuong' ? 'selected' : '' }}>
                                                    {{ __('profile.model_chuyennhuong') }}
                                                </option>
                                                <option value="oghep"
                                                    {{ request()->search_mohinh == 'oghep' ? 'selected' : '' }}>
                                                    {{ __('profile.model_oghep') }}
                                                </option>
                                            </select>
                                        </div>


                                        <!-- Tìm kiếm theo vị trí -->
                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <input class="form-control shadow-none" type="text" name="search_loainhadat"
                                                placeholder="{{ __('profile.search_type') }}"
                                                value="{{ request()->search_loainhadat }}">
                                        </div>

                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <select class="form-control shadow-none" name="search_trangthai">
                                                <option value="">{{ __('profile.search_status') }}</option>
                                                <option value="cosan"
                                                    {{ request()->search_trangthai == 'cosan' ? 'selected' : '' }}>
                                                    {{ __('profile.status_cosan') }}
                                                </option>
                                                <option value="dathue"
                                                    {{ request()->search_trangthai == 'dathue' ? 'selected' : '' }}>
                                                    {{ __('profile.status_dathue') }}
                                                </option>
                                                <option value="hethan"
                                                    {{ request()->search_trangthai == 'hethan' ? 'selected' : '' }}>
                                                    {{ __('profile.status_hethan') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <select name="search_duyet" id="search_duyet" class="form-control me-3">
                                                <option value="">{{ __('profile.search_approval') }}</option>
                                                <option value="pending"
                                                    {{ request('search_duyet') === 'pending' ? 'selected' : '' }}>
                                                    {{ __('profile.approval_pending') }}
                                                </option>
                                                <option value="approved"
                                                    {{ request('search_duyet') === 'approved' ? 'selected' : '' }}>
                                                    {{ __('profile.approval_approved') }}
                                                </option>
                                                <option value="rejected"
                                                    {{ request('search_duyet') === 'rejected' ? 'selected' : '' }}>
                                                    {{ __('profile.approval_rejected') }}
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Nút tìm kiếm và xóa lọc -->
                                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                                            <div class="text-center text-nowrap">
                                                <button type="submit" class="btn btn-danger rounded-pill">
                                                    <i class="fas fa-search me-2"></i>{{ __('common.search') }}
                                                </button>
                                                <a href="{{ route('profile.listBaidang') }}"
                                                    class="btn btn-secondary rounded-pill ms-2">
                                                    <i class="fas fa-times me-2"></i>{{ __('profile.clear_filters') }}

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('profile.post_code') }}</th>
                                            <th>{{ __('post.broker') }}</th>
                                            <th>{{ __('profile.image') }}</th>
                                            <th>{{ __('profile.title_col') }}</th>
                                            <th>{{ __('common.price') }}</th>
                                            <th>{{ __('common.acreage') }}</th>
                                            <th>{{ __('profile.model') }}</th>
                                            <th>{{ __('profile.property_type') }}</th>
                                            <th>{{ __('profile.vip_post') }}</th>
                                            <th>{{ __('profile.approval') }}</th>
                                            <th>{{ __('profile.status') }}</th>
                                            <th>{{ __('profile.post_date') }}</th>
                                            <th>{{ __('profile.actions') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @if ($BaiDangs->isEmpty())
                                            <tr>
                                                <td colspan="11" class="text-center">{{ __('profile.no_results') }}.
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($BaiDangs as $baidang)
                                                <tr data-id="{{ $baidang->id }}">
                                                    <td>{{ $baidang->mabaidang }}</td>
                                                    <td>{{ $baidang->mamoigioi }}</td>
                                                    {{-- <td>{{ $baidang->User->name }}</td> --}}
                                                    <td>
                                                        <img src="{{ $baidang->thumb }}" alt="{{ $baidang->title }}"
                                                            width="90px" height="90px">
                                                    </td>
                                                    <td class="title-cell">
                                                        @if (App::getLocale() === 'vi')
                                                            {!! $baidang->title !!}
                                                        @else
                                                            {!! $baidang->title_en ?? $baidang->title !!}
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($baidang->price, 0, ',', '.') }} đ</td>
                                                    <td>{{ $baidang->dientich }} M2</td>
                                                    <td>
                                                        <span>{{ $baidang->mohinh == 'thue' ? __('common.model.rent') : __('common.model.sale') }}</span>
                                                    </td>
                                                    <td>
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
                                                            $typeSlug = $baidang->nhadat->slug ?? null;
                                                            $typeKey =
                                                                $typeSlug && isset($propertyTypeMap[$typeSlug])
                                                                    ? 'common.property_type.' .
                                                                        $propertyTypeMap[$typeSlug]
                                                                    : null;
                                                        @endphp

                                                        {{ $typeKey ? __($typeKey) : '' }}
                                                    </td>

                                                    <td>
                                                        <input type="checkbox" class="toggle-isVip"
                                                            data-id="{{ $baidang->id }}"
                                                            {{ $baidang->isVip ? 'checked' : '' }}>
                                                    </td>
                                                    <td>
                                                        @if (is_null($baidang->adminduyet))
                                                            <span
                                                                class="badge bg-warning">{{ __('profile.approval_pending') }}</span>
                                                        @elseif ($baidang->adminduyet)
                                                            <span
                                                                class="badge bg-success">{{ __('profile.approval_approved') }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-danger">{{ __('profile.approval_rejected') }}</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <select class="form-control status-select"
                                                            data-id="{{ $baidang->id }}">
                                                            <option value="cosan"
                                                                {{ $baidang->status == 'cosan' ? 'selected' : '' }}>
                                                                {{ __('profile.status_cosan') }}
                                                            </option>
                                                            <option value="dathue"
                                                                {{ $baidang->status == 'dathue' ? 'selected' : '' }}>
                                                                {{ __('profile.status_dathue') }}
                                                            </option>
                                                            <option value="hethan"
                                                                {{ $baidang->status == 'hethan' ? 'selected' : '' }}>
                                                                {{ __('profile.status_hethan') }}
                                                            </option>
                                                        </select>
                                                    </td>



                                                    <td>{{ $baidang->created_at }}</td>
                                                    <td class="text-nowrap text-center">
                                                        <a href="{{ route('baidangDetail', $baidang->slug) }}"
                                                            class="bg-info rounded border px-2 py-1 text-dark fw-bold"
                                                            target="_blank">
                                                            {{ __('profile.action_detail') }}
                                                        </a>

                                                        <a href="{{ route('baidang.edit', $baidang->slug) }}"
                                                            class="bg-warning rounded border px-2 py-1 text-dark fw-bold mx-1">
                                                            {{ __('profile.action_edit') }}
                                                        </a>

                                                        <form class="mt-2 d-inline"
                                                            action="{{ route('baidang.destroy', $baidang->id) }}"
                                                            method="post"
                                                            onsubmit="return confirm('{{ __('profile.confirm_delete') }}');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-danger rounded text-white px-2 py-1">
                                                                {{ __('profile.action_delete') }}
                                                            </button>
                                                        </form>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                                <div class="pagination mt-4 pb-4">
                                    {{ $BaiDangs->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
