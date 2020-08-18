<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Clientes Factura';

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

<?php $id_cliente=$_GET["id_cliente"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php 

require_once("clientes_menutop_r.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO FACTURAS CLIENTES *************  -->

<div id="main" class="mainc" style="background-color:#fff">
	
<?php 
      if (isset($_POST["filtro"])) 
	   { $filtro=$_POST["filtro"] ;
	   }
        else
		{ $filtro='' ;
		}   ;

$limite=isset($_POST["limite"])?$_POST["limite"] : 30 ;

 ?>

	
<FORM action="clientes_facturas.php?id_cliente=<?php echo $id_cliente;?>" method="post" id="form1" name="form1">
		<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtro (nombre obra, concepto...)"   >
		<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" selected>30</option>
  			<option value="100">100</option>
  			<option value="999999999">Todas</option>
		</select>	
		<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$sql="SELECT ID_FRA,ID_OBRA ,N_FRA, NOMBRE_OBRA, FECHA_EMISION,CONCEPTO, IVA,   Importe_iva,FORMAT(Pdte_Cobro,2) as Pdte_Cobro,IF(Negociada,'X','') AS Neg , Banco_Neg  FROM Facturas_View WHERE ID_CLIENTE=$id_cliente AND (filtro LIKE '%$filtro%') AND $where_c_coste ORDER BY FECHA_EMISION DESC LIMIT $limite" ;
$sql="SELECT ID_FRA,ID_OBRA,CLIENTE ,N_FRA, NOMBRE_OBRA, FECHA_EMISION,CONCEPTO, IVA,   Importe_iva, Pdte_Cobro, Banco_Neg  FROM Facturas_View WHERE ID_CLIENTE=$id_cliente AND (filtro LIKE '%$filtro%') AND $where_c_coste ORDER BY FECHA_EMISION DESC LIMIT $limite" ;
$sql_T="SELECT  '' as a,'' as a55,'' as a5, '' as a11,'' as a111, '' as a11111, SUM(Importe_iva) as importe, SUM(Pdte_Cobro) as importe_pdte, '' as aa  FROM Facturas_View WHERE ID_CLIENTE=$id_cliente AND (filtro LIKE '%$filtro%') AND $where_c_coste ORDER BY FECHA_EMISION DESC LIMIT $limite" ;



//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

$links["N_FRA"] = ["factura_cliente.php?id_fra=", "ID_FRA"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$aligns["Importe_iva"] = "right" ;
$formats["Pdte_Cobro"] = "moneda" ;
//$formats["Negociada"] = "boolean" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Neg"] = "center" ;
//
//$aligns["Pagada"] = "center" ;
//$tooltips["Negociada"] = "Indica si la factura o certificación está negociada en alguna Línea de Descuento" ;
$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;




$titulo="FACTURAS DE CLIENTES";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN FACTURAS CLIENTES *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	
	</div>
	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
