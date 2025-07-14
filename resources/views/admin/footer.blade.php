<script>
    CKEDITOR.replace("ckeditor-desc");
    CKEDITOR.replace("ckeditor-content");
    CKEDITOR.replace("ckeditor-thongsokythuat");
</script>

<script src="/temp/js/admin.js"></script>
<script src="/temp/js/main.js"></script>
<script src="/temp/js/validate.js"></script>
<script src="/temp/admin/assets/js/owl.carousel.min.js"></script>
<script src="/temp/admin/assets/vendor/libs/jquery/jquery.js"></script>
<script src="/temp/admin/assets/vendor/libs/popper/popper.js"></script>
<script src="/temp/admin/assets/vendor/js/bootstrap.js"></script>
<script src="/temp/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/temp/admin/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="/temp/admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="/temp/admin/assets/js/main.js"></script>

<!-- Page JS -->
<script src="/temp/admin/assets/js/dashboards-analytics.js"></script>
<script src="/ckeditor/ckeditor.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
     $('#autoApproveSwitch').change(function () {
            let status = $(this).prop('checked') ? 1 : 0; // Lấy trạng thái (1 nếu bật, 0 nếu tắt)

            $.ajax({
                url: "settings/update-toggle", // Route xử lý AJAX
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
</script>


