<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

 require_once("../../conexion.php");
 require_once("../include/funciones.php");

// logs("Ejecutamos sql.php")	;
 
$code=isset($_GET["code"])? $_GET["code"] : 0   ;

if (is_encrypt2($_GET["sql"]))       
{ 
    // está encriptada, la desencriptamos
   $sql= decrypt2($_GET["sql"])  ;
   logs("sql.php line 18: $sql")	;
//   echo $sql;
   
}elseif ($code)
{
  // no está encriptada, pero tiene el antiguo sistema de código  
  $sql=base64_decode($_GET["sql"])  ;  
 
}
else
{   // no tiene ningún sistema de código, la mantenemos por COMPATIBILIDAD , pero hay que terminar eliminándola
//    $sql=$_GET["sql"]  ;
     logs( "SQL.PHP . ERROR SENTENCIA SQL SIN ENCRIPTAR:<BR> $sql" ) ;
     logs_db( "SQL.PHP . ERROR SENTENCIA SQL SIN ENCRIPTAR:<BR> $sql" , "cc_error") ;
     cc_die( "ERROR SENTENCIA SQL SIN ENCRIPTAR AVISAR A ADMINISTRADOR:<BR> $sql" ) ;
//     echo ( "ERROR SENTENCIA SQL SIN ENCRIPTAR AVISAR A ADMINISTRADOR:<BR> $sql" ) ;
     
    
}    
 
// vemos si hay variable1
if (isset($_GET["variable1"]))
{
    $sql= str_replace('_VARIABLE1_', $_GET["variable1"], $sql)  ;
    // probamos si hay una segunda variable
    if (isset($_GET["variable2"]))
    {
        $sql= str_replace('_VARIABLE2_', $_GET["variable2"], $sql)  ;
    }    
    if (isset($_GET["variable3"]))
    {
        $sql= str_replace('_VARIABLE3_', $_GET["variable3"], $sql)  ;
    }    
     
}    



 
 //$result = $Conn->query($sql);
 logs("Ejecutamos: $sql")	;
  
$error_txt=""; 
$array_sql=  explode("_CC_NEW_SQL_", $sql);       // cambiamos el caracter ; punto y coma por esta cadena _CC_NEW_SQL_ para separar varias consultas SQL
foreach ($array_sql as $sql_item) {
  if (trim($sql_item)!='') {$error_txt.= !($Conn->query($sql_item)) ? "ERROR : $sql_item  \n" : ""  ;}
}

 
 
// if ($Conn->multi_query($sql)) 
 if (!$error_txt) 
  { 
     // todo OK
    // echo "OK" ;
 echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";

  }  
   else
   { 
       //echo "___ERROR___" ;                           // mando mensaje de error
//       echo "ERROR : $sql" ;
       echo $error_txt ;
   }	  
 $Conn->close();



?>