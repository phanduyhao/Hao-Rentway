<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.head')
</head>
<body class="blue-skin">
	<style>
		@keyframes scale-up-down {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}
#intro-address {
  animation: scale-up-down 1s infinite;
}
		/* Style for the help popup */
.help-popup {
    position: fixed;
    bottom: 10px;
    right: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    width: 250px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 15px;
    z-index: 9999;
    display: none; /* Default is hidden */
}

.help-popup-content {
    position: relative;
}

.popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.popup-title {
    font-size: 16px;
    font-weight: bold;
}

.btn-close {
    font-size: 10px;
}

.popup-body ul {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}

.popup-body li {
    margin-bottom: 10px;
    font-size: 16px;
}

 #open-popup {
    position: fixed;
    bottom: 10px;
    right: 10px;
    background-color: #f44336;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
	z-index: 999;
}
#intro-address {
    position: fixed;
    bottom: 10px;
    left: 10px;
    background-color: #f69520;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
	z-index: 999;
}

#open-popup:hover {
    background-color: #d32f2f;
}

	</style>
  <!-- ============================================================== -->
     <!-- Preloader - style you can find in spinners.css -->
     <!-- ============================================================== -->
     <div id="preloader"><div class="preloader"><span></span><span></span></div></div>
 
     <!-- ============================================================== -->
     <!-- Main wrapper - style you can find in pages.scss -->
     <!-- ============================================================== -->
     <div id="main-wrapper">
        @include('layout.header', ['show_post' => $showPost ?? true]) <!-- Truyền biến cho header -->
        @yield('content')
        @include('layout.footer')
      <!-- Log In Modal -->
			<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
					<div class="modal-content" id="registermodal">
						<span class="mod-close" data-bs-dismiss="modal" aria-hidden="true">
							<span class="svg-icon text-primary svg-icon-2hx">
								<svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
									<rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
									<rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
								</svg>
							</span>
						</span>
						<div class="modal-body">
							<h4 class="modal-header-title">Log In</h4>
							<div class="d-flex align-items-center justify-content-center mb-3">
								<span class="svg-icon text-primary svg-icon-2hx">
									<svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M15.8797 15.375C15.9797 15.075 15.9797 14.775 15.9797 14.475C15.9797 13.775 15.7797 13.075 15.4797 12.475C14.7797 11.275 13.4797 10.475 11.9797 10.475C11.7797 10.475 11.5797 10.475 11.3797 10.575C7.37971 11.075 4.67971 14.575 2.57971 18.075L10.8797 3.675C11.3797 2.775 12.5797 2.775 13.0797 3.675C13.1797 3.875 13.2797 3.975 13.3797 4.175C15.2797 7.575 16.9797 11.675 15.8797 15.375Z" fill="currentColor"/>
										<path opacity="0.3" d="M20.6797 20.6749C16.7797 20.6749 12.3797 20.275 9.57972 17.575C10.2797 18.075 11.0797 18.375 11.9797 18.375C13.4797 18.375 14.7797 17.5749 15.4797 16.2749C15.6797 15.9749 15.7797 15.675 15.7797 15.375V15.2749C16.8797 11.5749 15.2797 7.47495 13.2797 4.07495L21.6797 18.6749C22.2797 19.5749 21.6797 20.6749 20.6797 20.6749ZM8.67972 18.6749C8.17972 17.8749 7.97972 16.975 7.77972 15.975C7.37972 13.575 8.67972 10.775 11.3797 10.375C7.37972 10.875 4.67972 14.375 2.57972 17.875C2.47972 18.075 2.27972 18.375 2.17972 18.575C1.67972 19.475 2.27972 20.475 3.27972 20.475H10.3797C9.67972 20.175 9.07972 19.3749 8.67972 18.6749Z" fill="currentColor"/>
									</svg>
								</span>
							</div>
							<div class="login-form">
								<form>
								
									<div class="form-floating mb-3">
										<input type="email" class="form-control" placeholder="name@example.com">
										<label>Email address</label>
									</div>
									
									<div class="form-floating mb-3">
									  <input type="password" class="form-control" placeholder="Password">
									  <label>Password</label>
									</div>
									
									<div class="form-group mb-3">
										<div class="d-flex align-items-center justify-content-between">
											<div class="flex-shrink-0 flex-first">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" id="save-pass" value="option1">
													<label class="form-check-label" for="save-pass">Save Password</label>
												</div>	
											</div>
											<div class="flex-shrink-0 flex-first">
												<a href="#" class="link fw-medium">Forgot Password?</a>	
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<button type="button" class="btn btn-lg btn-primary fw-medium full-width rounded-2">LogIn</button>
									</div>
								
								</form>
							</div>
							<div class="modal-divider"><span>Or login via</span></div>
							<div class="social-login mb-3">
								<ul class="d-block">
									{{-- <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li> --}}
									<li class="w-100"><a href="{{ route('google.login') }}" class="btn connect-google"><i class="ti-google"></i>Google+</a></li>
								</ul>
							</div>
							<div class="text-center">
								<p class="mt-4">Have't Any Account? <a href="create-account.html" class="link fw-medium">Acreate An Account</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Modal -->
			
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
			
		</div>
		
		<div class="help-popup border-danger" id="help-popup">
			<div>
				<button id="close-popup" class="btn-close border rounded-circle bg-danger d-flex align-items-center justify-content-center fw-bold text-white p-2"></button>

				</div>
				<div class="help-popup-content mt-1">
					<div class="bg-danger text-center p-2">
						<span class="popup-title text-white">{{ __('common.post_support') }}</span>
					</div>
					<div class="popup-body">
						<ul>
							<li>
								<strong>
									<a href="https://zalo.me/0828983338" target="_blank">Mr. Hai - 0828.983.338</a>
								</strong>
							</li>
						</ul>
					</div>
				</div>
				
		</div>
		<button id="open-popup" class="btn btn-info">{{ __('common.post_support') }}</button>
		<button id="intro-address" class="btn btn-info fw-bold">{{ __('common.intro_address') }}</button>
