<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 


//$fecha=date('Y-m-d');

$id_mov_banco=$_GET["id_mov_banco"]  ;	
  
$id_fra_prov=$_GET["id_fra_prov"]  ;	

//$id_cta_banco=Dfirst("id_cta_banco","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
//$importe=Dfirst("cargo","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
//$fecha_banco=Dfirst("fecha_banco","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
//$concepto=Dfirst("Concepto","MOV_BANCOS", "id_mov_banco=$id_mov_banco") ;	
//
//
//$sql="INSERT INTO `PAGOS` ( id_cta_banco,tipo_pago,f_vto,importe,observaciones,user )    VALUES ( '$id_cta_banco' ,'P' ,'$fecha_banco' ,'$importe' ,'$concepto' , '{$_SESSION['user']}' );" ;
//  // echo ($sql);
//  $result=$Conn->query($sql);
//  if ($result) //compruebo si se ha creado la obra
//        { 	
//         $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 
////         setVar("id_linea_avales_auto", $id_linea_avales) ;        // cre3amos la nueva variable 'id_linea_avales_auto' 
//         
//         $sql="INSERT INTO FRAS_PROV_PAGOS ( id_fra_prov,id_pago ) VALUES ( '$id_fra_prov'  ,'$id_pago'  );" ;
//         $result=$Conn->query($sql);
//
//         $sql="INSERT INTO PAGOS_MOV_BANCOS ( id_pago,id_mov_banco ) VALUES ( '$id_pago','$id_mov_banco'   );" ;
//         $result=$Conn->query($sql);
//         
//         
//        }
//      else
//       {die('ERROR CREANDO PAGO');
//       }

if (concilia_mov_banco_fra_prov($id_mov_banco,$id_fra_prov))
{  echo "CONCILACION CREADA: $id_mov_banco - $id_fra_prov"     ; }   //DEBUG 
else {  echo "ERROR EN CONCILACION: $id_mov_banco - $id_fra_prov"  ; }   //DEBUG 

?>