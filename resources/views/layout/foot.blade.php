<script>
    const translations = {
        selectProvince: "{{ __('common.select_province_city') }}",
        selectDistrict: "{{ __('common.select_district') }}",
        selectWard: "{{ __('common.select_ward') }}",
        floor: "{{ __('post.floor') }}",
        amountFloor: "{{ __('post.amount_floor') }}",
        number_of_rooms: "{{ __('post.number_of_rooms') }}",
        total_rooms: "{{ __('post.total_rooms') }}",
    };
</script>

<script src="/temp/assets/js/jquery.min.js"></script>
<script src="/temp/assets/js/popper.min.js"></script>
<script src="/temp/assets/js/bootstrap.min.js"></script>
<script src="/temp/assets/js/rangeslider.js"></script>
<script src="/temp/assets/js/select2.min.js"></script>
<script src="/temp/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/temp/assets/js/slick.js"></script>
<script src="/temp/assets/js/slider-bg.js"></script>
<script src="/temp/assets/js/lightbox.js"></script>
<script src="/temp/assets/js/imagesloaded.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="/temp/assets/js/custom.js"></script>
{{-- <script src="/ckeditor/ckeditor.js"></script> --}}
<script src="/temp/js/validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="/temp/js/main.js"></script>

<!-- ============================================================== -->
<!-- This page plugins -->
<script>
    $('#author').select2();
    $('#mamoigioi').select2();
    $('#filterModal').on('shown.bs.modal', function() {
        $('#country, #province, #district, #ward, #quoctich').select2();

        // Ngăn chặn sự kiện chuyển focus vào nút đóng
        $('.select2-container').on('focus', function(e) {
            e.stopImmediatePropagation(); // Ngăn chặn sự tiếp diễn của sự kiện
        });
    });
    $(document).ready(function() {
        let mapContainer = $("#map");

        // Lấy tọa độ từ data-attribute của div
        let lat = parseFloat(mapContainer.data("latitude"));
        let lon = parseFloat(mapContainer.data("longitude"));

        // Kiểm tra nếu có tọa độ hợp lệ
        if (!lat || !lon || isNaN(lat) || isNaN(lon)) {
            console.error("Lỗi: Tọa độ không hợp lệ!", lat, lon);
            return;
        }

        // Hiển thị bản đồ
        mapContainer.removeClass("d-none");

        // Khai báo bản đồ
        let map = L.map('map').setView([lat, lon], 15);

        // Thêm tile layer từ CARTO
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        // Thêm marker
        let marker = L.marker([lat, lon]).addTo(map)
            .bindPopup("Vị trí của bạn")
            .openPopup();

        // Đảm bảo bản đồ hiển thị đúng kích thước sau khi hiển thị
        setTimeout(() => {
            map.invalidateSize();
        }, 1000);

        // Nếu bản đồ nằm trong collapse, xử lý khi mở
        $('#clSix').on('shown.bs.collapse', function() {
            setTimeout(() => {
                map.invalidateSize();
            }, 500);
        });
    });
    $('.toggle-isVip').on('change', function(event) {
        event.stopPropagation();
        let baidangId = $(this).data('id');
        let isChecked = $(this).is(':checked');

        $.ajax({
            url: `/posts/isVip/${baidangId}`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: JSON.stringify({
                isVip: isChecked
            }),
            contentType: 'application/json',
            success: function(response) {
                toastr.success("✅ Cập nhật trạng thái thành công!");
            },
            error: function(xhr, status, error) {
                console.error('Lỗi:', error);
                alert('Có lỗi xảy ra!');
            },
        });
    });
    $(".status-select").on("change", function() {
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
            beforeSend: function() {
                selectElement.prop("disabled", true); // Vô hiệu hóa trong lúc gửi request
            },
            success: function(response) {
                if (response.success) {
                    toastr.success("✅ Cập nhật trạng thái thành công!");
                } else {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                }
            },
            error: function() {
                alert("Lỗi kết nối server!");
            },
            complete: function() {
                selectElement.prop("disabled", false); // Bật lại select sau khi request hoàn tất
            }
        });
    });
    $(document).on("submit", "#form-change-password", function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = form.serialize();

        // Xóa lỗi cũ trước khi gửi
        $(".error-message").text("");

        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            beforeSend: function() {
                $(".btn-primary").prop("disabled", true);
            },
            success: function(response) {
                $(".btn-primary").prop("disabled", false);
                alert(response.message); // Hoặc hiển thị thông báo thành công đẹp hơn
                form[0].reset(); // Reset form nếu đổi mật khẩu thành công
            },
            error: function(xhr) {
                $(".btn-primary").prop("disabled", false);
                let errors = xhr.responseJSON.errors;

                // Hiển thị lỗi ngay dưới mỗi input
                for (let key in errors) {
                    let errorMessage = errors[key][0]; // Lấy lỗi đầu tiên
                    $(`input[name="${key}"]`).next(".error-message").text(errorMessage);
                }
            }
        });
    });

    $(document).ready(function() {
        $('.list-gallery-inline').magnificPopup({
            delegate: 'a', // các thẻ <a> bên trong gallery
            type: 'image',
            gallery: {
                enabled: true // Bật tính năng chuyển ảnh
            },
            image: {
                titleSrc: 'title' // nếu có title trong ảnh
            }
        });
    });
    $(document).ready(function() {
        // Gửi yêu cầu đến API Restcountries để lấy danh sách quốc gia
        // Gửi yêu cầu đến API Restcountries để lấy danh sách quốc gia
        $.ajax({
            url: 'https://restcountries.com/v3.1/all', // Đường dẫn API
            method: 'GET',
            success: function(data) {
                // Duyệt qua tất cả quốc gia trong dữ liệu
                $.each(data, function(index, country) {
                    var countryName = country.name.common; // Tên quốc gia

                    // Kiểm tra nếu quốc gia là Việt Nam
                    var selected = (countryName === 'Vietnam') ? 'selected' : '';

                    // Thêm quốc gia vào dropdown và đánh dấu "Việt Nam" là mặc định
                    $('#quoctich').select2();
                    $('#quoctich').append('<option value="' + countryName + '" ' +
                        selected + '>' + countryName + '</option>');
                });
            },
            error: function(err) {
                console.log('Lỗi khi lấy dữ liệu quốc gia:', err);
            }
        });

    });
    // Hàm chung xử lý thêm mới (Tỉnh/Huyện/Xã)
    // Hàm chung xử lý thêm mới (Tỉnh/Huyện/Xã)
    function addLocation(locationType) {
        let modalId = `#add${locationType}Modal`; // Modal tương ứng (Tỉnh/Huyện/Xã)
        let formId = `#add${locationType}Form`; // Form tương ứng (Tỉnh/Huyện/Xã)
        let locationNameId = `${locationType.toLowerCase()}Name`; // Trường tên tương ứng
        let locationSelectId = `#${locationType.toLowerCase()}`; // Dropdown tương ứng (Tỉnh/Huyện/Xã)

        // Xử lý sự kiện nhấn nút "Thêm mới"
        // Xử lý sự kiện nhấn nút "Thêm mới"
        $(`#add-${locationType.toLowerCase()}`).on("click", function(e) {
            e.preventDefault();

            let allowOpen = true;
            let errorMsg = "";

            if (locationType === "Province") {
                if (!$("#country").val()) {
                    allowOpen = false;
                    errorMsg = "Vui lòng chọn Quốc gia trước khi thêm Tỉnh/Thành phố!";
                }
            }

            if (locationType === "District") {
                if (!$("#province").val()) {
                    allowOpen = false;
                    errorMsg = "Vui lòng chọn Tỉnh/Thành phố trước khi thêm Quận/Huyện!";
                }
            }

            if (locationType === "Ward") {
                if (!$("#district").val()) {
                    allowOpen = false;
                    errorMsg = "Vui lòng chọn Quận/Huyện trước khi thêm Phường/Xã!";
                }
            }

            if (!allowOpen) {
                alert(errorMsg);
                return;
            }

            $(modalId).modal('show'); // ✅ Chỉ show modal nếu điều kiện OK
        });


        // Xử lý khi form "Thêm mới" được submit
        $(formId).on("submit", function(e) {
            e.preventDefault();

            // Lấy thông tin tên địa phương mới từ form
            let locationName = $(`#${locationNameId}`).val();

            // Kiểm tra nếu tên địa phương trống
            if (!locationName) {
                alert(`Vui lòng nhập tên ${locationType}`);
                return;
            }

            // Lấy quốc gia đã chọn từ dropdown Quốc gia
            let country = $("#country").val();

            // Kiểm tra nếu quốc gia chưa được chọn
            if (!country) {
                alert("Vui lòng chọn quốc gia");
                return;
            }

            // Thực hiện gửi thông tin địa phương mới tới API hoặc cập nhật cơ sở dữ liệu
            $.ajax({
                url: `/api/add${locationType}`, // Thay đổi theo API của bạn
                type: "POST",
                data: {
                    name: locationName,
                    country: country
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật dropdown sau khi thêm thành công
                        $(locationSelectId).append(new Option(locationName, response[
                            `${locationType.toLowerCase()}_id`]));
                        $(modalId).modal('hide'); // Đóng modal
                    } else {
                        alert(`Lỗi khi thêm ${locationType}`);
                    }
                },
                error: function(error) {
                    console.error("Lỗi API:", error);
                    alert(`Có lỗi xảy ra khi thêm ${locationType}`);
                }
            });
        });
    }

    // Gọi hàm cho từng loại địa phương (Tỉnh, Huyện, Xã)
    addLocation("Province"); // Thêm mới Tỉnh
    addLocation("District"); // Thêm mới Huyện
    addLocation("Ward"); // Thêm mới Xã
    // Đảm bảo nút đóng modal (thẻ <button class="close">) đóng đúng modal
    $('.close').on('click', function() {
        $(this).closest('.modal').modal('hide'); // Đóng modal cha của nút close
    });


    // add location

    // Add location
    function submitNewLocation(locationType) {
        let modalId = `#add${locationType}Modal`;
        let formId = `#add${locationType}Form`;
        let nameInputId = `#${locationType.toLowerCase()}Name`;

        let locationName = $(nameInputId).val();
        let country = $("#country").val(); // Lấy quốc gia từ dropdown
        let provinceId = $("#province").val(); // Nếu thêm huyện, cần province_id
        let districtId = $("#district").val(); // Nếu thêm xã, cần district_id
        let province_name = $('#province_name').val();
        let district_name = $('#district_name').val();

        if (!locationName) {
            alert(`Vui lòng nhập tên ${locationType}`);
            return;
        }

        if (!country) {
            return;
        }

        // Chuẩn bị data gửi lên server
        let data = {
            name: locationName,
            country: country,
            locationType: locationType.toLowerCase() // Gửi locationType để biết thêm gì
        };

        if (locationType === "District") {
            if (!provinceId) {
                return;
            }
            data.province_code = provinceId;
            data.province_name = province_name;
        }

        if (locationType === "Ward") {
            if (!districtId) {
                return;
            }
            data.district_code = districtId;
            data.district_name = district_name;
        }

        // Gửi AJAX POST
        $.ajax({
            url: '/addLocation/' + locationType,
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Nếu có CSRF token
            },
            success: function(response) {
                if (response.success) {
                    let newId, code, newName, selectId, hiddenInputId;

                    if (locationType === 'Province') {
                        code = response.Province_code
                        newId = response.province_id;
                        newName = locationName;
                        selectId = '#province';
                        hiddenInputId = '#province_name';
                        console.log('code:', code);
                    } else if (locationType === 'District') {
                        code = response.District_code
                        newId = response.district_id;
                        newName = locationName;
                        selectId = '#district';
                        hiddenInputId = '#district_name';
                        console.log('code:', code);
                    } else if (locationType === 'Ward') {
                        code = response.Ward_code
                        newId = response.ward_id;
                        newName = locationName;
                        selectId = '#ward';
                        hiddenInputId = '#ward_name';
                        console.log('code:', code);
                    }

                    // 1. Append option mới vào select
                    $(selectId).append(
                        $('<option>', {
                            value: code,
                            text: newName,
                            'data-custom': true,
                            'data-code': code
                        })
                    );

                    // 2. Nếu select đang dùng select2 thì phải destroy và re-init
                    $(selectId).select2('destroy');
                    $(selectId).select2();

                    // 3. Set giá trị mới + trigger change
                    $(selectId).val(newId).trigger('change');

                    // 4. Update hidden input
                    $(hiddenInputId).val(code);

                    // 5. Đóng modal + reset form
                    $(modalId).modal('hide');
                    $(formId)[0]?.reset();


                    // 6. Nếu thêm District thì bật Ward
                    if (locationType === 'District') {
                        $("#district").prop("disabled", false);
                        $("#add-ward").prop("disabled", false); // Cho phép thêm phường
                    }

                    // Nếu thêm Ward thì bật submit gì đó nếu cần
                    if (locationType === 'Ward') {
                        $("#ward").prop("disabled", false);
                    }

                } else {
                    alert("Có lỗi xảy ra khi thêm!");
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("Lỗi hệ thống khi thêm mới!");
            }
        });
    }

    $('#addProvinceBtn').on('click', function() {
        submitNewLocation("Province"); // Gọi hàm submitNewLocation khi bấm Lưu
    });

    $('#addDistrictBtn').on('click', function() {
        submitNewLocation("District"); // Gọi hàm submitNewLocation khi bấm Lưu
    });

    $('#addWardBtn').on('click', function() {
        submitNewLocation("Ward"); // Gọi hàm submitNewLocation khi bấm Lưu
    });




    $(document).ready(function() {
        // Chỉ cho phép nhập số vào trường giá
        $('#price').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Loại bỏ mọi ký tự không phải là số
        });

        // Chỉ cho phép nhập số vào trường diện tích
        $('input[name="area"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Loại bỏ mọi ký tự không phải là số
        });

        // Chỉ cho phép nhập số vào trường số điện thoại
        $('input[name="phone_contact"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Loại bỏ mọi ký tự không phải là số
        });
    });
    $(document).ready(function() {
        // Bắt sự kiện bấm "Thêm mới Tỉnh"
        $("#add-province").click(function(e) {
            e.preventDefault(); // 👉 Chặn sự kiện mặc định trước đã

            let country = $("#country").val();
            if (!country) {
                return;
                $("#addProvinceModal").modal('hide');
            } else {
                $("#addProvinceModal").modal('show');
            }

        });

        $("#add-district").click(function(e) {
            e.preventDefault();

            let province = $("#province").val();
            if (!province) {
                return;
                $("#addDistrictModal").modal('hide');
            } else {
                $("#addDistrictModal").modal('show');
            }

        });

        $("#add-ward").click(function(e) {
            e.preventDefault();

            let district = $("#district").val();
            if (!district) {
                return;
                $("#addWardModal").modal('hide');
            } else {
                $("#addWardModal").modal('show');
            }

        });

    });
    $(document).ready(function() {
        // Lắng nghe sự kiện click vào nút "Chi tiết"
        $('a[id^="detail-btn-"]').on('click', function(e) {

            var baidangId = $(this).attr('id').split('-')[
            2]; // Lấy ID bài đăng từ id của nút "Chi tiết"

            // Gửi yêu cầu Ajax để đánh dấu bài đăng là đã đọc
            $.ajax({
                url: '/mark-as-read/' + baidangId, // Gọi route cập nhật isRead
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Thêm CSRF token để bảo vệ yêu cầu
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log('ok');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Có lỗi xảy ra khi cập nhật trạng thái bài đăng:', error);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("filterModal");

        // Các nút mở modal
        const openModalButtons = document.querySelectorAll(".open-modal");

        // Tạo backdrop nếu cần
        function createBackdrop() {
            if (!document.querySelector(".modal-backdrop")) {
                const backdrop = document.createElement("div");
                backdrop.className = "modal-backdrop show";
                document.body.appendChild(backdrop);
            }
        }

        // Xóa backdrop khi đóng
        function removeBackdrop() {
            const backdrop = document.querySelector(".modal-backdrop");
            if (backdrop) backdrop.remove();
            document.body.classList.remove("modal-open");
        }

        // Mở modal
        openModalButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                modal.style.display = "flex";
                createBackdrop();
                document.body.classList.add("modal-open");
            });
        });

        // Đóng modal khi click ra ngoài
        window.addEventListener("click", function(e) {
            if (e.target === modal) {
                modal.style.display = "none";
                removeBackdrop();
            }
        });

        // Thêm nút đóng (nếu bạn chưa có sẵn)
        const closeBtn = document.createElement("button");
        closeBtn.textContent = "×";
        closeBtn.className = "btn-close";
        closeBtn.style.position = "absolute";
        closeBtn.style.top = "10px";
        closeBtn.style.right = "15px";
        closeBtn.style.fontSize = "24px";
        closeBtn.style.border = "none";
        closeBtn.style.background = "transparent";
        closeBtn.style.cursor = "pointer";
        modal.querySelector(".modal-content").appendChild(closeBtn);

        closeBtn.addEventListener("click", function() {
            modal.style.display = "none";
            removeBackdrop();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const minInput = document.getElementById("priceMinDisplay");
        const maxInput = document.getElementById("priceMaxDisplay");

        const minUnit = document.getElementById("priceMinUnit");
        const maxUnit = document.getElementById("priceMaxUnit");

        const minHidden = document.getElementById("priceMin");
        const maxHidden = document.getElementById("priceMax");

        const minResult = document.getElementById("priceMinResult");
        const maxResult = document.getElementById("priceMaxResult");

        const minLabel = document.getElementById("priceMinLabel");
        const maxLabel = document.getElementById("priceMaxLabel");

    const unitLabels = {
            1000: @json(__('common.thousand')),
            1000000: @json(__('common.million')),
            1000000000: @json(__('common.billion')),
        };

        function normalizeNumber(val) {
            const num = parseFloat(val.replace(',', '.').replace(/[^0-9.]/g, ''));
            return isNaN(num) ? null : num;
        }

        function updatePrices() {
            const unitMin = parseInt(minUnit.value);
            const unitMax = parseInt(maxUnit.value);

            const baseMin = normalizeNumber(minInput.value);
            const baseMax = normalizeNumber(maxInput.value);

            const realMin = baseMin !== null ? baseMin * unitMin : null;
            const realMax = baseMax !== null ? baseMax * unitMax : null;

            // Gán vào hidden input
            minHidden.value = realMin !== null ? realMin : '';
            maxHidden.value = realMax !== null ? realMax : '';

            // Hiển thị định dạng
            if (realMin !== null) {
                minResult.textContent = realMin.toLocaleString('vi-VN') + 'đ';
                minLabel.textContent = `(${baseMin} ${unitLabels[unitMin]})`;
            } else {
                minResult.textContent = '';
                minLabel.textContent = '';
            }

            if (realMax !== null) {
                maxResult.textContent = realMax.toLocaleString('vi-VN') + 'đ';
                maxLabel.textContent = `(${baseMax} ${unitLabels[unitMax]})`;
            } else {
                maxResult.textContent = '';
                maxLabel.textContent = '';
            }
        }

        [minInput, maxInput, minUnit, maxUnit].forEach(el => {
            el.addEventListener('input', updatePrices);
            el.addEventListener('change', updatePrices);
        });

        updatePrices(); // gọi lần đầu
    });
     document.addEventListener('DOMContentLoaded', function() {
            const listMa = [{
                    prefix: 'CFA',
                    max: 200
                },
                {
                    prefix: 'HFA',
                    max: 200
                },
                {
                    prefix: 'CSA',
                    max: 200
                },
                {
                    prefix: 'HSA',
                    max: 200
                },
                {
                    prefix: 'LSA',
                    max: 200
                },
                {
                    prefix: 'LFA',
                    max: 50
                },
                {
                    prefix: 'CFO',
                    max: 100
                },
                {
                    prefix: 'HFO',
                    max: 100
                },
                {
                    prefix: 'CSO',
                    max: 100
                },
                {
                    prefix: 'HSO',
                    max: 100
                },
                {
                    prefix: 'LSO',
                    max: 60
                },
                {
                    prefix: 'LFO',
                    max: 50
                }
            ];

            const select = document.getElementById('mamoigioi');

            listMa.forEach(item => {
                for (let i = 1; i <= item.max; i++) {
                    const value = item.prefix + i.toString().padStart(3, '0');
                    const option = document.createElement('option');
                    option.value = value;
                    option.textContent = value;
                    select.appendChild(option);
                }
            });
        });
</script>
