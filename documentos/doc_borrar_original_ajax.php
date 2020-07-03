<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";


require_once("../../conexion.php");
require_once("../include/funciones.php");
 
$id_documentos = explode("-", $_GET["id_documentos"]); 

foreach ($id_documentos as $id_documento) {
   $path_archivo=  Dfirst("path_archivo","Documentos","id_documento='$id_documento' AND $where_c_coste")  ;
   if (is_picture($path_archivo)) // borramos el fichero original
       {
        if (unlink($path_archivo))
            {
              $tamano =  filesize($path_archivo."_large.jpg") ;
              $result=$Conn->query("UPDATE `Documentos` SET `tamano` = $tamano WHERE id_documento=$id_documento AND $where_c_coste " );
            }
       
       }  
}


?>