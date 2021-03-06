<?php

//Trabajar con sesiones al entrar en las páginas internas del sistema
if (strpos('localhost', $_SERVER['HTTP_HOST']) !== false) {
  ini_set("session.use_trans_sid",true);
  session_start();

  //Para mostrar errores de programación y demás sólo cuando quieran ser visualizados
  if ($_GET['debugmode'] == 'si') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
  }

  include_once('../../conexion.php');
  include_once('../include/funciones.php');
}
else {
  // Tratar sesión al subir al FTP
  include_once('../include/session.php');
}

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
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Icono por defecto -->
  <link rel="icon" type="image/svg+xml" href="../img/construcloud64.svg" sizes="any">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">