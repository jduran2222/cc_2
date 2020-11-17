<?php

$titulo = 'Recuperación de credenciales';

include_once('../templates/_inc_registro1_header.php');


// HERRAMIENTAS PARA EL EMAIL
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ('../include/phpmailer/Exception.php');
require_once ('../include/phpmailer/PHPMailer.php');
require_once ('../include/phpmailer/SMTP.php');

include_once('../../conexion.php');
include_once('../include/funciones.php');


//Si no se ha enviado el formulario:
$email = (isset($_POST["email"]) ? trim($_POST["email"]) : null);
$htmlAlert = '';
//Intentar cambiar clave: si se mandan datos correctos
if (!empty($email)) {
  if($id_usuario=Dfirst("id_usuario","Usuarios","email='$email'")) {

    $id_c_coste=Dfirst("id_c_coste","Usuarios","id_usuario='$id_usuario'");
    $empresa=Dfirst("C_Coste_Texto","C_COSTES","id_c_coste='$id_c_coste'");

    $usuario=Dfirst("usuario","Usuarios","id_usuario='$id_usuario'");

    // $new_password= 'newpw_'.trim(rand(10000000000, 100000000000 ));
    $new_password= 'newpw_'.trim(uniqid());
    $new_password_hash= cc_password_hash($new_password) ;

    $sql="UPDATE `Usuarios` SET `password_hash` = '$new_password_hash' WHERE id_usuario='$id_usuario' ";

    if ($Conn->query($sql)) {
      $mail = new phpmailer();
      $mail->CharSet = "UTF-8";
      $mail->Mailer = "smtp";
//      $mail->Host = "sw24.es";
      $mail->Host = "construcloud.es";
      $mail->SMTPAuth = true;
//      $mail->Username = "admin@sw24.es"; 
      $mail->Username = "soporte@construcloud.es"; 
      $mail->Password = clave_mail();

      $mail->From = "no-reply@construcloud.es"; 
      $mail->FromName = "ConstruCloud.es";

      $mail->AddAddress($email);

      $mail->ConfirmReadingTo = "soporte@construcloud.es"; 

      $mail->Subject = "ConstruCloud.es restablecimiento de password";
      $mail->Body = "<b>Se ha solicitado el restablecimiento del password de acceso a <a  href='http://www.construcloud.es/web' >ConstruCloud.es</a></b><br>"
                    . "<br><br><br>Por favor, acceda de nuevo con el nuevo password y proceda a cambiarlo si lo desea."
//                    . "<br><br>Empresa: $empresa "
//                    . "<br>Usuario: $usuario"
                    . "<br>Nuevo password: $new_password"
                    . "<br><br><br>Acceder con nuevo password <a  href='http://www.construcloud.es/web' > a login construcloud.es</a>"
                    . "<br>Saludos"
                    . "<br><a  href='http://www.construcloud.es'>ConstruCloud.es</a>";

//      $mail->AltBody ="Se ha solicitado el restablecimiento del password de acceso. Utilice Empresa: $empresa , Usuario: $usuario, Nuevo password: $new_password" ;
      $mail->AltBody ="Se ha solicitado el restablecimiento del password de acceso. Utilice nuevo password: $new_password" ;

      $mail->SMTPOptions = array(
                                  'ssl' => array(
                                                  'verify_peer' => false,
                                                  'verify_peer_name' => false,
                                                  'allow_self_signed' => true
                                                )
                                );

      $exito = $mail->Send();

      if($exito) {
        // echo "<br/><br/><br/><br/>Mensaje enviado correctamente a ";
        // echo "<br/>". $email; 
        // echo  "<br><br><br><h1><a class='btn btn-primary btn-lg' href='../registro/index.php' title=''>Volver a inicio</a></h1>" ;
        $htmlAlert = '<div class="alert alert-warning small" role="alert">Hemos enviado las nuevas credenciales a su correo ('.$email.').</div>';
      }
      else {
        // echo "<br/><br/><br/><br/>ERROR enviando correo electrónico a ";
        // echo "<br/>". $email; 
        // echo  "<br><br><br><h1><a class='btn btn-primary btn-lg' href='../registro/index.php' title=''>Volver a inicio</a></h1>" ;
        $htmlAlert = '<div class="alert alert-danger small" role="alert">Se ha producido un error. Por favor, verifique el email y/o inténtelo de nuevo más tarde.</div>';
      } 
    }
    else {
      // die("ERROR EN RESTABLECIMIENTO DE PASSWORD");
      $htmlAlert = '<div class="alert alert-danger small" role="alert">Se ha producido un error. Por favor, verifique el email y/o inténtelo de nuevo más tarde.</div>';
    }
  }
  else {
    // die("¡¡email no encontrado!!");
    $htmlAlert = '<div class="alert alert-danger small" role="alert">Se ha producido un error. Por favor, verifique el email y/o inténtelo de nuevo más tarde.</div>';
  }
}
//Nada: si no se ha enviado el formulario:
else {
  $htmlAlert = '';
}
?>

  <div class="login-box">
    <div class="login-logo">

      <img width="128px" src="../img/logo_cc_blanco.svg" alt="Logo ConstruCloud 2.0"/>
      <br>
      <a href="../"><strong>Constru</strong>Cloud 2.0</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">
          Recuperación de credenciales
        </p>

        <?php echo $htmlAlert; ?>

        <form action="../registro/olvide_password.php" method="post">
          <div class="input-group mb-3">
            <input type="text" name="email" id="email" class="form-control" required="required" placeholder="Email de usuario">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a class="btn btn-secondary small text-white" href="../">Volver</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <!-- <input class="d-none" type="hidden" name="Submit" value="Aceptar"/> -->
              <input type="submit" name="Submit" class="btn btn-success btn-block" value="Recuperar">
              <!-- <button type="submit" class="btn btn-success btn-block">Recuperar</button> -->
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

<?php 
include_once('../templates/_inc_registro3_footer.php');