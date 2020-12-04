<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 


$fecha=date('Y-m-d');

if (isset($_GET["id_linea_avales"]))
{   
  $id_linea_avales=$_GET["id_linea_avales"]  ;	
}
else   // 
{
  $id_linea_avales=getvar("id_linea_avales_auto") ;
  
  if (!$id_linea_avales)  // NO HAY id_linea_avales_auto.  La creamos
  {
  $sql="INSERT INTO `Lineas_Avales` ( id_c_coste,fecha,`banco` )    VALUES (  '{$_SESSION['id_c_coste']}','$fecha' , 'linea avales nueva' );" ;
//   echo ($sql);
  $result=$Conn->query($sql);
  if ($result) //compruebo si se ha creado la obra
        { 	
         $id_linea_avales=Dfirst( "MAX(id_linea_avales)", "Lineas_Avales", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
         setVar("id_linea_avales_auto", $id_linea_avales) ;        // cre3amos la nueva variable 'id_linea_avales_auto' 
        }
      else
       {cc_die('ERROR CREANDO LINEA DE AVALES');
       }
  }
}   


// decidimos que ID_OBRA usar
if (isset($_GET["id_obra"]))
{   
  $id_obra=$_GET["id_obra"]  ;	
}
else   // 
{
  $id_obra=getvar("id_obra_gg") ;

}   



//$id_cta_banco= getVar('id_cta_banco_auto');


$sql="INSERT INTO `Avales` ( id_linea_avales,id_c_coste,FECHA,F_Recogida,MOTIVO,`ASEGURADORA`, ID_OBRA) " . 
     " VALUES ( '$id_linea_avales', '{$_SESSION['id_c_coste']}','$fecha','$fecha' , 'motivo del aval', 'aseguradora','$id_obra' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	
              $id_aval=Dfirst( "MAX(ID_AVAL)", "Avales", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/aval_ficha.php?id_aval=$id_aval'>" ;

	     }
	       else
	     {
		echo "Error al crear registro, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>