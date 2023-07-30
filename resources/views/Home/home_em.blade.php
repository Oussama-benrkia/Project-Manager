@php
    $countco=0;
    $countpe=0;
    $countne=0;
    foreach ($data['count'] as $value) {
      if($value->etat=="new"){
        $countne=$value->tag_count;
      }elseif($value->etat=="completed"){
        $countco=$value->tag_count;
      }elseif ($value->etat=="pending") {
        $countpe=$value->tag_count;
      }
    }
@endphp

<div class="content">
    <div class="row gy-3 mb-6 justify-content-between">
      <div class="col-md-9 col-auto">
        <h2 class="mb-2 text-1100">Home Dashboard</h2>
      </div>
      
    </div>
    <div class="row mb-3 gy-6">
      <div class="col-12 col-xxl-2">
        <div class="row align-items-center g-3 g-xxl-0 h-100 align-content-between">
            <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice text-primary-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2">{{$data['all']}}</h2><span class="fs-1 fw-semi-bold text-900">Task</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">all task </p>
    
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice text-success-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2">{{$countco}}</h2><span class="fs-1 fw-semi-bold text-900">Task</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">completed</p>
    
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice "></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2">{{$countpe}}</h2><span class="fs-1 fw-semi-bold text-900">Task</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">pending</p>
    
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice text-warning-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2">{{$countne}}</h2><span class="fs-1 fw-semi-bold text-900">Task</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">new</p>
                  </div>
                </div>
              </div>
        </div>
      </div>
    
      <div >
        <div class="card h-100">
            <div class="card-body">
              
              <div class="mb-7">
                  <h4 class="mb-4">last task add<span class="text-700 fw-normal fs-2"></span></h4>
                  @foreach ($data['data'] as $item)
                  <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-200 py-3 gx-0 border-top">
                    <div class="col-12 col-lg-auto flex-1">
                      <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-1">
                        <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                          <label class="form-check-label mb-0 fs-0 me-2 line-clamp-1" for="checkbox-todo-0">{{$item->name}}</label>
                          @if ($item->etat=='new')
                          <span class="badge badge-phoenix fs--2 badge-phoenix-primary">New</span>
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
                        </div>
                          
                      </div>
                    </div>
                    <div class="col-12 col-lg-auto">
                      <div class="d-flex ms-4 lh-1 align-items-center">
                        <p class="text-700 fs--2 mb-md-0 me-2 me-lg-3 mb-0">{{date('Y-m-d', strtotime($item->created_at))}}</p>
                        <div >
                          <p class="text-700 fs--2 ps-lg-3 border-start-lg border-300 fw-bold mb-md-0 mb-0">{{date('H:i', strtotime($item->created_at));}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  
                </div>
              </div>
            </div>
      </div>
    
    
  </div>