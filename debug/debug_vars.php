<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	
?>



<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<TITLE>Debug</TITLE>
	<link href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel=stylesheet type="text/css" hreflang="es">
	<!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>

<body>

<style>
        .box_wiki{
    display: none;
    width: 100%;
}

a:hover + .box_wiki,.box_wiki:hover{
    display: block;
    position: relative;
    z-index: 100;
}
</style>    
    
    
<?php 

if($_SESSION['admin'])
{    

            require_once("../../conexion.php");
            require_once("../include/funciones.php");

            ?>
    Link previews for <a href="https://en.wikipedia.org/">Wikipedia</a><div class="box_wiki"><iframe src="https://en.wikipedia.org/" width = "500px" height = "500px"></iframe></div>, 
        <a href="http://www.jquery.com/">JQuery</a><div class="box_wiki"><iframe src="http://www.jquery.com/" width = "500px" height = "500px"></iframe></div>
        , and <a href="https://wiki.construcloud.es/index.php?title=Main_Page#Licitaciones" target='_blank'>Main_Page#Licitaciones</a><div class="box_wiki"><iframe src="https://wiki.construcloud.es/index.php?title=Main_Page#Licitaciones" width = "500px" height = "500px"></iframe></div>
        will appear when these links are moused over.
 <?php   
            
            echo "<br><br>INICIO \$_REQUEST[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_REQUEST);
            echo "</pre>";

            echo "<br><br>INICIO \$_GET[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_GET);
            echo "</pre>";
            
            echo "<br><br>INICIO \$_POST[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_POST);
            echo "</pre>";

            echo "<br><br><br><br><br>";
            echo "variable __FILE__";
            echo __FILE__ ;
            echo "<br>INICIO \$_SERVER[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_SERVER);
            echo "</pre>";
            echo "<br><br><br><br><br><br>INICIO \$_SESSION[]";

            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_SESSION);
            echo "</pre>";

            echo "<br><br><br><br><br><br>INICIO \$_FILES[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_FILES);
            echo "</pre>";

            echo "<br><br><br><br><br><br>";

            echo "<br><br><br><br><br><br>INICIO \$_ENV[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_ENV);
            echo "</pre>";

            echo "<br><br><br><br><br><br>INICIO \_COOKIE[]";
            echo "<pre>";
            //$a = array ('a' => 'manzana', 'b' => 'banana', 'c' => array ('x', 'y', 'z'));
            print_r ($_COOKIE);
            echo "</pre>";

            echo "<br><br><br><br><br><br>";


}            
?>

</BODY>

</HTML>
