@extends('Temp')
@section('cont')
<div class="content">
  <nav class="mb-2" aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item active">Create User</li>
    </ol>
  </nav>
  <h2 class="mb-4">Create a User</h2>
  <div class="row">
    <div class="col-xl-9">
@if (auth()->user()->role==="admin")
@include('User.Create.Cre_User_ad')

@else
@include('User.Create.Cre_User_ma')

@endif

</div>
</div>
</div>

@endsection