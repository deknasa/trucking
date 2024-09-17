<nav class="main-header navbar navbar-expand navbar-white navbar-light nav-compact">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a id="sidebarButton" class="nav-link sidebars" data-widget="pushmenu" data-auto-collapse-size="0" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <img src="{{ asset('libraries/tas-lib/img/taslogo.png') }}" alt="AdminLTE Logo" class="brand-image" style="width: 25px; margin-right: 5px;">
  <strong>TAS {{ (session('cabang') != 'BITUNG-EMKL') ? 'Trucking' : ''; }} System {{ session('cabang') }}</strong>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item mr-3">
      <div class="text-right">
        your ip <span class="d-none d-lg-inline">  address : </span> ({{request()->ip()}}) 
      </div>
    </li>
    <li class="nav-item">
      <div class="datetime-place text-right">
        <span class="date-place"></span>
        <span class="time-place ml-3"></span>
      </div>
    </li>
  </ul>
</nav>