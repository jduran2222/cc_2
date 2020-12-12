<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'SUBCONTRATOS';

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


    <h1>SUBCONTRATOS</h1>

<?php

$id_obra=$_GET["id_obra"];

require_once("../obras/obras_menutop_r.php");
//require_once("../menu/menu_migas.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 
      if (isset($_POST["filtro"])) 
	   { $filtro=$_POST["filtro"] ;
	   }
        else
		{ $filtro='' ;
		}   ;
 ?>
<FORM action="../obras/obras_subcontratos.php?id_obra=<?php echo $id_obra;?>" method="post" id="form1" name="form1">
    <INPUT id="filtro" type="text" name="filtro" placeholder="filtrar..." value="<?php echo $filtro;?>"   >
    <button type="button" onclick="document.getElementById('filtro').value='' ; ">*</button>
		<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


$result=$Conn->query($sql="SELECT id_subcontrato,id_proveedor ,subcontrato,PROVEEDOR ,fecha_creacion as fecha, Importe_cobro, p_contrato, Importe_subcontrato, Margen "
        . " ,Importe_ejecutado,  Porc_ej FROM Subcontratos_todos_View WHERE ID_OBRA=$id_obra AND (filtro LIKE '%$filtro%') ORDER BY fecha_creacion DESC " );
$result_T=$Conn->query($sql_T="SELECT 'Suma', '' as a,'' as b, SUM(Importe_cobro) as importe_cobro,IF(IMPORTE<>0,SUM(Importe_cobro)/IMPORTE,0) AS p_contrato, SUM( Importe_subcontrato) as importe_subcontrato "
        . ",(SUM(Importe_cobro)-SUM( Importe_subcontrato))/SUM(Importe_cobro) Margen "
        . " ,SUM(Importe_ejecutado) AS Importe_ejecutado,SUM(Importe_ejecutado)/SUM( Importe_subcontrato) AS  Porc_ej FROM Subcontratos_todos_View "
        . "WHERE ID_OBRA=$id_obra AND (filtro LIKE '%$filtro%') ORDER BY fecha_creacion DESC " );

echo "<br> {$result->num_rows} filas" ;

$formats["Importe_subcontrato"]='moneda' ;
$formats["Importe_cobro"]='moneda' ;
$formats["Importe_ejecutado"]='moneda' ;
$formats["Margen"]='porcentaje' ;
$formats["Porc_ej"]='porcentaje' ;
 
$links["subcontrato"] = ["../obras/subcontrato.php?id_subcontrato=", "id_subcontrato", '', 'formato_sub'] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor", '', 'formato_sub'] ;

//$aligns["PROVEEDOR"] = "left" ;
$aligns["Importe_subcontrato"] = "right" ;
$aligns["Importe_ejecutado"] = "right" ;
$aligns["Margen"] = "center" ;
$aligns["Porc_ej"] = "center" ;
$tooltips["Margen"] = "Margen de beneficio entre el cobro y lo subcontratado" ;
$tooltips["Porc_ej"] = "Porcentaje de subcontrato ejecutado" ;


echo   "<a class='btn btn-link btn-lg noprint' href='../obras/obras_subcontrato_anadir.php?_m=$_m&id_obra=$id_obra' target='_blank' ><i class='fas fa-plus-circle'></i> añadir Subcontrato</a>" ; // BOTON AÑADIR FACTURA


$titulo="SUBCONTRATOS";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN SUBCONTRATOS *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
