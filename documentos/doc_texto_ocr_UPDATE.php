<?php 

//namespace Google\Cloud\Samples\Vision;
//putenv('GOOGLE_APPLICATION_CREDENTIALS=construcloud-228009-a3014d1d8608.json');

require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_documento=$_GET["id_documento"]  ;
$id_documento2 = $id_documento + 200 ;
//$path_archivo=$_GET["path_archivo"]  ;



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../vendor/funciones_ocr.php");
 
 
//      $result_ini=$Conn->query("SELECT * FROM  ;" );

//      $sql= "SELECT *  FROM Documentos WHERE nombre_archivo LIKE '% %' "  ;     // 
$sql= "SELECT * FROM Documentos WHERE tipo_entidad<>'obra_foto' AND id_documento >= $id_documento AND id_documento < $id_documento2  "  ;     // 
$result = $Conn->query($sql);

//      $c=0;
//      $c_error=0;
      $c=0;
echo "<BR>EMPIEZO $result->num_rows  " ;
while ($rs = $result->fetch_array())
{
 $c++ ;     
   
//$tamano2=filesize($rs["path_archivo"]) ;

    

//if (!(like($rs["path_archivo"],"http%")))   // evitamos los links
if (file_exists($rs["path_archivo"]."_large.jpg"))   // evitamos los links
{
    $texto_ocr= quita_simbolos_mysql( Google\Cloud\Samples\Vision\texto_ocr($rs["path_archivo"]."_large.jpg") ) ;
    if($result2=$Conn->query("UPDATE `Documentos` SET `metadatos` = '$texto_ocr' WHERE id_documento={$rs["id_documento"]}  ;" ))
    {
            echo "<br>$c .- <span style='color:blue;font-weight: bold;'> OK {$rs["nombre_archivo"]}  </span> :<br><br> $texto_ocr " ;

    }else
    {
            echo "<br>$c .- <span style='color:red;font-weight: bold;'> ERROR {$rs["nombre_archivo"]} </span> :<br><br> $texto_ocr " ;
    }    

}

}
 $Conn->close();



?>