<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div id="split-bar"></div>
    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="brand-link">
        <img src="<?= base_url('assets') ?>/images/taslogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Trucking TAS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('assets') ?>/images/user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block">Admin</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
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
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <?php
                $sub = "";
                $plain = "";
                $n = 0;
                // echo json_encode($sqlmenu);
                // exit;
                foreach ($sqlmenu as $data) {
                    $n++;
                    $x = print_recursive_list($data['child']);
                    $menuexe = $data['menuexe'] == "0" ? "#" : base_url() . '/' . $data['menuexe'];
                    // $menuexe = $data['link']!=''?$data['link']:$menuexe;
                    if ($x != "") {
                ?>

                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link" id="<?= $data['menukode'] ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    <?php echo $data['menuno'] ?>. <?php echo $data['menuname'] ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php echo print_recursive_list($data['child']); ?>
                            </ul>
                        </li>

                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="<?= $menuexe ?>" class="nav-link" id="<?= $data['menukode'] ?>">
                                <i class="nav-icon <?= $data['menuname'] == 'Home' ? 'fa-icon-list-alt' : 'fas fa-sign-out-alt' ?>"></i>
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