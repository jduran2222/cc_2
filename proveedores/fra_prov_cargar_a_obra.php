<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

$id_obra= $_GET["id_obra"];

if (isset($_GET["id_fra_prov"]))
{  
  $id_fra_prov= $_GET["id_fra_prov"];
  $where= " id_fra_prov=$id_fra_prov " ;
}
elseif (isset($_GET["id_fra_prov_sel"]))
{   
     $where= " ID_FRA_PROV IN {$_GET["id_fra_prov_sel"]} " ;
 
}
else   // ERROR EN PARAMETROS _GET
{
     $where= " 1=0 " ;
}    

//$fecha=date('Y-m-d');

$sql="SELECT * FROM Fras_Prov_View WHERE $where AND $where_c_coste";
//echo $sql ;
$result=$Conn->query($sql) ;
//$rs = $result->fetch_array(MYSQLI_ASSOC) ;

while( $rs = $result->fetch_array(MYSQLI_ASSOC)) 
{
 $id_proveedor=$rs["ID_PROVEEDORES"] ;
 $id_fra_prov=$rs["ID_FRA_PROV"] ;
 $fecha= ($rs["FECHA"]== '0000-00-00 00:00:00' )?  date('Y-m-d') : $rs["FECHA"] ;

$sql2 =  "INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user` ) ";
$sql2 .= "VALUES ( '$id_proveedor', '$id_obra','$fecha' ,'vfac {$rs["N_FRA"]}' ,'$id_fra_prov', '{$_SESSION["user"]}' );" ;
//$sql2 .= "VALUES ( '$id_proveedor', '$id_obra','$fecha' ,'{$rs["FECHA"]}' ,'$id_fra_prov', '{$_SESSION["user"]}' );" ;


// echo ($sql2);
$result2=$Conn->query($sql2);
          
 if ($result2) //compruebo si se ha creado la obra
             { 	$id_vale=Dfirst( "MAX(ID_VALE)", "Vales_list", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
             
                
                $id_subobra_si = Dfirst( "id_subobra_auto", "OBRAS", "$where_c_coste AND ID_OBRA=$id_obra" ) ; 
                $id_subobra_si = $id_subobra_si ? $id_subobra_si : getVar("id_subobra_si") ;         // por si alguna OBRA no tiene id_subobra_auto

                
                $id_concepto_auto=Dfirst( "id_concepto_auto", "Proveedores", "ID_PROVEEDORES=$id_proveedor" ) ; 
                
                if (!$id_concepto_auto)    // proveedor sin id_concepto_auto (concepto para cargo de gastos automático) CREAMOS UN CONCEPTO NUEVO A COSTE 1€
                {
                    $id_obra_gg = getVar("id_obra_gg") ;
                    $id_cuenta_auto = getVar("id_cuenta_auto") ;
                    
                    
                    
                    $sql4 =  "INSERT INTO `CONCEPTOS` ( ID_PROVEEDOR,ID_OBRA,ID_CUENTA,CONCEPTO,COSTE,`user` ) ";
                    $sql4 .= "VALUES ( '$id_proveedor', '$id_obra_gg','$id_cuenta_auto' ,'GASTOS DE {$rs["PROVEEDOR"]}' ,'1', '{$_SESSION["user"]}' );" ;

//                    echo ($sql4);
                    $result4=$Conn->query($sql4);
                    
                    // rescato el nuevo id_concepto creado y lo asigno a la variable id_concepto_auto
                    $id_concepto_auto=Dfirst( "MAX(ID_CONCEPTO)", "CONCEPTOS", "ID_PROVEEDOR=$id_proveedor AND COSTE=1" ) ; 
                    
                    // registro su valor en su Proveedor
                    $result5=$Conn->query("UPDATE `Proveedores` SET `id_concepto_auto` = $id_concepto_auto WHERE ID_PROVEEDORES=$id_proveedor;" );

                    
                } 
                
                             
                $sql3 = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
                $sql3 .="VALUES ( '$id_vale', '$id_concepto_auto','{$rs["pdte_conciliar"]}' ,'$id_subobra_si' );" ;

//                echo ($sql3);
                $result3=$Conn->query($sql3);
             
             
	        // TODO OK-> Entramos a pagina_inicio.php
//	        echo "CARGO A OBRA creado satisfactoriamente." ;
//		echo  "Ir a Parte diario <a href='../personal/parte.php?id_parte=$id_parte' title='ver Parte Diario'> $id_parte</a>" ;
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../personal/parte.php?id_parte=$id_parte'>" ;
//               echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 

	     }
	       else
	     {
		echo "Error al CARGAR GASTO A OBRA, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
  } 
  
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 


?>