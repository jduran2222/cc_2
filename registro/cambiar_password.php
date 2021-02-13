<?php

$titulo = 'Cambio password';

//include_once('../templates/_inc_registro1_header.php');

include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');


include_once('../../conexion.php');
include_once('../include/funciones.php');

//Revisar acceso
$href_get='';
if ( $_SESSION["admin"] AND isset($_GET["id_usuario"]) ) {
  $id_usuario_get=$_GET["id_usuario"] ;
  $usuario=  Dfirst("usuario","Usuarios","id_usuario='$id_usuario_get'")  ;
  $href_get="?id_usuario=$id_usuario_get";
  $id_usuario=$id_usuario_get;
}
else if( $_SESSION["autorizado"] AND isset($_GET["id_usuario"]) ) {
  $id_usuario_get=$_GET["id_usuario"] ;
  $id_empresa_get = Dfirst('id_c_coste','Usuarios' , " id_usuario=$id_usuario_get " ) ;
  $id_empresa_autorizado = Dfirst('id_c_coste','Usuarios' , " id_usuario={$_SESSION["id_usuario"]} " ) ;

  if ( $id_empresa_get == $id_empresa_autorizado ) {
    $usuario=  Dfirst("usuario","Usuarios","id_usuario='$id_usuario_get'")  ;
    $href_get="?id_usuario=$id_usuario_get";
    $id_usuario=$id_usuario_get;
  }
}
else {
  $id_usuario=$_SESSION["id_usuario"] ;
  $usuario= $_SESSION["user"] ;
}

//Si no se ha enviado el formulario:
$new_password = (isset($_POST["new_password"]) ? trim($_POST["new_password"]) : null);
$new_password_confirm = (isset($_POST["new_password_confirm"]) ? trim($_POST["new_password_confirm"]) : null);
$htmlAlert = '';

//Cambiar clave: Si todo está en orden
if(!empty($new_password) && !empty($new_password_confirm) && $new_password == $new_password_confirm) { 
  $new_password_hash= cc_password_hash($new_password) ;
  $sql="UPDATE `Usuarios` SET `password_hash` = '$new_password_hash' WHERE id_usuario='{$id_usuario}' ";
  if ($Conn->query($sql)) {
    $htmlAlert = '<div class="alert alert-info small" role="alert">Password cambiada correctamente.</div>';
  }
  else {
    $htmlAlert = '<div class="alert alert-danger small" role="alert">Error inserperado con la BBDD. Inténtelo de nuevo más tarde.</div>';
  }
}
//Aviso de error: si las claves no coinciden
else if (!empty($new_password) && !empty($new_password_confirm) && $new_password != $new_password_confirm) {
  $htmlAlert = '<div class="alert alert-danger small" role="alert">Las claves no coinciden. Inténtelo de nuevo.</div>';
}
//Nada: si no se ha enviado el formulario:
else {
  $htmlAlert = '';
}
?>
<!--<body class="hold-transition login-page">-->
  <div class="login-box " style='margin: 0 auto;'>
    <div class="login-logo">

      <img width="128px" src="../img/logo_cc_blanco.svg" alt="Logo ConstruCloud 2.0"/>
      <br>
      <a href="../"><strong>Constru</strong>Cloud 2.0</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">
          Cambio de password de: 
          <strong ><?php echo $usuario?></strong>
        </p>

        <?php echo $htmlAlert; ?>

        <form action="../registro/cambiar_password.php<?php echo $href_get?>" method="post">
          <div class="input-group mb-3">
            <input type="password" name="new_password" id="new_password" class="form-control" required="required" placeholder="Nueva clave">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control" required="required" placeholder="Confirmar nueva clave">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <button class="btn btn-secondary small text-white" onclick="javascript:window.close();" >Cerrar</button>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <input class="d-none" type="hidden" name="Submit" value="Aceptar"/>
              <button type="submit" class="btn btn-success btn-block">Cambiar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
<br><br><br><br><br><br><br><br><br><br>
  <!-- /.login-box -->

<?php 
//include_once('../templates/_inc_registro3_footer.php');

include_once('../templates/_inc_privado3_footer.php');
