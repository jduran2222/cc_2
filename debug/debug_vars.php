<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Debug vars';

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

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');