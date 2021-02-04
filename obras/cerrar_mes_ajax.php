<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$ID_OBRA=$_GET["ID_OBRA"]  ;
$IMPORTE=$_GET["IMPORTE"]  ;
$GASTOS_EX=$_GET["GASTOS_EX"]  ;
$Mes=$_GET["Mes"]  ;


require_once("../../conexion.php");
require_once("../include/funciones.php");

if ($ID_OBRA= Dfirst("ID_OBRA","OBRAS","$where_c_coste AND ID_OBRA=$ID_OBRA"))   // SEGURIDAD
{
 
    if ($id = Dfirst("id","VENTAS","ID_OBRA=$ID_OBRA AND DATE_FORMAT(FECHA, '%Y-%m')='$Mes' "))    // SEGURIDAD
    {
      $sql="UPDATE VENTAS SET IMPORTE='$IMPORTE' ,  GASTOS_EX='$GASTOS_EX' WHERE id='$id'  ;"  ;
      
        
    } else {
        
        $fecha_ventas=$Mes."-01" ;   // fecha del mes a cerrar
        $sql="INSERT INTO VENTAS ( ID_OBRA,FECHA,IMPORTE,GASTOS_EX ) " . 
                   " VALUES ( '$ID_OBRA', '$fecha_ventas','$IMPORTE','$GASTOS_EX'  );"  ;
    }
 
   echo ($Conn->query($sql))?  "" : "ERROR creando o actualizando VENTAS" ;
        



 
}else
{
    echo "ERROR, obra desconocida";
}
?>