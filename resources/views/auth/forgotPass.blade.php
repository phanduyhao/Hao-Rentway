@extends('layout.layout')
@section('content')
<section class="section-hero overlay inner-page bg-image" style="background-image: url('/temp//temp/assets/images/hero_1.jpg');" id="home-section">
    <div class="container">
      <div class="row">
        <div class="col-md-7">
          <h1 class="text-white font-weight-bold">{{ __('common.pass_forgot') }}</h1>
          <div class="custom-breadcrumbs">
            <a href="/">Trang chủ</a> <span class="mx-2 slash">/</span>
            <span class="text-white"><strong>{{ __('common.pass_forgot') }}</strong></span>
          </div>
        </div>
      </div>
    </div>
  </section>
<section class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-3"></div>
        <div class="col-lg-6">
          <h2 class="mb-4 text-center font-weight-bold">{{ __('common.pass_forgot') }}</h2>
          <div class="error">
            @include('admin.error')
        </div> 
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
          <form action="{{route('sendMailForgotPass')}}" class="p-4 border rounded" method="post">
            @csrf
            <div class="row form-group">
              <div class="col-md-12 mb-3 mb-md-0">
                <label class="text-black" for="fname">Nhập Email</label>
                <input type="email" id="fname" class="form-control" name="email" placeholder="Email address">
              </div>
            </div>

            <div class="row form-group ">
              <div class="w-100 text-center">
                <input type="submit" value="Gửi mail" class="btn px-4 btn-primary text-white">
              </div>
            </div>

          </form>
        </div>
        <div class="col-3"></div>

      </div>
    </div>
  </section>
@endsection