@extends('Temp')
@section('cont')
<div class="content">
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">List Task</li>
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
  @if (session()->has("error"))
  <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
    <span class="fas fa-times-circle text-danger fs-3 me-3"></span>
    <p class="mb-0 flex-1">{{session("error")}}</p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
    <div class="mb-9">
        <div id="projectSummary" data-list="{&quot;valueNames&quot;:[&quot;projectName&quot;,&quot;assigness&quot;,&quot;start&quot;,&quot;deadline&quot;,&quot;task&quot;,&quot;projectprogress&quot;,&quot;status&quot;,&quot;action&quot;],&quot;page&quot;:6,&quot;pagination&quot;:true}">
        <div class="row mb-4 gx-6 gy-3 align-items-center">
            <div class="col-auto">
            <h2 class="mb-0">Task<span class="fw-normal text-700 ms-3">({{$data['count']}})</span></h2>
          </div>
          @if (auth()->user()->role!='employee')
                        <div class="col-auto"><a class="btn btn-primary px-5" href="{{route('task.create')}}" ><i class="fa-solid fa-plus me-2"></i> Add new Task</a></div>
          @endif
        </div>
        <div class="row g-3 justify-content-between align-items-end mb-4">
          <div class="col-12 col-sm-auto">
            <div class="d-flex align-items-center">
              <div class="search-box me-3">
                <form method="GET" class="position-relative" action="{{route('task.all')}}">
                    @csrf
                    <div class="d-flex">
                      <input name='search' value="{{$data['old']}}" class="form-control" type="text" placeholder="Search task" > 
                      <button class="btn btn-phoenix-info mb-1" type="submit">Search</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive scrollbar">
          <table class="table fs--1 mb-0 border-top border-200">
            <thead>
              <tr>
                <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">TASK NAME</th>
                @if (auth()->user()->role==="admin")
                <th class="sort align-middle ps-3" scope="col" data- style="width:10%;">MANAGER</th>
                @endif
                @if (auth()->user()->role!='employee')
                                    <th class="sort align-middle ps-3" scope="col"  style="width:10%;text-align: center;">EMPLOYEE</th>

                @endif
                <th class="sort align-middle ps-3" scope="col"  style="width:12%;text-align: center;">STARTING DATE</th>
                <th class="sort align-middle ps-3" scope="col"  style="width:15%;text-align: center;">EXPIRY DATE</th>
                <th class="sort align-middle ps-3" scope="col"  style="width:12%;text-align: center;">Projet</th>
                <th class="sort align-middle ps-3" scope="col"  style="width:5%;text-align: center;">Priority</th>
                <th class="sort align-middle text-end" scope="col"  style="width:10%;text-align: center;Urgent">STATUS</th>
                @if (auth()->user()->role!='employee')
                                    <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                @endif
              </tr>
            </thead>
            <tbody class="list" id="project-list-table-body">
                @foreach ($data['task'] as $item)<tr class="position-static">
                @if (auth()->user()->role!='employee')
                <td class="align-middle time white-space-nowrap ps-0 projectName py-4">
                <a class="fw-bold fs-0" href="{{route('task.show',['id'=>$item->id])}}">{{$item->name}}</a>
            </td>
            @else
            
            <td class="align-middle time white-space-nowrap ps-0 projectName py-4">
              <p class="fw-bold fs-0">{{$item->name}}</p>
          </td>
            @endif
            @if (auth()->user()->role==="admin")
                <td class="align-middle white-space-nowrap assigness ps-3 py-4">
                  <div class="avatar-group avatar-group-dense">
                    <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="{{route('user.show',['id'=>$item->manager->id])}}" >
                      <div class="avatar avatar-s  rounded-circle">
                        <img class="rounded-circle"
                        title="{{$item->manager->firstName.' '.$item->manager->lastName}}"
                        src="{{(!(is_null($item->manager->image) || empty($item->manager->image)))?asset("storage/".$item->manager->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                      </div>
                    </a>
                  </div>
                </td>
                @endif
                @if (auth()->user()->role !== 'employee')
                <td class="align-middle white-space-nowrap assigness ps-3 py-4">
                  @if ($item->emp_id)
                    <div class="avatar-group avatar-group-dense">
                      <a class="dropdown-toggle dropdown-caret-none d-inline-block" style="margin: auto" href="{{ route('user.show',['id'=>$item->employee->id]) }}">
                        <div class="avatar avatar-s rounded-circle">
                          <img class="rounded-circle" title="{{ $item->employee->firstName.' '.$item->employee->lastName }}" src="{{ (!(is_null($item->employee->image) || empty($item->employee->image))) ? asset("storage/".$item->employee->image) : asset("storage/logos/inconnue.jpeg") }}" alt="">
                        </div>
                      </a>
                    </div>
                  @else
                    <div class="avatar-group avatar-group-dense">
                      <span class="dropdown-toggle dropdown-caret-none d-inline-block" style="margin: auto">
                        <div class="avatar avatar-s rounded-circle">
                          <button data-bs-toggle="modal" data-bs-target="#verticallyCentered" style="border: none; background: #95969670; font-weight: bold; font-size: large; width: 28px; height: 29px;" class="rounded-circle">+</button>
                        </div>
                      </span>
                    </div>
                    <div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="verticallyCenteredModalLabel">Select Employee</h5>
                            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close">
                              <span class="fas fa-times fs--1"></span>
                            </button>
                          </div>
                          <form action="{{route('task.edit.emp',['id'=>$item->id])}}" method="post">
                            @csrf
                          <div class="modal-body">
                            <h6>Select employee</h6>
                            <select name="id_emp" class="form-select" id="organizerMultiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                              <option value="" disabled selected>Add employee</option>
                              @foreach ($data['emp'] as $employee)
                              @if ($employee->user_id==$item->man_id)
                              <option value="{{ $employee->id }}">{{ $employee->firstName . ' ' . $employee->lastName }}</option>
                              @endif
                              @endforeach
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Okay</button>

                            <button class="btn btn-outline-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                          </div></form>
                        </div>
                      </div>
                    </div>
                  @endif
                </td>
              @endif  

                <td class="align-middle white-space-nowrap start ps-3 py-4">
                  <p style="margin: auto;text-align: center;"  class="mb-0 fs--1 text-900">{{$item->date_deb}}</p>
                </td>
                <td class="align-middle white-space-nowrap deadline ps-3 py-4">
                  <p style="margin: auto;text-align: center;"  class="mb-0 fs--1 text-900">{{$item->date_fin}}</p>
                </td>
                <td class="align-middle white-space-nowrap task ps-3 py-4">
                  <p style="margin: auto;text-align: center;"  class="fw-bo text-900 fs--1 mb-0">{{$item->project->nom}}</p>
                </td>
                <td  class="align-middle white-space-nowrap text-end statuses" >
                  @if ($item->prio==0)
                  <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-secondary">little</span>
                  @else
                    @if ($item->prio==1)
                    <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-warning">medium</span>
                      @else
                      @if ($item->prio==2)
                      <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-danger">Urgent</span>
                       @endif
                          @endif
                  @endif
                </td>
                <td class="align-middle white-space-nowrap text-end statuses">
                    @if ($item->etat=='new')
                    <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-primary">new</span>
                    @else
                      @if ($item->etat=='completed')
                        <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-success">completed</span>
                        @else
                            @if ($item->etat=='pending')
                            <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-info">ON Pending</span>
                            @else
                            <span class="badge badge-phoenix fs--2 mb-4 badge-phoenix-secondary">Cancelled</span>
                            @endif
                            @endif
                    @endif
                </td>
                @if (auth()->user()->role!='employee')
                    <td class="align-middle text-end white-space-nowrap pe-0 action">
                    <div class="font-sans-serif btn-reveal-trigger position-static">
                      <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                        <span class="fas fa-ellipsis-h fs--2"></span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="{{
                          route('task.edit',['id'=>$item->id])
                          }}">Update</a>
                          @if ($item->emp_id)
                          <form method="POST" action="{{route('task.detach',['id'=>$item->id])}}" >@csrf<button class="dropdown-item text-warning" >separate</button></form>
                          @endif
                            <div class="dropdown-divider">
                              
                          </div><form method="POST" action="{{route('task.delete',['id'=>$item->id])}}" >@csrf<button class="dropdown-item text-danger" >Remove</button></form>
                      </div>
                    </div>
                    </td>
                @endif
                
                    </tr>
                @endforeach
                </tbody>
          </table>
        </div>
        
      </div>{{$data['task']->links('pagination::bootstrap-5')}}
    </div>
  </div>

@endsection