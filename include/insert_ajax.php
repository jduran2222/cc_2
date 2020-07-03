<?php 
require_once("../include/session.php"); 
//$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";



$sql=$_GET["sql"]  ;


//$tabla=$_GET["tabla"]  ;
//$wherecond=$_GET["wherecond"]  ;
//$field=$_GET["field"]  ;
//$nuevo_valor=$_GET["nuevo_valor"]  ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
// $sql= "UPDATE `$tabla` SET `$field` = '$nuevo_valor' WHERE $wherecond  "  ;
 
 //$result = $Conn->query($sql);

// FALLO SEGURIDAD  la consulta debe de venir encriptada salvo parametros

if ( strtoupper( substr($sql,0,11))== "INSERT INTO") 
{
 if ($Conn->query($sql)) 
  { 
     // todo OK
     echo "OK" ;

  }  
   else
   { 
       //echo "___ERROR___" ;                           // mando mensaje de error
       echo "ERROR : $sql" ;
   }	  
}  
 else
{ 
       //echo "___ERROR___" ;                           // mando mensaje de error
       echo "ERROR sql NO ES INSERT : $sql" ;
}	  

 $Conn->close();



?>