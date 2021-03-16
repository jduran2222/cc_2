<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_cta_banco= getVar('id_cta_banco_auto');
$fecha=date('Y-m-d');
$tipo_remesa=isset($_GET["tipo_remesa"]) ? $_GET["tipo_remesa"] : 'P' ;
$id_pago=isset($_GET["id_pago"]) ? $_GET["id_pago"] : '' ;

$remesa= $_GET["remesa"] ? $_GET["remesa"] : "remesa ". date('Y-m-d H:i:s') ;


$sql="INSERT INTO `Remesas` ( remesa, id_cta_banco,f_vto,`user`,tipo_remesa )    VALUES (  '$remesa','$id_cta_banco','$fecha' , '{$_SESSION["user"]}' ,'$tipo_remesa' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	
//              $id_remesa=Dfirst( "MAX(id_remesa)", "Remesas_View", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
              $id_remesa=$Conn->insert_id ; 
              
              if ($id_pago)
              {  
                  $sql_update= "UPDATE `PAGOS` SET id_remesa='$id_remesa'  WHERE  id_pago='$id_pago' ; "  ;
                  // echo ($sql);
                  $result=$Conn->query($sql_update);
              }

              
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/remesa_ficha.php?id_remesa=$id_remesa'>" ;

	     }
	       else
	     {
		echo "Error al crear registro, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>