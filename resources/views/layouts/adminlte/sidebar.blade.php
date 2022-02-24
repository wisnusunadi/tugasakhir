<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('/assets/image/recruitment.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Recruitment</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @if(Auth::user())
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="" class="img-circle elevation-2" alt="">
        </div>
        <div class="info">
          <a href="#" class="d-block"></a>
        </div>
      </div>
      @endif
 
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="/soal_tes" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Mulai Tes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/jadwal" class="nav-link">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Jadwal Recruitment
              </p>
            </a>
          </li>
          @if(Auth::user())
          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Daftar Peserta
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a title="logout" class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i>
                <p>Log Out</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
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