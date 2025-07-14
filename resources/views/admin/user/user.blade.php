@extends('admin.main')
@section('contents')

    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
        <div>
            <form class="form-search" method="GET" action="{{ route('user') }}">
                <div class="d-flex align-items-center mb-4">
                    <h4 class="ten-game me-3 mb-0">Tìm kiếm</h4>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="number" name="search_id" placeholder="Tìm theo mã số..." value="{{ request('search_id') }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_name" placeholder="Tìm theo tên..." value="{{ request('search_name') }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_email" placeholder="Tìm theo email..." value="{{ request('search_email') }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="text-nowrap">
                                <button type="submit" class="btn btn-danger rounded-pill"><i class="fas fa-search me-2"></i>Tìm kiếm</button>
                                <a href="{{ route('user') }}" class="btn btn-secondary rounded-pill ms-2"><i class="fas fa-times me-2"></i>Xóa lọc</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID Người dùng</th>
                        <th>Ảnh đại diện</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Quyền</th>
                        <th>Thời gian tạo</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                        <tr data-id="{{$user->id}}">
                            <td> {{ $loop->iteration }}</td>
                            <td>{{$user->id}}</td>
                            <td>
                                <img src="{{ $user->avatar}}" width="40" alt="">
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role == 'chunha' ? 'Chủ nhà' : ($user->role == 'user' ? 'Khách' : 'Môi giới')}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td class="">
                                <button type="button" data-url="{{route('destroyUser', ['id' => $user->id])}}" data-id="{{$user->id}}" class="btn btn-danger btnDeleteAsk px-2 me-2 py-1 fw-bolder" data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">Xóa</button>
                                <button type="button" data-id="{{$user->id}}" class="btn btn-edit btnEditUser btn-info text-dark px-2 py-1 fw-bolder">Sửa</button>
                            </td>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModal{{$user->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-white text-wrap" id="deleteModal{{$user->id}}Label">Bạn có chắc chắn xóa người dùng <b><u>{{$user->name}}</u></b>  không ?</h1>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="delete-forever btn btn-danger" data-id="{{ $user->id }}">Xóa</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <div class="modal fade ModelEditUser" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-white text-danger" id="createUserLabel"> </h1>
                            </div>
                            <div class="card-body">
                                <form method='post' action='' enctype="multipart/form-data" class="editUserForm form-edit" id="form_useremployee_update">
                                    @method('PATCH')
                                    @csrf
                                    <div class='mb-3'>
                                        <label
                                            class='form-label'
                                            for='basic-default-fullname'
                                        >Họ tên</label>
                                        <input
                                            type='text'
                                            class='form-control name input-field '
                                            id='name-edit'
                                            placeholder='Nhập họ tên'
                                            name='name' data-require='Mời nhập họ tên'
                                        />
                                    </div>
                                    <div class='mb-3'>
                                        <label
                                            class='form-label'
                                            for='basic-default-employee'
                                        >Email</label>
                                        <input
                                            type='email'
                                            class='form-control email input-field'
                                            id='email-edit'
                                            placeholder='Nhập Email'
                                            name='email' data-require='Mời nhập email'
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label class='form-label' for='basic-default-company' >Quyền</label>
                                        <select class="form-control shadow-none" name="role">
                                            <option value="">Chọn quyền</option>
                                            <option value="nhanvien" >Nhân viên</option>
                                            <option value="chunha" >Chủ nhà</option>
                                            <option value="moigioi" >Môi giới</option>
                                            <option value="user" >Khách</option>
                                        </select>
                                    </div>
                                    <input type="text" class="d-none" name="role_id" id="role-edit" value="3">

                                    <div class="modal-footer">
                                        <button type='submit' class='btn btn-success fw-semibold text-dark'>Cập nhật</button>
                                        <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pagination mt-4 pb-4">
                    {{ $users->links() }}
                </div>
               
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if ($('#createuser .alert-error').length > 0) {
                // Nếu có, hiển thị modal
                $('#createuser').modal('show');
            }
            $('.btnEditUser').on('click', function() {
                var userID = $(this).data('id'); // Lấy ID từ nút Sửa
                const ModelEdit = $('.ModelEditUser');
                const editUser = ModelEdit.attr('id', 'editUser'+userID);
                const IdEditUser = editUser.attr('id');

                $.ajax({
                    url: '/admin/users/' + userID, // URL API để lấy thông tin người dùng
                    type: 'GET',
                    success: function(response) {
                        // Cập nhật các trường dữ liệu trong modal
                        $('#'+IdEditUser + ' #name-edit').val(response.name);
                        $('#'+IdEditUser + ' .modal-title').text('Chỉnh sửa người dùng: ' + response.name);
                        $('#'+IdEditUser + ' #email-edit').val(response.email);
                        $('#'+IdEditUser + ' #password-edit').val("");

                        $('#form_useremployee_update').attr('action', '/admin/users/' + userID); // Cập nhật URL của form để sử dụng cho việc cập nhật
                        $(editUser).modal('show'); // Hiển thị modal
                    },
                    error: function() {
                        alert('Không thể lấy dữ liệu người dùng!');
                    }
                });
            });

        });
    </script>
@endsection

