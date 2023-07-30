@extends('Master.Layout')

@section('tit')
    Sign up
@endsection

@section('content')
<main class="main" id="top">
    <div class="container">
      <div class="row flex-center min-vh-100 py-5">
        <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3">
            <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block"></div>
          <div class="text-center mb-7">
            <h3 class="text-1000">Sign Up</h3>
            <p class="text-700">Create your account today</p>
          
          <form method="POST" action="{{route('register.user')}}">
            @csrf
            @method('POST')
            <div class="row g-3 mb-3">
              <div class="col-sm-6">
                <label class="form-label" for="firstName">first Name</label>
               <input class="form-control  @error('firstName') is-invalid @enderror"  value="{{old("firstName")}}" id="firstName" name="firstName" type="text" placeholder="first Name" />
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="lastName">last Name</label>
              <input class="form-control  @error('lastName') is-invalid @enderror" id="lastName" name="lastName" type="text" placeholder="last Name" />
              </div>
            </div>
            <div class="mb-3 text-start">
              <label class="form-label" for="tel">tel</label>
              <input 
              class="form-control form-icon-input @error('tel') is-invalid @enderror" 
              id="tel" 
              type="tel"
              value="{{old("tel")}}"
               placeholder="tel"
               name="tel">
            </div>
            <div class="mb-3 text-start">
              <label class="form-label" for="email">Email address</label>
              <input class="form-control  @error('email') is-invalid @enderror" name="email"  value="{{old("email")}}"  id="email" type="email" placeholder="name@example.com" /></div>
            <div class="row g-3 mb-3">
              <div class="col-sm-6"><label class="form-label" for="password">Password</label><input   name="password"     value="{{old("Password")}}"    class="form-control form-icon-input @error('password') is-invalid @enderror" id="password" type="password" placeholder="Password" /></div>
              <div class="col-sm-6"><label class="form-label" for="confirmPassword">Confirm Password</label><input  name="password_confirmation" class="form-control form-icon-input @error('password_confirmation ') is-invalid @enderror" id="confirmPassword" type="password" placeholder="Confirm Password" /></div>
            </div>
            <button class="btn btn-primary w-100 mb-3">Sign In</button>
          </form>
          <div class="text-center"><a class="fs--1 fw-bold" href="{{route('login')}}">Sign in to an existing account</a></div>
        </div>
      </div>
    </div>
  </main>
@endsection
