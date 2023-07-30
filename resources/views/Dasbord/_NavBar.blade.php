<nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault">
  <div class="collapse navbar-collapse justify-content-between">
    <div class="navbar-logo">
      <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
      <a class="navbar-brand me-1 me-sm-3" href="{{Route('home')}}">
        <div class="d-flex align-items-center">
          <div class="d-flex align-items-center">
            <p class="logo-text ms-2 d-none d-sm-block">TO DO</p>
          </div>
        </div>
      </a>
    </div>
    
    <ul class="navbar-nav navbar-nav-icons flex-row">
      
      
      
      <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-l ">
            <img class="rounded-circle " src="{{(!is_null(auth()->user()->image))?asset("storage/".auth()->user()->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
          <div class="card position-relative border-0">
            <div class="card-body p-0">
              <div class="text-center pt-4 pb-3">
                <div class="avatar avatar-xl ">
                  <img class="rounded-circle " src="{{(!is_null(auth()->user()->image))?asset("storage/".auth()->user()->image):asset("storage/logos/inconnue.jpeg")}}" alt="">
                </div>
                <h6 class="mt-2 text-black">{{auth()->user()->firstName.' '.auth()->user()->lastName}}</h6>
              </div>

            <div class="overflow-auto scrollbar" style="border: none">
              <ul class="nav d-flex flex-column mb-2 pb-1">
                <li class="nav-item"><a class="nav-link px-3" href="{{route('profile')}}"> <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user me-2 text-900"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg><span>Profile</span></a></li>
              </ul>
              <div class="px-3"><form method="POST" action="{{route('logout')}}">@csrf <button class="btn btn-phoenix-secondary d-flex flex-center w-100"> <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out me-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Sign out</button></form></div>
            </div>
              <div class="my-2 text-center fw-bold fs--2 text-600"></div>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>