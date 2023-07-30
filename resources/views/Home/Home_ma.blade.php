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
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-books text-primary-500"></span>
              <div class="ms-2">
                <div class="d-flex align-items-end">
                  <h2 class="mb-0 me-2">{{$data['count']['prj']}}</h2><span class="fs-1 fw-semi-bold text-900">Projects</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-users-alt text-success-500"></span>
              <div class="ms-2">
                <div class="d-flex align-items-end">
                  <h2 class="mb-0 me-2">{{$data['count']['user']}}</h2><span class="fs-1 fw-semi-bold text-900">Employee</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
            <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice text-warning-500"></span>
              <div class="ms-2">
                <div class="d-flex align-items-end">
                  <h2 class="mb-0 me-2">{{$data['count']['task']}}</h2><span class="fs-1 fw-semi-bold text-900">Task</span>
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>


    <div class="col-12 col-md-6" style="float: left;">
      <div class="card h-100">
          <div class="card-body">
            <div class="mb-7">
                <h4 class="mb-4">new projet <span class="text-700 fw-normal fs-2"></span></h4>
                @foreach ($data['data'] as $item)
                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-200 py-3 gx-0 border-top">
                  <div class="col-12 col-lg-auto flex-1">
                    <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-1">
                      <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                        <label class="form-check-label mb-0 fs-0 me-2 line-clamp-1" for="checkbox-todo-0">{{$item->nom}}</label>
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
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-lg-auto">
                    <div class="d-flex ms-4 lh-1 align-items-center">
                      <p class="text-700 fs--2 mb-md-0 me-2 me-lg-3 mb-0">{{$item->date_deb}}</p>
                      <div class="d-none d-lg-block end-0 position-absolute" style="top: 23%;">
                        <div class="hover-actions end-0">
                          <a class="btn btn-phoenix-secondary btn-icon me-1 fs--2 text-900 px-0 me-1" href="{{route('project.edit',['id'=>$item->id])}}">
                            <span class="fas fa-edit"></span>
                          </a>
                        </div>
                      </div>
                      <div class="hover-lg-hide">
                        <p class="text-700 fs--2 ps-lg-3 border-start-lg border-300 fw-bold mb-md-0 mb-0">{{$item->date_fin}}</p>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
    
  </div>
  <div class="col-12 col-md-6" style="float: left;">
    <div class="card h-100">
        <div class="card-body">
          <div class="mb-7">
            <h3 class="text-1100 text-nowrap">Task</h3>
            <div class="d-flex align-items-center justify-content-between">
              <p class="mb-0 fw-bold"></p>
              <p class="mb-0 fs--1">Total count <span class="fw-bold">{{$data['count']['task']}}</span></p>
            </div>
            <hr class="bg-200 mb-2 mt-2">
            <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-info-300 bullet-item me-2"></span>
              <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">New</p>
              <h5 class="mb-0 text-900">{{$data['task_count']['new']}}</h5>
            </div>
            <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-warning-300 bullet-item me-2"></span>
              <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">On pending</p>
              <h5 class="mb-0 text-900">{{$data['task_count']['pend']}}</h5>
            </div>
            <div class="d-flex align-items-center mb-1">
              <span class="d-inline-block bg-success-300 bullet-item me-2"></span>
              <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">Completed</p>
              <h5 class="mb-0 text-900">{{$data['task_count']['comp']}}</h5>
            </div>
            <div class="d-flex align-items-center mb-1">
              <span class="d-inline-block bg-danger-300 bullet-item me-2"></span>
              <p class="mb-0 fw-semi-bold text-900 lh-sm flex-1">Cancelled</p>
              <h5 class="mb-0 text-900">{{$data['task_count']['can']}}</h5>
            </div>
            <a href="{{route('task.all')}}" class="btn btn-outline-primary mt-5">See Details<span class="fas fa-angle-right ms-2 fs--2 text-center"></span></a>
          </div>
        </div>
      </div>
    </div>

</div>
  