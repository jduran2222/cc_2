<?php
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Invitación a usuario nuevo';

//include_once('../templates/_inc_registro1_header.php');
//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');



// HERRAMIENTAS PARA EL EMAIL
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ('../include/phpmailer/Exception.php');
require_once ('../include/phpmailer/PHPMailer.php');
require_once ('../include/phpmailer/SMTP.php');

include_once('../../conexion.php');
include_once('../include/funciones.php');


//Si no se ha enviado el formulario:
//$email = (isset($_POST["email"]) ? trim($_POST["email"]) : null);
$id_usuario_invitado = (isset($_GET["id_usuario"])) ? $_GET["id_usuario"] : '' ;



$htmlAlert = '';



//Intentar cambiar clave: si se mandan datos correctos
if( $id_usuario_invitado=Dfirst("id_usuario","Usuarios","id_usuario='$id_usuario_invitado' AND $where_c_coste"))    // control SEGURIDAD
   {

//    $id_c_coste=Dfirst("id_c_coste","Usuarios","id_usuario='$id_usuario'");
//    $empresa=Dfirst("C_Coste_Texto","C_COSTES","id_c_coste='$id_c_coste'");
//
//    $id_usuario_anfitrion=$_SESSION["id_usuario"] ;
    
//    $usuario=Dfirst("usuario","Usuarios","id_usuario='$id_usuario'");      // datos del usuario anfitrión
    $email_invitado=Dfirst("email","Usuarios","id_usuario='$id_usuario_invitado'");

    // $new_password= 'newpw_'.trim(rand(10000000000, 100000000000 ));
    $new_password= 'newpw_'.trim(uniqid());
    $new_password_hash= cc_password_hash($new_password) ;

    $sql="UPDATE `Usuarios` SET `password_hash` = '$new_password_hash' WHERE id_usuario='$id_usuario_invitado' AND $where_c_coste";

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

      $mail->AddAddress($email_invitado);

      $mail->ConfirmReadingTo = "soporte@construcloud.es"; 

      $mail->Subject = "ConstruCloud.es invitación de usuario a {$_SESSION["empresa"]}";
      $mail->Body = "El usuario {$_SESSION["user"]} con email {$_SESSION["email"]} de la empresa {$_SESSION["empresa"]} le ha enviado una invitación para acceder"
                                           . " a la ERP <a  href='http://www.construcloud.es/web' >ConstruCloud.es</a>"
                    . "<br><br><br>Por favor, acceda con su email y su password abajo indicados y proceda a cambiarlo cuando acceda."
                    . "<br>Usuario: <b>$email_invitado</b>"
                    . "<br>Password: <b>$new_password</b>"
                    . "<br><br><br>Acceder con nuevo password a <a  href='http://www.construcloud.es/web' > login</a> construcloud.es"
                    . "<br>Saludos"
                    . "<br><img width='256px' src='https://construcloud.es/web/img/logo_cc.svg' alt='Logo ConstruCloud 2.0'/>"
                    . "<br><a  href='http://www.construcloud.es'>ConstruCloud.es</a>";

//      $mail->AltBody ="Se ha solicitado el restablecimiento del password de acceso. Utilice Empresa: $empresa , Usuario: $usuario, Nuevo password: $new_password" ;
      $mail->AltBody ="El usuario {$_SESSION["user"]} de la empresa {$_SESSION["empresa"]} le ha enviado una invitación para acceder a https://construcloud.es  "
              . " Utilice su email y su nuevo password: $new_password   para acceder. No olvide cambiar su password" ;

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
        $htmlAlert = "<div class='alert alert-warning small' role='alert'>Hemos enviado la invitación al email $email_invitado</div>";
      }
      else {
        // echo "<br/><br/><br/><br/>ERROR enviando correo electrónico a ";
        // echo "<br/>". $email; 
        // echo  "<br><br><br><h1><a class='btn btn-primary btn-lg' href='../registro/index.php' title=''>Volver a inicio</a></h1>" ;
        $htmlAlert = '<div class="alert alert-danger small" role="alert">Se ha producido un error en el emvío del email. Por favor, verifique el email del usuario invitado.</div>';
      } 
    }
    else {
      // cc_die("ERROR EN RESTABLECIMIENTO DE PASSWORD");
      cc_die("ERROR AL REGISTRAR LA NUEVA PASSWORD");
    }
    
    echo $htmlAlert;
    
  }
  else {
    cc_die("ERROR USUARIO NO EXISTENTE");
  }


include_once('../templates/_inc_registro3_footer.php');