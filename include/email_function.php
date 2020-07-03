<?php

// HERRAMIENTAS PARA EL EMAIL
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function cc_email($sendto, $asunto, $mensaje, $replyto='')
{
require '../include/phpmailer/Exception.php';
require '../include/phpmailer/PHPMailer.php';
require '../include/phpmailer/SMTP.php';

require_once("../../conexion.php");
require_once("../include/funciones.php"); 



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
              $mail->AddAddress($sendto);
              $mail->AddReplyTo($replyto, 'Reply to name');

//              $mail->AddAddress("juanduran@ingenop.com");
            //  $mail->AddAddress("jduran2222@gmail.com");

              //Asignamos asunto y cuerpo del mensaje
              //El cuerpo del mensaje lo ponemos en formato html, haciendo 
              //que se vea en negrita

              $mail->ConfirmReadingTo = "juanduran@ingenop.com";

              $mail->Subject = $asunto;
              $mail->Body = $mensaje . " " ;                          // el Body vacío DA ERROR y no lo envía, añadimos un espacio al final
              $mail->AltBody = strip_tags($mensaje) ;     // msg sin tags html

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

  return $exito ;
}
          
  ?>        
          