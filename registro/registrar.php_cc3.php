<?php
ini_set("session.use_trans_sid",true);
session_start();
?>

<html>
<head>
  <title>ConstruCloud</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</head> 
<body>
	
	
<?php           //           ACCESO AL SISTEMA
	
require_once( "../../conexion.php") ;
require_once("../include/funciones.php"); 

	
 //Registramos en w_Accesos el acceso a la web
//function registrar_acceso($user,$pass,$resultado)
//{
//  //extract($GLOBALS);
//	
//	 $sql="insert into w_accesos (ip, usuario, clave,  sistema, resultado) values  ('{$_SERVER["REMOTE_ADDR"]}','$user','$pass','$resultado')";
//         $result = $Conn->query($sql);
//
//	return $result;
//} 


//confirmo si es autologin para simular el logueado
if (isset($_GET["login"]))
{
     $login=decrypt2(($_GET["login"]))   ;
     parse_str( $login, $_POST ) ;     // reconstruimos $_GET[] tras desencriptar y continuamos como si nada
}    
    
 $error=0 ;


 $email=trim(strtolower($_POST["email"])); //recojo los valores del formulario y los convierto en miniscula
// $empresa=strtolower($_POST["empresa"]);

 $password=$_POST["password"];
 $where_empresa=isset($_POST["id_c_coste"])? "id_c_coste={$_POST["id_c_coste"]}" : "1=1" ;

 $_SESSION['android']= preg_match('/Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']) ;     // estamos en un movil o tablet

    // GEOLOCALIZACION DE LA IP
 $ip=$_SERVER['REMOTE_ADDR'] ;
 $json_geoip=json_geoip($ip) ;
 $pais= pais($json_geoip); 

 $login=0;   
        // INICIAMOS COMPROBACION DE IDENTIFICACION
// $sql="SELECT id_usuario,id_c_coste,usuario,password_hash,email,admin,admin_chat,autorizado FROM Usuarios_View WHERE email='$email' AND activo=1 AND $where_empresa " ;
 $sql="SELECT * FROM Usuarios_View WHERE email='$email' AND activo=1 AND $where_empresa " ;
 $result=$Conn->query($sql);

