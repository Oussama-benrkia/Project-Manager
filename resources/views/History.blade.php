@extends('Temp')
@section('cont')
<div class="content">
   
    <div class="mb-9">
        <div id="projectSummary" data-list="{&quot;valueNames&quot;:[&quot;projectName&quot;,&quot;assigness&quot;,&quot;start&quot;,&quot;deadline&quot;,&quot;task&quot;,&quot;projectprogress&quot;,&quot;status&quot;,&quot;action&quot;],&quot;page&quot;:6,&quot;pagination&quot;:true}">

          <div class="row mb-4 gx-6 gy-3 align-items-center">
            <div class="col-auto">
              <h2 class="mb-0">History <span class="fw-normal text-700 ms-3">Project</span></h2>
            </div>
          </div>
        
    

        <div class="table-responsive scrollbar">
          @if (count($data)>0)
          <table class="table fs--1 mb-0 border-top border-200">
            <thead>
              <tr>
                <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="projectName" style="width:30%;">Action</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="assigness" style="width:10%;">User</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">project</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Date</th>
                <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">Time</th>
      
              </tr>
            </thead>
            <tbody class="list" id="project-list-table-body">
              @foreach ($data as $item)
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
              <td class="align-middle time white-space-nowrap ps-0 projectName py-4">
                <a class="fw-bold fs-0" href="{{route('project.show',['id'=>$item['project']['id']])}}">{{$item['project']['name']}}</a>
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
          {{ $hist->links('pagination::bootstrap-5') }}

          @else
            <p>No History</p>
          @endif
      
        </div>
      </div>
    </div>
  </div>
@endsection