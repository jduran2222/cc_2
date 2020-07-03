<?php
//require 'PHPMailerAutoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
//

//require("PHPMailer.php");

//$mail = new PHPMailer;
//$mail->setFrom('construwin@ingenop.com', 'Your Name');
//$mail->addAddress('juanduran@ingenop.com', 'My Friend');
//$mail->addAddress('jduran2222@gmail.com', 'My Friend2');
//$mail->Subject  = 'First PHPMailer Message';
//$mail->Body     = 'Hi! This is my first e-mail sent through PHPMailer.';
//if(!$mail->send()) {
//  echo 'Message was not sent.';
//  echo 'Mailer error: ' . $mail->ErrorInfo;
//} else {
//  echo 'Message has been sent.';
//}

  // primero hay que incluir la clase phpmailer para poder instanciar
  //un objeto de la misma
//  require "includes/class.phpmailer.php";

  //instanciamos un objeto de la clase phpmailer al que llamamos 
  //por ejemplo mail
  $mail = new phpmailer();

  //Definimos las propiedades y llamamos a los métodos 
  //correspondientes del objeto mail

  //Con PluginDir le indicamos a la clase phpmailer donde se 
  //encuentra la clase smtp que como he comentado al principio de 
  //este ejemplo va a estar en el subdirectorio includes
//  $mail->PluginDir = "includes/";

  //Con la propiedad Mailer le indicamos que vamos a usar un 
  //servidor smtp
  $mail->Mailer = "smtp";

  //Asignamos a Host el nombre de nuestro servidor smtp
  $mail->Host = "sw24.es";
//  $mail->Host = "smtp.serviciodecorreo.es";

  //Le indicamos que el servidor smtp requiere autenticación
  $mail->SMTPAuth = true;

  //Le decimos cual es nuestro nombre de usuario y password
//  $mail->Username = "construwin@ingenop.com"; 
//  $mail->Password = "Vbnmyuio3";

  $mail->Username = "admin@sw24.es"; 
  $mail->Password = clave_mail();
  
//  $mail->Username = "juanduran@ingenop.com"; 
//  $mail->Password = "Ad...3";
  
  
  //Indicamos cual es nuestra dirección de correo y el nombre que 
  //queremos que vea el usuario que lee nuestro correo
  $mail->From = "juanduran@ingenop.com"; 
  $mail->FromName = "Construcloud";

  //el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
  //una cuenta gratuita, por tanto lo pongo a 30  
//  $mail->Timeout=30;

  //Indicamos cual es la dirección de destino del correo
  $mail->AddAddress("juanduran@ingenop.com");
  $mail->AddAddress("jduran2222@gmail.com");

  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
  //que se vea en negrita
  $mail->Subject = "Prueba de phpmailer2";
  $mail->Body = "<b>Mensaje de prueba mandado con phpmailer en formato html</b>";

  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
  $mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

  // JUAND
//  $mail->SMTPDebug = 2;

  
  $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
  
  $pdffile = $_SERVER['DOCUMENT_ROOT'] . "/web/uploads/1/obra_doc/543/543_NuevoDocumento 42.pdf" ;
  $mail->AddAttachment( $pdffile );
//  $pdffile = $_SERVER['DOCUMENT_ROOT'] . "/facturen/test.pdf"
//$ConfirmReadingTo
  $mail->ConfirmReadingTo = "juanduran@ingenop.com";
  
  
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
	echo "Problemas enviando correo electrónico ";
//	echo "<br/>".$mail->ErrorInfo;	
   }
   else
   {
	echo "Mensaje enviado correctamente";
   } 
?>