<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

//$id_documento=$_GET["id_documento"]  ;
//$path_archivo=$_GET["path_archivo"]  ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
 
//      $result_ini=$Conn->query("SELECT * FROM  ;" );
 
//      $sql= "SELECT *  FROM Documentos WHERE nombre_archivo LIKE '% %' "  ;     // 
      $sql= "SELECT *  FROM Documentos WHERE nombre_archivo LIKE '%.jpg' AND tamano>300000"  ;     // 
      $result = $Conn->query($sql);
      $c=0;
      $c_error=0;
      $c=0;

      while($rs = $result->fetch_array())
      {
          $c++ ;
          
          $tamano2=filesize($rs["path_archivo"]) ;
          $result2=$Conn->query("UPDATE `Documentos` SET `tamano` = $tamano2 WHERE id_documento={$rs["id_documento"]};" );
          
          
//          copy($rs["path_archivo"].'_large.jpg',$rs["path_archivo"]) ;
          
//         $nombre_archivo2=quita_simbolos_file($rs["nombre_archivo"]) ;
//         
//         $path_archivo0=str_replace($nombre_archivo2,$rs["nombre_archivo"],$rs["path_archivo"])  ;    //
          
          
//         if (!file_exists($rs["path_archivo"]))
//         {
//             $c_error++ ;
//             echo "<br>ERROR pdf no existe: id_documento {$rs["id_documento"]} -> {$rs["path_archivo"]} "  ;
//             $result2=$Conn->query("UPDATE `Documentos` SET `fallo` = 1 WHERE $where_c_coste AND id_documento={$rs["id_documento"]};" );
//         }
//         else
//         {
////             $path_archivo2= quita_simbolos_file($rs["path_archivo"]) ;
////             
//////             rename($rs["path_archivo"], $path_archivo2) ;
////             rename($path_archivo0.'_medium.jpg', $rs["path_archivo"].'_medium.jpg') ;
////             rename($path_archivo0.'_large.jpg', $rs["path_archivo"].'_large.jpg') ;
//             
//             
//              if (!file_exists($rs["path_archivo"].'_large.jpg'))
//                      {echo "<br>ERROR  _large.jpg NO EXISTE {$rs["id_documento"]} , path_archivo {$rs["path_archivo"]} " ;
//                    $result2=$Conn->query("UPDATE `Documentos` SET `fallo` = 1 WHERE $where_c_coste AND id_documento={$rs["id_documento"]};" );
//                    } 
//              if (!file_exists($rs["path_archivo"].'_medium.jpg'))
//                      {echo "<br>ERROR  _medium.jpg NO EXISTE {$rs["id_documento"]} , path_archivo {$rs["path_archivo"]} " ;
//                    $result2=$Conn->query("UPDATE `Documentos` SET `fallo` = 1 WHERE $where_c_coste AND id_documento={$rs["id_documento"]};" );
//                    } 
//
//         }  
      }      

echo "<br><br><br>FIN CONVERSION. contador= $c , contador_error restauracion path: $c_error " ;
     

 $Conn->close();



?>