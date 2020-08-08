<?php

//Trabajar con sesiones al entrar en las páginas internas del sistema
//Para desarrollo local:
if (strpos('localhost', $_SERVER['HTTP_HOST']) !== false) {
  ini_set("session.use_trans_sid",true);
  session_start();

  //Para mostrar errores de programación y demás sólo cuando quieran ser visualizados: 
  //        poner en la url web.com/pagina.php?debugmode=si
  if ($_GET['debugmode'] == 'si' || strpos('localhost', $_SERVER['HTTP_HOST']) !== false || strpos('ingenop', $_SERVER['HTTP_HOST']) !== false ||strpos('www2', $_SERVER['HTTP_HOST']) !== false) {
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      //Guardar en sesión
      $_SESSION['debugmode'] = 'si';
  }
  else if (isset($_SESSION['debugmode'])) {
    if ($_SESSION['debugmode'] == 'si') {
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
    }
  }

  include_once('../../conexion.php');
  include_once('../include/funciones.php');
}
//Para desarrollo en el VPS
else {
  // Tratar sesión al subir al FTP
  include_once('../include/session.php');
}

// juand, agosto 2020
if ( preg_match("/ingenop|www2/i", $_SERVER['HTTP_HOST'])  ) {  error_reporting(E_ALL);}

//Limites de memoria:
ini_set('memory_limit', '256M');


//Importantísimo que no se haya escrito nada antes de todo este código por temas de sesiones y redirecciones 
// (por eso está el texto ? > < ! DOCTYPE html > todo junto)

?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $titulo; ?> | ConstruCloud.es 2.0</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../adminlte/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../adminlte/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../adminlte/plugins/summernote/summernote-bs4.css">
  <!-- Estilos propietarios bajo el fichero principal main.css -->
  <link rel="stylesheet" href="../css/main.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Icono por defecto -->
  <link rel="icon" type="image/svg+xml" href="../img/construcloud64.svg" sizes="any">



<!-- jQuery -->
<script src="../adminlte/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script> $.widget.bridge('uibutton', $.ui.button); </script>
<!-- Bootstrap 4 -->
<script src="../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../adminlte/plugins/moment/moment.min.js"></script>
<script src="../adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="../adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../adminlte/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="../adminlte/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="../adminlte/dist/js/demo.js"></script> -->

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link href="chat_style.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel="stylesheet" id="bootstrap-css">
  <link href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel=stylesheet type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<!--hay que añadir layout-navbar-fixed al body para hacer fijo el navbar pero tapa la página principal
añadiendo content-wrapper al div hacemos el movimiento horizontal de la página al collapsar el menu lateral, pero interfiere con el navbar
juand , 7 agosto 2020-->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
