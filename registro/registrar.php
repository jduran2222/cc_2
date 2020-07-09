<?php

include_once('../include/conexion.php');
include_once('../include/funciones.php');

$error=0 ;

//Autologin
$login = '';
if (isset($_GET["login"])) {
  $login=decrypt2(($_GET["login"]))   ;
  parse_str($login, $_POST) ;
}    

//Datos de formulario:
$email = (isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '');
$password = (isset($_POST['password']) ? $_POST['password'] : '');

$where_empresa=isset($_POST["id_c_coste"])? "id_c_coste={$_POST["id_c_coste"]}" : "1=1";

$_SESSION['android']= preg_match('/Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']) ;     // estamos en un movil o tablet

// GEOLOCALIZACION DE LA IP
$ip=$_SERVER['REMOTE_ADDR'] ;
$json_geoip=json_geoip($ip) ;
$pais= pais($json_geoip); 

$login=0;

// //[FJSL-2020-07-05] Revisar por qué las claves son distintas
// $sql="SELECT * FROM Usuarios WHERE email='f.sanchez@solucionessl.com' AND id_usuario = 133 " ;
// $result=$Conn->query($sql);
// while ( $rs = $result->fetch_array(MYSQLI_ASSOC) ) {
//   var_dump($rs);
// }
// exit ;
// //--- [FJSL-2020-07-05] Revisar por qué las claves son distintas

// INICIAMOS COMPROBACION DE IDENTIFICACION
// $sql="SELECT id_usuario,id_c_coste,usuario,password_hash,email,admin,admin_chat,autorizado FROM Usuarios_View WHERE email='$email' AND activo=1 AND $where_empresa " ;
$sql="SELECT * FROM Usuarios_View WHERE email='$email' AND activo=1 AND $where_empresa " ;
$result=$Conn->query($sql);

if ( ($num_empresas=$result->num_rows)>0 ) {
  while ( $rs = $result->fetch_array(MYSQLI_ASSOC) ) { 
    $password_hash_db= $rs["password_hash"];
    //  COMPROBACION DE PASSWORD PENDIENTE DE DESARROLLAR
    if (cc_password_verify_hash($password , $password_hash_db)) {
      $login=1;
      registra_session($rs);
      registrar_acceso($_SESSION["id_c_coste"],$_SESSION["user"],$_SESSION["empresa"],'Acceso OK',$ip, 0, $_SESSION['android'] ,$pais, $json_geoip) ;
      if ( $num_empresas>1 ) {
        header('Location: ../menu/pagina_empresas.php');
      }
      else {    
        header( ($_SESSION['android'] ?  'Location: ../menu/menu_app.php' : 'Location: ../menu/pagina_inicio.php' )  );
      }
    }
  }
  //En caso de no tener acceso registrar fallo:
  if (!$login) {
    registrar_acceso(0,"$email","error_no_password","$email CORRECTO, password ERRONEO: $password ",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
    $error = 1;
  }
}
else {
  registrar_acceso(0,$email,'error_no_email',"email INCORRECTO : $email",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
  $error = 2;
}

if ($error) {
  $html = '';
  // echo  " <center><div >   <p align=center style='font-size:30px ; text-align:center; color:lightskyblue; font-family:verdana '><br>ConstruCloud.es<br>"
	// . "<img src='../img/construcloud256.jpg'></p></div>";
  // echo "<br><br><br><h3>¡ERROR DE ACCESO cod: $error!, <br><br>si no tiene cuenta puede";
  // echo " <a class='btn btn-link btn-lg' href='../registro/empresa_nueva_form.php' >crear una empresa</a> de forma gratuita</h3>";
  // echo  "<br><h1><a class='btn btn-primary btn-lg' href='javascript:history.back(-1);' title='Ir la página anterior'>Volver a intentarlo</a></h1>";
  $Conn->close();
  header('Location: ../registro/index.php?credenciales=false');
  exit;
}

$Conn->close();
