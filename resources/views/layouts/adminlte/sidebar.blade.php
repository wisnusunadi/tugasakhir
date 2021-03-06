<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('/assets/image/recruitment.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Recruitment</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar user panel (optional) -->
      @if(Auth::user())
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('/assets/image/unknown.jpg')}}" class="img-circle elevation-2" alt="{{Auth::user()->nama}}">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->nama}}</a>
        </div>
      </div>
      @endif

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          @if(Auth::user())
          @if(Auth::user()->role == "admin")
          <li class="nav-item">
            <a href="/home" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
              <i class="nav-icon fa fa-home"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/jadwal/show" class="nav-link {{ (request()->is('jadwal*')) ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-calendar"></i>
              <p>
                Jadwal
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/draft_soal/show" class="nav-link {{ (request()->is('draft_soal*')) ? 'active' : '' }}">
              <i class=" nav-icon fa-regular fa-file-lines"></i>
              <p>
                Draft Soal
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/peserta" class="nav-link  {{ (request()->is('peserta*')) ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-users"></i>
              <p>
                Daftar Peserta
              </p>
            </a>
          </li>
          @else

        {{-- if session --}}
          @if (session()->has('waktu')) {
        @else
        <li class="nav-item">
            <a href="/soal_tes/preview" class="nav-link {{ (request()->is('soal_tes*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Mulai Tes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/jadwal/show" class="nav-link  {{ (request()->is('jadwal*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Jadwal Recruitment
              </p>
            </a>
          </li>
        @endif
   {{----}}

          @endif

          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                <p>Log Out</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </li>

          @else
          <li class="nav-item">
            <a href="/soal_tes/preview" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Mulai Tes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/jadwal/show" class="nav-link   {{ (request()->is('jadwal*')) ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Jadwal Recruitment
              </p>
            </a>
          </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">

    </div>

    <!-- /.sidebar-menu -->
  <!-- /.sidebar -->
</aside>
