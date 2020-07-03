<?php
require_once("../include/session.php");
?>

<!DOCTYPE html>
<html>
<body>

<?php $id_subdir = isset( $_GET["id_subdir"] ) ? $_GET["id_subdir"] : "" ;?>
	
<p> SUBIR MULTIPLES PDF DE FACTURAS PROVEEDOR </p>
<form action="fra_prov_anadir_m_PDFs.php" method="post" enctype="multipart/form-data">

<!--	<input type="hidden" name="tipo_entidad"  value="<?php echo $_GET["tipo_entidad"] ;?>" >
	<input type="hidden" name="id_subdir"  value="<?php echo $id_subdir;?>" >
	<input type="hidden" name="id_entidad"  value="<?php echo $_GET["id_entidad"];?>" >-->
	
   Selecciona archivo:
    <input type="file" name="fileToUpload[]" multiple ><br>
	  <!--<input type="text" name="documento"  placeholder="Documento... (opcional)"><br>-->
	  <!--<input type="text" name="observaciones" placeholder="Observaciones...  (opcional)"><br>-->
	  <!--<input type="checkbox" name="reemplazar" >¿Reemplazar fichero si existe?<br>-->										  
    <input type="submit" value="Aceptar" name="submit">
</form>

<?php require '../include/footer.php'; ?>
</BODY>
</html>