@extends('Master.Layout')

@section('tit')
    Sign in
@endsection

@section('content')
 <main class="main" id="top">
    <div class="container">
      <div class="row flex-center min-vh-100 py-5">
        <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
          <div class="text-center mb-7">
            <h3 class="text-1000">Sign In</h3>
            <p class="text-700">Get access to your account</p>
            <form action="{{ url('/auth/google') }}" method="GET">
              <button class="btn btn-phoenix-secondary w-100 mb-3"><span class="fab fa-google text-danger me-2 fs--1"></span> Sign in with google</button>
              @csrf
            </form>
            <div class="position-relative">
              <hr class="bg-200 mt-5 mb-4">
              <div class="divider-content-center">or use email</div>
            </div>
          <form action="{{route('login.user')}}" method="POST">
            @csrf
            @error('login')
            <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
              <span class="fas fa-times-circle text-danger fs-3 me-3"></span>
              <p class="mb-0 flex-1">{{$message}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
                @enderror
          <div class="mb-3 text-start"><label class="form-label" for="email">Email address</label>
            <div class="form-icon-container">
              <input class="form-control form-icon-input"   value="{{old("email")}}"
              id="email" type="email" name="email" placeholder="name@example.com" />
              <span class="fas fa-user text-900 fs--1 form-icon"></span></div>
          </div>
          @error('email')
                <p style="color: red">
                   {{$message}}
                </p>
                @enderror
          <div class="mb-3 text-start"><label class="form-label" for="password">Password</label>
            <div class="form-icon-container"><input class="form-control form-icon-input" 
              value="{{old("password")}}"
              id="password" type="password" name="password" placeholder="Password" /><span class="fas fa-key text-900 fs--1 form-icon"></span></div>
          </div>
          @error('password')
          <p style="color: red">
             {{$message}}
          </p>
          @enderror
          <button class="btn btn-primary w-100 mb-3">Sign In</button>
        </form>
          <div class="text-center"><a class="fs--1 fw-bold" href="{{route('register')}}">Create an account</a></div>
        </div>
      </div>
    </div>
  </main>
@endsection