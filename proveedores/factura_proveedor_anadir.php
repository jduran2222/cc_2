<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

$id_proveedor = isset($_GET["id_proveedor"]) ? $_GET["id_proveedor"] : getVar('id_proveedor_auto') ;   // si no se indica el id_proveedor lo asigno a getVar('id_proveedor_auto')
        
if ($id_fra_prov= factura_proveedor_anadir(0,$id_proveedor))
{    
          echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/factura_proveedor.php?_m=$_m&id_fra_prov=$id_fra_prov'>" ;
}
 else
{
 	echo "Error al crear factua prov, inténtelo de nuevo " ;
	echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
   
}


// determinamos si además de crear la nueva factura hay que linkarle un documento
//$id_documento=isset($_GET["id_documento"]) ? $_GET["id_documento"] : 0 ;  ;
//
//$id_proveedor= getVar('id_proveedor_auto');
//$fecha=date('Y-m-d');
//
//$sql="INSERT INTO `FACTURAS_PROV` ( `ID_PROVEEDORES`,N_FRA,FECHA,IMPORTE_IVA,`user` )    VALUES (  '$id_proveedor','num_factura', '$fecha' ,'0', '{$_SESSION["user"]}' );" ;
//// echo ($sql);
//$result=$Conn->query($sql);
//          
// if ($result) //compruebo si se ha creado la obra
//             { 	$id_fra_prov=Dfirst( "MAX(ID_FRA_PROV)", "Fras_Prov_Listado", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
//	        // TODO OK-> Entramos a pagina_inicio.php
////	       echo "factura proveedor creada satisfactoriamente." ;
////		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
//              if( $id_documento)
//              {
//                $sql="UPDATE `Documentos` SET `tipo_entidad` = 'fra_prov',  `id_entidad` = '$id_fra_prov'  "
//                      ."WHERE $where_c_coste AND `tipo_entidad`='pdte_clasif' AND id_documento=$id_documento; " ;
////               echo ($sql);
//  
//         	$result=$Conn->query($sql);
//  
//              }  
//             
//             
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov'>" ;
//
//	     }
//	       else
//	     {
//		echo "Error al crear factua prov, inténtelo de nuevo " ;
//		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
//	     }
       

?>