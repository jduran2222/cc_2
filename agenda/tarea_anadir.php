<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 


//$fecha=date('Y-m-d');

$tipo_entidad = isset($_GET["tipo_entidad"]) ? $_GET["tipo_entidad"] : 'general' ;
$indice = isset($_GET["indice"]) ? $_GET["indice"] : '' ;
$id_entidad = isset($_GET["id_entidad"]) ? $_GET["id_entidad"] : 0 ;

  

$sql="INSERT INTO `Tareas` ( id_c_coste,tipo_entidad,indice,id_entidad,Tarea, usuarios , user) "
        . "   VALUES (  '{$_SESSION['id_c_coste']}','$tipo_entidad','$indice' ,'$id_entidad' , '','{$_SESSION['user']} , ','{$_SESSION['user']}' );" ;
  // echo ($sql);
$result=$Conn->query($sql);
           
if ($result) //compruebo si se ha creado la obra
             { 	
              $id=Dfirst( "MAX(id)", "Tareas", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../agenda/tarea_ficha.php?id=$id'>" ;

	     }
	       else
	     {
		echo "Error al crear registro, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>