<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_udo=$_GET["id_udo"]  ;
//$id_produccion=$_GET["id_produccion"]  ;
//$fecha=$_GET["fecha"]  ;
//
//$select_MEDICION= $_GET["vacio"]==1 ? " 0 as MEDICION " : "MED_PROYECTO AS MEDICION"  ;

require_once("../../conexion.php");
require_once("../include/funciones.php");
 

$Estudio_coste= Dfirst("Estudio_coste", "Udos_View","id_udo=$id_udo AND $where_c_coste" ) ;  //aqui comprobamos la integridad de id_udo implicitamente


//compatibilidad con el uso de bin2hex en abril2020
if(preg_match("/__HEX__/", $Estudio_coste) ){ $Estudio_coste = hex2bin ( preg_replace("/__HEX__/", "", $Estudio_coste)) ; }


if ($id_udo and $Estudio_coste)   // comprobamos que estudio_coste existe y que no es vacio
{    
    
   // transformamos para limpiar la formula 
   $expresion = strip_tags($Estudio_coste);    // QUITAMOS LAS ETIQUETAS HTML TAGS
//   $expresion = strip_tags('<a>10.3</a>  #JUAN_DURAN  @REFER1  OTRO');    // QUITAMOS LAS ETIQUETAS HTML TAGS
//   $pos=strrpos($expresion,"=") ;     // ultima aparicion de =
//   $expresion= substr($Estudio_coste, $pos + 1) ;
   
   $expresion=  str_replace(["=","..."], '', $expresion); 
   
   logs("EXPRESION tras tags: $expresion");
   //quitamos las #HASHTAG y @REFERENCIAS
    $pattern = "/\B((?<![\"\'=>])#)(\S)+/";
     $expresion = preg_replace($pattern,'', $expresion ) ;
    $pattern = "/\B((?<![\"\'=>])@)(\S)+/";
     $expresion = preg_replace($pattern,'', $expresion ) ;

   logs("EXPRESION tras # @: $expresion");
//   $valor= evalua_expresion($expresion) ;                 // antigua formula de evaulacion, cambiada por la de MYSQL
   $valor= evalua_expresion_mysql($expresion) ;                 // nueva formula de evaulacion usando de MYSQL
   

   
   $sql= "UPDATE `Udos` SET `COSTE_EST` = '$valor' WHERE ID_UDO=$id_udo  "  ;
//   $sql= "UPDATE `Udos` SET `Estudio_coste` = '$valor' WHERE ID_UDO=$id_udo  "  ;
   
   if (!($Conn->query($sql)))                   // ejecutamos el UPDATE y si hay ERROR enviamos msg de error
   {  echo "ERROR en expresion: $exp"  ; }
   else
   {  echo $valor ; }    
       
}   
?>