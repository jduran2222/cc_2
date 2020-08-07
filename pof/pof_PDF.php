<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'PoF - Peticiones de Oferta';

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

$id_pof=$_GET["id_pof"];

?>

<div style="overflow:visible">	   

    
	<!--************ INICIO ficha POF *************  -->

			
<?php   // Iniciamos variables para ficha.php  background-color:#B4045


// LOGO
if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste"))
  {   $path_logo_empresa = "../img/no_image.jpg";}

 echo "<br><a class='btn btn-link noprint' title='imprimir' href=#  onclick='window.print();'>"
  . "<i class='fas fa-print'></i> Imprimir</a>" ; 

//echo "<div ><img width='300' src='{$path_logo_empresa}_large.jpg' > </div>" ;   

// DATOS GENERALES

$result=$Conn->query("SELECT * FROM POF_lista WHERE ID_POF=$id_pof AND $where_c_coste " ); 
$rs1 = $result->fetch_array(MYSQLI_ASSOC) ;


$html= file_get_contents( '../plantillas/pof.html' ) ;
//$html= file_get_contents( '../plantillas/p.html' ) ;

$rs1['LOGO_EMPRESA']=$path_logo_empresa ;



 
//  $updates=['NUMERO','NOMBRE_POF','F_Cierre','Importe_aprox',  'Observaciones', 'Terminada','Adjudicatario', 'Condiciones', 'f_adjudicacion']  ;
// // $id_proveedor=$rs["ID_PROVEEDORES"] ;
//  $tabla_update="PETICION DE OFERTAS" ;
//  $id_update="ID_POF" ;
//  $id_valor=$id_pof ;
// 
//  $formats["Terminada"]="boolean" ;
//
//$titulo="PETICION DE OFERTA (POF)";
//$msg_tabla_vacia="No hay.";
 
$id_obra=$rs1["ID_OBRA"] ;



     
//require("../include/ficha.php");
?>


<div  >
<?php   // Iniciamos variables para tabla.php  

$espacios_en_blanco='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp' ;

$sql="SELECT id,CANTIDAD, CONCAT('<b>',CONCEPTO,'</b><br><small>',IFNULL(DESCRIPCION,''),'</small>') AS CONCEPTO,"
        . " '$espacios_en_blanco' as _PRECIO ,"
        . " '$espacios_en_blanco' AS _IMPORTE "
        . " FROM POF_CONCEPTOS WHERE ID_POF=$id_pof AND Ocultar=0 ORDER BY id" ;

//echo $sql ;


$result=$Conn->query( $sql );

$titulo='';
$msg_tabla_vacia="No hay";

//$updates=['CANTIDAD','CONCEPTO', 'Precio_Cobro', 'Precio_Compra','P1','P2','P3','P4','P5','P6','P7','P8','P9']  ;
 
require("../include/tabla.php"); 

//echo $TABLE ;
$rs1["HTML_TABLA1"] = $TABLE ;



foreach ($rs1 as $clave => $valor)
{
$localizador='@@'.strtoupper($clave).'@@'  ;
$html= str_replace($localizador, $valor, $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos
//$html= str_replace('@@CIUDAD@@', 'Málaga', $html)  ;
//$html= str_replace('@@FECHA_LARGA@@', '26 de Febrero de 2.019', $html)  ;
} 

echo $html ;




?>



</div>

<!-- ************ FIN POF_CONCEPTOS (Unidades de Obra) *************  -->

<?php  

$Conn->close();

?>
	 

</div> 

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');