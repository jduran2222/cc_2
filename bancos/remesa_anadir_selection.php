<?php
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		

$id_remesa=$_GET["id_remesa"]   ;
$array_str=$_GET["array_str"]   ;

$fecha=date('Y-m-d');
$remesa="remesa ". date('Y-m-d H:i:s') ;

$tipo_remesa=isset($_GET["tipo_remesa"]) ? $_GET["tipo_remesa"] : 'P' ;


if ($id_remesa==0)      // si la id_remesa es 0, CREAMOS NUEVA REMESA
{   
     // id_cta_banco para la nueva REMESA el nuevo PAGO
    $id_cta_banco= getVar('id_cta_banco_auto');

    $sql="INSERT INTO `Remesas` ( id_cta_banco,f_vto,remesa,`user` ,tipo_remesa)    VALUES (  '$id_cta_banco','$fecha' ,'$remesa', '{$_SESSION["user"]}' ,'$tipo_remesa' );" ;
    // echo ($sql);
    $result=$Conn->query($sql);
     if ($result) //compruebo si se ha creado la obra
     { 	
         $id_remesa=Dfirst( "MAX(id_remesa)", "Remesas_View", $where_c_coste ) ; 
     }
     else
     {
          echo "Error al crear Remesa, inténtelo de nuevo " ;
          echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
     }
     
}else
{
    // id_cta_banco para el nuevo PAGO
   $id_cta_banco= Dfirst( "id_cta_banco", "Remesas_View", "id_remesa=$id_remesa  AND  $where_c_coste " );
 
}    


   
// YA TENEMOS id_remesa  (nueva o elegida) y empezamos a añadirle las facturas de proveedor
 

if ($tipo_remesa=='P')    // remesa de PAGOS
{
    $id_fra_prov_array = explode("-", $array_str);

    foreach ($id_fra_prov_array as $id_fra_prov)    
           {
               // definimos las variables para crear el ID_PAGO
               $pdte_pago=  round(Dfirst( "pdte_pago", "Fras_Prov_View", "ID_FRA_PROV=$id_fra_prov  AND  $where_c_coste" ),2) ; 


               $n_fra=Dfirst( "N_FRA", "Fras_Prov_Listado", "ID_FRA_PROV=$id_fra_prov  AND  id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
               $proveedor=substr(Dfirst( "PROVEEDOR", "Fras_Prov_Listado", "ID_FRA_PROV=$id_fra_prov  AND  id_c_coste={$_SESSION["id_c_coste"]}" ), 0, 15) ; 
               $observaciones="$proveedor fra $n_fra" ; 

               // INSERTAMOS EL ID_PAGO 
               $sql="INSERT INTO `PAGOS` ( id_cta_banco,id_remesa,tipo_pago,tipo_doc,f_vto,importe,observaciones,`user` )    VALUES (  '$id_cta_banco','$id_remesa','P','remesa', '$fecha' ,'$pdte_pago','$observaciones', '{$_SESSION["user"]}' );" ;
    //           echo ("<br>$sql");           
               $result=$Conn->query($sql);
    //           echo ("<br>Resultado insertar ID_PAGO: $result");
               $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 

               // Insertamos la relación FRA_PROV_PAGOS
               $sql="INSERT INTO `FRAS_PROV_PAGOS` (id_fra_prov , id_pago) VALUES ( '$id_fra_prov','$id_pago' );" ;
    //           echo ("<br>$sql");           
               $result=$Conn->query($sql);
    //           echo ("<br>Resultado insertar FRAS_PROV_PAGOS: $result");           
           }
}else
{       // remesa de COBROS
    $id_fra_array = explode("-", $array_str);

    foreach ($id_fra_array as $id_fra)    
           { 
               // definimos las variables para crear el ID_PAGO
        
               $rs=DRow( "Facturas_View", "ID_FRA=$id_fra  AND  $where_c_coste " ) ; 
               $pdte_provision =  round($rs["pdte_provision"],2) ; 

               $n_fra=$rs["N_FRA"] ; 
               $cliente=substr($rs["CLIENTE"], 0, 15) ; 
               $observaciones="$cliente fra $n_fra" ; 

               // INSERTAMOS EL ID_PAGO 
               $sql="INSERT INTO `PAGOS` ( id_cta_banco,id_remesa,tipo_pago,tipo_doc,f_vto,ingreso,observaciones,`user` ) "
                       . "    VALUES (  '$id_cta_banco','$id_remesa','C','remesa cobro', '$fecha' ,'$pdte_provision','$observaciones', '{$_SESSION["user"]}' );" ;
    //           echo ("<br>$sql");           
               $result=$Conn->query($sql);
    //           echo ("<br>Resultado insertar ID_PAGO: $result");
               $id_pago=Dfirst( "MAX(id_pago)", "PAGOS", "id_cta_banco=$id_cta_banco" ) ; 

               // Insertamos la relación FRA_PROV_PAGOS
               $sql="INSERT INTO `FRAS_CLI_PAGOS` (id_fra , id_pago) VALUES ( '$id_fra','$id_pago' );" ;
    //           echo ("<br>$sql");           
               $result=$Conn->query($sql);
    //           echo ("<br>Resultado insertar FRAS_PROV_PAGOS: $result");           
           }
    
}    
    
           
//echo ("<br>TODO TERMINADO SATISTACTORIAMENTE");     
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/remesa_ficha.php?id_remesa=$id_remesa'>" ;
    

?>