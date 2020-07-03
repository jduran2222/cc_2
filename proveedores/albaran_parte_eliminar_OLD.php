<?php
require_once("../include/session.php");



require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
if (isset($_GET["id_parte"]))
{    
//  $id_vale=$_GET["id_vale"] ;
  $id_parte=$_GET["id_parte"] ;
  
  $id_parte=Dfirst('ID_PARTE','Partes_View','ID_PARTE='.$id_parte.' AND '.$where_c_coste) ;        // confirmamos que el id_parte existe en el c_coste
  $id_vale=Dfirst('ID_VALE','Partes_View','ID_PARTE='.$id_parte.' AND '.$where_c_coste) ;
  
  if( $id_vale AND $id_parte ) 
  {       
     $sql="UPDATE `PARTES` SET `ID_VALE` = NULL " 
               ."WHERE  ID_PARTE='$id_parte' AND ID_VALE='$id_vale'  ; " ;

    //echo ($sql);
     
     if ( $Conn->query($sql))
     {        
     $sql_delete="DELETE FROM `VALES` WHERE ID_VALE='$id_vale'  ; " ;

    //echo ($sql);
     
          
    if ($Conn->query($sql_delete))       //compruebo si se ha creado el cliente
    {
//         { 	$id_vale=Dfirst( "MAX(ID_VALE)", "VALES", "ID_PROVEEDORES=$id_proveedor" ) ; 
//                if ($importe)         // valoramos el Vale
//                {
//                  $id_concepto_auto=Dfirst("id_concepto_auto","Proveedores" ,"ID_PROVEEDORES=$id_proveedor AND $where_c_coste" )  ;
////                  $id_subobra_auto=Dfirst("id_subobra_auto","OBRAS" ,"ID_OBRA=$id_obra AND $where_c_coste" )  ;
//                  $id_subobra_auto= getVar("id_subobra_si" )  ;
//                  $sql="INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) VALUES ( '$id_vale' , '$id_concepto_auto', '$importe'  ,   '$id_subobra_auto' );" ;
////                 echo ($sql);
//                  if (!$result=$Conn->query($sql))  die("ERROR: $sql");
//                          
//    
//                }
//         
//         
	             // TODO OK-> Entramos a clientes_ficha.php
//	echo "VALE eliminado satisfactoriamente." ;
//        echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/albaran_proveedor.php?id_vale=$id_vale'>" ;
        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 

     }
	 else
	  {
			echo "Error al eliminar VALE, inténtelo de nuevo " ;
			echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
}

}
 else
{
    echo "Error al eliminar VALE, inténtelo de nuevo " ;
}
}
else
{
    echo "Error al eliminar VALE, inténtelo de nuevo " ;
}   
?>