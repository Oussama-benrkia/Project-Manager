@extends('Temp')
@section('cont')
<div class="content">
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('project.all')}}">List project</a></li>
        <li class="breadcrumb-item active">Update project</li>
      </ol>
    </nav>
    <h2 class="mb-4">Update a project</h2>
    <div class="row">
      <div class="col-xl-9">
@if (auth()->user()->role==="admin")
    @include('Projet.Update.Update_pro_ad')
@else
@include('Projet.Update.Update_pro_ma')

@endif
</div>
</div>

</div>
@endsection