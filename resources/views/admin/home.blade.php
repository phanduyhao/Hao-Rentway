@extends('admin.main')

@section('contents')
<style>
    .card-body{
        height: 500px;
        overflow: auto;
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid py-4">
        <h2 class="text-center mb-4">Thống kê bài đăng</h2>

        <!-- Form lọc theo ngày -->
        {{-- <form method="GET" action="{{ route('homeAdmin') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="from_date">Từ ngày:</label>
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-4">
                    <label for="to_date">Đến ngày:</label>
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </div>
        </form> --}}

        <!-- Thống kê tổng số bài đăng -->
        <div class="card mb-4">
            <div class="card-header text-white">
                <h4 class="mb-0">Tổng số bài đăng của mỗi user</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered text-center table-hover">
                        <thead class="">
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Số bài đăng</th>
                                <th>Xếp loại tài khoản</th>
                            </tr>
                        </thead>
                        @php
                            $roleMappings = [
                                'user' => 'Khách',
                                'admin' => 'Người quản trị',
                                'chunha' => 'Chủ nhà',
                                'moigioi' => 'Môi giới',
                                'nhanvien' => 'Nhân viên',
                            ];
                        @endphp
                        <tbody>
                            @foreach ($thongkes as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $roleMappings[$user->role] ?? 'Không xác định' }}</td>
                                <td class="text-center">
                                    <a href="/admin/posts?search_user={{ $user->name }}"> 
                                        {{ $user->baidangs_count }}</td>
                                    </a>
                                <td class="text-center">
                                    <div class="rounded-3 text-white p-2" style="background: #000000b0">
                                        @php
                                            $stars = 1; // Mặc định là 1 sao
                                            if ($user->baidangs_count >= 50) {
                                                $stars = 5;
                                            } elseif ($user->baidangs_count > 19) {
                                                $stars = 4;
                                            } elseif ($user->baidangs_count > 9) {
                                                $stars = 3;
                                            } elseif ($user->baidangs_count > 4) {
                                                $stars = 2;
                                            }
                                        @endphp
                                        
                                        @for($i = 1; $i <= $stars; $i++)
                                            <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        @endfor
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Thống kê bài đăng theo tháng -->
        <div class="card mb-4">
            <div class="card-header text-white">
                <h4 class="mb-0">Bài đăng trong tháng này</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                <table class="table table-bordered text-center table-hover">
                    <thead class="">
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Bài đăng trong tháng</th>
                        </tr>
                    </thead>
                    @php
                        $roleMappings = [
                            'user' => 'Khách',
                            'admin' => 'Người quản trị',
                            'chunha' => 'Chủ nhà',
                            'moigioi' => 'Môi giới',
                            'nhanvien' => 'Nhân viên',
                        ];
                    @endphp
                    <tbody>
                        @foreach ($thongkeotheothang as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $roleMappings[$user->role] ?? 'Không xác định' }}</td>
                            <td class="text-center">
                                <a href="/admin/posts?search_user={{ $user->name }}"> 
                                    {{ $user->baidangs_count }}
                                </a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <!-- Thống kê bài đăng hôm nay -->
        <div class="card mb-4">
            <div class="card-header text-dark">
                <h4 class="mb-0">Bài đăng theo tuần</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                <table class="table table-bordered text-center table-hover">
                    <thead class="">
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Bài đăng trong tuần</th>
                        </tr>
                    </thead>
                    @php
                        $roleMappings = [
                            'user' => 'Khách',
                            'admin' => 'Người quản trị',
                            'chunha' => 'Chủ nhà',
                            'moigioi' => 'Môi giới',
                            'nhanvien' => 'Nhân viên',
                        ];
                    @endphp
                    <tbody>
                        @foreach ($thongkesoWeek as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $roleMappings[$user->role] ?? 'Không xác định' }}</td>
                            <td class="text-center">
                                <a href="/admin/posts?search_user={{ $user->name }}"> 
                                    {{ $user->baidangs_count }}
                                </a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <!-- Thống kê bài đăng hôm nay -->
        <div class="card mb-4">
            <div class="card-header text-dark">
                <h4 class="mb-0">Bài đăng hôm nay</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                <table class="table table-bordered text-center table-hover">
                    <thead class="">
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Bài đăng hôm nay</th>
                        </tr>
                    </thead>
                    @php
                        $roleMappings = [
                            'user' => 'Khách',
                            'admin' => 'Người quản trị',
                            'chunha' => 'Chủ nhà',
                            'moigioi' => 'Môi giới',
                            'nhanvien' => 'Nhân viên',
                        ];
                    @endphp
                    <tbody>
                        @foreach ($thongketheongay as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $roleMappings[$user->role] ?? 'Không xác định' }}</td>
                            <td class="text-center">
                                <a href="/admin/posts?search_user={{ $user->name }}"> 
                                    {{ $user->baidangs_count }}

                                </a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
