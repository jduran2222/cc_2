<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

//$id_documento=$_GET["id_documento"]  ;
//$path_archivo=$_GET["path_archivo"]  ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
 
      $result_ini=$Conn->query("UPDATE `Documentos` SET `fallo` = 0 WHERE $where_c_coste ;" );
 
      $sql= "SELECT * FROM `Documentos`  WHERE $where_c_coste "  ;     // 
      $result = $Conn->query($sql);

      while($rs = $result->fetch_array())
      {
//         if (!file_exists($rs["path_archivo"]))
         if (!($rs["id_entidad"]))
         {
//             echo "<br>FALLO en fichero {$rs["path_archivo"]} "  ;
             echo "<br>id_documento sin id_entidad {$rs["path_archivo"]} "  ;
             $result2=$Conn->query("UPDATE `Documentos` SET `fallo` = 1 WHERE $where_c_coste AND id_documento={$rs["id_documento"]};" );

         }
      }      

     

 $Conn->close();



?>