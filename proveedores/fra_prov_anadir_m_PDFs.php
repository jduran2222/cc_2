<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 








$id_proveedor= getVar('id_proveedor_auto');
$fecha=date('Y-m-d');

$sql="INSERT INTO `FACTURAS_PROV` ( `ID_PROVEEDORES`,N_FRA,FECHA,IMPORTE_IVA,`user` )    VALUES (  '$id_proveedor','', '$fecha' ,'0', '{$_SESSION["user"]}' );" ;
 echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_fra_prov=Dfirst( "MAX(ID_FRA_PROV)", "Fras_Prov_Listado", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
	       echo "factura proveedor creada satisfactoriamente." ;
		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov'>" ;

	     }
	       else
	     {
		echo "Error al crear factua prov, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>