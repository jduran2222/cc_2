<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

//$id_obra=$_GET["id_obra"]  ;
$id_produccion=$_GET["id_produccion"]  ;
$table_selection_IN=$_GET["table_selection_IN"]  ;
//$fecha=$_GET["fecha"]  ;
$fecha=date('Y-m-d');


require_once("../../conexion.php");
require_once("../include/funciones.php");

//$sql="SELECT * FROM PRODUCCIONES WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra ;"  ;
$result=$Conn->query($sql="SELECT * FROM Prod_view WHERE ID_PRODUCCION=$id_produccion AND $where_c_coste ");
$rs = $result->fetch_array() ;

//$id_obra=$rs["ID_OBRA"]  ;

 if($id_produccion=Dfirst("ID_PRODUCCION","Prod_view", "ID_PRODUCCION=$id_produccion AND $where_c_coste" ))   // CONFIRMAMOS QUE LA ID_PRODUCCION ES DEL ID_C_COSTE
 {

  $sql = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION ) "
        . "SELECT $id_produccion AS ID_PRODUCCION, '$fecha' AS Fecha , ID_UDO , med_completar AS MEDICION "
        . "FROM Prod_detalle_completar "
        . " WHERE ID_PRODUCCION=$id_produccion AND ID_UDO IN  $table_selection_IN " ;

  if ($result=$Conn->query($sql))
  {   echo "OK" ; }
  else {   echo "ERROR: $sql" ; 
  
  }
 }
 
  

//
//
// if ($result) //compruebo si se ha creado la obra
//             { 	
//              $id_produccion2=Dfirst( "MAX(ID_PRODUCCION)", "PRODUCCIONES", "ID_OBRA=$id_obra" ) ; 
//	        // TODO OK-> Entramos a pagina_inicio.php
////	       echo "factura proveedor creada satisfactoriamente." ;
////		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
////                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/aval_ficha.php?id_aval=$id_aval'>" ;
//
//            $sql2 = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION, Observaciones ) "
//               . "SELECT $id_produccion2 as ID_PRODUCCION,  '$fecha' AS Fecha, ID_UDO, MEDICION,Observaciones  "
//               . " FROM PRODUCCIONES_DETALLE WHERE ID_PRODUCCION=$id_produccion  ; "  ;
//      
//             if (!$Conn->query($sql2)) { echo "ERROR añadiendo detalles: $sql2" ; }; 
//             
//	     }
//	       else
//	     {
//		echo "ERROR creando produccion: $sql2" ;
////		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
//	     }
//            


?>