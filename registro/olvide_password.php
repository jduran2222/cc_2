<?php
ini_set("session.use_trans_sid",true);
session_start();


// HERRAMIENTAS PARA EL EMAIL
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../include/phpmailer/Exception.php';
require '../include/phpmailer/PHPMailer.php';
require '../include/phpmailer/SMTP.php';

require_once("../../conexion.php");
require_once("../include/funciones.php"); 

?>

 
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Olvide password</title></head>


<body >
<?php   
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
?>

<center>
<div >
    <p align=center style='font-size:30px ; text-align:center; color:lightskyblue; font-family:verdana '><br>ConstruCloud.es<br>
		<img width="200"  src="../img/construcloud64.svg">
	</p>
   
</div>

	
<?php


if(!isset($_POST["email"]))
{    
?> 

    <br><br><br><br><form action="../registro/olvide_password.php" method="post" name="form1"  >
 
  <table width="40%"  border="0" align="center" cellpadding="1" cellspacing="2">
	<tr><td colspan="2" align="center" ><span class="encabezadopagina2">Introduzca su email, se le enviará una nueva contraseña para acceder y posteriormente cambiarla</span><br><br></td></tr>
    <tr>
      <td><div align="center"><span class="glyphicon glyphicon-envelope"></span> Email</div></td>
      <td><span class="encabezadopagina2">
        <input class="form-control" name="email" required type="email" value=""  tabindex=""  >
      </span></td>
      <td>
              <input class="btn btn-success" width='200px' type="submit" name="Submit" value="enviar"  >
             </td>
    </tr>
    
    
  </table>

    
  </form>
</center>
  
<?php

}
else      // cambiamos pasword y enviamos email
{    
    $email=trim($_POST["email"]) ;
    if($id_usuario=Dfirst("id_usuario","Usuarios","email='$email'"))
    {
//        echo 'debug'.__LINE__ ;  
        $id_c_coste=Dfirst("id_c_coste","Usuarios","id_usuario='$id_usuario'")  ;
        $empresa=Dfirst("C_Coste_Texto","C_COSTES","id_c_coste='$id_c_coste'")  ;
        
//        echo 'debug'.__LINE__ ;  

        $usuario=Dfirst("usuario","Usuarios","id_usuario='$id_usuario'")  ;

        $new_password= 'newpw_'.trim(rand(10000000000,100000000000 ))  ;
        $new_password_hash= cc_password_hash($new_password) ;
        
        $sql="UPDATE `Usuarios` SET `password_hash` = '$new_password_hash' WHERE id_usuario='$id_usuario' "  ;
//        echo 'debug'.__LINE__ ;  

        // si no hay erroers en el cambio de password
        if ($Conn->query($sql))
        {
            // si todo OK, ENVIAMOS EMAIL
            
           
//            // MANDAMOS EL EMAIL
//            use PHPMailer\PHPMailer\PHPMailer;
//            use PHPMailer\PHPMailer\Exception;
            //

              $mail = new phpmailer();
              $mail->CharSet = "UTF-8";

              $mail->Mailer = "smtp";

              $mail->Host = "sw24.es";
            //  $mail->Host = "smtp.serviciodecorreo.es";
              //Le indicamos que el servidor smtp requiere autenticación
              $mail->SMTPAuth = true;

              $mail->Username = "admin@sw24.es"; 
              $mail->Password = clave_mail();

              //Indicamos cual es nuestra dirección de correo y el nombre que 
              //queremos que vea el usuario que lee nuestro correo
              $mail->From = "no-reply@construcloud.es"; 
              $mail->FromName = "ConstruCloud.es";

              //Indicamos cual es la dirección de destino del correo
              $mail->AddAddress($email);
//              $mail->AddAddress("juanduran@ingenop.com");
            //  $mail->AddAddress("jduran2222@gmail.com");

              //Asignamos asunto y cuerpo del mensaje
              //El cuerpo del mensaje lo ponemos en formato html, haciendo 
              //que se vea en negrita

              $mail->ConfirmReadingTo = "juanduran@ingenop.com";

              $mail->Subject = "ConstruCloud.es restablecimiento de password";
              $mail->Body = "<b>Se ha solicitado el restablecimiento del password de acceso a <a  href='http://www.construcloud.es/web' >ConstruCloud.es</a></b><br>"
                      . "<br><br><br>Por favor, acceda de nuevo con el nuevo password y proceda a cambiarlo si o desea."
                      . "<br><br>Empresa: $empresa "
                      . "<br>Usuario: $usuario"
                      . "<br>Nuevo password: $new_password"
                      . "<br><br><br>Acceder con nuevo password <a  href='http://www.construcloud.es/web' > a login construcloud.es</a>"
                      . "<br>Saludos"
                      . "<br><a  href='http://www.construcloud.es'>ConstruCloud.es</a>";

              //Definimos AltBody por si el destinatario del correo no admite email con formato html 
              $mail->AltBody ="Se ha solicitado el restablecimiento del password de acceso. Utilice Empresa: $empresa , Usuario: $usuario, Nuevo password: $new_password" ;

              // JUAND
            //  $mail->SMTPDebug = 2;


              $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                              )
                     );

            //  $pdffile = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/1/obra_doc/543/543_NuevoDocumento 42.pdf" ;
            //  $mail->AddAttachment( $pdffile );



              // JUAND


              //se envia el mensaje, si no ha habido problemas 
              //la variable $exito tendra el valor true
              $exito = $mail->Send();

              //Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
              //para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
              //del anterior, para ello se usa la funcion sleep	
            //  $intentos=1; 
            //  while ((!$exito) && ($intentos < 5)) {
            //	sleep(5);
            //     	//echo $mail->ErrorInfo;
            //     	$exito = $mail->Send();
            //     	$intentos=$intentos+1;	
            //	
            //   }
            // 

               if(!$exito)
               {
                    echo "<br/><br/><br/><br/>ERROR enviando correo electrónico a ";
                    echo "<br/>". $email;	
                      echo  "<br><br><br><h1><a class='btn btn-primary btn-lg' href='../registro/index.php' title=''>Volver a inicio</a></h1>" ;

//                    echo "<br/>". $mail->Body;	
            //	echo "<br/>".$mail->ErrorInfo;	
               }
               else
               {
                    echo "<br/><br/><br/><br/>Mensaje enviado correctamente a ";
                    echo "<br/>". $email;	
                    echo  "<br><br><br><h1><a class='btn btn-primary btn-lg' href='../registro/index.php' title=''>Volver a inicio</a></h1>" ;

//                    echo "<br/>". $mail->Body;	

               } 
        }
        else
        {
           die("ERROR EN RESTABLECIMIENTO DE PASSWORD") ;
        }    
            
        
    } else
    {
       echo logs();
       die("¡¡email no encontrado!!")    ;
    }       

    
    
    
}
?> 


<?php require '../include/footer.php'; ?>
</BODY>
</html>

