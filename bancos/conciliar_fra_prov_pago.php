<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		


//    $id_mov_banco=isset($_GET["id_mov_banco"]) ? $_GET["id_mov_banco"]: 'CAJA_METALICO'  ;         // si no viene el parámetro id_mov_banco , suponemos que va a PAGADO POR CAJA METALICO
$id_fra_prov=$_GET["id_fra_prov"]  ;
$id_pago=$_GET["id_pago"]  ;


// confirmamos COHERENCIA DE LOS DATOS para evitar hacker
$id_fra_prov=Dfirst("ID_FRA_PROV","Fras_Prov_Listado","ID_FRA_PROV=$id_fra_prov AND $where_c_coste") ;      
$id_pago=Dfirst("id_pago","Pagos_View","id_pago=$id_pago AND $where_c_coste" ) ;
    
 if ($id_pago AND $id_fra_prov )  // si los dos valores son distintos de CERO (es decir, son coherentes y existen en la BBDD)   
 {
      $sql="INSERT INTO FRAS_PROV_PAGOS ( id_fra_prov,id_pago ) VALUES ( '$id_fra_prov'  ,'$id_pago'  );" ;
      
      if ($result=$Conn->query($sql))
      {
         echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 
      }
      else
      {
          echo "ERROR EN CONCILIACION DE FRA_PROVEEDOR Y PAGO" ;
      }    
 
     
 }   
 else
      {
          echo "ERROR EN CONCILIACION DE FRA_PROVEEDOR Y PAGO. DATOS INCOHERENTES" ;
      }    
     

?>