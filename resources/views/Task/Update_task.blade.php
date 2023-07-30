@extends('Temp')
@section('cont')
<div class="content">
  <nav class="mb-2" aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{route('task.all')}}">Task List</a></li>
      @if ($redirect==1)
      <li class="breadcrumb-item"><a href="{{route('task.show',['id'=>$data['task']->id])}}">Task detail</a></li>
      @endif
      <li class="breadcrumb-item active">Update Task</li>
    </ol>
  </nav>
  @if (session()->has("success"))
  <div class="alert alert-outline-success d-flex align-items-center" role="alert">
    <span class="fas fa-check-circle text-success fs-3 me-3"></span>
    <p class="mb-0 flex-1">{{session("success")}}
    </p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
  <h2 class="mb-4">Update a Task</h2>
  <div class="row">
    <div class="col-xl-9">
      @include('Task.Update.Upd_task_ma')
    </div>
</div>
</div>

@endsection