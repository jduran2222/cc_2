<?php
ini_set("session.use_trans_sid",true);
//ini_set("session.gc_maxlifetime",180000);  // parece que no está funcionando
//ini_set('max_file_uploads', 50);

//Para mostrar errores de programación y demás sólo cuando quieran ser visualizados
if ($_GET['debugmode'] == 'si') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// intentando evitar  EL DOUBLE INSERT
//if(strpos($_SERVER['HTTP_USER_AGENT'],'Mediapartners-Google') !== false) {  exit();}
//if($_SERVER['REQUEST_URI'] == '/favicon.ico') {  exit();}

$_SESSION["adminlte"]=1;

require_once("../../conexion.php");
require_once("../include/funciones.php");

$_m=  isset($_GET['_m']) ?  $_GET['_m'] : '' ;    // inicializamos la variable migas de pan $_m
$_m.= "\\" .  str_replace('_ficha','', substr( basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']), 0,-4))  ;

//logs_db($_m) ;   // registro trazabilidad del usuario        suspendido , juand ene20

$dir_raiz = "https://" . $_SERVER['SERVER_NAME'] . "/web/"; 
$_SESSION["dir_raiz"]=$dir_raiz ;

if (!isset($_SESSION["logs"])) { $_SESSION["logs"] = '' ; }      // inicializamos $_SESSION["logs"]



//$debug = isset($_GET["debug"]) ? $_GET["dd"] : 0 ;

// comprobamos los accesos directos que evitan login (puertas de atrás)
  if (isset($_GET["login"]))         // ACCESO PUENTE DESDE URL PARA LOGUEARNOS CON GET login ENCRIPTADO
  {  
      
      // extraer el login con decrypt2
      // pasar por $_POST a REGOSTRO/registrar.PHP  (EMAIL Y PASSWORD)
      
      
//               require_once("../../conexion.php");
//               require_once("../include/funciones.php");
               $login=decrypt2(($_GET["login"]))   ;
               
               // FALTA DESCOMPONER LOGIN EN VARIABLES Y ENVIAR POR PIOST A REGISTRAR.PHP, JUAND 22/3/
            //   echo $_GET["login"]   ;   // DEBUG
            //   echo "<br>";
            //   echo base64_decode($_GET["login"])   ;
            //   echo "<br>$login";
               
               
               // GEOLOCALIZACION DE LA IP
                 $ip=$_SERVER['REMOTE_ADDR'] ;
                 $json_geoip=json_geoip($ip) ;
                 $pais= pais($json_geoip);

              $_SESSION['android']= preg_match('/Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']) ;     // estamos en un movil o tablet

               
               
               if ($login=='LOGIN_INVITADO2')        //JUAND
               {
                           $_SESSION["id_c_coste"]=1 ;
                           $_SESSION["empresa"]='ingenop' ;
                           $_SESSION["user"]='juand' ;
                           $_SESSION["admin"]=1 ;
                           $_SESSION["admin_chat"]=1 ;
                           $_SESSION["email"]='juanduran@ingenop.com' ;
                           $_SESSION["Moneda_simbolo"]='€' ;

                           $cif='B92334879' ;
                           $_SESSION["cif"]=$cif ;
                           $_SESSION["invitado"]=0 ;       
                           $_SESSION["autorizado"]=1 ;       
                           $_SESSION["permiso_licitacion"]=1 ;       
                           $_SESSION["permiso_obras"]=1 ;       
                           $_SESSION["permiso_administracion"]=1 ;       
                           $_SESSION["permiso_bancos"]=1 ;       


               } 
               elseif ($login=='LOGIN_INVITADO')
                   {

                           $_SESSION["id_c_coste"]=1 ;
                           $_SESSION["empresa"]='ingenop' ;
                           $_SESSION["user"]='invitado' ;
                           $_SESSION["admin"]=0 ;
                           $_SESSION["admin_chat"]=0 ;
                           $_SESSION["email"]='invitado' ;

                           $cif='B92334879' ;
                           $_SESSION["cif"]=$cif ;       
                           $_SESSION["invitado"]=1 ;   
                           $_SESSION["autorizado"]=0 ;       
                           


               }
                elseif ($login=='LOGIN_INVITADO_sergio')
                   {

                           $_SESSION["id_c_coste"]=1 ;
                           $_SESSION["empresa"]='ingenop' ;
                           $_SESSION["user"]='cristobal' ;
                           $_SESSION["admin"]=0 ; 
                           $_SESSION["admin_chat"]=0 ;
                           $_SESSION["email"]='invitado_cristobal' ;

                           $cif='B92334879' ;
                           $_SESSION["cif"]=$cif ;       
                           $_SESSION["invitado"]=1 ;  
                           $_SESSION["autorizado"]=0 ;       
                           


               }
               if (isset($_SESSION["id_c_coste"]))     // REGISTRAMOS ACCESO LOGIN OK
               {
                   
                   $_SESSION["id_usuario"]=Dfirst("id_usuario","Usuarios","usuario='{$_SESSION["user"]}' AND id_c_coste={$_SESSION["id_c_coste"]}") ;
                   registrar_acceso($_SESSION["id_c_coste"],$_SESSION["user"],$_SESSION["empresa"],'login_GET OK', $ip, 0, $_SESSION['android'], $pais, $json_geoip);
//function registrar_acceso($id_c_coste,$user,$empresa,$resultado,$sistema,$ip, $error, $android ,$pais='', $json_geoip='')

               }
               else {              /// ERROR EN ACCESO LOGIN
                   registrar_acceso(0,'error','ERROR','login_GET error',$ip,1,$_SESSION['android'],$pais, $json_geoip);
                   header('Location: ../index.php'); 
               }
//               $_SESSION['android']= preg_match('/Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']) ;     // estamos en un movil o tablet
               
  }
  
 else       // no venimos a loguearnos
     
  {
     if (!isset($_SESSION["id_c_coste"]))  // CONSULTAMOS SI ESTAMOS LOGUEADOS
//     if (1)  // CONSULTAMOS SI ESTAMOS LOGUEADOS
       {  header('Location: ../index.php');  }      // no estamos logueados ni traemos cadena de login, es decir, a Pantalla Index a loguearse.
    
   }
 // coletilla a añadir a todas las SQL para garantizar que nunca mezclamos datos de dos empresas
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;  
$admin= isset($_SESSION['admin']) ?  $_SESSION['admin'] : 0 ;   


// ANULAMOS PROVISIONALMENTE NO MOSTRAR LOS ERRORES
//if(!$admin){set_error_handler('logs_system_error') ;}          // si no somos ADMIN mandamos los errores a logs_db() y que no aparezcan en pantalla


?>