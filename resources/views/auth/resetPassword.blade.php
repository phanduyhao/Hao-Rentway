@extends('layout.layout')
@section('content')
<section class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-lg-6">
          <h2 class="mb-4 text-center font-weight-bold">Đặt lại mật khẩu</h2>
          <form action="{{ route('postResetPassword') }}" method="post" class="p-4 border rounded">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="row form-group">
              <div class="col-md-12 mb-3">
                <label class="text-black" for="password">Mật khẩu mới</label>
                <input type="password" id="password" class="form-control" name="password" required>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12 mb-3">
                <label class="text-black" for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-3"></div>
      </div>
    </div>
</section>
@endsection
