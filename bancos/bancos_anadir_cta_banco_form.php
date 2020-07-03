<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	
?>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
<title>ConstruCloud</title></head>


<body >
<?php   
 

require_once("../include/funciones.php");
require_once("../menu/topbar.php");
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
<?php require '../include/footer.php'; ?>
</BODY>
</html>

