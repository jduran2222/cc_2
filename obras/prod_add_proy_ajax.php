<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=$_GET["id_obra"]  ;
$id_produccion=$_GET["id_produccion"]  ;
$fecha=$_GET["fecha"]  ;
$factor=$_GET["factor"]  ;

//$select_MEDICION= $_GET["vacio"]==1 ? " 0 as MEDICION " : "MED_PROYECTO*$factor AS MEDICION"  ;

require_once("../../conexion.php");
require_once("../include/funciones.php");
 

$sql2 = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION ) "
        . "SELECT $id_produccion as ID_PRODUCCION, '$fecha' AS Fecha, ID_UDO, MED_PROYECTO*$factor AS MEDICION "
           . " FROM Udos WHERE ID_OBRA=$id_obra "  ;
    

if ($Conn->query($sql2))
    {  echo "$sql" ; }
    else
    {  echo "ERROR: $sql" ; }
    
        
       

 

?>