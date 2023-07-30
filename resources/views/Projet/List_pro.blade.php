@extends('Temp')
@section('cont')
<div class="content">
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active">List projet</li>
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
            <h2 class="mb-0">Projects<span class="fw-normal text-700 ms-3">({{$count_all}})</span></h2>
          </div>
          <div class="col-auto"><a class="btn btn-primary px-5" href="{{route('project.create')}}" ><i class="fa-solid fa-plus me-2"></i> Add new project</a></div>
        </div>
        <div class="row g-3 justify-content-between align-items-end mb-4">
          <div class="col-12 col-sm-auto">
            <ul class="nav nav-links mx-n2">
              <li class="nav-item"><a class="nav-link px-2 py-1 " aria-current="page" href="{{route('project.all')}}"><span>All</span><span class="text-700 fw-semi-bold">({{$count_all}})</span></a></li>
              <li class="nav-item"><a class="nav-link px-2 py-1" href="{{route('project.all',['etat'=>'cancelled'])}}"><span>Cancelled</span><span class="text-700 fw-semi-bold">({{$count_canc}})</span></a></li>
              <li class="nav-item"><a class="nav-link px-2 py-1" href="{{route('project.all',['etat'=>'completed'])}}"><span>Finished</span><span class="text-700 fw-semi-bold">({{$count_com}})</span></a></li>
              <li class="nav-item"><a class="nav-link px-2 py-1" href="{{route('project.all',['etat'=>'pending'])}}"><span>On Pending</span><span class="text-700 fw-semi-bold">({{$count_pen}})</span></a></li>
              <li class="nav-item"><a class="nav-link px-2 py-1" href="{{route('project.all',['etat'=>'new'])}}"><span>New</span><span class="text-700 fw-semi-bold">({{$count_new}})</span></a></li>

            </ul>
          </div>
          <div class="col-12 col-sm-auto">
            <div class="d-flex align-items-center">
              <div class="search-box me-3">
                <form method="GET" class="position-relative" action="{{route('project.all')}}">
                  @csrf
                  <div class="d-flex">
                    <input name='search' value="{{$old}}" class="form-control" type="text" placeholder="Search task" > 
                    <button class="btn btn-phoenix-info mb-1" type="submit">Search</button>
                  </div>
              </form>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive scrollbar">
          @if (count($data)>0)
          <table class="table fs--1 mb-0 border-top border-200">
            <thead>
              <tr>
                <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">PROJECT NAME</th>
                @if (auth()->user()->role==="admin")
                <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">MANAGER</th>
                @endif
                <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">ASSIGNESS</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">DEADLINE</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="task" style="width:12%;">TASK</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th>
                <th class="sort align-middle text-end" scope="col" data-sort="statuses" style="width:10%;">STATUS</th>
                <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
              </tr>
            </thead>
            <tbody class="list" id="project-list-table-body">
              @foreach ($data as $item)<tr class="position-static">
              <td class="align-middle time white-space-nowrap ps-0 projectName py-4">
                <a class="fw-bold fs-0" href="{{route('project.show',['id'=>$item->id])}}">{{$item->nom}}</a>
            </td>
            @if (auth()->user()->role==="admin")
            <td class="align-middle white-space-nowrap assigness ps-3 py-4">
              <div class="avatar-group avatar-group-dense">
                <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="{{route('user.edit',['id'=>$item->user->id])}}" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  <div class="avatar avatar-s  rounded-circle">
                    <img class="rounded-circle "
                    title="{{$item->user->firstName.' '.$item->user->lastName}}"
                    src="{{(!is_null($item->user->image))?asset("storage/".$item->user->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                  </div>
                </a>
              </div>
            </td>
            @endif
            <td class="align-middle white-space-nowrap assigness ps-3 py-4">
              <div class="avatar-group avatar-group-dense">
                @if ($item->employees()->distinct()->get()->count()>0)
                
                <span class="dropdown-toggle dropdown-caret-none d-inline-block" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                  <div class="avatar avatar-s  rounded-circle">
                    <img class="rounded-circle " 
                    title="{{$item->employees()->distinct()->first()->firstName.' '.$item->employees()->distinct()->first()->lastName}}"
                     src="{{(!is_null($item->employees()->distinct()->first()->image))?asset("storage/".$item->employees()->distinct()->first()->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                  </div>
                </span>
                @if ($item->employees()->distinct()->get()->count()>1)
                <div class="avatar avatar-s  rounded-circle">
                  <div class="avatar-name rounded-circle "><span>+{{$item->employees()->distinct()->get()->count()-1}}</span></div>
                </div>
                @endif
                @else
                <div class="avatar avatar-s  rounded-circle">
                  <p>no one</p>
                </div>
                @endif
               
          </div>
            </td>
            <td class="align-middle white-space-nowrap start ps-3 py-4">
              <p class="mb-0 fs--1 text-900">{{$item->date_deb}}</p>
            </td>
            <td class="align-middle white-space-nowrap deadline ps-3 py-4">
              <p class="mb-0 fs--1 text-900">{{$item->date_fin}}</p>
            </td>
            <td class="align-middle white-space-nowrap task ps-3 py-4">
              <p class="fw-bo text-900 fs--1 mb-0">{{$item->tasks()->get()->count()}}</p>
            </td>
            <td class="align-middle white-space-nowrap ps-3 projectprogress">
              @if ($item->etat!='cancelled')
              @php
              $pogr=0;
              if ($item->tasks()->get()->count()>0){
                $pogr=round(($item->tasks()->get()->whereIn('etat', ['completed', 'cancelled'])->count()*100)/$item->tasks()->get()->count());
              }
          @endphp
              <p class="text-800 fs--2 mb-0">
                {{$pogr}} % / 100%
              </p>
              <div class="progress" style="height:3px;">
                <div class="progress-bar bg-success" style="width: {{$pogr}}%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              @else
              <p class="text-800 fs--2 mb-0" style="text-align: center">
                -
              </p>
              @endif
              
            </td>

            <td class="align-middle white-space-nowrap text-end statuses">
              @if ($item->etat=='new')
              <span class="badge badge-phoenix fs--2 badge-phoenix-primary">new</span>
              @else
                @if ($item->etat=='completed')
                  <span class="badge badge-phoenix fs--2 badge-phoenix-success">completed</span>
                  @else
                      @if ($item->etat=='pending')
                      <span class="badge badge-phoenix fs--2 badge-phoenix-info">ON Pending</span>
                      @else
                      <span class="badge badge-phoenix fs--2  badge-phoenix-secondary">Cancelled</span>
                      @endif
                      @endif
              @endif
            </td>
            
            <td class="align-middle text-end white-space-nowrap pe-0 action">
              <div class="font-sans-serif btn-reveal-trigger position-static"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path></svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com --></button>
                <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="{{
                  route('task.create',['id'=>$item->id])
                }}">Add Task</a>
                <a class="dropdown-item" href="{{
                  route('project.edit',['id'=>$item->id])
                }}">Update</a>
              <div class="dropdown-divider"></div><form method="POST" action="{{route('project.delete',['id'=>$item->id])}}" >@csrf<button class="dropdown-item text-danger" >Remove</button></form>

              </div>
            </td>
          </tr>
              @endforeach
                </tbody>
          </table>
          {{$data->links('pagination::bootstrap-5')}}
          @else
            <p>No project</p>
          @endif

        </div>

        
      </div>
    </div>
  </div>
@endsection