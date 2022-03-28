<style>
  .sidebar-open #sidebar-overlay {
    display: block;
  }

  .sidebar-collapse #sidebar-overlay {
    display: none;
  }

  #split-bar {
    height: 100%;
    float: right;
    opacity: 0;
    width: 4px;
    cursor: col-resize;
  }

  .nav-link.hover {
    background-color: rgba(255, 255, 255, .1);
    color: #fff;
  }

  /* .selected-link {
    background-color: cyan !important;
  } */

  .selected-link {
    background-color: #007bff !important;
    color: #fff !important;
  }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div id="split-bar"></div>
  <!-- Brand Logo -->
  <a href="javascript:void(0)" class="brand-link">
    <img src="{{ asset('dist/img/taslogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Trucking TAS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('dist/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="javascript:void(0)" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group">
        <input id="search" class="form-control form-control-sidebar" onpaste="return false;" placeholder="Search">
        <div class="input-group-append">
          <label class="btn btn-sidebar" onclick="return false;">
            <i class="fas fa-search fa-fw"></i>
          </label>
        </div>
      </div>
    </div>
    <!-- Sidebar Menu -->

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        {!! \App\Helpers\Menu::printRecursiveMenu($sqlmenu) !!}
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>