if (($num_empresas=$result->num_rows)>0)  
{ 
                  
//              if ($id_usuario=Dfirst("id_usuario","Usuarios","usuario='$user' AND id_c_coste=$id_c_coste")) //existe el usuario en esa empresa
             
              while ( $rs = $result->fetch_array(MYSQLI_ASSOC) )   
                { 
                   
//                       $password_hash_db= Dfirst("password_hash","Usuarios","id_usuario=$id_usuario AND id_c_coste=$id_c_coste") ;
                     $password_hash_db= $rs["password_hash"] ;
//                     if ($password==decrypt(Dfirst("password_web","Usuarios","id_usuario=$id_usuario AND id_c_coste=$id_c_coste")))  //  COMPROBACION DE PASSWORD PENDIENTE DE DESARROLLAR
                     if (cc_password_verify_hash($password , $password_hash_db))          //  COMPROBACION DE PASSWORD PENDIENTE DE DESARROLLAR
                      {      
                         
//                         // PROVISIONALMENTE, GUARDAMOS LAS PASSWORD EN FREE PARA MIGRARLAS A OPENSSL, anulado JUAND, JULIO2020
//                              $sql_update= "UPDATE `Usuarios` SET password_free='$password'  WHERE  id_usuario={$rs["id_usuario"]}   ; "  ;
//                              $Conn->query($sql_update) ;
 
                  
                         //   $num_empresas
                               $login=1;   
                              // cc_password_verify_hash($password, $cc_hash)
//                               $_SESSION["email"]=$rs["email"] ;
//                               $_SESSION["id_c_coste"]=$rs["id_c_coste"] ;
//                               $_SESSION["empresa"]=Dfirst("C_Coste_Texto","C_COSTES","id_c_coste={$_SESSION["id_c_coste"]}");
//                               $_SESSION["user"]=$rs["usuario"] ;
//                               $_SESSION["id_usuario"]=$rs["id_usuario"] ;
//                               $_SESSION["admin"]=$rs["admin"] ;
//                               $_SESSION["admin_chat"]=$rs["admin_chat"] ;
//                               $_SESSION["autorizado"]=$rs["autorizado"] ;
//                               $_SESSION["Moneda_simbolo"]=trim($rs["Moneda_simbolo"]) ;
//                               $_SESSION["permiso_licitacion"]=$rs["permiso_licitacion"] ;
//                               $_SESSION["permiso_obras"]=$rs["permiso_obras"] ;
//                               $_SESSION["permiso_administracion"]=$rs["permiso_administracion"] ;
//                               $_SESSION["permiso_bancos"]=$rs["permiso_bancos"] ;
//
////                               $cif=Dfirst("cif","C_COSTES","id_c_coste={$_SESSION["id_c_coste"]}") ;
//                               $_SESSION["cif"]=$rs["cif"] ;
//                               $_SESSION["invitado"]=0 ;       
   
                                 registra_session($rs) ;
                               
                               //registrar_acceso($user,$empresa2,"OK") ; 
                               
                               registrar_acceso($_SESSION["id_c_coste"],$_SESSION["user"],$_SESSION["empresa"],'Acceso OK',$ip, 0, $_SESSION['android'] ,$pais, $json_geoip) ;
                               
//                               $sql="insert into w_Accesos (id_c_coste,ip, usuario, clave,  sistema, resultado) "
//                                       . " values  ($id_c_coste,'{$_SERVER['REMOTE_ADDR']}','$user','$empresa' , '{$_SERVER['HTTP_USER_AGENT']}','Acceso OK')";
//                               $result = $Conn->query($sql);

                               if ($num_empresas>1)    //tenemos más de una empresa
                               {
                                 header('Location: ../menu/pagina_empresas.php');         // TODO OK-> Entramos a pagina_inicio.php  
                               }
                               else
                               {    
                                 header( ($_SESSION['android'] ?  'Location: ../menu/menu_app.php' : 'Location: ../menu/pagina_inicio.php' )  );         // solo tenemos una empresa 
                               }

                               
               
                      }
//                     else
//                      { 
////                                echo "Error password erróneo  " ;
//                                //registrar_acceso($user,$empresa2,"Error empresa errónea: $empresa") ;
//                                registrar_acceso($id_c_coste,$user,$empresa,"Error password erróneo user $user, empresa  $empresa, password $password",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
//
////                                 $sql="insert into w_Accesos (id_c_coste, ip, usuario, clave,  sistema, resultado) values  "
////                                         . "($id_c_coste,'{$_SERVER['REMOTE_ADDR']}','$user','$empresa' , '{$_SERVER['HTTP_USER_AGENT']}','Error password erróneo user $user, empresa  $empresa, password $password')";
////                                 $result = $Conn->query($sql);
//                                
//                               $error=1 ;
////                               echo "DEBUG" ;
////                               die("LOGIN ERROR") ;
//
//
//                      }
               }   // salimos del bucle SIN ÉXITO, el email era correcto pero el password no

               if (!$login)   // fuerzo a no registrar acceso erroneo
               {  registrar_acceso(0,"$email","error_no_password","$email CORRECTO, password ERRONEO: $password ",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
                  $error=1 ;
               }

}       // el email no tiene empresas, no extá registrado
 else
{
//                echo "<br><br><br><br><br><br><h1>La Empresa <b><i>$empresa</i></b> no está registrada, ¿desea crearla?</h1>" ;
//                echo "<h1><a class='btn btn-primary btn-lg' href='../registro/empresa_nueva_form.php' >Crear empresa GRATIS</a></h1>" ;
                 registrar_acceso(0,$email,'error_no_email',"email INCORRECTO : $email",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
                 $error=2 ;
//                 echo "<br><br><br><br><br><br><h1>La Empresa <b><i>$empresa</i></b> no está registrada, ¿desea crearla?</h1>" ;
//                 echo "<h1><a class='btn btn-primary btn-lg' href='../registro/empresa_nueva_form.php' >Crear empresa GRATIS</a></h1>" ;
//                 echo  "<br><h1><a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a></h1>" ;


//                 $sql="insert into w_Accesos (id_c_coste,ip, usuario, clave,  sistema, resultado) values  (0,'{$_SERVER['REMOTE_ADDR']}','$user','$empresa' , '{$_SERVER['HTTP_USER_AGENT']}','Error empresa no existe: $empresa')";
//                 $result = $Conn->query($sql);

                //echo "<a href=\"../index.php\">Volver</a>" ;
 }
 
 if ($error)
 {
  
  echo  " <center><div >   <p align=center style='font-size:30px ; text-align:center; color:lightskyblue; font-family:verdana '><br>ConstruCloud.es<br>"
		. "<img src='../img/construcloud256.jpg'></p></div>" ;
   
  echo "<br><br><br><h3>¡ERROR DE ACCESO cod: $error!, <br><br>si no tiene cuenta puede" ;
  echo " <a class='btn btn-link btn-lg' href='../registro/empresa_nueva_form.php' >crear una empresa</a> de forma gratuita</h3>" ;
  echo  "<br><h1><a class='btn btn-primary btn-lg' href='javascript:history.back(-1);' title='Ir la página anterior'>Volver a intentarlo</a></h1>" ;
  
 }      

$Conn->close();

		
?>
	
<?php require '../include/footer.php'; ?>
</BODY>
</html> 
