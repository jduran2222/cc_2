<?php

//Trabajar con sesiones al entrar en las páginas internas del sistema
ini_set("session.use_trans_sid",true);
session_start();

//Para mostrar errores de programación y demás sólo cuando quieran ser visualizados
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

//Importantísimo que no se haya escrito nada antes de todo este código (por eso está el texto ? > < ! DOCTYPE html > todo junto)

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
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../adminlte/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Icono por defecto -->
    <link rel="icon" type="image/svg+xml" href="../img/construcloud64.svg" sizes="any">
  </head>
  <body class="hold-transition login-page">