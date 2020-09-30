<?php 

// VARABLES A DEFINIR PREVIAMENTE
//$tipo_entidad='personal' ;
//$id_entidad=$id_personal;
//$id_subdir=$id_personal ;
//


$indice= $tipo_entidad.'-'.$id_entidad ;

//$result_wt=$Conn->query($sql="SELECT * FROM Tareas_View WHERE Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%'"
//          . " AND indice LIKE '%{$indice}%' AND $where_c_coste ");
$result_wt=$Conn->query($sql="SELECT id, Terminada, Tarea, fecha_modificacion, user FROM Tareas_View WHERE  usuarios LIKE '%{$_SESSION["user"]}%'"
          . " AND tipo_entidad='$tipo_entidad' AND id_entidad='$id_entidad'  AND $where_c_coste ORDER BY   fecha_modificacion DESC");

          
//echo $sql . '; Filas->'. $result_wt->num_rows ;
//
   



echo "<h5>Tareas ({$result_wt->num_rows})</h5>" ;
echo "<a class='btn btn-link noprint' href=\"../agenda/tarea_anadir.php?tipo_entidad=$tipo_entidad&indice=$indice&id_entidad=$id_entidad\" target='_blank' >"
        . "<i class='fas fa-plus-circle'></i> Añadir tarea</a>" ;
//echo "<a class='btn'  href=\"../documentos/doc_upload_multiple_form.php?tipo_entidad=$tipo_entidad&id_subdir=$id_subdir&id_entidad=$id_entidad\" target='_blank' ><i class='fas fa-cloud-upload-alt'></i> Subir PDF</a>" ;
echo "<br>" ;
//$size=isset($size)? $size : '100px' ;
//$resolucion=isset($resolucion)? $resolucion : '_large.jpg' ;     // por defecto mostramos el tamaño grande

if ($result_wt->num_rows > 0)
 {  
    //echo "<a href=\"{$rs["path_archivo"]}\" >descargar PDF</a><br>" ;
     while ($rs = $result_wt->fetch_array(MYSQLI_ASSOC))
        {
	       
        echo "<br><a    href=\"../agenda/tarea_ficha.php?id={$rs["id"]}\" target='_blank' >{$rs["Tarea"]}</a>" ;
//        echo "</div>" ;  
       }
        
       
 }
 
 
 
 ?>


