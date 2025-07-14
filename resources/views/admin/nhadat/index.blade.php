@extends('admin.main')
@section('contents')

    <div class="container-fluid flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{$title}}</h3>
        <div>
            <form class="form-search" method="GET" action="{{ route('loainhadat.index') }}">
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
                                   placeholder="Tìm theo tên loại nhà đất..." 
                                   value="{{ request()->search_name }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <div class="text-center text-nowrap">
                                <button type="submit" class="btn btn-danger rounded-pill">
                                    <i class="fas fa-search me-2"></i>Tìm kiếm
                                </button>
                                <a href="{{ route('loainhadat.index') }}" class="btn btn-secondary rounded-pill ms-2">
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
                <button type="button" data-id="" class="btn btn-success text-dark px-2 py-1 fw-bolder" data-bs-toggle="modal" data-bs-target="#createloainhadat">Thêm mới</button>
            </div>
            <div class="modal fade" id="createloainhadat" tabindex="-1" aria-labelledby="createloainhadatLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-white" id="createloainhadatLabel">Thêm mới Loại nhà đất.</h1>
                        </div>
                        <div class="card-body">
                            <div class="error">
                                @include('admin.error')
                            </div>
                            <form id="form_loainhadat_store" class="form-create" enctype="multipart/form-data"  method='POST' action='{{route('loainhadat.store')}}'>
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
                                    >Mã nhà đất</label>
                                    <input
                                        type='text'
                                        class='form-control name input-field '
                                        id='ma_nha_dat-store'
                                        placeholder='Nhập Mã nhà đất'
                                        name='title' data-require='Mời nhập Mãnhà đất'
                                        value="{{ old('ma_nha_dat') }}"
                                    />
                                </div>
                                <div class='mb-3'>
                                    <label
                                        class='form-label'
                                        for='basic-default-fullname'
                                    >Tên loại nhà đất</label>
                                    <input
                                        type='text'
                                        class='form-control name input-field '
                                        id='title-store'
                                        placeholder='Nhập Tên loại nhà đất'
                                        name='title' data-require='Mời nhập Tên loại nhà đất'
                                        value="{{ old('title') }}"
                                    />
                                </div>
                                <div class='mb-3 w-100'>
                                    <label
                                        class='form-label'
                                        for='basic-default-company'
                                    >Slug</label>
                                    <input
                                        type='text'
                                        class='form-control slug input-field'
                                        id='slug-store'
                                        placeholder='Nhập Slug'
                                        name='slug' data-require='Mời nhập Slug'
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
                        <th>ID Loại nhà đất</th>
                        <th>Mã nhà đất</th>
                        <th>Ảnh</th>
                        <th>Tên loại nhà đất</th>
                        <th>Thời gian tạo</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($loainhadats as $loainhadat)
                        <tr data-id="{{$loainhadat->id}}">
                            <td> {{ $loop->iteration }}</td>
                            <td>{{$loainhadat->id}}</td>
                            <td>{{$loainhadat->ma_nha_dat}}</td>
                            <td>
                                <img width="70" src="{{ $loainhadat->icon}}" alt="">
                            </td>
                            <td>{{$loainhadat->title}}</td>
                            <td>{{$loainhadat->created_at}}</td>
                            <td class="">
                                <button type="button" data-url="/admin/loainhadat/{{$loainhadat->id}}" data-id="{{$loainhadat->id}}" class="btn btn-danger btnDeleteAsk px-2 me-2 py-1 fw-bolder" data-bs-toggle="modal" data-bs-target="#deleteModal{{$loainhadat->id}}">Xóa</button>
                                <button type="button" data-id="{{$loainhadat->id}}" class="btn btn-edit btnEditLoainhadat btn-info text-dark px-2 py-1 fw-bolder">Sửa</button>
                            </td>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{$loainhadat->id}}" tabindex="-1" aria-labelledby="deleteModal{{$loainhadat->id}}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-white text-wrap" id="deleteModal{{$loainhadat->id}}Label">Bạn có chắc chắn xóa Loại nhà đất <b><u>{{$loainhadat->title}}</u></b>  không ?</h1>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="delete-forever btn btn-danger" data-id="{{ $loainhadat->id }}">Xóa</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <div class="modal fade ModelEditLoainhadat" id="editLoainhadat" tabindex="-1" aria-labelledby="editLoainhadatLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-white text-danger" id="createLoainhadatLabel"> </h1>
                            </div>
                            <div class="card-body">
                                <form method='post' action='' enctype="multipart/form-data" class="editLoainhadatForm form-edit" id="form_loainhadatAdmin_update">
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
                                            for='basic-edit-fullname'
                                        >Mã nhà đất</label>
                                        <input
                                            type='text'
                                            class='form-control ma_nha_dat input-field '
                                            id='ma_nha_dat-edit'
                                            placeholder='Nhập Mã nhà đất'
                                            name='ma_nha_dat' data-require='Mời nhập Mã nhà đất'
                                        />
                                    </div>
                                    <div class='mb-3'>
                                        <label
                                            class='form-label'
                                            for='basic-default-fullname'
                                        >Tên loại nhà đất</label>
                                        <input
                                            type='text'
                                            class='form-control title input-field '
                                            id='title-edit'
                                            placeholder='Nhập Tên loại nhà đất'
                                            name='title' data-require='Mời nhập Tên loại nhà đất'
                                        />
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label
                                            class='form-label'
                                            for='basic-default-company'
                                        >Slug</label>
                                        <input
                                            type='text'
                                            class='form-control slug input-field'
                                            id='slug-edit'
                                            placeholder='Nhập Slug'
                                            name='slug' data-require='Mời nhập Slug'
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
                    {{ $loainhadats->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if ($('#createloainhadat .alert-error').length > 0) {
                // Nếu có, hiển thị modal
                $('#createloainhadat').modal('show');
            }
            $('.btnEditLoainhadat').on('click', function() {
                var loainhadatID = $(this).data('id'); // Lấy ID từ nút Sửa
                const ModelEdit = $('.ModelEditLoainhadat');
                const editLoainhadat = ModelEdit.attr('id', 'editLoainhadat'+loainhadatID);
                const IdEditLoainhadat = editLoainhadat.attr('id');

                $.ajax({
                    url: '/admin/loainhadat/' + loainhadatID, // URL API để lấy thông tin Loại nhà đất
                    type: 'GET',
                    success: function(response) {
                        // Cập nhật các trường dữ liệu trong modal
                        $('#'+IdEditLoainhadat + ' #title-edit').val(response.title);
                        $('#'+IdEditLoainhadat + ' #ma_nha_dat-edit').val(response.ma_nha_dat);
                        $('#'+IdEditLoainhadat + ' #slug-edit').val(response.slug);
                        $('#'+IdEditLoainhadat + ' .modal-title').text('Chỉnh sửa Loại nhà đất: ' + response.title);
                        $('#image-preview-edit').attr('src', response.icon);
                        $('#form_loainhadatAdmin_update').attr('action', '/admin/loainhadat/' + loainhadatID); 
                        $(editLoainhadat).modal('show'); // Hiển thị modal
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

