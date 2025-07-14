<aside
    id='layout-menu'
    class='layout-menu menu-vertical menu bg-menu-theme'
    data-bg-class='bg-menu-theme'
>
    <div class='app-brand demo'>
        <a href='/admin' class='app-brand-link'>
            <img src='{{$settings['logo']}}' width='200' alt='' />
        </a>

        <a
            href='javascript:void(0);'
            class='layout-menu-toggle menu-link text-large ms-auto d-xl-none'
        >
            <i class='bx bx-chevron-left bx-sm align-middle'></i>
        </a>
    </div>

    <div class='menu-inner-shadow'></div>

    <ul class='menu-inner py-1 ps ps--active-y'>
        <!-- Dashboard -->
        <li class='menu-item active'>
            <a href='/admin' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-home-circle'></i>
                <div data-i18n='Analytics'>Trang quản trị</div>
            </a>
        </li>

        @if(Auth::user()->role == 'admin')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Người dùng</span>
        </li>
        <li class='menu-item'>
            <a href='javascript:void(0);' class='menu-link menu-toggle'>
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n='Layouts'>Quản lý tài khoản</div>
            </a>
            <ul class='menu-sub'>
                <li class='menu-item'>
                    <a href='{{route('adminUser')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Tài khoản quản trị</div>
                    </a>
                </li>
                <li class='menu-item'>
                    <a href='{{route('user')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Tài khoản người dùng</div>
                    </a>
                </li>
            </ul>
        </li>
        @endif
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Công việc</span>
        </li>
        <li class='menu-item'>
            <a href='{{route('thietbi.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-category-alt'></i>
                <div data-i18n='Layouts'>Quản lý thiết bị/ dịch vụ</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('loainhadat.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-category-alt'></i>
                <div data-i18n='Layouts'>Quản lý loại nhà đất</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='javascript:void(0);' class='menu-link menu-toggle'>
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n='Layouts'>Quản lý Bài Đăng</div>
                <span class="badge bg-danger">{{$count_baidang}}</span>
            </a>
            <ul class='menu-sub'>
                <li class='menu-item'>
                    <a href='{{route('baidangDaduyet')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Bài Đăng đã duyệt</div>
                    </a>
                </li>
                <li class='menu-item'>
                    <a href='{{route('baidangChoduyet')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Bài Đăng đang chờ duyệt</div>
                        <span class="badge bg-danger ms-3">{{$count_baidang}}</span>
                    </a>
                </li>
                <li class='menu-item'>
                    <a href='{{route('baidangDahuy')}}' class='menu-link'>
                        <div data-i18n='Without menu'>Bài Đăng đã hủy</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class='menu-item'>
            <a href='{{route('addresses.index')}}' class='menu-link'>
                <i class='menu-icon tf-icons bx bx-category-alt'></i>
                <div data-i18n='Layouts'>Quản lý địa chỉ</div>
            </a>
        </li>
        <li class='menu-item'>
            <a href='{{route('settings.index')}}' class='menu-link'>
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n='Layouts'>Thiết lập</div>
            </a>
        </li>
    </ul>
</aside>
