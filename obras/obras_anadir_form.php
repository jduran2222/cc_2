<?php
require_once("../include/session.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
        <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
        
<title>Obra nueva</title></head>


<body >

<?php require("../menu/topbar.php");	?>
<?php   
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
?>


<div class="mainc" >
	
	<div align="center"><img width="200" src="../img/construcloud64.svg"> </div>
	
<?php 

// registramos el documento en la bbdd
require("../../conexion.php"); 
require_once("../include/funciones.php"); 


$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	
//$option=DArray("ID_CLIENTE,CLIENTE","Clientes",$where_c_coste, "CLIENTE")  ; 

?>
      	
<div align="center">	

<form action="../obras/obras_anadir.php" method="post" name="form1"  >
 <div class="form-group">
  <table width="60%"  border="0" cellpadding="1" cellspacing="2">
      <tr ><td colspan="2" align="center" ><span class="encabezadopagina2"><h1><i class="fas fa-road"></i> Obra nueva</h1></span></td></tr>	
<!--	    // ANULAMOS EL CAMPO CLIENTE PARA SIMPLIFICAR EL REGISTRO DE NUEVA OBRA, juand, mayo20
	<tr>
      <td width="20%"><span ><i class="fas fa-briefcase"></i> Cliente</span></td>
      <td>
       <select class="form-control input-sm" name="id_cliente">
		   <?php 
//            foreach ($option as $clave => $valor)  //  VALORES
//     	   {  
//			echo  "<option value=\"{$valor['id_cliente']}\">{$valor['Cliente']}</option>";
//		
//			}
                   
//		  echo DOptions("ID_CLIENTE,CLIENTE","Clientes",$where_c_coste, "CLIENTE")  ; 
	       //  <option value="volvo">Volvo</option>
			?>
    	</select>
		  
      </td>
    </tr>  -->
	  
    <tr> 
      <td><i class="fas fa-road"></i> Nombre Obra</td>
      <td><input class="form-control input-sm" name="nombre_obra" required type="text"  style="background-color: #C8C8C8" tabindex=""  ></td>
    </tr>
    <tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td align="center"><input class='btn btn-primary btn-lg'  type="submit" name="Submit" value="Aceptar"  ></td>
    </tr>
  </table>

</div>
  </form>
</div>
</div>

<?php require '../include/footer.php'; ?>
</BODY>
</html>

