@extends('admin.main')

@section('contents')

<div class="container-fluid flex-grow-1 container-p-y">
    <h3 class="fw-bold text-primary py-3 mb-4">{{ $title }}</h3>

    <!-- Form tìm kiếm -->
    <form class="form-search" method="GET" action="{{ route('addresses.index') }}">
        @csrf
        <div class="row mb-4">
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <select class="form-control shadow-none" name="search_country">
                    <option value="">Chọn quốc gia</option>
                    <option value="Philippines" {{ request()->search_country == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                    <option value="Thailand" {{ request()->search_country == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                    <option value="Campuchia" {{ request()->search_country == 'Campuchia' ? 'selected' : '' }}>Campuchia</option>
                </select>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <input class="form-control shadow-none" 
                       type="text" 
                       name="search_province" 
                       placeholder="Tìm theo tỉnh/ thành phố" 
                       value="{{ request()->search_province }}">
            </div>
            
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <input class="form-control shadow-none" 
                       type="text" 
                       name="search_district" 
                       placeholder="Tìm theo quận/ huyện" 
                       value="{{ request()->search_district }}">
            </div>
            
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <input class="form-control shadow-none" 
                       type="text" 
                       name="search_ward" 
                       placeholder="Tìm theo phường/ xã" 
                       value="{{ request()->search_ward }}">
            </div>
            
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <div class="text-center text-nowrap">
                    <button type="submit" class="btn btn-danger rounded-pill">
                        <i class="fas fa-search me-2"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('addresses.index') }}" class="btn btn-secondary rounded-pill ms-2">
                        <i class="fas fa-times me-2"></i>Xóa lọc
                    </a>
                </div>
            </div>
        </div>
    </form>

    <!-- Danh sách địa chỉ -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID Địa chỉ</th>
                        <th>Tỉnh/ Thành phố</th>
                        <th>Quận/ Huyện</th>
                        <th>Phường/ Xã</th>
                        <th>Địa chỉ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addresses as $address)
                    <tr data-id="{{ $address->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $address->ward->district->province->country }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span id="province-name-{{ $address->id }}">{{ $address->ward->district->province->name }}</span>
                                <div>
                                    <button class="btn btn-sm btn-edit btn-warning text-dark fw-bold ms-2" data-id="{{ $address->id }}" data-type="province">Sửa</button>
                                    <input type="text" id="province-input-{{ $address->id }}" class="form-control d-none" value="{{ $address->ward->district->province->name }}">
                                    <input type="text" id="province-input-id-{{ $address->id }}" class="form-id" hidden value="{{ $address->ward->district->province->id }}">
                                    <button class="btn btn-sm btn-save btn-success mt-2 text-dark d-none" data-id="{{ $address->id }}" data-type="province">Lưu</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span id="district-name-{{ $address->id }}">{{ $address->ward->district->name }}</span>
                                <div>
                                    <button class="btn btn-sm btn-edit btn-warning text-dark fw-bold ms-2" data-id="{{ $address->id }}" data-type="district">Sửa</button>
                                    <input type="text" id="district-input-{{ $address->id }}" class="form-control d-none" value="{{ $address->ward->district->name }}">
                                    <input type="text" id="district-input-id-{{ $address->id }}" class="form-id" hidden value="{{ $address->ward->district->id }}">
                                    <button class="btn btn-sm btn-save btn-success mt-2 text-dark d-none" data-id="{{ $address->id }}" data-type="district">Lưu</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span id="ward-name-{{ $address->id }}">{{ $address->ward->name }}</span>
                                <div>
                                    <button class="btn btn-sm btn-edit btn-warning text-dark fw-bold ms-2" data-id="{{ $address->id }}" data-type="ward">Sửa</button>
                                    <input type="text" id="ward-input-{{ $address->id }}" class="form-control d-none" value="{{ $address->ward->name }}">
                                    <input type="text" id="ward-input-id-{{ $address->id }}" class="form-id" hidden value="{{ $address->ward->id }}">
                                    <button class="btn btn-sm btn-save btn-success mt-2 text-dark d-none" data-id="{{ $address->id }}" data-type="ward">Lưu</button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span id="street-name-{{ $address->id }}">{{ $address->street }}</span>
                                <div>
                                    <button class="btn btn-sm btn-edit btn-warning text-dark fw-bold ms-2" data-id="{{ $address->id }}" data-type="street">Sửa</button>
                                    <input type="text" id="street-input-{{ $address->id }}" class="form-control d-none" value="{{ $address->street }}">
                                    <input type="text" id="street-input-id-{{ $address->id }}" class="form-id" hidden value="{{ $address->id }}">
                                    <button class="btn btn-sm btn-save btn-success mt-2 text-dark d-none" data-id="{{ $address->id }}" data-type="street">Lưu</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="pagination mt-4 pb-4">
                {{ $addresses->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Lấy tất cả các nút "Sửa" trong bảng
    const editButtons = document.querySelectorAll('.btn-edit');

editButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Lấy ID của hàng hiện tại
        const addressId = this.getAttribute('data-id');
        const type = this.getAttribute('data-type');  // Loại cột (province, district, ward, street)

        // Lấy phần tử liên quan đến tên và input của trường cần chỉnh sửa
        const nameSpan = document.getElementById(`${type}-name-${addressId}`);
        const inputField = document.getElementById(`${type}-input-${addressId}`);
        const saveButton = document.querySelector(`.btn-save[data-id="${addressId}"][data-type="${type}"]`);
        const editButton = this;  // Lấy chính nút "Sửa" mà bạn click vào

        // Ẩn nút "Sửa"
        editButton.classList.add('d-none');

        // Hiển thị input và nút Lưu
        nameSpan.classList.add('d-none');
        inputField.classList.remove('d-none');
        saveButton.classList.remove('d-none');
    });
});

    // Xử lý sự kiện khi bấm nút "Lưu"
    const saveButtons = document.querySelectorAll('.btn-save');
    
    saveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const addressId = this.getAttribute('data-id');
            const type = this.getAttribute('data-type');
            const inputField = document.getElementById(`${type}-input-${addressId}`);
            const nameSpan = document.getElementById(`${type}-name-${addressId}`);
            
            // Lấy giá trị nhập vào
            const newValue = inputField.value;

            // Lấy ID từ input hidden
            let id = null;
            if (type === 'province') {
                id = document.getElementById(`province-input-id-${addressId}`).value; // Lấy province_id
            } else if (type === 'district') {
                id = document.getElementById(`district-input-id-${addressId}`).value; // Lấy district_id
            } else if (type === 'ward') {
                id = document.getElementById(`ward-input-id-${addressId}`).value; // Lấy ward_id
            } else if (type === 'street') {
                id = document.getElementById(`street-input-id-${addressId}`).value; // Lấy address_id (street)
            }

            // Gửi giá trị mới và ID tới backend để cập nhật
            fetch(`/admin/addresses/update/${type}/${id}`, {
                method: 'POST',
                body: JSON.stringify({
                    id: id,
                    type: type,
                    value: newValue,
                    [`${type}_id`]: id,  // Dùng dynamic key để gửi ID tương ứng
                }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Nếu cần CSRF token
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // alert(data.message); // Hiển thị thông báo thành công
                    // window.location.reload();
                } else {
                    alert('Cập nhật thất bại'); // Thông báo lỗi nếu có
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra');
            });

            // Cập nhật giá trị và ẩn input, hiển thị lại span
            nameSpan.textContent = newValue;
            nameSpan.classList.remove('d-none');
            inputField.classList.add('d-none');
            this.classList.add('d-none'); // Ẩn nút Lưu
            editButton.classList.remove('d-none');  // Hiển thị lại nút "Sửa"
        });
    });
});

</script>
