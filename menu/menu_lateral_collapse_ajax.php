<?php
require_once("../include/session.php");
// cambiamos el valor de menu lateral collapse para que se mantenga al abrir nuevas ventanas
$_SESSION["menu_lateral_collapse"] = !($_SESSION["menu_lateral_collapse"]) ;
//$_SESSION["menu_lateral_collapse"] = 1 ;
//echo 'juan' ;
?>