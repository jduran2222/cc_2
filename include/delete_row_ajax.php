<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";



 require_once("../../conexion.php");
 require_once("../include/funciones.php");

 
if (isset($_GET['url_enc']))         // venimos ENCRYPTADOS?, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;

    parse_str( $url_dec.$url_raw , $_GET ) ;
}

$tabla=$_GET["tabla"]  ;
$wherecond=$_GET["wherecond"]  ;



 
 $sql_s= "SELECT * FROM `$tabla`  WHERE $wherecond  "  ;  /// sql del Select para contar las líneas a borrar
 logs("DELETE_ROW_AJAX.PHP(SELECT) : " . $sql_s) ;

 $result_s = $Conn->query($sql_s);
 $rows_s=$result_s->num_rows ;
 
 if ($rows_s > 0)                                     // compruebo si la sentencia afecta solamente a un registro antes de ejecutar DELETE
     { 
       $sql= "DELETE FROM `$tabla`  WHERE $wherecond  "  ;     // ejecuto DELETE
       logs("DELETE_ROW_AJAX.PHP(DELETE) : " . $sql) ;
       // EJECUTO EL DELETE
       if ($Conn->query($sql))
        { 
           // COMPRUEBO SI SE BORRARON TODOS LAS ROW QUE HABIA
           $result_s = $Conn->query($sql_s);     // HAGO LA CONSULTA SELECT DE NUEVO
           echo (($result_s->num_rows) ? "ERROR: No se borraron algunos elementos. \n (por seguridad, debe eliminar manualmente todos los elementos de la entidad)" : 'OK')   ;}
         else
         { 
          //echo "___ERROR___" ;                           // mando mensaje de error
          echo "ERROR : ". ($_SESSION["admin"] ? $sql : "" )  . " \n Por seguridad, debe eliminar manualmente todos los elementos de la entidad." ;
         }	  
     }
     else
     {
             echo "ERROR: ninguna fila a borrar " ;
     }
 $Conn->close();



?>