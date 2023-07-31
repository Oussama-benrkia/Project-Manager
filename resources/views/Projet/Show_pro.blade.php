@extends('Temp')
@section('cont')
<div class="content px-0 pt-9">
  <div class="row g-0">
    <div class="col-12 col-xxl-8 px-0 bg-soft">
      <div class="px-4 px-lg-6 pt-6 pb-9">
        <div class="mb-5">
          <div class="d-flex justify-content-between">
            <h2 class="text-black fw-bolder mb-2">{{$data->nom}}</h2>

            <div class="font-sans-serif btn-reveal-trigger position-static">
              <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                <span class="fas fa-ellipsis-h fs--2"></span>
              </button>
              <div class="dropdown-menu dropdown-menu-end py-2">
                <a class="dropdown-item" href="{{
                  route('task.create',['id'=>$data->id])
                  }}">Add Task</a>
                <a class="dropdown-item" href="{{
                  route('project.edit',['id'=>$data->id])
                  }}">Update</a>

                    <div class="dropdown-divider">
                    
                  </div><form method="POST" action="{{route('project.delete',['id'=>$data->id])}}" >@csrf<button class="dropdown-item text-danger" >Remove</button></form>
              </div>
            </div>
          </div>
          @if ($data->etat=='new')
          <span class="badge badge-phoenix fs--2 badge-phoenix-primary">new</span>
          @else
            @if ($data->etat=='completed')
              <span class="badge badge-phoenix fs--2 badge-phoenix-success">completed</span>
              @else
                  @if ($data->etat=='pending')
                  <span class="badge badge-phoenix fs--2 badge-phoenix-info">ON Pending</span>
                  @else
                  <span class="badge badge-phoenix fs--2  badge-phoenix-secondary">Cancelled</span>
                  @endif
                  @endif
          @endif
        </div>
        <div class="row gx-0 gx-sm-5 gy-8 mb-8">
          <div class="col-12 col-xl-3 col-xxl-4 pe-xl-0">
            <div class="mb-4 mb-xl-7">
              <div class="row gx-0 gx-sm-7">
                <div class="col-12 col-sm-auto">
                  <table class="lh-sm mb-4 mb-sm-0 mb-xl-4">
                    <tbody>
                      
                      <tr>
                        <td class="align-top py-1">
                          <div class="d-flex"><span class="fa-solid fa-user me-2 text-700 fs--1"></span>
                            <h5 class="text-900 mb-0 text-nowrap">Manager</h5>
                          </div>
                        </td>
                        <td class="ps-1 py-1"><a class="fw-semi-bold d-block lh-sm" href="{{route('user.show',['id'=>$data->user->id])}}">{{$data->user->firstName.' '.$data->user->lastName}}</a></td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                <div class="col-12 col-sm-auto">
                  <table class="lh-sm">
                    <tbody>
                      <tr>
                        <td class="align-top py-1 text-900 text-nowrap fw-bold">Started : </td>
                        <td class="text-600 fw-semi-bold ps-3">{{$data->date_deb}}</td>
                      </tr>
                      <tr>
                        <td class="align-top py-1 text-900 text-nowrap fw-bold">Deadline :</td>
                        <td class="text-600 fw-semi-bold ps-3">{{$data->date_fin}}</td>
                      </tr>
                      <tr>
                        @if ($data->etat!='cancelled')
                        @php
                        $pogr=0;
                        if ($data->tasks()->get()->count()>0){
                          $pogr=round(($data->tasks()->get()->whereIn('etat', ['completed', 'cancelled'])->count()*100)/$data->tasks()->get()->count());
                        }
                        @endphp
                        <td class="align-top py-1 text-900 text-nowrap fw-bold">Progress :</td>
                        <td class="text-primary fw-semi-bold ps-3">{{$pogr}} %</td>
                        @endif
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div>
              <div class="d-flex align-items-center">
                <span class="fa-solid fa-list-check me-2 text-700 fs--1"></span>
                <h5 class="text-1100 mb-0 me-2">{{$data->tasks()->get()->count()}}<span class="text-900 fw-normal ms-2">tasks</span></h5>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-7 col-lg-8 col-xl-5">
            @if ($data->employees()->distinct()->get()->count()>0)
            <h4 class="text-1100 mb-4">Team members</h4>
            @foreach ($data->employees()->distinct()->get() as $item)
            <div class="d-flex mb-8" style='float:left'>
              <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="{{route('user.show',['id'=>$item->id])}}" >
                  <div class="avatar avatar-xl  me-1">
                    <img class="rounded-circle " title='{{$item->firstName.' '.$item->lastName}}'  src="{{(!is_null($item->image))?asset("storage/".$item->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                  </div>
                </a>
              </div>
            </div>
            @endforeach

            @endif
          </div>
        </div>
        @if($data->tasks()->get()->count())
        <div class="col-12 col-xxl-8">
          <div class="mb-6">
            <h3 class="mb-4">Task</h3>
            <div class="border-top border-bottom border-200" id="customerOrdersTable" data-list="{&quot;valueNames&quot;:[&quot;order&quot;,&quot;total&quot;,&quot;payment_status&quot;,&quot;fulfilment_status&quot;,&quot;delivery_type&quot;,&quot;date&quot;],&quot;page&quot;:6,&quot;pagination&quot;:true}">
              <div class="table-responsive scrollbar">
                <table class="table table-sm fs--1 mb-0">
                  <thead>
                    <tr>
                      <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">TASK NAME</th>
                      @if (auth()->user()->role==="admin")
                      <th class="sort align-middle ps-3" scope="col" data- style="width:10%;">MANAGER</th>
                      @endif
                      <th class="sort align-middle ps-3" scope="col"  style="width:10%;text-align: center;">EMPLOYEE</th>
                      <th class="sort align-middle ps-3" scope="col"  style="width:12%;text-align: center;">STARTING DATE</th>
                      <th class="sort align-middle ps-3" scope="col"  style="width:15%;text-align: center;">EXPIRY DATE</th>
                      <th class="sort align-middle ps-3" scope="col"  style="width:5%;text-align: center;">Urgent</th>
                      <th class="sort align-middle text-end" scope="col"  style="width:10%;text-align: center;Urgent">STATUS</th>
                      <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
                    </tr>
                  </thead>
                  <tbody class="list" id="customer-order-table-body">
                  @foreach ($data->tasks()->paginate(8) as $item)
                <td class="align-middle time white-space-nowrap ps-0 projectName py-4">
                    <a class="fw-bold fs-0" href="{{route('task.show',['id'=>$item->id])}}">{{$item->name}}</a>
                </td>
                @if (auth()->user()->role==="admin")
                <td class="align-middle white-space-nowrap assigness ps-3 py-4">
                  <div class="avatar-group avatar-group-dense">
                    <a class="dropdown-toggle dropdown-caret-none d-inline-block" href="{{route('user.edit',['id'=>$item->manager->id])}}" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                      <div class="avatar avatar-s  rounded-circle">
                        <img class="rounded-circle "
                        title="{{$item->manager->firstName.' '.$item->manager->lastName}}"
                        src="{{(!is_null($item->manager->image))?asset("storage/".$item->manager->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                      </div>
                    </a>
                  </div>
                </td>
                @endif

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
                              @foreach ($emp as $employee)
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
                <td class="align-middle white-space-nowrap start ps-3 py-4">
                  <p style="margin: auto;text-align: center;"  class="mb-0 fs--1 text-900">{{$item->date_deb}}</p>
                </td>
                <td class="align-middle white-space-nowrap deadline ps-3 py-4">
                  <p style="margin: auto;text-align: center;"  class="mb-0 fs--1 text-900">{{$item->date_fin}}</p>
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
                            <span class="badge badge-phoenix fs--2 mb-4  badge-phoenix-secondary">Cancelled</span>
                            @endif
                            @endif
                    @endif
                </td>
                <td class="align-middle text-end white-space-nowrap pe-0 action">
                    <div class="font-sans-serif btn-reveal-trigger position-static">
                    <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path></svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com --></button>
                    <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="{{
                        route('task.edit',['id'=>$item->id])
                    }}">Update</a>
                     @if ($item->emp_id)
                     <form method="POST" action="{{route('task.detach',['id'=>$item->id])}}" >@csrf<button class="dropdown-item text-warning" >separate</button></form>
                     @endif
                        <div class="dropdown-divider"></div><form method="POST" action="{{route('task.delete',['id'=>$item->id])}}" >@csrf<button class="dropdown-item text-danger" >Remove</button></form>
                    </div>
                    </div>
                    </td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
              </div>            </div>
              {{$data->tasks()->paginate(8)->links('pagination::bootstrap-5')}}


          </div>
        </div>
        @endif

        <h3 class="text-1100 mb-4">description</h3>
        <p class="text-800 mb-4">{{$data->desc}}</p>
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
                        <span class="badge badge-phoenix fs--2 badge-phoenix-success">created</span>
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
</div>
@endsection
