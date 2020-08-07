<?php 
//incluimos códigos y datos de cálculo y consultas para el menú superior
include_once('../templates/_inc_privado2_1_topbar.php');

?>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light navbar-fixed-top noprint">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
      <li class="nav-item d-inline-block">
        <a href="#" class="px-1 px-sm-2 btn btn-link" title="Busqueda global" onclick="busqueda_global();">
          <i class="fas fa-search"></i>
          <span class="d-none d-sm-inline">Búsqueda</span>
        </a>
      </li>
      <li class="nav-item d-inline-block">
        <a href="#" class="px-1 px-sm-2 btn btn-link" title="Imprimir" onclick="window.print();">
          <i class="fas fa-print"></i>
        </a>
      </li>
      <li class="nav-item d-inline-block p-1">
        <a href="?" class="p-1 px-1 px-sm-2 btn btn-success btn-xs" title="Refrescar">
          <i class="fas fa-redo"></i>
          <span class="d-none d-sm-inline">Refrescar</span>
        </a>
      </li>
      <li class="nav-item d-inline-block p-1">
        <a href="#" class="p-1 px-1 px-sm-2 btn btn-warning btn-xs" title="Cerrar" onclick="javascript:window.close();">
          <i class="far fa-window-close"></i>
          <span class="d-none d-sm-inline">Cerrar</span>
        </a>
      </li>

      <?php 
      //Para revisar elementos en caso de ser administrador:
      if ($admin) {
        $htmlAdmin = '
      <li class="nav-item d-inline-block border-left">
        <a href="../debug/debug_logs.php" class="px-1 px-sm-2 btn btn-link" target="_blank" title="Abrir debugger">
            <i class="fab fa-dyalog"></i>
            <span class="d-none d-sm-inline"><span class="d-none">D</span>ebug</span>
        </a>
      </li>
      <li class="nav-item d-inline-block">
        <a href="../debug/debug_reset.php" target="_blank" title="Realizar reset" class="px-1 px-sm-2 btn btn-link ">
            <i class="fas fa-registered"></i>
            <span class="d-none d-sm-inline"><span class="d-none">R</span>eset</span>
        </a>
      </li>
        ';
        echo $htmlAdmin;
      }
      ?>

      <li class="nav-item d-inline-block border-left">
        <a id="btn_empresa" href="../configuracion/empresa_ficha.php" class="px-1 px-sm-2 btn btn-link" title="Ver ficha Empresa">
            <i class="fas fa-building"></i>
            <span class="d-none d-sm-inline"> <?php echo (ucwords($_SESSION["empresa"])); ?> </span>
        </a>
      </li>
      <li class="nav-item d-inline-block border-left">
        <a href="../configuracion/usuario_ficha.php" class="px-1 px-sm-2 btn btn-link" title="Ver ficha Usuario">
            <i class="far fa-user"></i>
            <span class="d-none d-sm-inline">  
                <?php echo (ucwords($_SESSION["user"])); ?>
                <sup class="bg-info small px-0 px-sm-1">
                <?php 
                    // if ($admin AND 0) { echo " (admin)"; } //AND 0 hace que siempre sea falsa la condicion.

                    echo ( 
                            isset($_SESSION['android']) ?
                            (
                                ( 
                                    !empty($_SESSION['android'])) ?
                                    'android' :
                                    'pc'
                            ) :
                            'pc' 
                        );
                ?>
                </sup>
            </span>
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-inline-block border-left">
        <a id="btn_empresa" href="../agenda/tareas.php" class="px-1 px-sm-2 btn btn-link" title="Tareas">
          <i class="fab fa-tumblr"></i>
          <span class="d-none d-sm-inline"><span class="d-none">T</span>areas</span> 
          <?php 
            echo (badge($tareas,'info') . badge($tareas_new,'danger'));
          ?> 
        </a>
      </li>
      <li class="nav-item d-inline-block">
        <a id="btn_empresa" href="../agenda/portafirmas.php" class="px-1 px-sm-2 btn btn-link" title="Realizar firma">
          <i class="fas fa-pen-nib"></i>
          <span class="d-none d-sm-inline">PortaFirmas</span> 
          <?php 
            echo (badge($portafirmas,'danger'));
          ?> 
        </a>
      </li>
      <li class="nav-item d-inline-block">
        <a id="btn_empresa" href="../chat/chat_index.php" class="px-1 px-sm-2 btn btn-link" title="Abrir Chat">
          <i class="far fa-comments"></i>
          <span class="d-none d-sm-inline">Chat</span> 
          <?php 
            echo ($badge_txt);
          ?> 
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
          <img src="<?php echo ($path_logo_empresa); ?>_large.jpg" class="img-circle elevation-2" alt="logo empresa usuario">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo ($_SESSION["empresa"] .' | '. $_SESSION["user"]); ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul id="left-navbar" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="../menu/pagina_inicio.php" class="nav-link">
                <i class="nav-icon fa fa-home"></i>
                <p>
                  Inicio
                </p>
              </a>
            </li>

            <?php 
            $htmlMenuPermisoLicitacion = '';
            if($_SESSION["permiso_licitacion"]) {
                
                $htmlMenuPermisoLicitacion .= '<li class="nav-item has-treeview">';
                $htmlMenuPermisoLicitacion .= '  <a href="#" class="nav-link">';
                $htmlMenuPermisoLicitacion .= '    <i class="fas fa-copy nav-icon"></i>';
                $htmlMenuPermisoLicitacion .= '    <p>';
                $htmlMenuPermisoLicitacion .= '      Licitaciones';
                $htmlMenuPermisoLicitacion .= '      <i class="fas fa-angle-left right"></i>';
                $htmlMenuPermisoLicitacion .= '      <span class="badge badge-info right">'.$num_estudios.'</span>';
                $htmlMenuPermisoLicitacion .= '    </p>';
                $htmlMenuPermisoLicitacion .= '  </a>';
                $htmlMenuPermisoLicitacion .= '  <ul class="nav nav-treeview small">';
                $htmlMenuPermisoLicitacion .= '    <li class="nav-item">';
                $htmlMenuPermisoLicitacion .= '      <a href="../estudios/estudios_calendar.php?_m='.$_m.'&fecha='.date("Y-m-d").'" class="nav-link">';
                $htmlMenuPermisoLicitacion .= '        <i class="far fa-calendar-alt nav-icon"></i>';
                $htmlMenuPermisoLicitacion .= '        <p>Calendario Licitaciones</p>';
                $htmlMenuPermisoLicitacion .= '      </a>';
                $htmlMenuPermisoLicitacion .= '    </li>';
                $htmlMenuPermisoLicitacion .= '    <li class="nav-item">';
                $htmlMenuPermisoLicitacion .= '      <a href="../estudios/estudios_buscar.php" class="nav-link">';
                $htmlMenuPermisoLicitacion .= '        <i class="fas fa-list nav-icon"></i>';
                $htmlMenuPermisoLicitacion .= '        <p>Listado Licitaciones</p>';
                $htmlMenuPermisoLicitacion .= '      </a>';
                $htmlMenuPermisoLicitacion .= '    </li>';
                $htmlMenuPermisoLicitacion .= '    <li class="nav-item">';
                $htmlMenuPermisoLicitacion .= '      <a href="../estudios/ofertas_clientes.php" class="nav-link">';
                $htmlMenuPermisoLicitacion .= '        <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoLicitacion .= '        <p>Presupuestos</p>';
                $htmlMenuPermisoLicitacion .= '      </a>';
                $htmlMenuPermisoLicitacion .= '    </li>';
                $htmlMenuPermisoLicitacion .= '  </ul>';
                $htmlMenuPermisoLicitacion .= '</li>';
            }
            echo $htmlMenuPermisoLicitacion;
            ?>
            <?php 
            $htmlMenuPermisoObras = '';
            if($_SESSION["permiso_obras"]) {

                $htmlMenuPermisoObras .= '<li class="nav-item has-treeview">';
                $htmlMenuPermisoObras .= '  <a href="#" class="nav-link">';
                $htmlMenuPermisoObras .= '    <i class="fa fa-hard-hat nav-icon"></i>';
                $htmlMenuPermisoObras .= '    <p title="Obras, proyectos y servicios">';
                $htmlMenuPermisoObras .= '      Obras';
                $htmlMenuPermisoObras .= '      <i class="fas fa-angle-left right"></i>';
                $htmlMenuPermisoObras .= '      <span class="badge badge-info right">'.$num_obras.'</span>';
                $htmlMenuPermisoObras .= '    </p>';
                $htmlMenuPermisoObras .= '  </a>';
                $htmlMenuPermisoObras .= '  <ul class="nav nav-treeview small">';
                $htmlMenuPermisoObras .= '    <li class="nav-item">';
                $htmlMenuPermisoObras .= '      <a href="../obras/obras_buscar.php?_m='.$_m.'&tipo_subcentro=OEGA" class="nav-link">';
                $htmlMenuPermisoObras .= '        <i class="fas fa-hard-hat nav-icon"></i>';
                $htmlMenuPermisoObras .= '        <p>Obras o Proyectos</p>';
                $htmlMenuPermisoObras .= '      </a>';
                $htmlMenuPermisoObras .= '    </li>';
                $htmlMenuPermisoObras .= '    <li class="nav-item">';
                $htmlMenuPermisoObras .= '      <a href="../personal/partes.php" class="nav-link">';
                $htmlMenuPermisoObras .= '        <i class="far fa-calendar-alt nav-icon"></i>';
                $htmlMenuPermisoObras .= '        <p>Partes Diarios</p>';
                $htmlMenuPermisoObras .= '      </a>';
                $htmlMenuPermisoObras .= '    </li>';
                $htmlMenuPermisoObras .= '    <li class="nav-item">';
                $htmlMenuPermisoObras .= '      <a href="../obras/gastos.php?_m='.$_m.'&fecha1='.$fecha_inicio.'" class="nav-link">';
                $htmlMenuPermisoObras .= '        <i class="fas fa-shopping-cart nav-icon"></i>';
                $htmlMenuPermisoObras .= '        <p>Gastos</p>';
                $htmlMenuPermisoObras .= '      </a>';
                $htmlMenuPermisoObras .= '    </li>';
                $htmlMenuPermisoObras .= '    <li class="nav-item">';
                $htmlMenuPermisoObras .= '      <a href="../maquinaria/maquinaria_buscar.php?_m='.$_m.'&tipo_subcentro=M" class="nav-link">';
                $htmlMenuPermisoObras .= '        <i class="fas fa-truck-pickup nav-icon"></i>';
                $htmlMenuPermisoObras .= '        <p>Maquinaria</p>';
                $htmlMenuPermisoObras .= '        <span class="badge badge-info right">'.$num_maquinaria.'</span>';
                $htmlMenuPermisoObras .= '      </a>';
                $htmlMenuPermisoObras .= '    </li>';
                $htmlMenuPermisoObras .= '    <li class="nav-item">';
                $htmlMenuPermisoObras .= '      <a href="../obras/obras_view.php?_m='.$_m.'&tipo_subcentro=O&fecha1='.$fecha_inicio.'" class="nav-link">';
                $htmlMenuPermisoObras .= '        <i class="fas fa-list nav-icon"></i>';
                $htmlMenuPermisoObras .= '        <p>Gestión Obras</p>';
                $htmlMenuPermisoObras .= '      </a>';
                $htmlMenuPermisoObras .= '    </li>';
                $htmlMenuPermisoObras .= '  </ul>';
                $htmlMenuPermisoObras .= '</li>';
            }
            echo $htmlMenuPermisoObras;
            ?>
            <?php 
            $htmlMenuPermisoAdministracion = '';
            if($_SESSION["permiso_administracion"]) {

                $htmlMenuPermisoAdministracion .= '<li class="nav-item has-treeview">';
                $htmlMenuPermisoAdministracion .= '  <a href="#" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '    <i class="fa fa-coins nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '    <p>';
                $htmlMenuPermisoAdministracion .= '      Administración';
                $htmlMenuPermisoAdministracion .= '      <i class="right fas fa-angle-left"></i>';
                $htmlMenuPermisoAdministracion .= '    </p>';
                $htmlMenuPermisoAdministracion .= '  </a>';
                $htmlMenuPermisoAdministracion .= '  <ul class="nav nav-treeview small">';
                $htmlMenuPermisoAdministracion .= '    <li class="nav-item has-treeview">';
                $htmlMenuPermisoAdministracion .= '      <a href="#" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '        <i class="fa fa-cubes nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '        <p>';
                $htmlMenuPermisoAdministracion .= '          Proveedores';
                $htmlMenuPermisoAdministracion .= '          <i class="right fas fa-angle-left"></i>';
                $htmlMenuPermisoAdministracion .= '        </p>';
                $htmlMenuPermisoAdministracion .= '      </a>';
                $htmlMenuPermisoAdministracion .= '      <ul class="nav nav-treeview small">';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../proveedores/proveedores_buscar.php" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-box nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Proveedores</p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../documentos/doc_upload_multiple_form.php?_m='.$_m.'&tipo_entidad=fra_prov" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-upload nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Subir fras. proveedores</p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../proveedores/facturas_proveedores.php?fecha1='.$fecha_inicio.'" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Facturas Proveedores <span class="badge badge-info right">'.$num_fras_prov.'</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../proveedores/facturas_proveedores.php?_m='.$_m.'&id_proveedor='.$id_proveedor_auto.'" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Fras prov. no registradas<span class="num_fras_prov_NC badge badge-danger right">'.$num_fras_prov_NR.'</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../proveedores/facturas_proveedores.php?_m='.$_m.'&conciliada=0&fecha1='.$fecha_inicio.'" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Fras prov. no cargadas<span class="num_fras_prov_NC badge badge-danger right" >...</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../proveedores/facturas_proveedores.php?_m='.$_m.'&conciliada=1&pagada=0&fecha1='.$fecha_inicio.'" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Fras prov. no pagadas<span class="num_fras_prov_NP badge badge-danger  right" >...</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa=\'P\'&conc=activa=1" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fas fa-euro-sign nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Remesa de Pagos <span class="badge badge-info right">'.$num_remesa_pagos.'</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '      </ul>';
                $htmlMenuPermisoAdministracion .= '    </li>';
                $htmlMenuPermisoAdministracion .= '  </ul>';
                $htmlMenuPermisoAdministracion .= '  <ul class="nav nav-treeview small">';
                $htmlMenuPermisoAdministracion .= '    <li class="nav-item has-treeview">';
                $htmlMenuPermisoAdministracion .= '      <a href="#" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '        <i class="fas fa-users nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '        <p>';
                $htmlMenuPermisoAdministracion .= '          Clientes';
                $htmlMenuPermisoAdministracion .= '          <i class="fas fa-angle-left right"></i>';
                $htmlMenuPermisoAdministracion .= '        </p>';
                $htmlMenuPermisoAdministracion .= '      </a>';
                $htmlMenuPermisoAdministracion .= '      <ul class="nav nav-treeview small">';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../clientes/clientes_buscar.php" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-portrait nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Clientes</p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../clientes/facturas_clientes.php?fecha1='.$fecha_inicio.'" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Facturas Clientes <span class="badge badge-info right">'.$num_fras_cli.'</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../clientes/facturas_clientes.php?cobrada=0" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Fras. Clientes pdte cobro <span class="badge badge-danger right">'.'pdte'.'></span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '        <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '          <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa=\'C\'&conc=activa=1" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '            <i class="fas fa-euro-sign nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '            <p>Remesa de Cobros <span class="badge badge-info  right">'.$num_remesa_cobros.'</span></p>';
                $htmlMenuPermisoAdministracion .= '          </a>';
                $htmlMenuPermisoAdministracion .= '        </li>';
                $htmlMenuPermisoAdministracion .= '      </ul>';
                $htmlMenuPermisoAdministracion .= '    </li>';
                $htmlMenuPermisoAdministracion .= '    <li class="nav-item">';
                $htmlMenuPermisoAdministracion .= '      <a href="../personal/personal_listado.php?baja=BAJA=0" class="nav-link">';
                $htmlMenuPermisoAdministracion .= '        <i class="fa fa-person-booth nav-icon"></i>';
                $htmlMenuPermisoAdministracion .= '        <p>Personal<span class="badge badge-info right">'.$num_empleados.'</span></p>';
                $htmlMenuPermisoAdministracion .= '      </a>';
                $htmlMenuPermisoAdministracion .= '    </li>';

                if($_SESSION["permiso_bancos"]) {
                    $htmlMenuPermisoBancos = '';

                    $htmlMenuPermisoBancos .= '<li class="nav-item">';
                    $htmlMenuPermisoBancos .= '  <a href="../bancos/bancos_ctas_bancos.php?_m='.$_m.'&activo=on" class="nav-link">';
                    $htmlMenuPermisoBancos .= '    <i class="fas fa-university nav-icon"></i>';
                    $htmlMenuPermisoBancos .= '    <p>Bancos<span class="badge badge-info right">'.$num_ctas_bancos.'</span></p>';
                    $htmlMenuPermisoBancos .= '  </a>';
                    $htmlMenuPermisoBancos .= '</li>';
                    $htmlMenuPermisoAdministracion .= $htmlMenuPermisoBancos;
                }

                $htmlMenuPermisoAdministracion .='    <li class="nav-item">';
                $htmlMenuPermisoAdministracion .='      <a href="../bancos/pagos_y_cobros.php" class="nav-link">';
                $htmlMenuPermisoAdministracion .='        <i class="fa fa-hand-holding-usd nav-icon" ></i>';
                $htmlMenuPermisoAdministracion .='        <p>Pagos y Cobros</p>';
                $htmlMenuPermisoAdministracion .='      </a>';
                $htmlMenuPermisoAdministracion .='    </li>';
                $htmlMenuPermisoAdministracion .='    <li class="nav-item">';
                $htmlMenuPermisoAdministracion .='      <a href="../bancos/bancos_lineas_avales.php" class="nav-link">';
                $htmlMenuPermisoAdministracion .='        <i class="fas fa-stamp nav-icon"></i>';
                $htmlMenuPermisoAdministracion .='        <p>Avales<span class="badge badge-danger right" >'.$num_avales_pdtes.'</span></p>';
                $htmlMenuPermisoAdministracion .='      </a>';
                $htmlMenuPermisoAdministracion .='    </li>';
                $htmlMenuPermisoAdministracion .='  </ul>';
                $htmlMenuPermisoAdministracion .='</li>';
            }
            echo $htmlMenuPermisoAdministracion;
            ?>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fa fa-cogs nav-icon"></i>
                <p>
                  Herramientas
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview small">
                <!-- USUARIOS -->
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="far fa-user nav-icon"></i>

                    <p>
                      Usuarios
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview small">
                    <li class="nav-item">
                      <a href="../configuracion/usuario_ficha.php" class="nav-link">
                        <i class="fa fa-user-cog nav-icon"></i>
                        <p>Usuario actual</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../configuracion/usuario_anadir.php" class="nav-link">
                        <i class="fa fa-user-plus nav-icon"></i>
                        <p>Añadir usuario</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../include/tabla_general.php?url_enc=<?php echo encrypt2("select=id_usuario,usuario,email,online,activo,autorizado,permiso_licitacion,permiso_obras,permiso_administracion,permiso_bancos,user,fecha_creacion&tabla=Usuarios_View&where=activo AND id_c_coste=$id_c_coste&link=../configuracion/usuario_ficha.php?id_usuario=&campo=usuario&campo_id=id_usuario") ; ?>" class="nav-link">
                        <i class="fa fa-house-user nav-icon"></i>
                        <p>Usuarios empresa <span class="badge badge-info right"><?php echo $num_usuarios; ?></span></p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&id_proveedor=<?php echo $id_proveedor_auto; ?>" class="nav-link">
                        <i class="fa fa-user-lock nav-icon"></i>
                        <p>Accesos<span class='num_fras_prov_NC badge badge-danger  right' ><?php echo $num_fras_prov_NR; ?></span></p>
                      </a>
                    </li>
                  </ul>
                </li>
                <?php
                    $htmlAgregadoAdmin = '';
                    if ($_SESSION["admin"]) {
                        $htmlAgregadoAdmin .= '<!-- AdminLTE -->';
                        $htmlAgregadoAdmin .= '<li class="nav-item">';
                        $htmlAgregadoAdmin .= '  <a href="../adminlte/" class="nav-link" target="_blank">';
                        $htmlAgregadoAdmin .= '    <i class="fa fa-code nav-icon"></i>';
                        $htmlAgregadoAdmin .= '    <p>Admin LTE</p>';
                        $htmlAgregadoAdmin .= '  </a>';
                        $htmlAgregadoAdmin .= '</li>';
                        $htmlAgregadoAdmin .= '<!-- Fras -->';
                        $htmlAgregadoAdmin .= '<li class="nav-item">';
                        $htmlAgregadoAdmin .= '  <a href="../proveedores/facturas_proveedores.php?_m='.$_m.'&conciliada=1&pagada=0&fecha1='.$fecha_inicio.'" class="nav-link">';
                        $htmlAgregadoAdmin .= '    <i class="fa fa-file-invoice-dollar nav-icon"></i>';
                        $htmlAgregadoAdmin .= '    Fras prov. no pagadas';
                        $htmlAgregadoAdmin .= '    <span class="num_fras_prov_NP badge badge-danger right">'.'pdte'.'</span>';
                        $htmlAgregadoAdmin .= '  </a>';
                        $htmlAgregadoAdmin .= '</li>';
                        $htmlAgregadoAdmin .= '<!-- Remesas -->';
                        $htmlAgregadoAdmin .= '<li class="nav-item">';
                        $htmlAgregadoAdmin .= '  <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa=P&conc=activa=1" class="nav-link">';
                        $htmlAgregadoAdmin .= '    <i class="fas fa-euro-sign nav-icon"></i>';
                        $htmlAgregadoAdmin .= '    Remesa de Pagos';
                        $htmlAgregadoAdmin .= '    <span class="badge badge-info right" >'.$num_remesa_pagos.'</span>';
                        $htmlAgregadoAdmin .= '  </a>';
                        $htmlAgregadoAdmin .= '</li>';
                    }
                    echo $htmlAgregadoAdmin;
                ?>
              </ul>

              <ul class="nav nav-treeview small">
                <!-- CLIENTES -->
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <p>
                      Clientes
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview small">
                    <li class="nav-item">
                      <a href="../clientes/clientes_buscar.php" class="nav-link">
                        <i class="fa fa-portrait nav-icon"></i>
                        <p>Clientes</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>" class="nav-link">
                        <i class="fa fa-file-invoice-dollar nav-icon"></i>
                        <p>Facturas Clientes <span class="badge badge-info right"><?php echo $num_fras_cli; ?></span></p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../clientes/facturas_clientes.php?cobrada=0" class="nav-link">
                        <i class="fa fa-file-invoice-dollar nav-icon"></i>
                        <p>Fras. Clientes pdte cobro <span class="badge badge-danger right"><?php echo "pdte"; ?></span></p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa=C&conc=activa=1" class="nav-link">
                        <i class="fas fa-euro-sign nav-icon"></i>
                        <p>Remesa de Cobros <span class='badge badge-info  right' ><?php echo $num_remesa_cobros; ?></span></p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                  <a href="../personal/personal_listado.php?baja=BAJA=0" class="nav-link">
                    <i class="fa fa-person-booth nav-icon"></i>
                    <p>Personal<span class='badge badge-info  right' ><?php echo $num_empleados; ?></span></p>
                  </a>
                </li>
                <?php
                    $htmlMenuPermisoBancos = '';
                    if ($_SESSION["permiso_bancos"]) {
      
                        $htmlMenuPermisoBancos .= '<!-- bancos -->';
                        $htmlMenuPermisoBancos .= '<li class="nav-item">';
                        $htmlMenuPermisoBancos .= '  <a href="../bancos/bancos_ctas_bancos.php?_m='.$_m.'&activo=on" class="nav-link">';
                        $htmlMenuPermisoBancos .= '    <i class="fas fa-university nav-icon"></i>';
                        $htmlMenuPermisoBancos .= '    <p>Bancos<span class="badge badge-info right">'.$num_ctas_bancos.'</span></p>';
                        $htmlMenuPermisoBancos .= '  </a>';
                        $htmlMenuPermisoBancos .= '</li>';
                    }
                    echo $htmlMenuPermisoBancos;
                ?>
              </ul>
            </li>



            <!-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Charts
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview small">
                <li class="nav-item">
                  <a href="pages/charts/chartjs.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>ChartJS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/flot.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Flot</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/charts/inline.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inline</p>
                  </a>
                </li>
              </ul>
            </li> -->


            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">             
                <i class="fa fa-question nav-icon"></i>
                <p>
                  Ayuda
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview small">
                <li class="nav-item">
                  <a href="../img/diagrama_construwin.jpg" target="_blank" class="nav-link">
                    <i class="fa fa-sitemap nav-icon"></i>
                    Diagrama
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://www.youtube.com/channel/UCHnW4ZAPAYxWQ6rRzUmS_tw" target="_blank" class="nav-link">
                    <i class="fab fa-youtube nav-icon"></i>
                    Video-tutoriales
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://foro.construcloud.es" target="_blank" class="nav-link"> 
                    <i class="fas fa-users nav-icon"></i>
                    Comunidad ConstruCloud
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://wiki.construcloud.es" target="_blank" class="nav-link">
                    <i class="fab fa-wikipedia-w nav-icon"></i>
                    Wiki ConstruCloud
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../include/tabla_general.php?url_enc=<?php echo encrypt2("tabla=historial&where=Tipo_cambio LIKE '%PHP%' &campo=titulo&campo_id=id&link=../include/ficha_general.php?tabla=historial__AND__id_update=id__AND__id_valor=") ?>" class="nav-link">
                    <i class="fa fa-list nav-icon"></i>
                    Versiones
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