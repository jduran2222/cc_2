<?php
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		

$id_usuario=$_GET["id_usuario"]   ;
$observaciones= isset($_GET["observaciones"])? $_GET["observaciones"] : ""   ;
$tipo_entidad=$_GET["tipo_entidad"]   ;
$array_str=$_GET["array_str"]   ;

//$fecha=date('Y-m-d');


$array_id_entidad = explode("-", $array_str);

if($id_usuario=Dfirst("id_usuario","Usuarios", "id_usuario=$id_usuario AND $where_c_coste"))
{
    foreach ($array_id_entidad as $id_entidad)    
   {
       // definimos las variables para crear el ID_PAGO
//       $pdte_pago=  round(Dfirst( "pdte_pago", "Fras_Prov_View", "ID_FRA_PROV=$id_fra_prov  AND  $where_c_coste" ),2) ; 
        
       $firma = entidad_descripcion($tipo_entidad,$id_entidad );

       $sql_insert= "INSERT INTO `Firmas` (`tipo_entidad`, `id_entidad`,`id_usuario`, firma ,observaciones,   user) "
            . "VALUES ( '$tipo_entidad', '$id_entidad', '$id_usuario' , '$firma','$observaciones' , '{$_SESSION['user']}' );"   ;
  
       $result=$Conn->query($sql_insert);
   }

}           
//echo ("<br>TODO TERMINADO SATISTACTORIAMENTE");     
//echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/remesa_ficha.php?id_remesa=$id_remesa'>" ;
 
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 


?>