

<?php 


if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS SI NO TIENEN ACCESO A ESA OBRA

{

$GET_listado_personal = isset($GET_listado_personal)  ? $GET_listado_personal :   "?agrupar=cal_obras" ;
$GET_Nominas = isset($GET_Nominas)  ? $GET_Nominas :   "?nomina=1" ;


$active= isset($active)? $active : basename( $_SERVER['PHP_SELF'], ".php")  ;  // elemento a dejar activo

//   <!--NO CAMBIAR LAS CLASES DEL DIV SIN CAMBIAR LA FUNCION DE JAVASCRIPT--> 
echo "<div class='topnav noprint' id='myTopnav'>" ;
	

echo "<a ".($active=='personal_listado'? "class='cc_active'" : "" ) ." href='../personal/personal_listado.php'  target='_blank'  title='Listado del personal empleado en la empresa'>Personal</a>" ;
//echo "<a href='../personal/partes.php'>Calendario Partes</a>" ;
echo "<a ".($active=='partes'? "class='cc_active'" : "" ) ." href='../personal/partes.php$GET_listado_personal'   target='_blank' >Partes</a>" ;
echo "<a ".($active=='facturas_proveedores'? "class='cc_active'" : "" ) ." href='../proveedores/facturas_proveedores.php$GET_Nominas'  target='_blank' >Nominas</a>" ;

echo "<a href='javascript:void(0);'  class='icon' onclick='myFunction()'>&#9776;</a>" ;

//  <!--<a href='javascript:void(0);" style="font-size:80px;" class="icon" onclick="myFunction()">&#9776;</a>-->
echo "</div>" ;

echo "<br><br><br>";
echo "<br><br><br>";

?>


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