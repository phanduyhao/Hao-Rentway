let myEditor;
let myEditorEn;

ClassicEditor
  .create(document.querySelector('#description_post'), {
    // các cấu hình khác ở đây
  })
  .then(editor => {
    myEditor = editor; // Gán editor cho description_post
    editor.editing.view.change(writer => {
      writer.setStyle('min-height', '250px', editor.editing.view.document.getRoot());
    });
  })
  .catch(error => {
    console.error(error);
  });

ClassicEditor
  .create(document.querySelector('#description_post_en'), {
    // các cấu hình khác ở đây
  })
  .then(editor => {
    myEditorEn = editor; // Gán editor cho description_post_en
    editor.editing.view.change(writer => {
      writer.setStyle('min-height', '250px', editor.editing.view.document.getRoot());
    });
  })
  .catch(error => {
    console.error(error);
  });


// Hàm để cập nhật placeholder
function updatePricePlaceholder() {
    var mohinh = $('#mohinh').val();
    var priceInput = $('#price');

    if (mohinh === 'thue' || mohinh === 'oghep') {
        priceInput.attr('placeholder', 'Tổng số tiền / tháng');
    } else {
        priceInput.attr('placeholder', 'Tổng số tiền');
    }
}

// Gọi hàm khi trang được tải
updatePricePlaceholder();

// Gọi hàm khi thay đổi giá trị của dropdown
$('#mohinh').change(function() {
    updatePricePlaceholder();
});
   let map, marker;

   function initMap() {
       map = L.map('map').setView([10.7769, 106.7009], 13); // Mặc định Sài Gòn

       // Load bản đồ từ OpenStreetMap
       L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
           attribution: '&copy; OpenStreetMap contributors'
       }).addTo(map);

       marker = L.marker([10.7769, 106.7009], { draggable: true }).addTo(map);

       // Khi kéo thả marker, cập nhật địa chỉ
       marker.on('dragend', function () {
           let position = marker.getLatLng();
           map.setView(position);
           reverseGeocode(position.lat, position.lng);
       });
   }

   function reverseGeocode(lat, lng) {
       let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;

       $.get(url, function (data) {
           if (data && data.display_name) {
               alert("Địa chỉ gần nhất: " + data.display_name);
           }
       });
   }
