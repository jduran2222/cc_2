<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Banc Subida';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">

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

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');