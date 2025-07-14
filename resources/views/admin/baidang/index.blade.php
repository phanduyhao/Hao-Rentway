@extends('admin.main')
@section('contents')
<style>
    .modal-dialog{
        max-width: 992px;
    }
    .modal-dialog .p{
        text-wrap: auto;
    }
</style>
    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{ $title }}</h3>
        <div>
            <form class="form-search" method="GET" action="">
                @csrf
                <div class="d-flex align-items-center mb-4">
                    <h4 class="ten-game me-3 mb-0">Tìm kiếm</h4>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <!-- Tìm kiếm theo tên người đăng -->
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_user"
                                placeholder="Tìm theo tên người đăng" value="{{ request()->search_user }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_mabaidang"
                                placeholder="Tìm theo mã bài đăng" value="{{ request()->search_mabaidang }}">
                        </div>
                        <!-- Tìm kiếm theo tên công ty -->
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_title"
                                placeholder="Tìm theo tiêu đề bài đăng" value="{{ request()->search_title }}">
                        </div>

                        <!-- Tìm kiếm theo tiêu đề công việc -->
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <select class="form-control shadow-none" name="search_mohinh">
                                <option value="">Chọn mô hình</option>
                                <option value="thue" {{ request()->search_mohinh == 'thue' ? 'selected' : '' }}>Cho thuê</option>
                                <option value="ban" {{ request()->search_mohinh == 'ban' ? 'selected' : '' }}>Bán</option>
                                <option value="chuyennhuong" {{ request()->search_mohinh == 'chuyennhuong' ? 'selected' : '' }}>Chuyển nhượng</option>
                                <option value="oghep" {{ request()->search_mohinh == 'oghep' ? 'selected' : '' }}>Ở ghép</option>
                            </select>
                        </div>

                        <!-- Tìm kiếm theo vị trí -->
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_loainhadat"
                                placeholder="Tìm theo loại nhà đất" value="{{ request()->search_loainhadat }}">
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <select class="form-control shadow-none" name="search_mohinh">
                                <option value="">Chọn trạng thái</option>
                                <option value="cosan" {{ request()->search_mohinh == 'cosan' ? 'selected' : '' }}>Có sẵn</option>
                                <option value="dathue" {{ request()->search_mohinh == 'dathue' ? 'selected' : '' }}>Đã thuê</option>
                                <option value="hethan" {{ request()->search_mohinh == 'hethan' ? 'selected' : '' }}>Hết hạn</option>
                            </select>
                        </div>

                        <!-- Nút tìm kiếm và xóa lọc -->
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="text-center text-nowrap">
                                <button type="submit" class="btn btn-danger rounded-pill">
                                    <i class="fas fa-search me-2"></i>Tìm kiếm
                                </button>
                                <a href="{{ route('baidangDaduyet') }}" class="btn btn-secondary rounded-pill ms-2">
                                    <i class="fas fa-times me-2"></i>Xóa lọc
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
                            <th>Mã bài đăng</th>
                            <th>Người đăng</th>
                            <th>Loại liên hệ</th>
                            <th>Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Giá </th>
                            <th>Diện tích</th>
                            <th>Mô hình</th>
                            <th>Loại nhà đất</th>
                            <th>Bài Vip</th>
                            <th>Duyệt</th>
                            <th>Trạng thái</th>
                            <th>Hoa Hồng</th>
                            <th>Ngày đăng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if($BaiDangs->isEmpty())
                            <tr>
                                <td colspan="11" class="text-center">Không tìm thấy công việc nào phù hợp với từ khóa tìm kiếm.</td>
                            </tr>
                        @else
                            @foreach ($BaiDangs as $baidang)
                                <tr data-id="{{ $baidang->id }}">
                                    <td>{{ $baidang->mabaidang }}</td>
                                    <td>{{ $baidang->User->name }}</td>
                                    @php
                                        $roleMappings = [
                                            'user' => 'Khách',
                                            'admin' => 'Người quản trị',
                                            'chunha' => 'Chủ nhà',
                                            'moigioi' => 'Môi giới',
                                            'nhanvien' => 'Nhân viên',
                                        ];
                                    @endphp
                                    <td>{{ $roleMappings[$baidang->User->role] ?? 'Không xác định' }}</td>
                                    <td>
                                        <img src="{{ $baidang->thumb}}" alt="{{ $baidang->title }}"
                                        width="90px" height="90px">
                                    </td>
                                    <td class="title-baidang">
                                        <a href="{{ route('baidangDetail', $baidang->slug) }}">
                                            {{ $baidang->title }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($baidang->price , 0, ',', '.') }} đ</td>
                                    <td>{{ $baidang->dientich }} M2</td>
                                    <td>
                                        @php
                                        $moHinhMap = [
                                            'thue' => 'Cho thuê',
                                            'ban' => 'Bán',
                                            'chuyennhuong' => 'Chuyển nhượng',
                                            'oghep' => 'Ở ghép'
                                        ];
                                    @endphp
                                    
                                    <span>{{ $moHinhMap[$baidang->mohinh] ?? 'Không xác định' }}</span>
                                    </td>
                                    <td>{{ $baidang->nhadat->title ?? "" }}</td>
                                    <td>
                                        <input type="checkbox" class="toggle-isVip" data-id="{{ $baidang->id }}"
                                               {{ $baidang->isVip ? 'checked' : '' }}>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Đã duyệt</span>
                                    </td>
                                    <td>
                                        <select class="form-control status-select" data-id="{{ $baidang->id }}">
                                            <option value="cosan" {{ $baidang->status == 'cosan' ? 'selected' : '' }}>Có sẵn</option>
                                            <option value="dathue" {{ $baidang->status == 'dathue' ? 'selected' : '' }}>Đã thuê</option>
                                            <option value="hethan" {{ $baidang->status == 'hethan' ? 'selected' : '' }}>Hết hạn</option>
                                        </select>                                    
                                    </td>
                                    <td>{{ optional($baidang->baidangchitiet)->hoahong ?? '' }} %</td>

                                    <td>{{ $baidang->created_at}}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('baidangDetail', $baidang->slug) }}" class="btn btn-info text-dark fw-bold" target="_blank">Chi tiết</a>
                                        <form class="mt-2" action="{{route('baidang.cancel', $baidang->id)}}" method="post">
                                            @csrf
                                            <button class="btn btn-warning">Hủy</button>
                                        </form>
                                        <form class="mt-2 " action="{{ route('baidang.destroy', $baidang->id) }}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                            @csrf
                                            @method('DELETE') 
                                            <button type="submit" class="btn btn-danger">Xóa</button>
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
    <script>
        $(document).ready(function() {
            $('.toggle-isVip').on('change', function (event) {
                event.stopPropagation();
                let baidangId = $(this).data('id');
                let isChecked = $(this).is(':checked');

                $.ajax({
                    url: `/posts/isVip/${baidangId}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: JSON.stringify({ isVip: isChecked }),
                    contentType: 'application/json',
                    success: function (response) {
                        toastr.success("✅ Đã bật chế độ Vip!");
                    },
                    error: function (xhr, status, error) {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra!');
                    },
                });
            });

            $(".status-select").on("change", function () {
                let baidangId = $(this).data("id"); // Lấy ID bài đăng
                let newStatus = $(this).val(); // Lấy giá trị trạng thái mới
                let selectElement = $(this); // Lưu lại phần tử để xử lý UI

                $.ajax({
                    url: "/posts/update-status", // Route xử lý cập nhật
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}", // Token CSRF
                        id: baidangId,
                        status: newStatus
                    },
                    beforeSend: function () {
                        selectElement.prop("disabled", true); // Vô hiệu hóa trong lúc gửi request
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success("✅ Cập nhật trạng thái thành công!");
                        } else {
                            alert("Có lỗi xảy ra, vui lòng thử lại!");
                        }
                    },
                    error: function () {
                        alert("Lỗi kết nối server!");
                    },
                    complete: function () {
                        selectElement.prop("disabled", false); // Bật lại select sau khi request hoàn tất
                    }
                });
            });

        });

    </script>
@endsection
