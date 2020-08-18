<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Obra nueva';

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

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

