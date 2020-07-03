<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_obra= $_GET["id_obra"];
$fecha=date('Y-m-d');

$id_proveedor_mo=getVar('id_proveedor_mo') ;

//$id_proveedor_mo=Dfirst( "valor", "c_coste_vars", "variable='id_proveedor_mo' AND $where_c_coste " )  ;

// $sql4 = "SELECT valor FROM `c_coste_vars` WHERE variable='id_proveedor_mo' AND $where_c_coste";
// $result4 = $Conn->query($sql4); 
// if ($result4->num_rows > 0)
//    {
//        $rs4 = $result4->fetch_array();   // cogemos el primer valor
//        $id_proveedor = $rs4["valor"];
//    } else
//    {
////        echo "<br>VALOR NO ENCONTRADO" ;                            //debug  
//        $id_proveedor = 'ERROR';           // devuelvo 0 si no encuentro nada
//    }

 


$sql="INSERT INTO `Subcontratos` ( `id_obra`,id_proveedor, subcontrato,f_subcontrato,`user` )    VALUES (  '$id_obra','$id_proveedor_mo','subcontrato nuevo', '$fecha' , '{$_SESSION["user"]}' );" ;
 echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_subcontrato=Dfirst( "MAX(id_subcontrato)", "Subcontratos_obra", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
	       echo "creada satisfactoriamente." ;
		echo  "Ir a subcontrato <a href=\"../obras/subcontrato.php?_m=$_m&id_subcontrato=$id_subcontrato\" title='ver '> $id_subcontrato</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../obras/subcontrato.php?_m=$_m&id_subcontrato=$id_subcontrato'>" ;

	     }
	       else
	     {
		echo "Error , inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>