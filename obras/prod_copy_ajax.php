<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=$_GET["id_obra"]  ;
$id_produccion=$_GET["id_produccion"]  ;
//$where=  isset($_GET["where"]) ? $_GET["where"] : 'ID_PRODUCCION=$id_produccion '  ;

//$fecha=$_GET["fecha"]  ;
$fecha=date('Y-m-d');


require_once("../../conexion.php");
require_once("../include/funciones.php");

//$sql="SELECT * FROM PRODUCCIONES WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra ;"  ;
$result=$Conn->query("SELECT * FROM PRODUCCIONES WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra ");
$rs = $result->fetch_array() ;

$id_obra=$rs["ID_OBRA"]  ;
$id_produccion=$rs["ID_PRODUCCION"]  ;

//$where=  isset($_GET["where"]) ? rawurldecode($_GET["where"]) : " ID_PRODUCCION = $id_produccion "  ;
$where=  isset($_GET["where"]) ? base64_decode ($_GET["where"]) : " ID_PRODUCCION = $id_produccion "  ;

$produccion= isset($_GET["produccion"]) ? $_GET["produccion"] : $rs["PRODUCCION"] . " - copia - $fecha" ;      // nombre de la nueva produccion

$sql2 = "INSERT INTO PRODUCCIONES ( ID_OBRA,PRODUCCION ,A_DEDUCIR,F_certificacion,CERT_ANTERIOR,OPC_DEDUCIR,Observaciones,user ) "
     ." VALUES ( '{$rs["ID_OBRA"]}','$produccion','{$rs["A_DEDUCIR"]}','{$rs["F_certificacion"]}','{$rs["CERT_ANTERIOR"]}','{$rs["OPC_DEDUCIR"]}','{$rs["Observaciones"]}', '{$_SESSION['user']}' );" ;

$result=$Conn->query($sql2);
 


 if ($result) //compruebo si se ha creado la obra
             { 	
              $id_produccion2=Dfirst( "MAX(ID_PRODUCCION)", "PRODUCCIONES", "ID_OBRA=$id_obra" ) ;  
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/aval_ficha.php?id_aval=$id_aval'>" ;

            $sql2 = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION, Observaciones ) " 
               . "SELECT $id_produccion2 as ID_PRODUCCION,  '$fecha' AS Fecha, ID_UDO, MEDICION,Observaciones  "
               . " FROM ConsultaProd WHERE $where AND $where_c_coste ; "  ;
      
             if (!$Conn->query($sql2)) { echo "ERROR añadiendo detalles: $sql2" ; }; 
             
	     }
	       else
	     {
		echo "ERROR creando produccion: $sql2" ;
//		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
            




    
        
       

 

?>