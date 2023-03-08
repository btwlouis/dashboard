  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('assets/dist/img/logo_b_service.png') }}" alt="Logo" class="brand-image " style="opacity: .8">
      <span class="brand-text font-weight-light">b-service.xyz</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/dist/img/avatar-default.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
          <li class="nav-header">TEAM</li>
          
          <li class="nav-item">
            <!-- dashboard -->
            <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->segment(1) == '') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>


          </li>

           

          <li class="nav-item">
            <!-- tickets -->
            <a href="{{ route('ticket.index') }}" class="nav-link {{ (request()->segment(1) == 'tickets') ? 'active' : '' }}">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>
                Tickets
              </p>
            </a>
          </li>



          <li class="nav-item">
            <!-- profil -->
            <a href="{{ route('profile') }}" class="nav-link {{ (request()->segment(1) == 'profile') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profil
              </p>
            </a>
          </li>



          @can('admin')
          <li class="nav-header">ADMIN</li>

          <li class="nav-item">
            <!-- templates -->
            <a href="{{ route('templates.index') }}" class="nav-link {{ (request()->segment(1) == 'templates') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Vorlagen
              </p>
            </a>
          </li>

          <li class="nav-item">
            <!-- users -->
            <a href="{{ route('user.index') }}" class="nav-link {{ (request()->segment(1) == 'users') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Benutzerverwaltung
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('logs.index') }}" class="nav-link {{ (request()->segment(1) == 'logs') ? 'active' : '' }}">
              <i class="nav-icon fas fa-history"></i>
              <p>
                Protokoll
              </p>
            </a>
          </li>
        @endcan 

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>