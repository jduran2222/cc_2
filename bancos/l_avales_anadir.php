<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
//$id_cta_banco= getVar('id_cta_banco_auto');
$fecha=date('Y-m-d');

$sql="INSERT INTO `Lineas_Avales` ( id_c_coste,fecha,`banco` )    VALUES (  '{$_SESSION['id_c_coste']}','$fecha' , 'linea avales nueva' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	
              $id_linea_avales=Dfirst( "MAX(id_linea_avales)", "Lineas_Avales", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/l_avales_ficha.php?id_linea_avales=$id_linea_avales'>" ;

	     }
	       else
	     {
		echo "Error al crear registro, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>