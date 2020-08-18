<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Añadir nueva cuenta bancaria';

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
<?php   
 
require_once("../bancos/bancos_menutop_r.php");

?>
      	
<div class="mainc" style="background-color:white;align:center;width:70%;">

	
<img style="display:block; margin:auto;" width="200" src="../img/construcloud64.svg">
	
	
<form action="bancos_anadir_cta_banco.php" method="post" name="form1">
  <table  style="margin:auto;" >
	  <tr><td colspan="2" align="center" ><h1>Cuenta Bancaria nueva</h1></td></tr>	
    <tr>
      <td><div align="center">Tipo de cuenta bancaria</div></td>
      <td><input list="tipos" name="tipo">
  	       <datalist id="tipos">
    		<option value="CCC">
    		<option value="PRESTAMO">
    		<option value="P.CREDITO">
    		<option value="LINEA DESC">
    		<option value="CONFIRMING">
			<option value="PLAZO FIJO">
			<option value="OTRO">	
  		   </datalist></td>
		
	  
    </tr>
	   <tr>
      <td><div align="center">Banco*</div></td>
      <td><input name="Banco" required type="text"  placeholder="Nombre de la entidad bancaria..."></td>
	 </tr> 
	 <tr>
      <td><div align="center">Número de cuenta</div></td>
      <td><input name="N_Cta"  type="text"  placeholder="Número de cuenta o IBAN..."></td>
	 </tr> 
	 
	 <tr>
      <td><div align="center">Línea de descuento</div></td>
      <td><input type="radio" name="Linea_Dto" value="0" checked>No <input type="radio" name="Linea_Dto" value="1">Si
		 </td>
	 </tr> 
	   <tr>
      <td><div align="center">Límite de descuento o crédito</div></td>
      <td><input name="Limite_Dto"  type="text" value="0"  placeholder="Importe máximo disponible..."></td>
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
  

</div>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');