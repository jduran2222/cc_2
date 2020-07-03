
<?php 
require_once("../include/funciones.php"); 

if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS SI NO TIENEN ACCESO A ESA OBRA

{

$active= isset($active)? $active : basename( $_SERVER['PHP_SELF'], ".php")  ;  // elemento a dejar activo


?>

<div class="topnav noprint" id="myTopnav">
	
  

  <!--<a href="../menu/pagina_inicio.php" class="active">Inicio</a>-->
  <a <?php echo ($active=='estudios_buscar'? "class='cc_active'" : "" ) ; ?> href="../estudios/estudios_buscar.php" >Listado Licitaciones</a>
  <a  <?php echo ($active=='estudios_calendar'? "class='cc_active'" : "" ) ; ?>    href="../estudios/estudios_calendar.php?fecha=<?php echo date("Y-m-d"); ?>" >Calendario Licitaciones</a>
  <!--<a href="../estudios/estudios_nuevo.php" > Añadir Licitación</a>-->
  <a <?php echo ($active=='ofertas_clientes'? "class='cc_active'" : "" ) ; ?> href="../estudios/ofertas_clientes.php" >Presupuestos a Clientes</a>
  <!--<a href="../estudios/estudios_calendar_aperturas.php?fecha=<?php echo date("Y-m-d"); ?>" >Calendario Aperturas</a>-->
 <!--<a href="../estudios/ofertas_clientes.php" >Ofertas_Clientes (pdte)</a>-->
 <a href="javascript:void(0);"  class="icon" onclick="myFunction()">&#9776;</a>

   <!--<a href="javascript:void(0);" style="font-size:15px;cursor:pointer"  onclick="openNav()">Menu PPAL</a>-->  


</div>



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
