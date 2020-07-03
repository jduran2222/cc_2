<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

//$id_documento=$_GET["id_documento"]  ;
//$path_archivo=$_GET["path_archivo"]  ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
 
//      $result_ini=$Conn->query("UPDATE `Documentos` SET `fallo` = 0 WHERE $where_c_coste ;" );
 
  $sql= "SELECT * FROM `Documentos`  WHERE id_entidad=0 AND $where_c_coste "  ;     // 
  $result = $Conn->query($sql);

  while($rs = $result->fetch_array())
  {
      $path_archivo=$rs["path_archivo"] ;
      $id_documento=$rs["id_documento"] ;
//         if (!file_exists($rs["path_archivo"]))
//             echo "<br>FALLO en fichero {$rs["path_archivo"]} "  ;
         echo "<br><br>id_documento sin id_entidad $path_archivo "  ;
//         $result2=$Conn->query("UPDATE `Documentos` SET `fallo` = 1 WHERE $where_c_coste AND id_documento={$rs["id_documento"]};" );

         $sql= "DELETE FROM `Documentos`  WHERE id_documento=$id_documento AND $where_c_coste "  ;     // ejecuto DELETE
         if ($Conn->query($sql))
         { 
             $error_msg= unlink($path_archivo) ? "" : "<br>ERROR borrando: $path_archivo " ;
             $error_msg.= unlink($path_archivo. "_large.jpg") ? "" : "<br>ERROR borrando: $path_archivo". "_large.jpg" ;
             $error_msg.= unlink($path_archivo. "_medium.jpg") ? "" : "<br>ERROR borrando: $path_archivo". "_medium.jpg" ;
    //         unlink($path_archivo . "_large.jpg") ;
    //         unlink($path_archivo . "_medium.jpg") ;
    //         unlink($path_archivo . "_small.jpg") ;

             echo ($error_msg)? $error_msg : "<br>OK. borrado $path_archivo"    ;  // si $error_msg es vacio respondo OK
         }
  }      

     

 $Conn->close();



?>