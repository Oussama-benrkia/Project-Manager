<nav class="navbar navbar-vertical navbar-expand-lg">
    <script>
      var navbarStyle = window.config.config.phoenixNavbarStyle;
      if (navbarStyle && navbarStyle !== 'transparent') {
        document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
      }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
      <!-- scrollbar removed-->
      <div class="navbar-vertical-content">
        <ul class="navbar-nav flex-column" id="navbarVerticalNav">
          <li class="nav-item">
            <!-- parent pages-->
            <div class="nav-item-wrapper">
              <a class="nav-link label-1" href="{{route('home')}}" role="button" data-bs-toggle="" aria-expanded="false">
                <div class="d-flex align-items-center">
                  <span class="nav-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg></span>
                    <span class="nav-link-text-wrapper">
                      <span class="nav-link-text">Home</span>
                    </span>
                  </div>
              </a>
          </div>
          </li>
          
          <li class="nav-item">
            <!-- label-->
            <p class="navbar-vertical-label">Apps</p>
            <hr class="navbar-vertical-line"><!-- parent pages-->
            @if (auth()->user()->role==="employee")

              <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-task" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-task">
                <div class="d-flex align-items-center">
                  <div class="dropdown-indicator-icon"><svg class="svg-inline--fa fa-caret-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path></svg><!-- <span class="fas fa-caret-right"></span> Font Awesome fontawesome.com --></div><span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></span><span class="nav-link-text">Task</span>
                </div>
              </a>
              <div class="parent-wrapper label-1">
                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-task">
                  <li class="collapsed-nav-item-title d-none">Task</li>
                  
                  <li class="nav-item"><a class="nav-link"href="{{route('todo')}}"  data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">To Do</span></div>
                    </a><!-- more inner pages-->
                  </li>
                  <li class="nav-item"><a class="nav-link" href="{{route('task.all')}}" data-bs-toggle="" aria-expanded="false">
                      <div class="d-flex align-items-center"><span class="nav-link-text">List Task</span></div>
                    </a><!-- more inner pages-->
                  </li>
               
                </ul>
              </div>
            </div>       
            @else
            <div class="nav-item-wrapper">
              <a class="nav-link dropdown-indicator label-1" href="#nv-project-management" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-project-management">
                <div class="d-flex align-items-center">
                  <div class="dropdown-indicator-icon">
                    <svg class="svg-inline--fa fa-caret-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
                      <path fill="currentColor" d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path></svg>
                  </div><span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg></span><span class="nav-link-text">Project management</span>
                </div>
              </a>
              <div class="parent-wrapper label-1">
                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-project-management">
                  <li class="collapsed-nav-item-title d-none">Project management</li>
                  <li class="nav-item"><a class="nav-link" href="{{route('project.create')}}" data-bs-toggle="" aria-expanded="false">
                      <div class="d-flex align-items-center"><span class="nav-link-text">Create new</span></div>
                    </a><!-- more inner pages-->
                  </li>
                  
                  <li class="nav-item"><a class="nav-link" href="{{route('project.all')}}" data-bs-toggle="" aria-expanded="false">
                      <div class="d-flex align-items-center"><span class="nav-link-text">Project list </span></div>
                    </a><!-- more inner pages-->
                  </li>
                  @if (auth()->user()->role==="admin")
                  <li class="nav-item"><a class="nav-link" href="{{route('project.trash')}}" >
                    <div class="d-flex align-items-center"><span class="nav-link-text">Trash Projet</span></div>
                  </a><!-- more inner pages-->
                  </li>
                  @endif
                </ul>
              </div>
            </div><!-- parent pages-->
            <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-task" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-task">
                <div class="d-flex align-items-center">
                  <div class="dropdown-indicator-icon"><svg class="svg-inline--fa fa-caret-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path></svg><!-- <span class="fas fa-caret-right"></span> Font Awesome fontawesome.com --></div><span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></span><span class="nav-link-text">Task</span>
                </div>
              </a>
              <div class="parent-wrapper label-1">
                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-task">
                  <li class="collapsed-nav-item-title d-none">Task</li>
                  
                  <li class="nav-item"><a class="nav-link" href="{{route('task.create')}}" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">Create new</span></div>
                    </a><!-- more inner pages-->
                  </li>
                  <li class="nav-item"><a class="nav-link" href="{{route('task.all')}}" data-bs-toggle="" aria-expanded="false">
                      <div class="d-flex align-items-center"><span class="nav-link-text">List Task</span></div>
                    </a><!-- more inner pages-->
                  </li>
                  @if (auth()->user()->role==="admin")
                  <li class="nav-item"><a class="nav-link" href="{{route('task.trash')}}" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">Trash task</span></div>
                  </a><!-- more inner pages-->
                </li>
                  @endif
                </ul>
              </div>
            </div>
            <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-events" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-events">
              <div class="d-flex align-items-center">
                <div class="dropdown-indicator-icon"><svg class="svg-inline--fa fa-caret-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path></svg><!-- <span class="fas fa-caret-right"></span> Font Awesome fontawesome.com --></div><span class="nav-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></span><span class="nav-link-text">User</span>
              </div>
            </a>
            <div class="parent-wrapper label-1">
              <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-events">
                <li class="nav-item"><a class="nav-link" href="{{route('user.create')}}" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">Create User</span></div>
                  </a>
                </li>
             
                <li class="nav-item"><a class="nav-link" href="{{route('user.all')}}" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">List User</span></div>
                  </a>
                </li>
                @if (auth()->user()->role==="admin")
                  <li class="nav-item"><a class="nav-link" href="{{route('user.trash')}}" data-bs-toggle="" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text">User Trash</span></div>
                  </a> </li>
                @endif
              </ul>
              </div>
            </div>
            @if (auth()->user()->role==="admin")
            <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-hist" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-events">
              <div class="d-flex align-items-center">
                <div class="dropdown-indicator-icon">
                  <svg class="svg-inline--fa fa-caret-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M118.6 105.4l128 127.1C252.9 239.6 256 247.8 256 255.1s-3.125 16.38-9.375 22.63l-128 127.1c-9.156 9.156-22.91 11.9-34.88 6.943S64 396.9 64 383.1V128c0-12.94 7.781-24.62 19.75-29.58S109.5 96.23 118.6 105.4z"></path></svg><!-- <span class="fas fa-caret-right"></span> Font Awesome fontawesome.com --></div>
                  <span class="nav-link-icon">
                    <i class="fa-solid fa-clock-rotate-left"></i>               
                     </span>
                  <span class="nav-link-text">History</span>
              </div>
            </a>
            <div class="parent-wrapper label-1">
              <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-hist">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('history.project')}}" data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">history User </span></div>
                  </a> 
                </li>
             
                <li class="nav-item"><a href="{{route('history.task')}}" class="nav-link"  data-bs-toggle="" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-text">History task</span></div>
                  </a>
                </li>
                  <li class="nav-item"><a href="{{route('history.User')}}" class="nav-link" data-bs-toggle="" aria-expanded="false">
                  <div class="d-flex align-items-center"><span class="nav-link-text">History User</span></div>
                  </a> </li>
                
              </ul>
              </div>
            </div>@endif
            @endif
          </li>
        </ul>
      </div>
    </div>
    <div class="navbar-vertical-footer">
      <button class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-0"></span><span class="uil uil-arrow-from-right fs-0"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button></div>
  </nav>