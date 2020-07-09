  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light navbar-fixed-top noprint">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="?" class='btn_topbar btn btn-success noprint' title='Refrescar'>
            <i class="fas fa-redo"></i>
            <span class=''> Refrescar</span>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class='btn_topbar btn btn-warning noprint' title='Cerrar' onclick='javascript:window.close();'>
            <i class='far fa-window-close'></i>
            <span class=''> Cerrar</span>
        </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class='btn_topbar btn btn-link noprint' title='Imprimir' onclick='window.print();'>
            <i class="fas fa-print"></i>
        </a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- 
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> 
    -->
    <a href="#" class='btn_topbar btn btn-link' title='Busqueda global' onclick='busqueda_global();'>
      <i class="fas fa-search"></i>
      <span class=''>Busqueda</span>
    </a>

    <?php 
      //Para revisar elementos en caso de ser administrador:
      if ($admin) {
        $htmlAdmin = '
        <a href="../debug/debug_logs.php" target="_blank" class="btn_topbar btn btn-link noprint ">
            <i class="fab fa-dyalog"></i>
            <span class="">ebug</span>
        </a>
        <a href="../debug/debug_reset.php" target="_blank" class="btn_topbar btn btn-link noprint ">
            <i class="fas fa-registered"></i>
            <span>eset</span>
        </a>
        ';
        echo $htmlAdmin;
      }
    ?>

      <a id='btn_empresa' href="../configuracion/empresa_ficha.php" class='btn_topbar btn btn-link noprint' title='Ver ficha Empresa'>
          <i class="fas fa-building"></i>
          <span class=''> <?php echo ucwords($_SESSION["empresa"]); ?> </span>
      </a>
      <span class='noprint '>|</span>
      <a href="../configuracion/usuario_ficha.php" class='btn_topbar btn btn-link noprint' title='Ver ficha Usuario'>
          <i class="far fa-user"></i>
          <span class='' >  
              <?php echo ucwords($_SESSION["user"]); ?>
              <sup class='bg-info small px-1'>
              <?php 
                  // if ($admin AND 0) { echo " (admin)"; } //AND 0 hace que siempre sea falsa la condicion.

                  echo ( 
                          isset($_SESSION['android']) ?
                          (
                              ( 
                                  !empty($_SESSION['android'])) ?
                                  ' android ' :
                                  ' pc ' 
                          ) :
                          ' pc ' 
                      );
              ?>
              </sup>
          </span>
      </a>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 noprint">
    <!-- Brand Logo -->
    <a href="../" class="brand-link">
      <img src="../img/construcloud64.svg" alt="ConstruCloud Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><strong>Constru</strong>Cloud 2.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?php 
        // <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            // <!-- Add icons to the links using the .nav-icon class
            //      with font-awesome or any other icon font library -->
            // <li class="nav-item has-treeview menu-open">
            //   <a href="#" class="nav-link active">
            //     <i class="nav-icon fas fa-tachometer-alt"></i>
            //     <p>
            //       Dashboard
            //       <i class="right fas fa-angle-left"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="./index.html" class="nav-link active">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Dashboard v1</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="./index2.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Dashboard v2</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="./index3.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Dashboard v3</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item">
            //   <a href="pages/widgets.html" class="nav-link">
            //     <i class="nav-icon fas fa-th"></i>
            //     <p>
            //       Widgets
            //       <span class="right badge badge-danger">New</span>
            //     </p>
            //   </a>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-copy"></i>
            //     <p>
            //       Layout Options
            //       <i class="fas fa-angle-left right"></i>
            //       <span class="badge badge-info right">6</span>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/layout/top-nav.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Top Navigation</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Top Navigation + Sidebar</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/layout/boxed.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Boxed</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/layout/fixed-sidebar.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Fixed Sidebar</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/layout/fixed-topnav.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Fixed Navbar</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/layout/fixed-footer.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Fixed Footer</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Collapsed Sidebar</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-chart-pie"></i>
            //     <p>
            //       Charts
            //       <i class="right fas fa-angle-left"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/charts/chartjs.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>ChartJS</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/charts/flot.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Flot</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/charts/inline.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Inline</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-tree"></i>
            //     <p>
            //       UI Elements
            //       <i class="fas fa-angle-left right"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/UI/general.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>General</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/icons.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Icons</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/buttons.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Buttons</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/sliders.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Sliders</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/modals.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Modals & Alerts</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/navbar.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Navbar & Tabs</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/timeline.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Timeline</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/UI/ribbons.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Ribbons</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-edit"></i>
            //     <p>
            //       Forms
            //       <i class="fas fa-angle-left right"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/forms/general.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>General Elements</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/forms/advanced.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Advanced Elements</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/forms/editors.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Editors</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/forms/validation.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Validation</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-table"></i>
            //     <p>
            //       Tables
            //       <i class="fas fa-angle-left right"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/tables/simple.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Simple Tables</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/tables/data.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>DataTables</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/tables/jsgrid.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>jsGrid</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-header">EXAMPLES</li>
            // <li class="nav-item">
            //   <a href="pages/calendar.html" class="nav-link">
            //     <i class="nav-icon far fa-calendar-alt"></i>
            //     <p>
            //       Calendar
            //       <span class="badge badge-info right">2</span>
            //     </p>
            //   </a>
            // </li>
            // <li class="nav-item">
            //   <a href="pages/gallery.html" class="nav-link">
            //     <i class="nav-icon far fa-image"></i>
            //     <p>
            //       Gallery
            //     </p>
            //   </a>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon far fa-envelope"></i>
            //     <p>
            //       Mailbox
            //       <i class="fas fa-angle-left right"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/mailbox/mailbox.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Inbox</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/mailbox/compose.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Compose</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/mailbox/read-mail.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Read</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-book"></i>
            //     <p>
            //       Pages
            //       <i class="fas fa-angle-left right"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/examples/invoice.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Invoice</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/profile.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Profile</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/e-commerce.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>E-commerce</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/projects.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Projects</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/project-add.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Project Add</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/project-edit.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Project Edit</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/project-detail.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Project Detail</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/contacts.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Contacts</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon far fa-plus-square"></i>
            //     <p>
            //       Extras
            //       <i class="fas fa-angle-left right"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="pages/examples/login.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Login</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/register.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Register</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/forgot-password.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Forgot Password</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/recover-password.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Recover Password</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/lockscreen.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Lockscreen</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/legacy-user-menu.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Legacy User Menu</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/language-menu.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Language Menu</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/404.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Error 404</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/500.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Error 500</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/pace.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Pace</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="pages/examples/blank.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Blank Page</p>
            //       </a>
            //     </li>
            //     <li class="nav-item">
            //       <a href="starter.html" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Starter Page</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-header">MISCELLANEOUS</li>
            // <li class="nav-item">
            //   <a href="https://adminlte.io/docs/3.0" class="nav-link">
            //     <i class="nav-icon fas fa-file"></i>
            //     <p>Documentation</p>
            //   </a>
            // </li>
            // <li class="nav-header">MULTI LEVEL EXAMPLE</li>
            // <li class="nav-item">
            //   <a href="#" class="nav-link">
            //     <i class="fas fa-circle nav-icon"></i>
            //     <p>Level 1</p>
            //   </a>
            // </li>
            // <li class="nav-item has-treeview">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon fas fa-circle"></i>
            //     <p>
            //       Level 1
            //       <i class="right fas fa-angle-left"></i>
            //     </p>
            //   </a>
            //   <ul class="nav nav-treeview">
            //     <li class="nav-item">
            //       <a href="#" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Level 2</p>
            //       </a>
            //     </li>
            //     <li class="nav-item has-treeview">
            //       <a href="#" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>
            //           Level 2
            //           <i class="right fas fa-angle-left"></i>
            //         </p>
            //       </a>
            //       <ul class="nav nav-treeview">
            //         <li class="nav-item">
            //           <a href="#" class="nav-link">
            //             <i class="far fa-dot-circle nav-icon"></i>
            //             <p>Level 3</p>
            //           </a>
            //         </li>
            //         <li class="nav-item">
            //           <a href="#" class="nav-link">
            //             <i class="far fa-dot-circle nav-icon"></i>
            //             <p>Level 3</p>
            //           </a>
            //         </li>
            //         <li class="nav-item">
            //           <a href="#" class="nav-link">
            //             <i class="far fa-dot-circle nav-icon"></i>
            //             <p>Level 3</p>
            //           </a>
            //         </li>
            //       </ul>
            //     </li>
            //     <li class="nav-item">
            //       <a href="#" class="nav-link">
            //         <i class="far fa-circle nav-icon"></i>
            //         <p>Level 2</p>
            //       </a>
            //     </li>
            //   </ul>
            // </li>
            // <li class="nav-item">
            //   <a href="#" class="nav-link">
            //     <i class="fas fa-circle nav-icon"></i>
            //     <p>Level 1</p>
            //   </a>
            // </li>
            // <li class="nav-header">LABELS</li>
            // <li class="nav-item">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon far fa-circle text-danger"></i>
            //     <p class="text">Important</p>
            //   </a>
            // </li>
            // <li class="nav-item">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon far fa-circle text-warning"></i>
            //     <p>Warning</p>
            //   </a>
            // </li>
            // <li class="nav-item">
            //   <a href="#" class="nav-link">
            //     <i class="nav-icon far fa-circle text-info"></i>
            //     <p>Informational</p>
            //   </a>
            // </li>
        // </ul>
        ?>
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false"> -->
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="../menu/pagina_inicio.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Inicio
              </p>
            </a>
          </li>

 <?php if($_SESSION["permiso_licitacion"])
       { 
             ?>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <!--<span class="glyphicon glyphicon-calendar nav-icon"></span>-->
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Licitaciones
                <i class="right fas fa-angle-left"></i>
                <span class="badge badge-info right"><?php echo $num_estudios; ?></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../estudios/estudios_calendar.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>" class="nav-link">
                  <span class="glyphicon glyphicon-calendar nav-icon"></span>
                  <p>Calendario Licitaciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../estudios/estudios_buscar.php" class="nav-link">
                  <i class="fas fa-list nav-icon "></i>
                  <p>Listado Licitaciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../estudios/ofertas_clientes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Presupuestos</p>
                </a>
              </li>
            </ul>
          </li> 
<?php
       }
       if($_SESSION["permiso_obras"])
       { 
             ?>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">             
              <span class="glyphicon glyphicon-road nav-icon"></span>
              <p>
                Obras proyectos servicios
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"><?php echo $num_obras; ?></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=OEGA" class="nav-link">
                  <span class="glyphicon glyphicon-road nav-icon"></span>
                  <p>Obras  proyectos servicios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../personal/partes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Partes Diarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../obras/gastos.php?_m=<?php echo $_m; ?>&fecha1=<?php echo $fecha_inicio; ?>" class="nav-link"> 
                  <span class="glyphicon glyphicon-shopping-cart nav-icon"></span>
                  <p>Gastos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../maquinaria/maquinaria_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" class="nav-link">
                  <i class="fas fa-truck-pickup nav-icon"></i>
                  <span class="badge badge-info right"><?php echo $num_maquinaria; ?></span>
                  <p>Maquinaria</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../obras/obras_view.php?_m=<?php echo $_m; ?>&tipo_subcentro=O&fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Gestión Obras</p>
                </a>
              </li>              
            </ul>
          </li>
          
<?php      
       }
        if($_SESSION["permiso_administracion"])
       { 
             ?>
          
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Administración
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Proveedores
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../proveedores/proveedores_buscar.php" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Proveedores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../documentos/doc_upload_multiple_form.php?_m=<?php echo $_m; ?>&tipo_entidad=fra_prov" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Subir fras. proveedores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../proveedores/facturas_proveedores.php?fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Facturas Proveedores <span class="badge badge-info right"><?php echo $num_fras_prov; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&id_proveedor=<?php echo $id_proveedor_auto; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fras prov. no registradas<span class='num_fras_prov_NC badge badge-danger  right' ><?php echo $num_fras_prov_NR; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=0&fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fras prov. no cargadas<span class='num_fras_prov_NC badge badge-danger  right' >...</span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=1&pagada=0&fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fras prov. no pagadas<span class='num_fras_prov_NP badge badge-danger  right' >...</span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='P'&conc=activa=1" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Remesa de Pagos <span class='badge badge-info  right' ><?php echo $num_remesa_pagos; ?></span></p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Clientes
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../clientes/clientes_buscar.php" class="nav-link">
                      <span class="glyphicon glyphicon-briefcase nav-icon"></span>
                      <p>Clientes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Facturas Clientes <span class="badge badge-info right"><?php echo $num_fras_cli; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../clientes/facturas_clientes.php?cobrada=0" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fras. Clientes pdte cobro <span class="badge badge-danger right"><?php echo "pdte"; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='C'&conc=activa=1" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Remesa de Cobros <span class='badge badge-info  right' ><?php echo $num_remesa_cobros; ?></span></p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="../personal/personal_listado.php?baja=BAJA=0" class="nav-link">
                  <span class="glyphicon glyphicon-user nav-icon"></span>
                  <p>Personal<span class='badge badge-info  right' ><?php echo $num_empleados; ?></span></p>
                </a>
              </li>
<?php      
        if($_SESSION["permiso_bancos"])
       { 
             ?>
              
              <li class="nav-item">
                <a href="../bancos/bancos_ctas_bancos.php?_m=<?php echo $_m; ?>&activo=on" class="nav-link">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Bancos<span class='badge badge-info  right' ><?php echo $num_ctas_bancos; ?></span></p>
                </a>
              </li>
  <?php      
        }
             ?>
              
              <li class="nav-item">
                <a href="../bancos/pagos_y_cobros.php" class="nav-link">
                  <span class="glyphicon glyphicon-calendar nav-icon" ></span>
                  <p>Pagos y Cobros</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../bancos/bancos_lineas_avales.php" class="nav-link">
                  <i class="fas fa-stamp nav-icon"></i>
                  <p>Avales<span class='badge badge-danger  right' ><?php echo $num_avales_pdtes; ?></span></p>
                </a>
              </li>
            </ul>
          </li>
          
  <?php      
       }  // fin permiso Administracion
        
             ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fa fa-tools nav-icon"></i>
              <p>
                Herramientas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Usuarios
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../proveedores/proveedores_buscar.php" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Usurio actual</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../documentos/doc_upload_multiple_form.php?_m=<?php echo $_m; ?>&tipo_entidad=fra_prov" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Añadir usuario</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../include/tabla_general.php?url_enc=<?php echo encrypt2("select=id_usuario,usuario,email,online,activo,autorizado,permiso_licitacion,permiso_obras,permiso_administracion,permiso_bancos,user,fecha_creacion&tabla=Usuarios_View&where=activo AND id_c_coste=$id_c_coste&link=../configuracion/usuario_ficha.php?id_usuario=&campo=usuario&campo_id=id_usuario") ; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Usuarios empresa <span class="badge badge-info right"><?php echo $num_usuarios; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&id_proveedor=<?php echo $id_proveedor_auto; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Accesos<span class='num_fras_prov_NC badge badge-danger  right' ><?php echo $num_fras_prov_NR; ?></span></p>
                    </a>
                  </li>
                 </ul>
 <?php      
       if ($_SESSION["admin"]) // #ADMIN
       {
             ?>
                  
                  <li class="nav-item">
                    <a href="../adminlte/" class="nav-link" target="_blank">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Admin LTE</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=1&pagada=0&fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fras prov. no pagadas<span class='num_fras_prov_NP badge badge-danger  right' >...</span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa=P&conc=activa=1" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Remesa de Pagos <span class='badge badge-info  right' ><?php echo $num_remesa_pagos; ?></span></p>
                    </a>
                  </li>
  <?php      
       }  // fin admin
        
             ?>
                  
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Clientes
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="../clientes/clientes_buscar.php" class="nav-link">
                      <span class="glyphicon glyphicon-briefcase nav-icon"></span>
                      <p>Clientes</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Facturas Clientes <span class="badge badge-info right"><?php echo $num_fras_cli; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../clientes/facturas_clientes.php?cobrada=0" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fras. Clientes pdte cobro <span class="badge badge-danger right"><?php echo "pdte"; ?></span></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa=C&conc=activa=1" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Remesa de Cobros <span class='badge badge-info  right' ><?php echo $num_remesa_cobros; ?></span></p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="../personal/personal_listado.php?baja=BAJA=0" class="nav-link">
                  <span class="glyphicon glyphicon-user nav-icon"></span>
                  <p>Personal<span class='badge badge-info  right' ><?php echo $num_empleados; ?></span></p>
                </a>
              </li>
