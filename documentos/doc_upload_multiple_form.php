<?php
require_once("../include/session.php");
?>

<!DOCTYPE html>
<html>
    <TITLE>Upload ficheros</TITLE>
    <HEAD>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</HEAD>
<body>

<?php 

$tipo_entidad = isset( $_GET["tipo_entidad"] ) ? $_GET["tipo_entidad"] : "" ;
$id_entidad = isset( $_GET["id_entidad"] ) ? $_GET["id_entidad"] : "" ;
$id_subdir = isset( $_GET["id_subdir"] ) ? $_GET["id_subdir"] : "" ;

//$id_obra = isset( $_GET["id_obra"] ) ? $_GET["id_obra"] : "" ;
$fecha_doc = isset( $_GET["fecha_doc"] ) ? $_GET["fecha_doc"] : "" ;

//$tipo_entidad = isset( $_GET["tipo_entidad"] ) ? $_GET["tipo_entidad"] : "" ;


require_once("../../conexion.php");
require_once("../include/funciones.php");

 if (!$path_logo_empresa=Dfirst("path_archivo", "Documentos", "tipo_entidad='empresa' AND $where_c_coste")) $path_logo_empresa="../img/no_logo.jpg" ;

if ($tipo_entidad=='fra_prov')
{    $tipo_doc="Enviar FACTURAS PROVEEDOR" ; }
elseif($tipo_entidad=='obra_foto')
    {   $tipo_doc="VARIAS FOTOS" ; }  
elseif($tipo_entidad=='estudios_XML')
    {   $tipo_doc="Enviar  estudios XML" ; }  
elseif($tipo_entidad=='albaran')
    {   $tipo_doc="Páginas del ALBARAN" ; }  
else {   $tipo_doc="Enviar FOTO o DOCUMENTO" ; }  



?>
    
<style>
 input { 
/*    border: 2px solid red;
    background-color: lightyellow;*/
    font-size:40px; width:400px; height:100px;

}

@media only screen and (max-width:981px) {
 
input,button 
{
    font-size:40px; width:800px; height:200px;
}
/*input.input_mobile , a.input_mobile {       
     width: 100%;
     height: 15% ;
     font-size: 60px;
}*/
 

}
 

    
    
</style>        

    
<img align="center" width="200" src="<?php echo $path_logo_empresa; ?>" >


<h1> <?php echo $tipo_doc; ?> </h1><h6> (<?php echo ini_get('max_file_uploads') ;?> máximo por cada botón. Arrastre ficheros sobre el botón) </h6>
<form action="../documentos/doc_upload_multiple.php" method="post" enctype="multipart/form-data">

	<input type="hidden" name="tipo_entidad"  value="<?php echo $tipo_entidad ;?>" >
	<input type="hidden" name="id_entidad"  value="<?php echo $id_entidad ;?>" >
	<input type="hidden" name="id_subdir"  value="<?php echo $id_subdir ;?>" >
	<input type="hidden" name="fecha_doc"  value="<?php echo $fecha_doc ;?>" >
        
        

	
    <input type="file" multiple style="font-size:40px; " class="btn btn-primary btn-lg" id="input_element" name="fileToUpload_1[]" ><br>
    <input type="file" multiple style="font-size:40px; " class="btn btn-primary btn-lg" name="fileToUpload_2[]" ><br>
    <input type="file" multiple style="font-size:40px; " class="btn btn-primary btn-lg" name="fileToUpload_3[]" ><br>
    <input type="file" multiple style="font-size:40px; " class="btn btn-primary btn-lg" name="fileToUpload_4[]" ><br>
    

    <input style="font-size:80px;  " type="submit" class="btn btn-success btn-lg" value="Enviar" name="submit">
    <br><br><br>  <input type="checkbox" style="font-size:10px;width:10px; height:10px; " name="dividir_pdf"  value="1" > Dividir PDF por páginas<br>
    <br><input type="checkbox" style="font-size:10px;width:10px; height:10px; " name="eliminar_original" checked value="1" > Eliminar foto original (ahorra espacio)<br>
</form>

 <!--<button>Open File Dialog</button>-->


<script>
    
//$("button").on("click", function() {
//        $("#input_element").trigger("click");
//      });  
//$("button").show();      
//$("button").focus();      
//$("button").click();      
//document.getElementById("input_element").show();
//document.getElementById("input_element").focus();
//document.getElementById("input_element").trigger("click");
//alert(document.getElementById("input_element").name);
//$('#input_element').show();
//$('#input_element').focus();
//$('#input_element').click();
//$('#input_element').hide();

</script>


<?php require '../include/footer.php'; ?>
</BODY>
</html>