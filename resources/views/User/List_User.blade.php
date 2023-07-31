@extends('Temp')
@section('cont')
<div class="content">
  @if (session()->has("message"))
  <div class="alert alert-outline-success d-flex align-items-center" role="alert">
    <span class="fas fa-check-circle text-success fs-3 me-3"></span>
    <p class="mb-0 flex-1">        {{session("message")}}
    </p>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#!">Home</a></li>
        <li class="breadcrumb-item active">List User</li>
      </ol>
    </nav>

    <h2 class="text-bold text-1100 mb-5">@if (auth()->user()->role=='admin')
      user
      @else
      employee
      @endif
      <span class="fw-normal text-700 ms-3">({{$alldata}})</span></h2>
    <div id="members" data-list="{&quot;valueNames&quot;:[&quot;customer&quot;,&quot;email&quot;,&quot;mobile_number&quot;,&quot;city&quot;,&quot;last_active&quot;,&quot;joined&quot;],&quot;page&quot;:10,&quot;pagination&quot;:true}">
      <div class="row align-items-center justify-content-between g-3 mb-4">
        
        <div class="col col-auto">
        @if (auth()->user()->role=='admin')
        <ul class="nav nav-links mx-n2">
          <li class="nav-item"><a class="nav-link px-2 py-1" aria-current="page" href="{{route('user.all')}}"><span>All</span><span class="text-700 fw-semi-bold">({{$alldata}})</span></a></li>
          <li class="nav-item"><a class="nav-link px-2 py-1" href="{{route('user.all', ['type' => 'employee'])}}"><span>employee</span><span class="text-700 fw-semi-bold">({{$cnt_em}})</span></a></li>
          <li class="nav-item"><a class="nav-link px-2 py-1" href="{{route('user.all', ['type' => 'manager'])}}"><span>manager</span><span class="text-700 fw-semi-bold">({{$cnt_ma}})</span></a></li>
        </ul>              @endif

        </div>
        <div class="col-auto">
          <div class="d-flex align-items-center"><button onclick="window.location.assign('{{route('user.create')}}');" class="btn btn-primary"> <span class="fas fa-plus me-2"></span> Add member</button></div>
        </div>
      </div>
      
        @if (count($data)>0) 
        <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1"> 
        <div class="table-responsive scrollbar ms-n1 ps-1">
        
          <table class="table table-sm fs--1 mb-0">
            <thead>
              <tr>
                <th class="sort align-middle" scope="col" data-sort="customer" style="width:15%; min-width:200px;">User</th>
                <th class="sort align-middle" scope="col" data-sort="email" style="width:15%; min-width:200px;">EMAIL</th>
                <th class="sort align-middle pe-3" scope="col" data-sort="mobile_number" style="width:20%; min-width:200px;">Tel</th>
                @if (auth()->user()->role=='admin')
                <th class="sort align-middle" scope="col" data-sort="Type" style="width:10%;">Type</th>
                @endif
                <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
              </tr>
            </thead>
            <tbody class="list" id="members-table-body"><tr class="hover-actions-trigger btn-reveal-trigger position-static">
                @foreach ($data as $item)
                  <td class="customer align-middle white-space-nowrap">
                    <a class="d-flex align-items-center text-900 text-hover-1000" href="{{route('user.show',['id'=>$item['id']])}}">
                      <div class="avatar avatar-m"><img class="rounded-circle" src="{{(!is_null($item['image']))?asset("storage/".$item['image']):asset("storage/logos/inconnue.jpeg")}}" alt=""></div>
                      <h6 class="mb-0 ms-3 fw-semi-bold">{{$item['firstName'].' '.$item['lastName']}}</h6>
                    </a>
                  </td>
              <td class="email align-middle white-space-nowrap"><a class="fw-semi-bold" href="mailto:{{$item['email']}}">{{$item['email']}}</a></td>
              <td class="mobile_number align-middle white-space-nowrap"><a class="fw-bold text-1100" href="tel:{{$item['tel']}}">{{$item['tel']}}</a></td>
              @if (auth()->user()->role=='admin')
              <td class="city align-middle white-space-nowrap text-900">{{$item['role']}}</td>
              @endif
              <td class="align-middle text-end white-space-nowrap pe-0 action">
                  <div class="font-sans-serif btn-reveal-trigger position-static"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"></path></svg><!-- <span class="fas fa-ellipsis-h fs--2"></span> Font Awesome fontawesome.com --></button>
                    <div class="dropdown-menu dropdown-menu-end py-2">
                      <a class="dropdown-item" href="{{route('user.edit',['id'=>$item['id']])}}">Update</a> 

                      <div class="dropdown-divider"></div>
                      <form action="{{route('user.delete',['id'=>$item['id']])}}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">Remove</button>
                      </form>
                    </div>
                  </div>
                </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        
        </div>
               </div>
        {{$data->links('pagination::bootstrap-5')}}
        @else
          <div class="alert alert-phoenix-primary" role="alert">NO user in app</div>
          @endif

    </div>

  </div>
@endsection