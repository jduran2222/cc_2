

<?php 
//require_once("../include/funciones.php"); 

if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS SI NO TIENEN ACCESO A ESA OBRA

{

$active= isset($active)? $active : basename( $_SERVER['PHP_SELF'], ".php")  ;  // elemento a dejar activo

?>


<div class="topnav" id="myTopnav">
	
<!--  <a href="javascript:void(0);" style="font-size:15px;cursor:pointer"  onclick="openNav()">Menu PPAL</a>  -->

  
  <a  <?php echo ($active=='bancos_ctas_bancos'? "class='cc_active'" : "" );?>  href="../bancos/bancos_ctas_bancos.php" >Ctas. bancos</a>	
  <!--<a href="../bancos/pagos.php?tipo=P">Pagos</a>-->
  <a  <?php echo ($active=='pagos_y_cobros'? "class='cc_active'" : "" );?>  href="../bancos/pagos_y_cobros.php">Pagos y Cobros</a>
  <a  <?php echo ($active=='facturas_proveedores'? "class='cc_active'" : "" );?>  href="../proveedores/facturas_proveedores.php">Fras Prov</a>
  <a  <?php echo ($active=='facturas_clientes'? "class='cc_active'" : "" );?>  href="../clientes/facturas_clientes.php">Fras Clientes</a>
   <a  <?php echo ($active=='remesas_listado'? "class='cc_active'" : "" );?>  href="../bancos/remesas_listado.php">Remesas Pagos</a>
  <!--<a href="../bancos/bancos_pagos_anuario.php">Tesoreria</a>-->
  <a  <?php echo ($active=='bancos_otros_movs_ng'? "class='cc_active'" : "" );?>  href="../bancos/bancos_otros_movs_ng.php?" >Otras Cuentas</a>
  <a  <?php echo ($active=='bancos_lineas_avales'? "class='cc_active'" : "" );?>  href="../bancos/bancos_lineas_avales.php?" >Linea Avales</a>
  <a  <?php echo ($active=='bancos_impuestos'? "class='cc_active'" : "" );?>  href="../bancos/bancos_impuestos.php?" >Impuestos</a>
  
  
  <a   href="javascript:void(0);"  class="icon" onclick="myFunction()">&#9776;</a>
 
 </div>
<br><br><br>



<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav noprint") {
        x.className += " responsive";
    } else {
        x.className = "topnav noprint";
    }
}
</script>
<?php
 
}

?>
