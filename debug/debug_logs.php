<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Debug logs';

//INICIO
//include_once('../templates/_inc_privado1_header.php');
//include_once('../templates/_inc_privado2_navbar.php');

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

echo logs() ;

?>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
//include_once('../templates/_inc_privado3_footer.php');
