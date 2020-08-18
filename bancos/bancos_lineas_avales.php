<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Líneas avales';

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


<h5><?php echo $_SERVER["SCRIPT_NAME"];?></h5>

<?php // $id_proveedor=$_GET["id_proveedor"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php require_once("bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO SUBCONTRATOS *************  -->

<div id="main" class="mainc_100" >
	<h1>LINEAS DE AVALES</h1>
<?php 
     
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;
$limite = isset($_POST["limite"]) ? $_POST["limite"] : 30 ;

 ?>

<a class="btn btn-primary" href="l_avales_anadir.php" target='_blank'><i class="fas fa-plus-circle"></i> Añadir Linea Avales</a><br>
<a class="btn btn-primary" href="../bancos/aval_anadir.php" target='_blank'><i class="fas fa-plus-circle"></i> Nuevo aval</a><br>

<div style="width:100% ; border-style:solid;border-width:2px; border-color:silver ;" >
	
 <FORM action="bancos_lineas_avales.php" method="post" id="form1" name="form1">
		<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>" placeholder="Filtrar..."   >
<!--		<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" selected>30</option>
  			<option value="100">100</option>
  			<option value="999999999">Todas</option>
		</select>-->
                <INPUT type='submit' class='btn btn-success btn-xl' value='Actualizar' id='submit' name='submit'>
		<!--<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">-->
 </FORM>

</div>
	
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045



$sql="SELECT  ID_AVAL,id_linea_avales,ID_OBRA,FECHA,MOTIVO,IMPORTE,banco,NOMBRE_OBRA,CONCAT(NUMERO,'-',NOMBRE) AS Licitacion"
        . ",F_Recogida, IF(NOW()<F_Recogida,1,0) AS En_Plazo,Solicitado,F_solicitud ,Observaciones "
        . " FROM Avales_View "
        . "WHERE CONCAT_WS('-',MOTIVO,IFNULL(NOMBRE_OBRA,''),banco,IMPORTE)  LIKE '%$filtro%' AND (!Recogido) AND  $where_c_coste ORDER BY id_linea_avales" ;
$sql_T="SELECT 'TOTAL IMPORTES',SUM(Importe_Limite) AS Importe_Limite ,SUM(importe_Avalado) AS importe_Avalado,SUM(importe_disponible) AS importe_disponible, '' as a1 FROM bancos_Avales WHERE (banco LIKE '%$filtro%') AND  $where_c_coste " ;
//$sql_S="SELECT id_linea_avales,banco,Importe_Limite,importe_Avalado,importe_disponible	FROM bancos_Avales WHERE (banco LIKE '%$filtro%') AND  $where_c_coste ORDER BY banco" ;
$sql_S="SELECT id_linea_avales,banco,Importe_Limite,importe_Avalado,importe_disponible	FROM bancos_Avales WHERE   $where_c_coste ORDER BY banco" ;
$id_agrupamiento="id_linea_avales" ;

//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)


$updates=[] ;
$formats["Importe_Limite"]='moneda' ;
$formats["IMPORTE"]='moneda' ;
$formats["importe_Avalado"]='moneda' ;
$formats["importe_disponible"]='moneda' ;
$formats["En_Plazo"]='semaforo_OK' ;
$formats["Solicitado"]='semaforo_txt_SOLICITADO' ; 
$formats["Observaciones"]='textarea_20_0' ; 

 
$etiquetas["F_Recogida"]=['F prevista recogida',"Fecha prevista de recogida por devolución.\n Es decir, el periodo de garantia (UN AÑO habitualmente) tras la fecha prevista de finalización"]; 


$links["banco"] = ["../bancos/l_avales_ficha.php?id_linea_avales=", "id_linea_avales"] ;
//$links[""] = ["../bancos/l_avales_ficha.php?id_linea_avales=", "id_linea_avales"] ;
//$links["MOTIVO"] = ["../include/ficha_general.php?tabla=Avales&id_update=ID_AVAL&id_valor=", "ID_AVAL"] ;
$links["FECHA"] = ["../bancos/aval_ficha.php?id_aval=", "ID_AVAL",'','formato_sub'] ;
$links["MOTIVO"] = ["../bancos/aval_ficha.php?id_aval=", "ID_AVAL",'','formato_sub'] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ; 


//$links["N_Cta"] = $links["Banco"] ;
//$links["Tipo_Cuenta"] = $links["Banco"] ;

//$aligns["Limite_Dto"] = "right" ;
//$aligns["Credito_disponible"] = "right" ;
//$aligns["Saldo"] = "right" ;
//$aligns["Linea_Dto"] = "center" ;
//$aligns["Activa"] = "center" ;
//$tooltips["Activa"] = "Indica si la cuenta está en uso o no" ;
//$tooltips["Linea_Dto"] = "Las líneas de descuento necesitan certificaciones públicas o pagarés privados para disponer del crédito" ;
//

$anchos_ppal=[30,20,20,20,20,20,20] ;

$titulo="";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla_group.php");?>

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