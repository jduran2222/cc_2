<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_documento=$_GET["id_documento"]  ;
$path_archivo=isset($_GET["path_archivo"])? $_GET["path_archivo"] : Dfirst('path_archivo', 'Documentos', "id_documento=$id_documento AND $where_c_coste ") ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
      $sql= "DELETE FROM `Documentos`  WHERE id_documento=$id_documento AND $where_c_coste "  ;     // ejecuto DELETE
       if ($Conn->query($sql))
        { 
         $error_msg= unlink($path_archivo) ? "" : "ERROR borrando: $path_archivo " ;
         $error_msg.= unlink($path_archivo. "_large.jpg") ? "" : "ERROR borrando: $path_archivo". "_large.jpg" ;
         $error_msg.= unlink($path_archivo. "_medium.jpg") ? "" : "ERROR borrando: $path_archivo". "_medium.jpg" ;
//         unlink($path_archivo . "_large.jpg") ;
//         unlink($path_archivo . "_medium.jpg") ;
//         unlink($path_archivo . "_small.jpg") ;
        
         echo ($error_msg)? $error_msg : "OK"    ;  // si $error_msg es vacio respondo OK
        
        }
         else
         { 
          //echo "___ERROR___" ;                           // mando mensaje de error
          echo "ERROR: $sql" ;
         }	  
     

 $Conn->close();



?>