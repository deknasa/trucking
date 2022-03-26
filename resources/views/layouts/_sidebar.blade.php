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

  .selected-link {
    background-color: cyan !important;
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
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
        <?php

        use App\Http\Controllers\MyController;
        use App\Models\Menu;

        $sub = "";
        $plain = "";
        $n = 0;
        $current_menu = Menu::leftJoin('acos', 'menu.aco_id', '=', 'acos.id')
          ->where('acos.class', (new MyController)->class)
          ->first();
        // dd($current_menu->menuparent);
        $get_parent = Menu::where('id', ($current_menu == null ? '' : $current_menu->menuparent))
          ->first();
        // dd($get_parent == null);
        $get_all = Menu::where('id', ($get_parent == null ? '' : $get_parent->menuparent))
          ->first();

        foreach ($sqlmenu as $data) {
          $n++;
          $x = \App\Helpers\Menu::print_recursive_list($data['child']);
          // echo $x !== null ? "asdf" : "assss";
          $menuexe = $data['menuexe'] == "0" ? "#" : $data['menuexe'];
          // $menuexe = $data['link']!=''?$data['link']:$menuexe;
          if ($x !== "") {
        ?>
            <!--  $get_parent->menuparent == $data['menuid'] ? 'menu-is-opening menu-open' : ''  -->
            <!-- dump($get_parent->menuparent == $data['menuid']); -->
            <!-- $get_parent->menuparent == $data['menuid'] ? 'menu-is-opening active' : '' -->
            <!-- ($get_all == null ? 0 : ($get_all->menuparent == $data['menuid'] ? 'true' : 'false')) -->
            <li class="nav-item <?= ($get_all == null ? 0 : ($get_all->id == $data['menuid'] ? 'menu-is-opening menu-open' : '')) ?>">
              <a href="javascript:void(0)" class="nav-link" id="<?= $data['menukode'] ?>">
                <i class="nav-icon <?php echo $data['menuicon'] ?>"></i>
                <p>
                  <?php echo $data['menuno'] ?>. <?php echo $data['menuname'] ?>
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <?php echo \App\Helpers\Menu::print_recursive_list($data['child'], $data['menuname']); ?>
              </ul>
            </li>

          <?php } else { ?>
            <li class="nav-item">
              <a href="<?= $data['menuname'] == 'Home' ? route('dashboard') : route('logout') ?>" class="nav-link" id="<?= $data['menukode'] ?>">
                <i class="nav-icon <?= $data['menuname'] == 'Home' ? 'fas fa-home' : 'fas fa-sign-out-alt' ?>"></i>
                <p>
                  <?php echo $data['menuno'] ?>. <?php echo $data['menuname'] ?>
                </p>
              </a>
            </li>
        <?php
          }
        }
        ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>