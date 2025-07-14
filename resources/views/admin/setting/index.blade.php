@extends('admin.main')

@section('contents')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">Cấu hình hệ thống</h3>

        <!-- Hiển thị thông báo thành công -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Hiển thị lỗi -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form cập nhật toàn bộ cấu hình -->
        <form action="{{route('updateSetting')}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12 mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="autoApproveSwitch" 
                               {{ isset($settings['tudongduyet']) && $settings['tudongduyet'] == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="autoApproveSwitch">Tự động duyệt bài</label>
                    </div>
                </div>
                
                <!-- Cấu hình Logo -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold"> Logo VIỆT NAM</div>
                        <div class="card-body text-center">
                            <input type="file" class="form-control mb-2" name="logo">
                            <img src="{{ $settings['logo'] }}" alt="Logo" class="img-fluid rounded" width="150">
                        </div>
                    </div>
                     <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold"> Logo ENGLISH</div>
                        <div class="card-body text-center">
                            <input type="file" class="form-control mb-2" name="logo_en">
                            <img src="{{ $settings['logo_en'] }}" alt="Logo_en" class="img-fluid rounded" width="150">
                        </div>
                    </div>
                </div>

                <!-- Cấu hình Banner Trang Chủ -->
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold">Cấu hình Banner Trang Chủ</div>
                        <div class="card-body text-center">
                            <input type="file" class="form-control mb-2" name="banner">
                            <img src="{{ $settings['banner'] }}" alt="Banner" class="img-fluid rounded" width="250">
                        </div>
                    </div>
                </div>

                <!-- Cấu hình Số điện thoại -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold">Cấu hình Số điện thoại</div>
                        <div class="card-body">
                            <input type="text" class="form-control" name="phone" value="{{ $settings['phone'] ?? '' }}" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                </div>

                <!-- Cấu hình Email -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold">Cấu hình Email</div>
                        <div class="card-body">
                            <input type="email" class="form-control" name="email" value="{{ $settings['email'] ?? '' }}" placeholder="Nhập email">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold">Cấu hình Facebook</div>
                        <div class="card-body">
                            <input type="text" class="form-control" name="link_fb" value="{{ $settings['link_fb'] ?? '' }}" placeholder="Nhập link facebook">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold">Cấu hình Telegram</div>
                        <div class="card-body">
                            <input type="text" class="form-control" name="link_telegram" value="{{ $settings['link_telegram'] ?? '' }}" placeholder="Nhập link Telegeram">
                        </div>
                    </div>
                </div>
                <!-- Cấu hình Email -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-bold">Cấu hình địa chỉ</div>
                        <div class="card-body">
                            <input type="email" class="form-control" name="address" value="{{ $settings['address'] ?? '' }}" placeholder="Nhập địa chỉ">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút Cập nhật -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary fw-bold px-4 py-2">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection
<script>
    $(document).ready(function () {
        $('#autoApproveSwitch').change(function () {
            let status = $(this).prop('checked') ? 1 : 0; // Lấy trạng thái (1 nếu bật, 0 nếu tắt)

            $.ajax({
                url: "admin/settings/update-toggle", // Route xử lý AJAX
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tudongduyet: status
                },
                success: function (response) {
                    alert(response.message); // Hiển thị thông báo thành công
                },
                error: function () {
                    alert("Có lỗi xảy ra!"); // Báo lỗi nếu AJAX thất bại
                }
            });
        });
    });
</script>