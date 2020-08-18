<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Proveedores PoFs';

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

<?php

// cogemos el parámetro GET comprobando su coherencia con el id_c_coste
if (!($id_proveedor=Dfirst( "ID_PROVEEDORES" ,"Proveedores"," $where_c_coste AND ID_PROVEEDORES={$_GET['id_proveedor']} " ))) {die("<br><br><br><br><h1>ERROR PROVEEDOR NO ENCONTRADO</h1>");}

require_once("proveedores_menutop_r.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 
     
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;
$limite = isset($_POST["limite"]) ? $_POST["limite"] : 10 ;

 ?>

    <br><br><br><br>	
<FORM action="proveedores_pofs.php?id_proveedor=<?php echo $id_proveedor;?>" method="post" id="form1" name="form1">
		<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>"   >
		<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30">30</option>
  			<option value="100">100</option>
  			<option value="999999999">Todas</option>
		</select>	
		<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045



//$sql="SELECT id_subcontrato, id_obra, NOMBRE_OBRA ,subcontrato,fecha_creacion,FORMAT(Importe_cobro,2) as Importe_cobro, FORMAT(Importe_subcontrato,2) as Importe_subcontrato,CONCAT(FORMAT(100*Margen,2),'%') as Margen  ,	FORMAT(Importe_ejecutado,2) as Importe_ejecutado,CONCAT(FORMAT(100*Porc_ej,1),'%') as  Porc_ej FROM Subcontratos_todos_View WHERE id_proveedor=$id_proveedor AND (filtro LIKE '%$filtro%') ORDER BY fecha_creacion DESC LIMIT $limite" ;
$sql="SELECT id, ID_POF,ID_OBRA,path_archivo, NOMBRE_OBRA ,NOMBRE_POF,PROVEEDOR,fecha_creacion,  Importe "
        . " FROM POF_prov_View WHERE id_proveedor=$id_proveedor AND (filtro LIKE '%$filtro%') ORDER BY fecha_creacion DESC LIMIT $limite" ;

//$sql_T="SELECT '' as a, '' as b, '' as c, SUM( Importe_cobro) as Importe_cobro, SUM( Importe_subcontrato) as Importe_subcontrato,'' AS DD  ,SUM(Importe_ejecutado) as Importe_ejecutado, '' AS FF FROM Subcontratos_todos_View WHERE id_proveedor=$id_proveedor AND (filtro LIKE '%$filtro%') GROUP BY id_proveedor" ;


//echo $sql ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

$etiquetas["PROVEEDOR"]="Oferta" ;

//$links["subcontrato"] = ["../obras/subcontrato.php?id_subcontrato=", "id_subcontrato", "", "formato_sub"] ;
$links["PROVEEDOR"] = ["../pof/pof_proveedor_ficha.php?id=", "id", "", "formato_sub"] ;
$links["NOMBRE_POF"] = ["../pof/pof.php?id_pof=", "ID_POF", "", "formato_sub"] ;
$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["path_archivo"]="pdf_100_500" ;

//$aligns["Importe_cobro"] = "right" ;
//$aligns["Importe_subcontrato"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Margen"] = "center" ;
//$aligns["Porc_ej"] = "center" ;
//$tooltips["Margen"] = "Margen de beneficio entre el cobro y lo subcontratado" ;
//$tooltips["Porc_ej"] = "Porcentaje de subcontrato ejecutado" ;


$titulo="POF PRESUPUESTADAS POR PROVEEDOR";
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
