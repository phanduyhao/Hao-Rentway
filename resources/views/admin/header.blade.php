<link rel="icon" type="image/x-icon" sizes="5760x5760" href="{{$settings['logo']}}" /><!-- Place favicon.ico in the root directory -->

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="/temp/admin/assets/vendor/fonts/boxicons.css" />
<link rel="stylesheet" href="/temp/bootstrap/css/bootstrap.min.css">

<!-- Core CSS -->
<link rel="stylesheet" href="/temp/admin/assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/temp/admin/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/temp/admin/assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="/temp/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<link rel="stylesheet" href="/temp/admin/assets/vendor/libs/apex-charts/apex-charts.css" />
<link rel="stylesheet" href="/temp/viewer/dist/viewer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Page CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Helpers -->
<script src="/temp/admin/assets/vendor/js/helpers.js"></script>
<script src="/temp/admin/assets/vendor/libs/jquery/dist/jquery.min.js"></script>
<script src="/temp/admin/assets/js/bootstrap.bundle.min.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="/temp/admin/assets/js/config.js"></script>
<script src="/ckeditor/ckeditor.js"></script>


<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 10px;
    }

    .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        border: none;
        width: 20px;
        display: flex;
        height: 20px;
        border-radius: 50%;
        align-items: center;
    }
    .text-black-main{
        color: black;
    }
    .circle-active{
        width: 10px;
        height: 10px;
    }
    .btn-show__details-file{
        transition: .3s all;
    }
    .btn-show__details-file:hover{
        background: rgba(0, 0, 0, 0.43);
        transition: .3s all;
    }
    .admin th, .admin h5{
        color: black !important;
    }

    .btn-favourite i{
        transition: .2s all;
    }

    .btn-favourite:hover i{
        color: red;
        transition: .2s all;
    }
    .rating:hover{
        cursor: pointer;
    }
    .rating .filled-stars {
        position: absolute;
        left: 0;
        top: 0;
        white-space: nowrap;
        overflow: hidden;
    }
    .cke_contents{
        height: 500px !important;
    }
</style>
<link rel="icon" type="image/x-icon" href="/temp//temp/assets/images/general/favicon.png" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="/temp/admin/assets/vendor/fonts/boxicons.css" />
<link rel="stylesheet" href="/temp/bootstrap/css/bootstrap.min.css">

<!-- Core CSS -->
<link rel="stylesheet" href="/temp/admin/assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/temp/admin/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/temp/admin/assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="/temp/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<link rel="stylesheet" href="/temp/admin/assets/vendor/libs/apex-charts/apex-charts.css" />
<link rel="stylesheet" href="/temp/viewer/dist/viewer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Page CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Helpers -->
<script src="/temp/admin/assets/vendor/js/helpers.js"></script>
<script src="/temp/libs/jquery/dist/jquery.min.js"></script>
<script src="/temp/admin/assets/js/bootstrap.bundle.min.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="/temp/admin/assets/js/config.js"></script>
<script src="/ckeditor/ckeditor.js"></script>


<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 10px;
    }

    .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: red;
        color: white;
        border: none;
        width: 20px;
        display: flex;
        height: 20px;
        border-radius: 50%;
        align-items: center;
    }
    .text-black-main{
        color: black;
    }
    .circle-active{
        width: 10px;
        height: 10px;
    }
    .btn-show__details-file{
        transition: .3s all;
    }
    .btn-show__details-file:hover{
        background: rgba(0, 0, 0, 0.43);
        transition: .3s all;
    }
    .admin th, .admin h5{
        color: black !important;
    }

    .btn-favourite i{
        transition: .2s all;
    }

    .btn-favourite:hover i{
        color: red;
        transition: .2s all;
    }
    .rating:hover{
        cursor: pointer;
    }
    .rating .filled-stars {
        position: absolute;
        left: 0;
        top: 0;
        white-space: nowrap;
        overflow: hidden;
    }
    .cke_contents{
        height: 500px !important;
    }
</style>
