@extends('Master.Layout')

@section('tit')
    Sign up
@endsection

@section('content')
<main class="main" id="top">
    <div class="container">
      <div class="row flex-center min-vh-100 py-5">
        <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
          <div class="text-center mb-5">
            <div class="avatar avatar-4xl mb-4"> <p class="logo-text ms-2 d-none d-sm-block">TO DO</p> </div>
            <h2 class="text-1000"> <span class="fw-normal">Hello </span>John Smith</h2>
            <p class="text-700">Enter your password to access the admin</p>
          </div><input class="form-control mb-3" id="password" type="password" placeholder="Enter Password"><a class="btn btn-primary w-100" href="../../../index.html">Sign In</a>
        </div>
      </div>
    </div>
  </main>
  @endsection