<?php      
        if($_SESSION["permiso_bancos"])
       { 
             ?>
              
              <li class="nav-item">
                <a href="../bancos/bancos_ctas_bancos.php?_m=<?php echo $_m; ?>&activo=on" class="nav-link">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Bancos<span class='badge badge-info  right' ><?php echo $num_ctas_bancos; ?></span></p>
                </a>
              </li>
  <?php      
        }
             ?>
              
              <li class="nav-item">
                <a href="../bancos/pagos_y_cobros.php" class="nav-link">
                  <span class="glyphicon glyphicon-calendar nav-icon" ></span>
                  <p>Pagos y Cobros</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">             
              <span class="glyphicon glyphicon-question-sign nav-icon"></span>
              <p>
                Ayuda
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../img/diagrama_construwin.jpg" class="nav-link">
                  <i class="fas fa-image nav-icon"></i>
                  <p>Diagrama</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="https://www.youtube.com/channel/UCHnW4ZAPAYxWQ6rRzUmS_tw" class="nav-link">
                  <i class="fab fa-youtube nav-icon"></i>
                  <p>Videos tutoriales Youtube</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="https://foro.construcloud.es" class="nav-link"> 
                  <i class="fas fa-users nav-icon"></i>
                  <p>ConstruCloud Community forum</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="https://wiki.construcloud.es" class="nav-link">
                  <i class="fab fa-wikipedia-w nav-icon"></i>
                  <p>ConstruWIKI</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-list nav-icon"></i>
                  <p>Versiones</p>
                </a>
              </li>              
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>