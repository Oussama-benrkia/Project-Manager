@extends('Temp')
@section('cont')
<div class="content">
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#!">Home</a></li>
        <li class="breadcrumb-item"><a href="#!">List User</a></li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>
    <div class="mb-9">
      <div class="row align-items-center justify-content-between g-3 mb-4">
        <div class="col-auto">
          <h2 class="mb-0">User details</h2>
        </div>
        <div class="col-auto">
          <div class="row g-3">
            <div class="col-auto"><button class="btn btn-phoenix-danger">
                <span class="fa-solid fa-trash-can me-2"></span>
                Delete User</button></div>
          </div>
        </div>
      </div>
      <div class="row g-5">
        <div class="col-12 col-xxl-4">
          <div class="row g-3 g-xxl-0 h-100">
            
            <div class="col-12 col-md-7 col-xxl-12 mb-xxl-3">
              <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between pb-3">
                  <div class="row align-items-center g-5 mb-3 text-center text-sm-start">
                    <div class="col-12 col-sm-auto mb-sm-2">
                      <div class="avatar avatar-5xl"><img class="rounded-circle" src="{{(!is_null($data['image']))?asset("storage/".$data['image']):asset("storage/logos/inconnue.jpeg")}}" alt=""></div>
                    </div>
                    <div class="col-12 col-sm-auto flex-1">
                      <h3>{{$data['firstName'].' '.$data['lastName']}}</h3>
                    </div>
                  </div>
                  <div class="d-flex flex-between-center border-top border-dashed border-300 pt-4">
                    @if ($data->role=='manager')
                    @if (auth()->user()->role=='admin')
                                              <div>
                        <h6>Total project</h6>
                        <p class="fs-1 text-800 mb-0">{{$data->projects()->get()->count()}}</p>
                      </div>
                    
                    <div>
                      <h6>Total task</h6>
                      <p class="fs-1 text-800 mb-0">{{$data->managedTasks()->get()->count()}}</p>
                    </div>
                    @endif

                    @else
                    <div>
                      <h6>Total task</h6>
                      <p class="fs-1 text-800 mb-0">{{$data->assignedTasks()->get()->count()}}</p>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div><div class="col-12 col-md-5 col-xxl-12 mb-xxl-3">
              <div class="card h-100">
                <div class="card-body pb-3">
                  <div class="d-flex align-items-center mb-3">
                    <h3 class="me-1">Update</h3>
                    <a href="{{route('user.edit',['id'=>$data->id])}}" class="btn btn-link p-0">
                         <span class="fas fa-pen fs-0 ms-3 text-500"></span></a>
                  </div>
                  <div class="mb-3">
                    <h5 class="text-800">Email</h5><a href="mailto:{{$data['email']}}">{{$data['email']}}</a>
                  </div>
                  <h5 class="text-800">Phone</h5><a class="text-800" href="tel:{{$data['tel']}}">{{$data['tel']}}</a>
                </div>
              </div>
            </div>
            
          </div>
        </div>    
        </div>
        @if (auth()->user()->role=="admin")
        @if ($data->role=='manager')
        <div style="float: left">
          <div class="d-flex align-items-center">
             <span class="fa-solid fa-list-check me-2 text-700 fs--1"></span>
            <h5 class="text-1100 mb-0 me-2">{{$data->managedTasks()->get()->count()}}<span class="text-900 fw-normal ms-2">tasks</span>
            </h5><a class="fw-bold fs--1 mt-1" href="{{route('task.all',['id_m'=>$data->id])}}">See tasks <span class="fa-solid fa-chevron-right me-2 fs--2"></span> </a>
          </div>
        </div> 
        <div style="float: left">
          <div class="d-flex align-items-center">
             <span class="fas fa-paperclip me-1"></span>
            <h5 class="text-1100 mb-0 me-2">{{$data->projects()->get()->count()}}<span class="text-900 fw-normal ms-2">Project</span>
            </h5><a class="fw-bold fs--1 mt-1" href="{{route('project.all',['id_u'=>$data->id])}}">See tasks <span class="fa-solid fa-chevron-right me-2 fs--2"></span> </a>
          </div>
        </div>
        @endif
        @endif

        @if ($data->role=='employee')
        <div style="float: left">
          <div class="d-flex align-items-center">
            <span  class="fa-solid fa-list-check me-2 text-700 fs--1"></span> 
            <h5 class="text-1100 mb-0 me-2">{{$data->assignedTasks()->get()->count()}}<span class="text-900 fw-normal ms-2">tasks</span>
            </h5><a class="fw-bold fs--1 mt-1" href="{{route('task.all',['id_e'=>$data->id])}}">See tasks <span class="fa-solid fa-chevron-right me-2 fs--2"></span> </a>
          </div>
        </div> 
        @endif
        @if (auth()->user()->role=='admin')
            
            <div class="accordion" id="accordionExample">
              <div class="accordion-item border-top border-300">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    History
                  </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseOne" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                  @if (count($his))
                  <table class="table fs--1 mb-0 border-top border-200">
                    <thead>
                      <tr>
                        <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">Action</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">User</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Date</th>
                        <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Time</th>
              
                      </tr>
                    </thead>
                    <tbody class="list" id="project-list-table-body">
                      @foreach ($his as $item)
                      <tr class="position-static">
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                            @if ($item['Action']=='created')
                            <span class="badge badge-phoenix fs--2 badge-phoenix-success">
                                @if ($item['User_action']['id']==$item['User']['id'])
                                    Register
                                @else
                                    created
                                @endif
                            </span>
                            @else
                            @if ($item['Action']=='updated')
                            <span class="badge badge-phoenix fs--2 badge-phoenix-primary">updated</span>
                            @else
                                @if ($item['Action']=='deleted')
                                <span class="badge badge-phoenix fs--2 badge-phoenix-warning">deleted</span>
                                @else
                                <span class="badge badge-phoenix fs--2  badge-phoenix-secondary">restored</span>
                                @endif
                            @endif
                           @endif
                      </td>
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        <div class="avatar-group avatar-group-dense">
                          <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="{{route('user.show',['id'=>$item['User']['id']])}}" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <div class="avatar avatar-s  rounded-circle">
                              <img class="rounded-circle "
                              title="{{$item['User']['name']}}"
                              src="{{(!is_null($item['User']['image']))?asset("storage/".$item['User']['image']):asset("storage/logos/inconnue.jpeg")}}" alt="">
                            </div>
                          </a>
                        </div>
                      </td>
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        <p class="fw-bo text-900 fs--1 mb-0">{{$item['Date']}}</p>
                      </td>
                      <td class="align-middle white-space-nowrap task ps-3 py-4">
                        <p class="fw-bo text-900 fs--1 mb-0">{{$item['Time']}}</p>
                      </td></tr>
                      @endforeach
                        </tbody>
                  </table>
                  @else
                  <div class="accordion-body pt-0">
                    <strong>No History</strong>
                  </div>
                  @endif
                  
                </div>
              </div>
            </div>
          
            @endif
      </div>
    </div>
  </div>
@endsection