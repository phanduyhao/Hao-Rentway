<style>
    .nav-menu-pc a {
        font-weight: 600 !important;
        /* padding-right: 3px !important; */
        /* padding-left: 3px !important; */
    }

    .h-fit {
        height: fit-content !important;
    }

    .dropdown_post:hover .nav-dropdown_post {
        left: 0 !important;
        bottom: -90px !important;
    }

    .btn-home-mobile {
        font-size: 14px;
        background: lightblue;
        line-height: 1.5rem;
        padding: 3px;
        font-weight: 500;
        white-space: nowrap;
        border-radius: 5px;
    }

    .active-mobile {
        background-color: #007bff !important;
        color: white !important;
    }

    .submenu-indicator-chevron {
        display: none;
    }

    .nav-submenu {
        display: none;
        list-style: none;
        padding-left: 0;
        position: absolute;
        background-color: white;
        border: 1px solid #ccc;
        z-index: 1000;
        margin-top: 5px;
        min-width: 200px;
    }

    .has-submenu {
        position: relative;
    }

    .has-submenu.open>.nav-submenu {
        display: block;
    }

    .toggle-submenu {
        cursor: pointer;
        display: inline-block;
        padding: 8px 12px;
        color: #333;
        text-decoration: none;
    }

    .toggle-submenu:hover {
        color: #007bff;
    }

    .submenu-indicator {
        margin-left: 6px;
        font-size: 12px;
    }

    .mobile .nav-dropdown.nav-submenu {
        left: 0%;
    }
