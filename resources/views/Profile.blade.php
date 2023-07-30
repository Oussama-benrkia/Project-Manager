@extends('Temp')
@section('cont')
<div class="content">
    <div class="mb-9">
      <div class="row g-6">
        <form action="{{ route('profile.update') }}" method="POST">
          @csrf
        <div class="col-12 col-xl-4">
          <div class="card mb-5">
            
            <div style="min-height: 130px; " class="card-header hover-actions-trigger position-relative mb-6">
             <input class="d-none" id="upload-settings-porfile-picture" type="file">
              <label class="avatar avatar-4xl status-online feed-avatar-profile cursor-pointer" for="upload-settings-porfile-picture">
                <img class="rounded-circle img-thumbnail bg-white shadow-sm" src="{{(!is_null($data->image))?asset("storage/".$data->image):asset("storage/logos/inconnue.jpeg")}}" width="200" alt=""></label>
            </div><div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex flex-wrap mb-2 align-items-center">
                    <h3 class="me-2">{{$data->firstName.' '.$data->lastName}}</h3>
                    <span class="fw-normal fs-0">{{$data->role}}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><div class="col-12 col-xl-8">
          <div class="border-bottom border-300 mb-4">
            <div class="mb-6">
              <h4 class="mb-4">Personal Information</h4>
              <div class="row g-3">
                <div class="col-12 col-sm-6">
                  <div class="form-icon-container">
                    <div class="form-floating">
                      <input class="form-control form-icon-input" 
                      id="firstName" name="firstName" value="{{$data->firstName}}" 
                      type="text" placeholder="First Name">
                      <label class="text-700 form-icon-label" for="firstName">FIRST NAME</label>
                    </div>
                        <span class="fa-solid fa-user text-900 fs--1 form-icon"></span>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-icon-container">
                    <div class="form-floating">
                      <input value="{{$data->lastName}}" 
                      name="lastName" class="form-control form-icon-input"
                       id="lastName" type="text" placeholder="Last Name">
                       <label class="text-700 form-icon-label" for="lastName">LAST NAME</label></div>
                        <span class="fa-solid fa-user text-900 fs--1 form-icon"></span>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-icon-container">
                    <div class="form-floating">
                      <input value="{{$data->email}}" name="email" disabled 
                      class="form-control form-icon-input" id="emailSocial" 
                      type="email" placeholder="Email">
                      <label class="text-700 form-icon-label" for="emailSocial">ENTER YOUR EMAIL</label>
                    </div>
                      <span class="fa-solid fa-envelope text-900 fs--1 form-icon"></span> 
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-icon-container">
                    <div class="form-floating">
                      <input value="{{$data->tel}}" name="tel" 
                      class="form-control form-icon-input" id="phone" 
                      type="tel" placeholder="Phone">
                      <label class="text-700 form-icon-label" for="phone">ENTER YOUR PHONE</label>
                    </div>
                      <span class="fa-solid fa-phone text-900 fs--1 form-icon"></span> 
                  </div>
                </div>
                
              </div>
            </div>
            <div class="row gx-3 mb-6 gy-6 gy-sm-3">
              
              <div class="col-12 col-sm-6">
                <h4 class="mb-4">Change Password</h4>
                <div class="form-icon-container mb-3">
                  <div class="form-floating">
                    <input name="oldPassword" class="form-control form-icon-input"
                     id="oldPassword" type="password" placeholder="Old password">
                     <label class="text-700 form-icon-label" for="oldPassword">Old Password</label>
                    </div>
                    <span class="fa-solid fa-lock text-900 fs--1 form-icon"></span> 
                </div>
                <div class="form-icon-container mb-3">
                  <div class="form-floating">
                    <input name="newPassword" class="form-control form-icon-input"
                     id="newPassword" type="password" placeholder="New password">
                     <label class="text-700 form-icon-label" for="newPassword">New Password</label></div>
                    <span class="fa-solid fa-key text-900 fs--1 form-icon"></span>
                </div>
                <div class="form-icon-container">
                  <div class="form-floating">
                    <input name="confirmednewpassword" class="form-control form-icon-input"
                     id="newPassword2" type="password" placeholder="Confirm New password">
                     <label class="text-700 form-icon-label" for="newPassword2">Confirm New Password</label></div>
                    <span class="fa-solid fa-key text-900 fs--1 form-icon"></span>
                </div>
              </div>
            </div>
            
            <div class="text-end mb-6">
              <div><button class="btn btn-phoenix-primary">Save Information</button></div>
            </div>
          </div>
          
        <div>
          </div></div>
        </form>
      </div>
      
    </div>
  </div>
  
@endsection 