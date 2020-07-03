<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 

require_once("../../conexion.php");
require_once("../include/funciones.php");


$id_produccion=$_GET["id_produccion"]  ;

if (isset($_GET["array_str"]))  // viene un array?
{
  $array_str=rawurldecode($_GET["array_str"]) ;  
  $observaciones="" ;
  $fecha=date('Y-m-d');
}
else
{    
  $id_udo=$_GET["id_udo"]  ;
  $medicion=$_GET["medicion"]  ;
  $observaciones= isset($_GET["observaciones"]) ? $_GET["observaciones"] : ""  ;
  $fecha= isset($_GET["fecha"]) ? $_GET["fecha"] : date('Y-m-d')  ;
  
  $array_str="$id_udo&$medicion"  ;  // simulamos el array de datos
}


//$fecha=date('Y-m-d');

$filas = explode(";", $array_str);

foreach ($filas as $fila)
{ 
   $c = explode("&", $fila);
   
   $id_udo = $c[0] ;
   $medicion=$c[1] ;
   
   $sql3 = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION,Observaciones,user ) "
        . "VALUES ( $id_produccion , '$fecha' , $id_udo , '$medicion', '$observaciones', '{$_SESSION["user"]}' ) " ;
   
  if ($Conn->query($sql3))
    { 
//      echo "$sql3" ; 
      	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";	

      
    }
     else
    {  echo "ERROR: $sql3" ; }
    
}    
        
       

 

?>