$(document).ready(function () {
    
    let iframe = $('#mapFrame');

    // Hiển thị iframe khi có src
    let checkSrc = setInterval(() => {
        if (iframe.attr('src')) {
            iframe.removeClass('d-none');
            clearInterval(checkSrc);
        }
    }, 500);

    let countrySelect = $("#country"),
        provinceSelect = $("#province"),
        districtSelect = $("#district"),
        wardSelect = $("#ward"),
        streetInput = $("#street"),
        provinceNameInput = $("#province_name"),
        districtNameInput = $("#district_name"),
        wardNameInput = $("#ward_name"),
        wardCodeInput = $("#ward_code");

        countrySelect.select2();
        provinceSelect.select2();
        districtSelect.select2();
        wardSelect.select2();
    let countryData = {
        "Vietnam": "https://provinces.open-api.vn/api/p/",
        "Philippines": "https://psgc.gitlab.io/api/provinces.json",
        "Thailand": "https://raw.githubusercontent.com/kongvut/thai-province-data/master/api_province.json"
    };

    countrySelect.on("change", function () {
        let country = $(this).val();
provinceSelect.html('<option value="">' + translations.selectProvince + '</option>');
districtSelect.html('<option value="">' + translations.selectDistrict + '</option>');
wardSelect.html('<option value="">' + translations.selectWard + '</option>');

    
        if (!countryData[country]) return;
    
        $.get(`/getProvince/${country}`, function (data) {
            // Phân tích cú pháp dữ liệu JSON nếu cần
            try {
                if (typeof data === "string") {
                    data = JSON.parse(data);
                }
            } catch (e) {
                console.error("Lỗi khi phân tích cú pháp dữ liệu JSON:", e);
                return;
            }
    
            console.log("Dữ liệu từ API:", data); // Xem dữ liệu sau khi phân tích cú pháp
    
                console.log("Dữ liệu từ API khác:", data);
    
                if (Array.isArray(data)) {
                    data.forEach(province => provinceSelect.append(new Option(province.name, province.code)));
                } else if (typeof data === "object" && data.data) {
                    data.data.forEach(province => provinceSelect.append(new Option(province.name, province.code)));
                } else {
                    console.error("Dữ liệu API không đúng định dạng:", data);
                }
            // }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("❌ Lỗi khi gọi API:", textStatus, errorThrown);
        });
    });

    provinceSelect.on("change", function () {
        let provinceCode = $(this).val(),
            provinceName = $(this).find("option:selected").text(),
            country = countrySelect.val();
    
        provinceNameInput.val(provinceName);
        districtSelect.html('<option value="">' + translations.selectDistrict + '</option>').prop("disabled", true);
        wardSelect.html('<option value="">' + translations.selectWard + '</option>').prop("disabled", true);
    
        if (!provinceCode) return;
    
        // Gửi request đến backend để lấy danh sách Districts
        $.get(`/getDistrict/${provinceCode}/${country}`, function (data) {
            if (Array.isArray(data)) {
                districtSelect.empty().append(new Option(translations.selectDistrict, ""));
                data.forEach(district => {
                    districtSelect.append(new Option(district.name, district.code)); // Gán `district.name` và `district.code`
                });
                districtSelect.prop("disabled", false); // Kích hoạt districtSelect
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("❌ Lỗi khi gọi route getDistrict:", textStatus, errorThrown);
        });
    });
    
    
    districtSelect.on("change", function () {
        let districtCode = $(this).val(),
            districtName = $(this).find("option:selected").text(),
            country = countrySelect.val(); // Lấy thông tin quốc gia hiện tại
    
        districtNameInput.val(districtName);
        wardSelect.html('<option value="">' + translations.selectWard + '</option>').prop("disabled", true);
    
        if (!districtCode) return;
        // if (country === "Vietnam") {
        //     // Gọi API lấy danh sách phường/xã cho Việt Nam
        //     $.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`, function (data) {
        //         if (data.wards) {
        //             data.wards.forEach(ward => wardSelect.append(new Option(ward.name, ward.code)));
        //             wardSelect.prop("disabled", false);
        //         } else {
        //             console.error("⚠ Dữ liệu API không đúng định dạng:", data);
        //         }
        //     }).fail(function (jqXHR, textStatus, errorThrown) {
        //         console.error("❌ Lỗi khi gọi API:", textStatus, errorThrown);
        //     });
        // }else{

            // Gửi request đến backend để lấy danh sách Ward
            $.get(`/getWard/${districtCode}/${country}`, function (data) {
                if (Array.isArray(data)) {
                    wardSelect.empty().append(new Option("Chọn phường/xã", ""));
                    data.forEach(ward => {
                        wardSelect.append(new Option(ward.name, ward.code)); // Gán `ward.name` và `ward.code`
                    });
                    wardSelect.prop("disabled", false); // Kích hoạt wardSelect
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error("❌ Lỗi khi gọi route getWard:", textStatus, errorThrown);
            });
        // }
    });
    

    wardSelect.on("change", function () {
        let wardName = $(this).find("option:selected").text(),
            wardCode = $(this).val();

        wardNameInput.val(wardName);
        wardCodeInput.val(wardCode);
        // updateMap();
    });

    // Cập nhật bản đồ khi có thay đổi về địa chỉ
    // $("#street, #ward, #district, #province").on("change keyup", updateMap);
});


// Hàm để cập nhật placeholder
function updatePricePlaceholder() {
    var mohinh = $('#mohinh').val();
    var priceInput = $('#price');

    if (mohinh === 'thue' || mohinh === 'oghep') {
        priceInput.attr('placeholder', 'Tổng số tiền / tháng');
    } else {
        priceInput.attr('placeholder', 'Tổng số tiền');
    }
}

// Gọi hàm khi trang được tải
updatePricePlaceholder();

// Gọi hàm khi thay đổi giá trị của dropdown
$('#mohinh').change(function() {
    updatePricePlaceholder();
});

$('#priceNegotiable').change(function() {
    if ($(this).is(':checked')) {
        $('#price').hide(); // Ẩn ô nhập giá
    } else {
        $('#price').show(); // Hiện ô nhập giá
    }
});



// Đăng tin
$(document).ready(function () {
    
    let $imageUpload = $("#imageUpload");
let $imageInput = $("#imageInput");
let $previewContainer = $("#previewContainer");

let uploadedFiles = []; // Mảng lưu trữ file ảnh đã chọn

let isManualTrigger = false;

// Kéo & Thả file
$imageUpload.on("dragover", function (e) {
    e.preventDefault();
    $(this).css("border-color", "#007bff");
});

$imageUpload.on("dragleave", function () {
    $(this).css("border-color", "#ccc");
});

$imageUpload.on("drop", function (e) {
    e.preventDefault();
    $(this).css("border-color", "#ccc");
    let files = e.originalEvent.dataTransfer.files;
    handleFiles(files);
});

// Click vào khung để chọn file
$imageUpload.on("click", function (e) {
    if (!isManualTrigger) {
        isManualTrigger = true;
        $imageInput.trigger("click");
    }
    setTimeout(() => {
        isManualTrigger = false;
    }, 500);
});

// Khi chọn file từ input
$imageInput.on("change", function () {
    let files = this.files;
    handleFiles(files);
    $imageInput.val(""); // Reset input file
});

function handleFiles(files) {
    $.each(files, function (index, file) {
        if (!file.type.startsWith("image/")) {
            alert("Chỉ được chọn file ảnh!");
            return;
        }

        convertToWebP(file).then((webpFile) => {
            uploadedFiles.push(webpFile); // Thay file gốc bằng file WebP

            let reader = new FileReader();
            reader.onload = function (e) {
                let imgElement = $("<div class='image-preview'>")
                    .append($("<img>").attr("src", e.target.result))
                    .append(
                        $("<span class='remove-btn'>&times;</span>").on(
                            "click",
                            function () {
                                let indexToRemove = $(".remove-btn").index(this);
                                uploadedFiles.splice(indexToRemove, 1);
                                $(this).parent().remove();

                                if (uploadedFiles.length === 0) {
                                    $imageInput.val("");
                                }
                            }
                        )
                    );
                $previewContainer.append(imgElement);
            };
            reader.readAsDataURL(webpFile);
        });
    });
}
    // Upload video
   // upload video 
   const $videoInput = $("#videoInput");
   const $videoPreviewContainer = $("#videoPreviewContainer");
   const $videoUrlInput = $("#video_url");
   const $uploadBox = $("#videoUploadBox");
   
   let uploadedVideos = []; // Mảng lưu file video đã chọn
   
   // Khi click vào vùng upload thì mở file chọn video
   $uploadBox.on("click", function (event) {
       event.stopPropagation();
       $videoInput[0].click();
   });
   
   $videoInput.on("change", function () {
       const files = this.files;
       if (files.length === 0) return;
   
       let maxSizeMB = 50;
   
       for (let i = 0; i < files.length; i++) {
           const file = files[i];
   
           // Kiểm tra file có phải video không
           if (!file.type.startsWith('video/')) {
               alert(`File thứ ${i + 1} không phải định dạng video!`);
               continue;
           }
   
           // Kiểm tra kích thước file
           if (file.size > maxSizeMB * 1024 * 1024) {
               alert(`File video thứ ${i + 1} vượt quá ${maxSizeMB}MB!`);
               continue;
           }
   
           uploadedVideos.push(file); // Lưu file video hợp lệ vào mảng
   
           // Tạo container bao video + nút xóa
           const videoWrapper = $("<div>", {
               class: "video-wrapper",
               style: "display:inline-block; position: relative; margin-right: 10px; margin-bottom: 10px;"
           });
   
           // Tạo thẻ video
           const videoElement = $("<video>", {
               controls: true,
               width: 200,
               style: "display: block; border: 1px solid #ccc; border-radius: 4px; object-fit: cover;",
           });
   
           const videoURL = URL.createObjectURL(file);
           videoElement.attr('src', videoURL);
   
           videoElement.on('loadeddata', function () {
               URL.revokeObjectURL(videoURL);
           });
   
           videoElement.on('error', function () {
               alert(`Không thể tải video thứ ${i + 1}.`);
           });
   
           // Tạo nút xóa video riêng cho từng video, vị trí nút ở góc phải trên
           const deleteButton = $("<button>", {
               text: "Xóa",
               class: "btn btn-danger btn-sm btn-delete-video",
               style: "position: absolute; top: 5px; right: 5px; padding: 2px 6px; font-size: 12px;",
               click: function () {
                   videoWrapper.remove();
                   // Xóa file tương ứng trong mảng uploadedVideos
                   const index = uploadedVideos.indexOf(file);
                   if (index > -1) {
                       uploadedVideos.splice(index, 1);
                   }
               }
           });
   
           // Thêm video + nút xóa vào container riêng
           videoWrapper.append(videoElement, deleteButton);
   
           // Thêm container vào vùng preview (thêm chứ không xóa)
           $videoPreviewContainer.append(videoWrapper);
       }
   
       // Reset input file để chọn lại file trùng
       $videoInput.val('');
   });
   

    $('.form-baidang').submit(function (e) {
        e.preventDefault();
           // Tính tổng dung lượng file ảnh  // Kiểm tra xem cả hai editor đã được khởi tạo chưa
    let totalSize = 0;
    uploadedFiles.forEach(file => {
        totalSize += file.size;
    });
    // Tính tổng dung lượng file video
    uploadedVideos.forEach(file => {
        totalSize += file.size;
    });

    let maxTotalSizeMB = 10; // Giới hạn 10MB
    if (totalSize > maxTotalSizeMB * 1024 * 1024) {
        alert(`Tổng dung lượng ảnh và video không được vượt quá ${maxTotalSizeMB}MB!`);
        return; // Ngừng submit
    }

        const id = $(this).attr('id');
        const action = $(this).attr('action');
        const descriptionContent = myEditor.getData();
        $('textarea[name="description"]').val(descriptionContent); // Cập nhật dữ liệu vào form
        const descriptionContentEn = myEditorEn.getData();
        $('textarea[name="description_en"]').val(descriptionContentEn); // Cập nhật dữ liệu vào form
        let formData = new FormData(this);
        uploadedFiles.forEach((file) => {
            formData.append("images[]", file); // ✅ Đảm bảo file được thêm đúng
        });
        // Append tất cả video file vào formData
        uploadedVideos.forEach((file) => {
            formData.append("videos[]", file);
        });
    
        for (let pair of formData.entries()) {
            console.log(pair[0], pair[1]); 
        }
        $.ajax({
            url: action,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
             headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // ✅ CSRF từ meta tag trong <head>
                },
            beforeSend: function () {
                $('#loading').show(); // Nếu có loading
            },
            success: function (response) {
                $('#loading').hide();
                if (response.status === "success") {
                    toastr.success("✅ Đăng tin thành công!");
                    setTimeout(function(){
                        window.location.href = '/';
                    },500);
                } else {
                    showErrorPage("Lỗi không xác định từ server.");
                }
            },
            error: function (xhr) {
                $('#loading').hide();
                let errorMessage = `Lỗi server: ${xhr.status} - ${xhr.statusText}`;
            
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage += "<ul>";
                    for (let key in xhr.responseJSON.errors) {
                        errorMessage += `<li>${xhr.responseJSON.errors[key]}</li>`;
                    }
                    errorMessage += "</ul>";
                } else if (xhr.responseText) {
                    errorMessage += "<br><pre>" + xhr.responseText + "</pre>";
                }
            
                // Redirect sang error.html và truyền lỗi qua URL
                // window.location.href = "error.html?message=" + encodeURIComponent(errorMessage);
            }
            
            
        });
    });

    $(".remove-btn").on("click", function () {
        let imageUrl = $(this).data("image-url"); // Lấy URL ảnh
        let $previewItem = $(this).closest(".image-preview"); // Lấy phần tử cần xóa

        if (!confirm("Bạn có chắc chắn muốn xóa ảnh này?")) return;

        $.ajax({
            url: "/posts/delete-image", // Đường dẫn đến controller xử lý
            type: "POST",
            data: {
                image: imageUrl, // Gửi URL ảnh cần xóa
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
            },
            success: function (response) {
                $previewItem.remove(); // Xóa ảnh khỏi giao diện nếu xóa thành công
            },
            error: function () {
                alert("Có lỗi xảy ra, vui lòng thử lại.");
            },
        });
    });

    $(".btn-delete-video").on("click", function () {
        let videoUrl = $(this).data("video-url"); // Lấy URL ảnh
        let $previewItem = $(this).closest(".video-wrapper"); // Lấy phần tử cần xóa

        if (!confirm("Bạn có chắc chắn muốn xóa video này?")) return;

        $.ajax({
            url: "/posts/delete-video", // Đường dẫn đến controller xử lý
            type: "POST",
            data: {
                video: videoUrl, // Gửi URL ảnh cần xóa
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
            },
            success: function (response) {
                $previewItem.remove(); // Xóa ảnh khỏi giao diện nếu xóa thành công
            },
            error: function () {
                alert("Có lỗi xảy ra, vui lòng thử lại.");
            },
        });
    });

// Hàm chuyển đổi ảnh sang WebP
function convertToWebP(file) {
    return new Promise((resolve, reject) => {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (event) {
            let img = new Image();
            img.src = event.target.result;
            img.onload = function () {
                let canvas = document.createElement("canvas");
                let ctx = canvas.getContext("2d");

                // Đặt kích thước ảnh giống ảnh gốc
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);

                // Chuyển đổi sang WebP (chất lượng 80%)
                canvas.toBlob(
                    (blob) => {
                        let webpFile = new File(
                            [blob],
                            file.name.replace(/\.[^.]+$/, ".webp"),
                            { type: "image/webp", lastModified: Date.now() }
                        );
                        resolve(webpFile);
                    },
                    "image/webp",
                    0.8
                );
            };
        };
        reader.onerror = function (error) {
            reject(error);
        };
    });
}


});
