<!DOCTYPE html>
<style>

    /*necesito crear estas class vacias para que los reconozca el jquery .num_fras_prov_NC*/
    .num_fras_prov_NC {        
    }
    .num_fras_prov_NP {        
    }

</style>

<HEAD>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ConstruCloud 2020</title>
   
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
         

        <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
        

        <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->


    
   <link rel="stylesheet" href="../adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <!--<link rel="stylesheet" href="../adminlte/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
  <!-- Tempusdominus Bbootstrap 4 -->
  <!--<link rel="stylesheet" href="../adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">-->
  <!-- iCheck -->
  <!--<link rel="stylesheet" href="../adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">-->
  <!-- JQVMap -->
  <!--<link rel="stylesheet" href="../adminlte/plugins/jqvmap/jqvmap.min.css">-->
  <!-- Theme style -->
  
  <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <!--<link rel="stylesheet" href="../adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">-->
  <!-- Daterange picker -->
  <!--<link rel="stylesheet" href="../adminlte/plugins/daterangepicker/daterangepicker.css">-->
  <!-- summernote -->
  <!--<link rel="stylesheet" href="../adminlte/plugins/summernote/summernote-bs4.css">-->
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  
</HEAD>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<!--<body >-->
<div class="wrapper">

<!--   Navbar 
  <nav class="main-header navbar navbar-expand navbar-white navbar-light navbar-fixed-top">
     Left navbar links 
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../menu/pagina_inicio.php" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

     SEARCH FORM 
    <form class="form-inline ml-3" action="../menu/busqueda_global.php" method="post">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search" name="filtro">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

     Right navbar links 
    <ul class="navbar-nav ml-auto">
       Messages Dropdown Menu 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
             Message Start 
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
             Message End 
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
             Message Start 
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
             Message End 
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
             Message Start 
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
             Message End 
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
       Notifications Dropdown Menu 
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
   /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../menu/pagina_inicio.php" class="brand-link">
      <img src="../img/logo_cc_blanco.svg" alt="construcloud" class="brand-image img-circle elevation-3"
  
           style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div >
       <?php // if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste")) {$path_logo_empresa = "../img/no_logo_empresa.jpg";} ; ?>
     
          <img src="<?php echo $path_logo_empresa; ?>" alt="logo empresa">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo "{$_SESSION["empresa"]}/{$_SESSION["user"]}" ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
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
                  <i class="far fa-calendar-alt nav-icon"></i>
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
                  <i class="fas fa-list nav-icon "></i>
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
                  <i class="fas fa-hard-hat nav-icon"></i>
                  <p>Obras o Proyectos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../personal/partes.php" class="nav-link">
                  <i class="far fa-calendar-alt nav-icon"></i>
                  <p>Partes Diarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../obras/gastos.php?_m=<?php echo $_m; ?>&fecha1=<?php echo $fecha_inicio; ?>" class="nav-link"> 
                  <i class="fas fa-shopping-cart nav-icon"></i>
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
              <span class="glyphicon glyphicon-cog nav-icon"></span>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<!--    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div> /.col 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> /.col 
        </div> /.row 
      </div> /.container-fluid 
    </div>-->
    <!-- /.content-header -->

    <!-- Main content -->
<!--    <section class="content">
      <div class="container-fluid">-->

