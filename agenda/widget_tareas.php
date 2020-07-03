<?php 

// VARABLES A DEFINIR PREVIAMENTE
//$tipo_entidad='personal' ;
//$id_entidad=$id_personal;
//$id_subdir=$id_personal ;
//


$indice= $tipo_entidad.'-'.$id_entidad ;

$result_wt=$Conn->query($sql="SELECT * FROM Tareas_View WHERE Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%'"
          . " AND indice LIKE '%{$indice}%' AND $where_c_coste ");

          
//echo $sql . '; Filas->'. $result_wt->num_rows ;
//
          
echo "<h2>Tareas</h2>" ;
echo "<a class='btn btn-link noprint' href=\"../agenda/tarea_anadir.php?tipo_entidad=$tipo_entidad&indice=$indice&id_entidad=$id_entidad\" target='_blank' >"
        . "<i class='fas fa-plus-circle'></i> Añadir tarea <i class='fas fa-plus-circle'></i></a>" ;
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


<script>
//function delete_doc(id_documento,path_archivo) {
//    var nuevo_valor=window.confirm("¿Borrar documento? ");
////    alert("el nuevo valor es: "+valor) ;
//   if (!(nuevo_valor === null) && nuevo_valor)
//   { 
//       cadena_link="tabla='Documentos'&wherecond=id_documento=".id_documento ; 
//       var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                   // mostramos el ERROR
//        else
//        {  //alert(this.responseText) ;     //debug
//           location.reload(true); }  // refresco la pantalla tras edición
//      }
//  };
//  xhttp.open("GET", "../documentos/delete_doc_ajax.php?id_documento="+id_documento+"&path_archivo="+path_archivo, true);
//  xhttp.send();   
//   }
//   else
//   {return;}
//   
//}
//    
//function down_img_size(id_imagen) {
//   
//    $( id_imagen ).css( "width", "-=100" );
//}
//
//function up_img_size(id_imagen) {
//
//    $( id_imagen ).css( "width", "+=100" );
//
//}

</script>