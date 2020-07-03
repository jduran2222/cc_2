
<?php 

// VARABLES A DEFINIR PREVIAMENTE
//$tipo_entidad='personal' ;
//$id_entidad=$id_personal;
//$id_subdir=$id_personal ;
//

$result=$Conn->query($sql="SELECT id_documento, documento,nombre_archivo, path_archivo FROM Documentos WHERE tipo_entidad='$tipo_entidad' AND id_entidad=$id_entidad AND $where_c_coste ");

echo "<h2>Documentos PDF</h2>" ;
echo "<a class='btn btn-primary' href=\"../documentos/doc_upload_form.php?tipo_entidad=$tipo_entidad&id_subdir=$id_subdir&id_entidad=$id_entidad\" >Subir PDF</a>" ;
echo "<br>" ;
if ($result->num_rows > 0)
 {  
    //echo "<a href=\"{$rs["path_archivo"]}\" >descargar PDF</a><br>" ;
     while ($rs = $result->fetch_array(MYSQLI_ASSOC))
        {
	
	//echo "<a href=\"{$rs["path_archivo"]}_large.png\" ><img src=\"{$rs["path_archivo"]}_medium.png\" >  </a>" ;
	//echo "<a href=\"{$rs["path_archivo"]}_large.jpg\" ><img src=\"{$rs["path_archivo"]}_large.jpg\" >  </a>" ;
        echo "<h3>{$rs["documento"]}<br>{$rs["nombre_archivo"]} <br></h3>" ; 
	echo "<a href=\"{$rs["path_archivo"]}_large.jpg\" target='_blank' ><img src=\"{$rs["path_archivo"]}_large.jpg\"></a>" ;
        echo "<a class='btn btn-link btn-xs' href=\"{$rs["path_archivo"]}\" target='_blank' >pdf</a><br>" ;
        }
	// mostrar_tumbail(id_documento) ;
 }
 
 
 ?>