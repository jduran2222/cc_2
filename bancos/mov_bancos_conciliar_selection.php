<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		
//$id_cta_banco= getVar('id_cta_banco_auto');

//$id_remesa=$_GET["id_remesa"]   ;
//$array_str=$_GET["array_str"]   ;
$array_str=rawurldecode($_GET["array_str"])   ;


//$fecha=date('Y-m-d');

//if ($id_remesa==0)      // si la id_remesa es 0, CREAMOS NUEVA REMESA
//{   
//$sql="INSERT INTO `Remesas` ( id_cta_banco,f_vto,remesa,`user` )    VALUES (  '$id_cta_banco','$fecha' ,'remesa automatica', '{$_SESSION["user"]}' );" ;
// echo ($sql);
//$result=$Conn->query($sql);
// if ($result) //compruebo si se ha creado la obra
//     { 	
//     $id_remesa=Dfirst( "MAX(id_remesa)", "Remesas_View", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
//     }
//     else
//     {
//      echo "Error al crear Remesa, inténtelo de nuevo " ;
//      echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
//     }
//     
//}
   
// YA TENEMOS id_remesa  (nueva o elegida) y empezamos a añadirle las facturas de proveedor
     
 $values_mov_banco_pago_array = explode("-", $array_str);
      
  foreach ($values_mov_banco_pago_array as $values_mov_banco_pago)    
       {
           // definimos las variables para crear el ID_PAGO
//           $importe_iva=Dfirst( "IMPORTE_IVA", "Fras_Prov_Listado", "ID_FRA_PROV=$id_fra_prov  AND  id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
//           $n_fra=Dfirst( "N_FRA", "Fras_Prov_Listado", "ID_FRA_PROV=$id_fra_prov  AND  id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
//           $proveedor=substr(Dfirst( "PROVEEDOR", "Fras_Prov_Listado", "ID_FRA_PROV=$id_fra_prov  AND  id_c_coste={$_SESSION["id_c_coste"]}" ), 0, 15) ; 
//           $observaciones="$proveedor fra $n_fra" ; 
           
           // INSERTAMOS EL ID_PAGO
//           $sql="INSERT INTO `PAGOS_MOV_BANCOS` ( id_mov_banco,id_pago )    VALUES $values_mov_banco_pago  ;" ;  // SUSTITUIDA POR ELIMINACION DE TABLA PAGOS_MOV_BANCOS
 
           $par_array = explode("&", $values_mov_banco_pago);
           $sql="UPDATE PAGOS SET id_mov_banco='{$par_array[0]}' WHERE id_pago={$par_array[1]} ;"  ;
           
//           echo ("<br>$sql");           
           if( $result=$Conn->query($sql) )
           {
            echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 
           }   
           else
           {   
           echo ("<br>ERROR: Resultado insertar ID_PAGO. SQL: $sql");           
           }
//           $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 
           
           // Insertamos la relación FRA_PROV_PAGOS
//           $sql="INSERT INTO `FRAS_PROV_PAGOS` (id_fra_prov , id_pago) VALUES ( '$id_fra_prov','$id_pago' );" ;
//           echo ("<br>$sql");           
//           $result=$Conn->query($sql);
//           echo ("<br>Resultado insertar FRAS_PROV_PAGOS: $result");           

            
           
       }
      
//echo ("<br>CONCILIACION TERMINADA SATISTACTORIAMENTE");     
//echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/remesa_ficha.php?id_remesa=$id_remesa'>" ;
    

?>