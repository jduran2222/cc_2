<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=($_GET["id_obra"])  ;
//$wherecond=$_GET["wherecond"]  ;
//$field=$_GET["field"]  ;
//$nuevo_valor=rawurldecode($_GET["nuevo_valor"] ) ;
//$tipo_dato =   isset($_GET["tipo_dato"]) ? $_GET["tipo_dato"]  : "" ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
// $nuevo_valor= htmlspecialchars($nuevo_valor) ;
 
$id_obra=Dfirst( "ID_OBRA"  ,'OBRAS' , " ID_OBRA=$id_obra AND $where_c_coste " ) ; 
 
if ($id_obra)
{
       $sql= "INSERT INTO  `Capitulos` (id_obra,CAPITULO ,user )  "
                        . " VALUES ('$id_obra', '99.- COSTES INDIRECTOS _NO_PRINT_' , '{$_SESSION['user']}'  ) "  ;
 
       $result = $Conn->query($sql);                 
       $id_capitulo=Dfirst( "MAX(ID_CAPITULO)"  ,'Capitulos_View' ," ID_OBRA=$id_obra AND $where_c_coste" ) ;              // metemos las comillas invertidas para compatibilidad con campos que usan espacios en el nombre: 'Estudios_de_Obra'
       //
    // CREO EL CAPITULO
    $sql2= "INSERT INTO  `SubObras` (ID_OBRA,SUBOBRA ,user )  "
              . " VALUES ('$id_obra', 'COSTES INDIRECTOS' , '{$_SESSION['user']}'  ) "  ;
     echo "<br>$sql2" ;
 
    $result = $Conn->query($sql2);
    $id_subobra=Dfirst( "MAX(ID_SUBOBRA)"  ,'SubObras' ," ID_OBRA=$id_obra " ) ;              // metemos las comillas invertidas para compatibilidad con campos que usan espacios en el nombre: 'Estudios_de_Obra'

 
 
//     $valor_bd=Dfirst( $field  , $tabla, $wherecond) ;              // metemos las comillas invertidas para compatibilidad con campos que usan espacios en el nombre: 'Estudios_de_Obra'
 
     $sql3= "INSERT INTO  `Udos` (id_obra,ID_CAPITULO,ID_SUBOBRA ,MED_PROYECTO,UDO,TEXTO_UDO,user )  "
             . " VALUES ('$id_obra', '$id_capitulo' ,'$id_subobra',1 ,'COSTES INDIRECTOS','COSTES INDIRECTOS','{$_SESSION['user']}'  ) "  ;
     
     echo "<br>$sql3  Result: " ;
     echo ($Conn->query($sql3)) ;
     	
     $sql3= "INSERT INTO  `Udos` (id_obra,ID_CAPITULO,ID_SUBOBRA ,MED_PROYECTO,UDO,TEXTO_UDO,user )  "
             . " VALUES ('$id_obra', '$id_capitulo' ,'$id_subobra',1 ,'MAQUINARIA','MAQUINARIA','{$_SESSION['user']}'  ) "  ;
     
     echo "<br>$sql3  Result: " ;
     echo ($Conn->query($sql3)) ;
     	
     $sql3= "INSERT INTO  `Udos` (id_obra,ID_CAPITULO,ID_SUBOBRA ,MED_PROYECTO,UDO,TEXTO_UDO,user )  "
             . " VALUES ('$id_obra', '$id_capitulo' ,'$id_subobra',1 ,'MANO DE OBRA','MANO DE OBRA','{$_SESSION['user']}'  ) "  ;
     
     echo "<br>$sql3  Result: " ;
     echo ($Conn->query($sql3)) ;
     	
    
}
else 
{
  	  
   
   echo "ERROR en id_obra" ;     // la obra no es de esta empresa
}


  echo close_java(); 

 $Conn->close();



?>