<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Fras. Proveedor (subida múltiple)';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal 
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************

                <!--****************** BUSQUEDA GLOBAL  *****************
                <!--<div class="col-12 col-md-4 col-lg-9">-->

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

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');