<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Profil -->
    
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>
      <div class="dropdown-menu dropdown-menu dropdown-menu-right">
        <a href="{{ route('profile') }}" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profil
        </a>
        <!-- dark mode toggle -->

        <div class="dropdown-divider"></div>
        
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Abmelden
          </button>
        </form>

        
        
      </div>
  </ul>
</nav>
<!-- /.navbar -->