<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Proveedor Añadir';

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

<center>
<div >
	<p align=center style='text-align:center'>
		<img width="200" src="../img/construcloud64.svg">
	</p>
   
</div>    	

<form action="proveedores_anadir.php" method="post" name="form1">
  <table width="40%"  >
	<tr><td colspan="2" align="center" >Proveedor nuevo</td></tr>	
    <tr>
      <td><div align="center">Proveedor</div></td>
      <td><input name="proveedor" required type="text"  style="background-color: #C8C8C8" tabindex=""></td>
	  
    </tr>
	  <tr>
      <td><div align="center">CIF</div></td>
      <td><input name="cif" required type="text"  style="background-color: #C8C8C8" tabindex=""></td>
	  
    </tr> 
    <tr>

	  <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div align="center">
        <input type="submit" name="Submit" value="Aceptar"  >
      </div></td>
      <td align="center"><input name="Cancelar" type="reset" value="Cancelar"></td>
    </tr>
  </table>


  </form>
</center>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');