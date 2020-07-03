<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
     <title>Actividad</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>

    <BR><BR><BR><BR><BR><BR>


<!-- CONEXION CON LA BBDD Y MENUS -->
<?php require_once("../../conexion.php"); ?> 
<?php require_once("../include/funciones.php"); ?> 
<?php require_once("../menu/topbar.php");?>
<?php // require_once("../bancos/bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" >
	
<?php 

$usuario=$_SESSION["user"] ;


// fecha desde la que mostrar eventos

if (isset($_POST["fecha"]))
{
 $fecha=$_POST["fecha"]  ;   
}
else
{    
  $fecha=Dfirst("fecha_eventos_vistos","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
  $fecha= $fecha ? $fecha : '2000-01-01' ;
}

$result_UPDATE=$Conn->query("UPDATE `Usuarios` SET `fecha_eventos_vistos` = NOW() WHERE $where_c_coste AND id_usuario={$_SESSION["id_usuario"]}" );



$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;
//$terminada=isset($_POST["terminada"])?$_POST["terminada"] : 'Terminada=0' ;
//$cobradas=isset($_POST["cobradas"])?$_POST["cobradas"] : '1=1' ;
$grupo=isset($_POST["grupo"])?$_POST["grupo"] : 'listado' ;

    

if ($_SESSION['admin'])
{
    echo "<a class='btn btn-link noprint' href= '../agenda/eventos.php' ><i class='fas fa-globe-europe'></i> Eventos global</a><br>" ;
    echo "<a class='btn btn-link noprint' href= '../agenda/eventos.php?local=1' >Eventos de {$_SESSION['empresa']} ({$_SESSION['id_c_coste']} )</a><br>" ;
}   

$listado_global=$_SESSION['admin'] AND !isset($_GET["local"]) ;  // listado global si somos admin y no es local


 ?> 

	
    <FORM action="../agenda/eventos.php" method="post" id="form1" name="form1">
		Filtro<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>"    >
		
                <br>Fecha desde:<input type="date" name="fecha" > 
                <br>
                
<!--                <br><input type="radio" name="cobradas" value="1=1"> todas 
                <input type="radio" name="cobradas" value="cobrada=1"> cobradas
                <input type="radio" name="cobradas" value="cobrada=0"> no cobradas
                <br>-->
                
                Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" >30</option>
  			<option value="100" selected>100</option>
  			<option value="300" selected>100</option>
  			<option value="1000" selected>100</option>
  			<option value="999999999">todos</option>
		</select>
                <br>
<!--                <br>Agrupar <input type="radio" name="grupo" value="listado"> listado 
                <input type="radio" name="grupo" value="meses"> por meses
                <input type="radio" name="grupo" value="bancos"> por banco
                <br>-->
                <INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

 switch ($grupo) {
    case "listado":
//     $sql="SELECT id_remesa,remesa,activa,Observaciones,Banco,importe,num_pagos  FROM Remesas_View WHERE  (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY id_remesa DESC LIMIT $limite" ;
     $sql= ( $listado_global )  ?          // si es ADMIN y NO LOCAL, hacemos búsqueda Global
            "SELECT  id_c_coste as empresa, Fecha_Creacion, user, tipo as tipo_entidad,descripcion ,CONCAT('tipo_entidad=',tipo,'&id_entidad=',id) as id_entidad_link, Fecha_Creacion as _fecha_creacion, id as nid FROM eventos "
            . "WHERE tipo LIKE '%$filtro%' AND Fecha_Creacion >= '$fecha' ORDER BY Fecha_Creacion DESC LIMIT $limite" :
            "SELECT  Fecha_Creacion, user, tipo as tipo_entidad,descripcion ,CONCAT('tipo_entidad=',tipo,'&id_entidad=',id) as id_entidad_link, Fecha_Creacion as _fecha_creacion, id as nid FROM eventos "
            . "WHERE tipo LIKE '%$filtro%' AND $where_c_coste AND Fecha_Creacion >= '$fecha' ORDER BY Fecha_Creacion DESC LIMIT $limite" ;
//    echo $sql ;

//     $sql_T="SELECT '' AS A1 , '' AS A2,SUM(importe) as importe,SUM(ingreso) as ingreso,'' AS B,'' AS C,'' as d,'' as f  FROM Pagos_View WHERE tipo_pago='$tipo' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY f_vto LIMIT $limite" ;
    break;
   case "meses":
//     $sql="SELECT  DATE_FORMAT(f_vto, '%Y-%m') as mes,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY mes " ;
//     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
//    break;
   case "bancos":
//     $sql="SELECT  id_cta_banco, banco,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY id_cta_banco " ;
//     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
//    break;
 }

//echo   "<a class='btn btn-link btn-lg' href='../agenda/tarea_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Añadir Tarea</a>" ;

//echo $sql ;
$result=$Conn->query($sql) ;


$links["tipo_entidad"] =["../include/ficha_entidad.php?", "id_entidad_link", "ver entidad asociada al documento (Factura, albarán, ...)", 'formato_sub'] ;
$links["empresa"] =["../configuracion/empresa_ficha.php?id_empresa=", "empresa", "ver empresa", 'formato_sub'] ;

$visibles=['id'] ;
$formats["id"] = "" ;
$formats["Fecha_Creacion"] = "fecha_friendly" ;
//$formats["Texto"] = "text_edit" ;
//$formats["prioridad"] = "text_edit" ;
//$formats["Terminada"] = "boolean" ;
//$formats["vista"] = "semaforo" ;
//$formats["fecha_modificacion"] = "" ;
//$formats["Terminada"] = "semaforo" ;
//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["f_vto"] = "fecha" ;
//$formats["activa"] = "boolean" ;
//$formats["firmada"] = "semaforo" ;
//$formats["saldo"] = "moneda" ;
//$formats["cobrada"] = "boolean" ;
////$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["num_pagos"] = "center" ;
////$aligns["Pagada"] = "center" ;
//$tooltips["Terminada"] = "Indica si la Tarea ha finalizado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;

$global_txt= $listado_global ? "GLOBAL"  : "" ;
$titulo="<h2>ACTIVIDAD $global_txt ({$result->num_rows})</h2>";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	
	</div>-->
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

