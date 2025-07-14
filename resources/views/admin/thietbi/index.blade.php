@extends('admin.main')
@section('contents')

    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
        <div>
            <form class="form-search" method="GET" action="{{ route('thietbi.index') }}">
                @csrf
                <div class="d-flex align-items-center mb-4">
                    <h4 class="ten-game me-3 mb-0">Tìm kiếm</h4>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" 
                                   type="text" 
                                   id="searchInputNv" 
                                   name="search_id" 
                                   placeholder="Tìm theo mã số..." 
                                   value="{{ request()->search_id }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" 
                                   type="text" 
                                   id="searchInputVk" 
                                   name="search_name" 
                                   placeholder="Tìm theo tên thiết bị..." 
                                   value="{{ request()->search_name }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <div class="text-center text-nowrap">
                                <button type="submit" class="btn btn-danger rounded-pill">
                                    <i class="fas fa-search me-2"></i>Tìm kiếm
                                </button>
                                <a href="{{ route('thietbi.index') }}" class="btn btn-secondary rounded-pill ms-2">
                                    <i class="fas fa-times me-2"></i>Xóa lọc
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card">
            <div class="d-flex p-4 justify-content-between">
                <button type="button" data-id="" class="btn btn-success text-dark px-2 py-1 fw-bolder" data-bs-toggle="modal" data-bs-target="#createthietbi">Thêm mới</button>
            </div>
            <div class="modal fade" id="createthietbi" tabindex="-1" aria-labelledby="createthietbiLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-white" id="createthietbiLabel">Thêm mới Thiết bị.</h1>
                        </div>
                        <div class="card-body">
                            <div class="error">
                                @include('admin.error')
                            </div>
                            <form id="form_thietbi_store" class="form-create" enctype="multipart/form-data"  method='POST' action='{{route('thietbi.store')}}'>
                                @csrf
                                <div class='mb-3'>
                                    <label
                                        class='form-label'
                                        for='basic-default-fullname'
                                    >Hình ảnh</label>
                                    <input type="file" id="image-store" class="form-control mb-2" name="icon">
                                    <img id="image-preview" src="" alt="Preview" class="img-fluid rounded d-none" width="150">

                                </div>
                                <div class='mb-3'>
                                    <label
                                        class='form-label'
                                        for='basic-default-fullname'
                                    >Tên thiết bị</label>
                                    <input
                                        type='text'
                                        class='form-control name input-field '
                                        id='title-store'
                                        placeholder='Nhập Tên thiết bị'
                                        name='title' data-require='Mời nhập Tên thiết bị'
                                        value="{{ old('title') }}"
                                    />
                                </div>
                                <div class="modal-footer">
                                    <button type='submit' class='btn btn-success fw-semibold text-dark'>Thêm mới</button>
                                    <button type="button" class="btn btn-secondary fw-semibold" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID Thiết bị</th>
                        <th>Ảnh</th>
                        <th>Tên thiết bị</th>
                        <th>Thời gian tạo</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($thietbis as $thietbi)
                        <tr data-id="{{$thietbi->id}}">
                            <td> {{ $loop->iteration }}</td>
                            <td>{{$thietbi->id}}</td>
                            <td>
                                <img width="70" src="{{ $thietbi->icon}}" alt="">
                            </td>
                            <td>{{$thietbi->title}}</td>
                            <td>{{$thietbi->created_at}}</td>
                            <td class="">
                                <button type="button" data-url="/admin/thietbi/{{$thietbi->id}}" data-id="{{$thietbi->id}}" class="btn btn-danger btnDeleteAsk px-2 me-2 py-1 fw-bolder" data-bs-toggle="modal" data-bs-target="#deleteModal{{$thietbi->id}}">Xóa</button>
                                <button type="button" data-id="{{$thietbi->id}}" class="btn btn-edit btnEditThietbi btn-info text-dark px-2 py-1 fw-bolder">Sửa</button>
                            </td>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{$thietbi->id}}" tabindex="-1" aria-labelledby="deleteModal{{$thietbi->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-white text-wrap" id="deleteModal{{$thietbi->id}}Label">Bạn có chắc chắn xóa Thiết bị <b><u>{{$thietbi->title}}</u></b>  không ?</h1>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="delete-forever btn btn-danger" data-id="{{ $thietbi->id }}">Xóa</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <div class="modal fade ModelEditThietbi" id="editThietbi" tabindex="-1" aria-labelledby="editThietbiLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-white text-danger" id="createThietbiLabel"> </h1>
                            </div>
                            <div class="card-body">
                                <form method='post' action='' enctype="multipart/form-data" class="editThietbiForm form-edit" id="form_thietbiAdmin_update">
                                    @method('PATCH')
                                    @csrf
                                    
                                    <div class='mb-3'>
                                        <label
                                            class='form-label'
                                            for='basic-default-fullname'
                                        >Hình ảnh</label>
                                        <input type="file" id="image-edit" class="form-control mb-2" name="icon">
                                        <img id="image-preview-edit" src="" alt="Preview" class="img-fluid rounded" width="150">
    
                                    </div>
                                    <div class='mb-3'>
                                        <label
                                            class='form-label'
                                            for='basic-default-fullname'
                                        >Tên thiết bị</label>
                                        <input
                                            type='text'
                                            class='form-control title input-field '
                                            id='title-edit'
                                            placeholder='Nhập Tên thiết bị'
                                            name='title' data-require='Mời nhập Tên thiết bị'
                                        />
                                    </div>
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
                    {{ $thietbis->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if ($('#createthietbi .alert-error').length > 0) {
                // Nếu có, hiển thị modal
                $('#createthietbi').modal('show');
            }
            $('.btnEditThietbi').on('click', function() {
                var thietbiID = $(this).data('id'); // Lấy ID từ nút Sửa
                const ModelEdit = $('.ModelEditThietbi');
                const editThietbi = ModelEdit.attr('id', 'editThietbi'+thietbiID);
                const IdEditThietbi = editThietbi.attr('id');

                $.ajax({
                    url: '/admin/thietbi/' + thietbiID, // URL API để lấy thông tin Thiết bị
                    type: 'GET',
                    success: function(response) {
                        // Cập nhật các trường dữ liệu trong modal
                        $('#'+IdEditThietbi + ' #title-edit').val(response.title);
                        $('#'+IdEditThietbi + ' .modal-title').text('Chỉnh sửa Thiết bị: ' + response.title);
                        $('#image-preview-edit').attr('src', response.icon);
                        $('#form_thietbiAdmin_update').attr('action', '/admin/thietbi/' + thietbiID); 
                        $(editThietbi).modal('show'); // Hiển thị modal
                    },
                    error: function() {
                        alert('Không thể lấy dữ liệu khách hàng!');
                    }
                });
            });


            $("#image-store").change(function (event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#image-preview").attr("src", e.target.result);
                        $("#image-preview").removeClass("d-none"); // Hiện ảnh khi có file
                    };
                    reader.readAsDataURL(input.files[0]); // Đọc file ảnh
                }
            });
            $("#image-edit").change(function (event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#image-preview-edit").attr("src", e.target.result);
                        $("#image-preview-edit").attr("src", e.target.result);

                    };
                    reader.readAsDataURL(input.files[0]); // Đọc file ảnh
                }
            });

        });
    </script>
@endsection