<!-- Modal Hướng dẫn địa chỉ sau sáp nhập -->
<div class="modal fade" id="addressGuideModal" tabindex="-1" role="dialog" aria-labelledby="addressGuideTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title text-primary" id="addressGuideTitle">Hướng dẫn xem địa chỉ sau khi sáp nhập Việt Nam</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>

      <div class="modal-body">
        <p>Do thay đổi hành chính tại một số tỉnh, địa chỉ cũ có thể được cập nhật thành địa chỉ mới. Bạn có thể:</p>
        <ul>
          <li>Tra cứu theo số nhà, tên đường cũ trên Google Maps.</li>
          <li>Xem bản đồ hành chính mới của tỉnh/thành phố.</li>
          <li>Liên hệ chủ tin hoặc hỗ trợ để xác nhận địa chỉ chính xác.</li>
        </ul>
        <p>Nếu bạn gặp khó khăn, vui lòng liên hệ hỗ trợ để được giải đáp.</p>
      </div>
	  <div class="p-3 border-top">
		<h4>- Click vào các link dưới đây để xem chi tiết !</h4>
		<div class="ps-3">
			<ol type="1">
				<li>
					<h5><a class="text-info" target="_blank" href="https://share.google/eVsT57NoOJ9lclgdN">Hướng dẫn xem TP.Đà Nẵng </a></h3>
				</li>
			</ol>
		</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>


    @include('layout.foot')
	<script>
    document.getElementById('intro-address').addEventListener('click', function () {
        var myModal = new bootstrap.Modal(document.getElementById('addressGuideModal'));
        myModal.show();
    });
</script>

	<script>
		document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById('help-popup');
    const openButton = document.getElementById('open-popup');
    const closeButton = document.getElementById('close-popup');

    // Mở popup khi trang được tải
    popup.style.display = 'block';

    // Khi bấm nút mở popup
    openButton.addEventListener('click', function () {
        popup.style.display = 'block';
    });

    // Khi bấm nút đóng popup
    closeButton.addEventListener('click', function () {
        popup.style.display = 'none';
    });
});

	</script>
  </body>
</html>
