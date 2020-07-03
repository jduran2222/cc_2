<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

//PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 
//
require '../include/phpmailer/Exception.php';
require '../include/phpmailer/PHPMailer.php';
require '../include/phpmailer/SMTP.php';
//


$id_remesa = $_GET["id_remesa"]; 

// anotamos como FIRMADA la remesa
$result_UPDATE=$Conn->query("UPDATE `Remesas` SET `firmada` = 1 WHERE  id_remesa=$id_remesa" );


//header("Content-type: text/xml");
//header("Content-type: text/txt");



require_once("../../conexion.php");
require_once("../include/funciones.php"); 


    
 // incluimos los APUNTES DE LOS PROVEEDORES
$result2 = $Conn->query("SELECT * from Pagos_View WHERE id_remesa=$id_remesa AND $where_c_coste ");

if ($result2->num_rows > 0)
{  
    
  

    // CABECERA FICHERO REMESA.XML
 while( $rs = $result2->fetch_array(MYSQLI_ASSOC))
 {       
        
    $proveedor=$rs["RAZON_SOCIAL"] ;
    $email_pagos=$rs["email_pagos"] ;
//    $proveedor=$rs["PROVEEDOR"] ;
    $importe=cc_format($rs["importe"],'moneda') ;
    $observaciones=substr($rs["observaciones"],0,34) ;
    $iban=substr($rs["IBAN"],0,8).'...'.substr($rs["IBAN"],-4) ;
    
    
//    $observaciones_abono="$empresa {$rs["observaciones"]}" ;
//    $observaciones_abono=substr($observaciones_abono,0,34) ;
//    $fecha=date('Y-m-d H:i:s') ;    
//    $iban=$rs["IBAN"] ;
//    $bic=$rs["BIC"] ;
     //por ejemplo mail
  $mail = new phpmailer();
  $mail->CharSet = "UTF-8";
  
  $mail->Mailer = "smtp";

  //Asignamos a Host el nombre de nuestro servidor smtp
  $mail->Host = "sw24.es";
//  $mail->Host = "smtp.serviciodecorreo.es";
  //Le indicamos que el servidor smtp requiere autenticación
  $mail->SMTPAuth = true;

  $mail->Username = "admin@sw24.es"; 
  $mail->Password = clave_mail();
   
  //Indicamos cual es nuestra dirección de correo y el nombre que 
  //queremos que vea el usuario que lee nuestro correo
  $mail->From = "juanduran@ingenop.com"; 
  $mail->FromName = "INGENOP";

  //Indicamos cual es la dirección de destino del correo
  $mail->AddAddress($email_pagos);
  $mail->AddAddress("juanduran@ingenop.com");
//  $mail->AddAddress("jduran2222@gmail.com");

  //Asignamos asunto y cuerpo del mensaje
  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
  //que se vea en negrita
  
  $mail->ConfirmReadingTo = "juanduran@ingenop.com";

  $mail->Subject = "Información de pago de Ingenop";
  $mail->Body = "<b>Les comunicamos que se ha ordenado la siguiente transferencia, la cual se hará efectiva en unas horas:</b><br>"
          . "<br>"
          . "<br>Proveedor: $proveedor "
          . "<br>Pago: $observaciones"
          . "<br>IBAN de abono: $iban"
          . "<br>Importe: <b>$importe</b>"
          . "<br>"
          . "<br>Saludos"
          . "<br>INGENOP";

  //Definimos AltBody por si el destinatario del correo no admite email con formato html 
  $mail->AltBody ="Se ha realizado el pago al Proveedor: $proveedor,  Pago: $observaciones, Importe: $importe" ;
       
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
	echo "<br/><br/><br/><br/>ERROR enviando correo electrónico ";
	echo "<br/>". $email_pagos;	
	echo "<br/>". $mail->Body;	
//	echo "<br/>".$mail->ErrorInfo;	
   }else
   {
	echo "<br/><br/><br/><br/>Mensaje enviado correctamente";
	echo "<br/>". $email_pagos;	
        echo "<br/>". $mail->Body;	

   } 
   
   
   }

}

 echo "<br><br><button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick=\"window.close()\"/><i class='far fa-window-close'></i> cerrar ventana</button>" ;



$Conn->close();


?>