<?php
require_once("../include/session.php");
?>

<!DOCTYPE html>
<html>
    <HEAD>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<body>

<?php $id_cta_banco = $_GET["id_cta_banco"]  ;?>
	
<h1> Subir fichero CSB </h1>
<form action="mov_bancos_upload.php?id_cta_banco=<?php echo $id_cta_banco;?>" method="post" enctype="multipart/form-data">

<!--	<input type="hidden" name="tipo_entidad"  value="<?php echo $_GET["tipo_entidad"] ;?>" >
	<input type="hidden" name="id_subdir"  value="<?php echo $id_subdir;?>" >
	<input type="hidden" name="id_entidad"  value="<?php echo $_GET["id_entidad"];?>" >-->
	
   Selecciona archivo CSB:
    <input type="file" style="font-size:40px; width:400px; height:200px" class="btn btn-primary btn-lg" name="fileToUpload" ><br>
<!--	  <input type="text" name="documento"  placeholder="Documento... (opcional)"><br>
	  <input type="text" name="observaciones" placeholder="Observaciones...  (opcional)"><br>
	  <input type="checkbox" name="reemplazar" >¿Reemplazar fichero si existe?<br>										  -->
    <br><br><br><br><input style="font-size:80px;   width:400px; height:200px" type="submit" class="btn btn-success btn-lg" value="Aceptar" name="submit">
</form>

<?php require '../include/footer.php'; ?>
</BODY>
</html>