</style>
<div class="header header-light head-shadow py-2 position-md-sticky top-0" style="z-index: 1000;">
    <div class="container-fluid px-xl-5 px-0">
        <nav id="navigation" class="navigation navigation-landscape ">
            <div class="nav-header">
                <a class="nav-brand text-logo me-0" href="/">
                    @if (App::getLocale() === 'vi')
                        <img src="{{ $settings['logo'] }}" width="80px" alt="">
                    @else
                        <img src="{{ $settings['logo_en'] }}" width="80px" alt="">
                    @endif
                    <span class="d-md-none d-block btn-home-mobile fw-semibold">{{ __('common.home') }}</span>
                </a>
                <div class="mobile_nav m-0">
                    <ul>
                        <li class="mobile-profile-dropdown position-relative d-flex flex-column text-center ms-0">
                            @guest
                                <a href="{{ route('showLogin') }}" class="text-muted text-nowrap">
                                    <span
                                        class="d-md-none d-block btn-home-mobile fw-semibold bg-warning text-white fw-bold">{{ __('common.login') }}</span>
                                </a>
                                <a href="{{ route('showRegister') }}" class="text-muted text-nowrap mt-2">
                                    <span
                                        class="d-md-none d-block btn-home-mobile fw-semibold bg-danger text-white fw-bold">{{ __('common.register') }}</span>
                                </a>
                            @else
                                <a href="javascript:void(0);" class="text-muted avatar-toggle">
                                    <span class="svg-icon svg-icon-2hx">
                                        <img class="rounded-circle" src="{{ Auth::user()->avatar }}" width="30"
                                            height="30" alt="">
                                    </span>
                                </a>
                                <ul class="nav-dropdown nav-submenu mobile-profile-menu bg-white position-absolute flex-column border rounded-3 align-items-start"
                                    style="top: 3rem; left: -9rem;">
                                    @if (Auth::check() && Auth::user()->role !== 'user')
                                        <li><a class="ps-2" href="/admin">{{ __('common.admin') }}</a></li>
                                        <li class="position-relative">
                                            <a class="ps-1" href="{{ route('baidangnhanh.list') }}">Danh sách đăng tin
                                                nhanh</a>
                                            <span class="bg-danger px-2 py-1 position-absolute rounded-3 text-white top-50 "
                                                style="transform: translateY(-50%); right:25px">{{ $count_tinnhanh_unread }}</span>
                                        </li>
                                    @endif
                                    <li><a class="ps-2" href="/profile">{{ __('common.profile') }}</a></li>
                                    <li><a class="ps-2" href="/profile/list-baidang">{{ __('common.posts') }}</a></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post" class="logout">
                                            @csrf
                                            <button type="submit"
                                                class="dropdown-item ps-2">{{ __('common.logout') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            @endguest
                        </li>
                        <li class="p-2 ms-0">
                            <form>
                                <select class="form-select form-select-sm fw-bold"
                                    onchange="window.location.href='{{ url('lang') }}/' + this.value">
                                    <option value="vi" {{ app()->getLocale() === 'vi' ? 'selected' : '' }}>VIE
                                    </option>
                                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>ENG
                                    </option>
                                </select>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="nav-menus-wrapper nav-menu-pc d-flex align-items-center justify-content-between"
                style="transition-property: none;">
                <ul class="nav-menu text-uppercase">
                    <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="/">{{ __('common.home') }}</a>
                    </li>

                    <li class="{{ request('mohinh') ? 'active' : '' }}">
                        <a href="JavaScript:Void(0);">{{ __('common.model') }}<span
                                class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li class="{{ request('mohinh') == 'ban' ? 'active' : '' }}">
                                <a
                                    href="{{ route('posts.list', ['mohinh' => 'ban']) }}">{{ __('common.model.sale') }}</a>
                            </li>
                            <li class="{{ request('mohinh') == 'thue' ? 'active' : '' }}">
                                <a
                                    href="{{ route('posts.list', ['mohinh' => 'thue']) }}">{{ __('common.model.rent') }}</a>
                            </li>
                            <li class="{{ request('mohinh') == 'chuyennhuong' ? 'active' : '' }}">
                                <a
                                    href="{{ route('posts.list', ['mohinh' => 'chuyennhuong']) }}">{{ __('common.model.transfer') }}</a>
                            </li>
                            <li class="{{ request('mohinh') == 'oghep' ? 'active' : '' }}">
                                <a
                                    href="{{ route('posts.list', ['mohinh' => 'oghep']) }}">{{ __('common.model.roommate') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ request('country') ? 'active' : '' }}">
                        <a href="JavaScript:Void(0);">{{ __('common.country') }}<span
                                class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li class="{{ request('country') == 'Vietnam' ? 'active' : '' }}">
                                <a
                                    href="{{ route('posts.list', ['country' => 'Vietnam']) }}">{{ __('common.country.vietnam') }}</a>
                            </li>
                            <li class="{{ request('country') == 'Philippines' ? 'active' : '' }}">
                                <a href="{{ route('posts.list', ['country' => 'Philippines']) }}">Philippines</a>
                            </li>
                            <li class="{{ request('country') == 'Thailand' ? 'active' : '' }}">
                                <a
                                    href="{{ route('posts.list', ['country' => 'Thailand']) }}">{{ __('common.country.thailand') }}</a>
                            </li>
                            <li class="{{ request('country') == 'Campuchia' ? 'active' : '' }}">
                                <a href="{{ route('posts.list', ['country' => 'Campuchia']) }}">Campuchia</a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ request()->routeIs('listByNhadat') ? 'active' : '' }}">
                        <a href="JavaScript:Void(0);">{{ __('common.property_type') }}<span
                                class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu" style="right: auto; display: none;">
                            <li class="">
                                <a href="/posts/baidang/loai/can-ho-chung-cu">
                                    {{ __('common.property_type.office') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="/posts/baidang/loai/nha-dan">
                                    {{ __('common.property_type.private_house') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="/posts/baidang/loai/phong-tro">
                                    {{ __('common.property_type.rental_room') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="/posts/baidang/loai/biet-thu">
                                    {{ __('common.property_type.villa') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="/posts/baidang/loai/khach-san">
                                    {{ __('common.property_type.hotel') }}
                                </a>
                            </li>
                            <li class="">
                                <a href="/posts/baidang/loai/mat-bang-kinh-doanh">
                                    {{ __('common.property_type.business') }}
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="{{ request()->routeIs('project') ? 'active' : '' }}">
                        <a href="/">{{ __('common.project') }}</a>
                    </li>

                    <li class="{{ request()->routeIs('service') ? 'active' : '' }}">
                        <a href="/">{{ __('common.service') }}</a>
                    </li>
                </ul>

                <ul class="nav-menu nav-menu-social align-to-right d-flex align-items-center">
                    @guest
                        <li class=" p-3 bg-warning rounded-3 {{ request()->routeIs('showLogin') ? 'active' : '' }}">
                            <a href="{{ route('showLogin') }}" class="fw-medium text-nowrap text-white p-0"
                                style="color:white !important">{{ __('common.login') }}</a>
                        </li>
                        <li class=" p-3 bg-danger rounded-3 mx-3 {{ request()->routeIs('showLogin') ? 'active' : '' }}">
                            <a href="{{ route('showRegister') }}" class="fw-medium text-nowrap text-white p-0"
                                style="color:white !important">{{ __('common.register') }}</a>
                        </li>
                    @else
                        <li class="dropdown {{ request()->routeIs('profile') ? 'active' : '' }}">
                            <a href="JavaScript:Void(0);" class="fw-medium text-muted-2">
                                @if (Auth::user()->avatar)
                                    <img class="rounded-circle" width="22" height="22"
                                        src="{{ Auth::user()->avatar }}">
                                @else
                                    <svg width="22" height="22" viewBox="0 0 18 18" fill="none">
                                        <rect x="7" y="6" width="4" height="4" rx="2"
                                            fill="currentColor" />
                                    </svg>
                                @endif
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="nav-dropdown nav-submenu py-0">

                                <li>
                                    <a href="/profile">{{ __('common.profile') }}</a>
                                </li>
                                <li><a class="ps-2" href="/profile/list-baidang">{{ __('common.posts') }}</a></li>

                                @if ((Auth::check() && Auth::user()->role == 'admin') || Auth::user()->role == 'nhanvien')
                                    <li>
                                        <a href="/admin">{{ __('common.admin') }}</a>
                                    </li>
                                    <li class="position-relative">
                                        <a class="me-3"
                                            href="{{ route('baidangnhanh.list') }}">{{ __('common.quick_post_list') }}</a>
                                        <span
                                            class="bg-danger px-2 py-1 position-absolute rounded-3 text-white top-50 end-0"
                                            style="transform: translateY(-50%)">{{ $count_tinnhanh_unread }}</span>
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="post" class="logout">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item ps-2">{{ __('common.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                    <li class="pe-3 ps-0">
                        <form>
                            {{-- <label for="lang-select" class="form-label fw-semibold mb-2">
                                🌐 {{ __('common.language') }}
                            </label> --}}
                            <select class="form-select form-select-sm fw-bold" style="min-width:70px"
                                onchange="window.location.href='{{ url('lang') }}/' + this.value">
                                <option value="vi" {{ app()->getLocale() === 'vi' ? 'selected' : '' }}>VIE</option>
                                <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>ENG</option>
                            </select>
                        </form>
                    </li>
                    @guest
                    @else
                        @if ($show_post ?? true)
                            <!-- Kiểm tra biến -->
                            <li class="dropdown p-3 bg-primary text-white rounded-3 dropdown_post">
                                {{-- <span class="svg-icon svg-icon-muted svg-icon-2hx me-1">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" width="12" height="2" rx="1"
                                            transform="matrix(-1 0 0 1 15.5 11)" fill="currentColor"></rect>
                                        <path
                                            d="M13.6313 11.6927L11.8756 10.2297C11.4054 9.83785 11.3732 9.12683 11.806 8.69401C12.1957 8.3043 12.8216 8.28591 13.2336 8.65206L16.1592 11.2526C16.6067 11.6504 16.6067 12.3496 16.1592 12.7474L13.2336 15.3479C12.8216 15.7141 12.1957 15.6957 11.806 15.306C11.3732 14.8732 11.4054 14.1621 11.8756 13.7703L13.6313 12.3073C13.8232 12.1474 13.8232 11.8526 13.6313 11.6927Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M8 5V6C8 6.55228 8.44772 7 9 7C9.55228 7 10 6.55228 10 6C10 5.44772 10.4477 5 11 5H18C18.5523 5 19 5.44772 19 6V18C19 18.5523 18.5523 19 18 19H11C10.4477 19 10 18.5523 10 18C10 17.4477 9.55228 17 9 17C8.44772 17 8 17.4477 8 18V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3H10C8.89543 3 8 3.89543 8 5Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </span> --}}
                                {{ __('common.post') }}
                                <ul class="nav-dropdown nav-submenu py-0 nav-dropdown_post">
                                    <li>
                                        <a href="{{ route('postPage') }}">{{ __('common.post_full') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('baidangnhanh.index') }}">{{ __('common.quick_post') }}</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    @endguest
                </ul>
            </div>

        </nav>
    </div>
</div>
@php
    $query = request()->query();

    $currentCountry = $query['country'] ?? null;
    $currentMohinh = $query['mohinh'] ?? null;
@endphp

<div class="position-sticky top-0 z-3 bg-white shadow-sm">
    <div class="container d-lg-none d-block border-2 p-2 border-top">

    <ul class="d-flex justify-content-center nav-menu mobile flex-wrap">
        <li class="has-submenu rounded-5 border mt-2  h-fit {{ request('mohinh') ? 'active' : '' }}">
            <a href="JavaScript:void(0);"
                class="toggle-submenu p-2 text-nowrap">{{ __('common.model') }} </a>
            <ul class="nav-dropdown nav-submenu bg-white border">
                <li class="{{ request('mohinh') == 'ban' ? 'active' : '' }}">
                    <a href="{{ route('posts.list', ['mohinh' => 'ban']) }}">{{ __('common.model.sale') }}</a>
                </li>
                <li class="{{ request('mohinh') == 'thue' ? 'active' : '' }}">
                    <a href="{{ route('posts.list', ['mohinh' => 'thue']) }}">{{ __('common.model.rent') }}</a>
                </li>
                <li class="{{ request('mohinh') == 'chuyennhuong' ? 'active' : '' }}">
                    <a
                        href="{{ route('posts.list', ['mohinh' => 'chuyennhuong']) }}">{{ __('common.model.transfer') }}</a>
                </li>
                <li class="{{ request('mohinh') == 'oghep' ? 'active' : '' }}">
                    <a href="{{ route('posts.list', ['mohinh' => 'oghep']) }}">{{ __('common.model.roommate') }}</a>
                </li>
            </ul>
        </li>

        <li class="has-submenu rounded-5 border mt-2  h-fit mx-2 {{ request('country') ? 'active' : '' }}">
            <a href="JavaScript:void(0);"
                class="toggle-submenu p-2 text-nowrap">{{ __('common.country') }} </a>
            <ul class="nav-dropdown nav-submenu bg-white border">
                <li class="{{ request('country') == 'Vietnam' ? 'active' : '' }}">
                    <a
                        href="{{ route('posts.list', ['country' => 'Vietnam']) }}">{{ __('common.country.vietnam') }}</a>
                </li>
                <li class="{{ request('country') == 'Philippines' ? 'active' : '' }}">
                    <a href="{{ route('posts.list', ['country' => 'Philippines']) }}">Philippines</a>
                </li>
                <li class="{{ request('country') == 'Thailand' ? 'active' : '' }}">
                    <a
                        href="{{ route('posts.list', ['country' => 'Thailand']) }}">{{ __('common.country.thailand') }}</a>
                </li>
                <li class="{{ request('country') == 'Campuchia' ? 'active' : '' }}">
                    <a href="{{ route('posts.list', ['country' => 'Campuchia']) }}">Campuchia</a>
                </li>
            </ul>
        </li>

        <li class="has-submenu rounded-5 border mt-2  h-fit me-2 {{ request()->routeIs('listByNhadat') ? 'active' : '' }}">
            <a href="JavaScript:void(0);"
                class="toggle-submenu p-2 text-nowrap">{{ __('common.property_type') }}</a>
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

            <ul class="nav-dropdown nav-submenu bg-white border">
                @foreach ($loainhadats as $loainhadat)
                    @php
                        $key = $propertyTypeMap[$loainhadat->slug] ?? null;
                    @endphp
                    <li class="{{ request('slug') == $loainhadat->slug ? 'active' : '' }}">
                        <a href="{{ route('listByNhadat', ['slug' => $loainhadat->slug]) }}">
                            {{ $key ? __('common.property_type.' . $key) : $loainhadat->title }}
                        </a>
                    </li>
                @endforeach
            </ul>

        </li>
        <li class="has-submenu rounded-5 border mt-2  h-fit me-2 {{ request('mohinh') ? 'active' : '' }}">
            <a href="JavaScript:void(0);"
                class="toggle-submenu p-2 text-nowrap">{{ __('common.project') }} </a>
        </li>
        <li class="has-submenu rounded-5 border mt-2  h-fit {{ request('mohinh') ? 'active' : '' }}">
            <a href="JavaScript:void(0);"
                class="toggle-submenu p-2 text-nowrap">{{ __('common.service') }} </a>
        </li>
    </ul>
</div>
</div>

<!-- End Navigation -->
<div class="clearfix"></div>
<script>
    function openFilterSearch() {
        document.getElementById("filter_search").style.display = "block";
    }

    function closeFilterSearch() {
        document.getElementById("filter_search").style.display = "none";
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.toggle-submenu');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const parentLi = this.closest('.has-submenu');
                parentLi.classList.toggle('open');

                // Optional: close others
                document.querySelectorAll('.has-submenu').forEach(li => {
                    if (li !== parentLi) {
                        li.classList.remove('open');
                    }
                });
            });
        });

        // Optional: Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.has-submenu')) {
                document.querySelectorAll('.has-submenu').forEach(li => li.classList.remove('open'));
            }
        });
    });
</script>
