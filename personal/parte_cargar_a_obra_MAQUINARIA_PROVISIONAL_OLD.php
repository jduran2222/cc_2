<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
//$id_parte= $_GET["id_parte"];
//$delete_vale = isset($_GET["delete_vale"]) ? 1 : 0 ;

//echo "DELETE_VALE ES: ". $delete_vale ;
//$id_obra= $_GET["id_obra"];
//$fecha=date('Y-m-d');

$result=$Conn->query("SELECT * FROM Partes_Maquinas_View WHERE Fecha>='2012-07-12' AND Fecha<='2019-08-31' "
        . " AND NOT(Maquinaria LIKE '%TEJIDOS%')  AND NOT(Maquinaria LIKE '%LLANETE%') AND $where_c_coste");

$id_proveedor = getVar("id_proveedor_mo")  ;   // proveedor automatico para mano de obra
$id_fra_prov = getVar("id_fra_mo")  ;          //  factura automatica para conciliar mano de obra
$id_subobra_general = getVar("id_subobra_si") ;        // en esta SUBOBRA general registraremos los abonos
$id_subobra_si =   getVar("id_subobra_si") ;  // en caso de que haya error usamos la predeterminada

$id_concepto_dc = getVar("id_concepto_dc") ;  // concepto de Media Dieta 
$id_concepto_md = getVar("id_concepto_md") ;  // concepto de Dieta Completa

$c=0;
$id_vale_cargo=0;

while ($rs = $result->fetch_array(MYSQLI_ASSOC))
{        

    $c++ ;
    
$id_parte=$rs["ID_PARTE"] ;
$id_obra=$rs["id_obra_mq"] ;
$fecha=$rs["Fecha"];

// buscamos VARIABLES DE ENTORNO

//$id_subobra_si = Dfirst("id_subobra_auto","OBRAS"," $where_c_coste AND ID_OBRA=$id_obra")  ;


  // vemos cual es el valor del último id_vale para comparar
//  $id_vale0=Dfirst( "MAX(ID_VALE)", "Vales_list", $where_c_coste ) ; 
  
  // insertamos un VALE nuevo vacío
  $sql2 =  "INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user` ) ";
  $sql2 .= "VALUES ( '$id_proveedor', '$id_obra','$fecha' ,'PD-ABONO-MQ-auto-$id_parte' ,'$id_fra_prov', '{$_SESSION["user"]}' );" ;
  //  echo ($sql2)."<br>";
  
  $result2=$Conn->query($sql2) ;

      // buscamos el nuevo id_vale
      $id_vale_cargo=Dfirst( "MAX(ID_VALE)", "Vales_list", " $where_c_coste AND ID_PROVEEDORES=$id_proveedor AND ID_OBRA=$id_obra " ) ; 
           
    $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
    $sql3 .= "VALUES ( '$id_vale_cargo','{$rs["id_concepto_mq"]}' ,'-{$rs["cantidad"]}', '$id_subobra_general' );" ;
//  echo ($sql3)."<br>";
    $result3=$Conn->query($sql3);

    
}   


//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 
echo "TERMINADO. total  $c filas" ;   //DEBUG
//echo "TODO OK" ;   //DEBUG
       

?>