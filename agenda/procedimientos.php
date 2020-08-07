<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'TProcedimientos';

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


<!-- CONEXION CON LA BBDD Y MENUS -->
<?php // require_once("../bancos/bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" style="width:80%;background-color:#fff">
	
<?php 

//$usuario=$_SESSION["user"] ;
//
//$fecha_tareas_vistas=Dfirst("fecha_tareas_vistas","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
//
//$fecha_tareas_vistas= $fecha_tareas_vistas ? $fecha_tareas_vistas : '2000-01-01' ;
//
//$result_UPDATE=$Conn->query("UPDATE `Usuarios` SET `fecha_tareas_vistas` = NOW() WHERE $where_c_coste AND id_usuario={$_SESSION["id_usuario"]}" );



$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;
$obsoleto=isset($_POST["obsoleto"])?$_POST["obsoleto"] : 'Obsoleto=0' ;
//$cobradas=isset($_POST["cobradas"])?$_POST["cobradas"] : '1=1' ;
$grupo=isset($_POST["grupo"])?$_POST["grupo"] : 'listado' ;
 ?>

	
    <FORM action="../agenda/procedimientos.php" method="post" id="form1" name="form1">
		Filtro<INPUT id="filtro" type="text" name="filtro" value="<?php echo $filtro;?>"    >
		
<!--                <br><input type="radio" name="terminada" value="1=1"> todas 
                <input type="radio" name="terminada" value="Terminada=1"> Tareas Terminadas
                <input type="radio" name="terminada" value="Terminada=0"> Tareas no Terminadas
                <br>-->
<?php
                $radio=$obsoleto ;
                $radio_name='obsoleto' ;
                $chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
                if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
                //echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
                echo "<br>"
                     . "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
                     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />todos     </label> "
                     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />Obsoletos   </label>"
                     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />No Obsoletos</label>"
                     . "</div>"
                     . "" ;

?>


                
<!--                <br><input type="radio" name="cobradas" value="1=1"> todas 
                <input type="radio" name="cobradas" value="cobrada=1"> cobradas
                <input type="radio" name="cobradas" value="cobrada=0"> no cobradas
                <br>-->
                
                <br>Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" >30</option>
  			<option value="100" selected>100</option>
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

$where = $filtro ? " Procedimiento LIKE '%$filtro%' AND Texto LIKE '%$filtro%' " : "1=1"  ;
        
 switch ($grupo) {
    case "listado":
//     $sql="SELECT id_remesa,remesa,activa,Observaciones,Banco,importe,num_pagos  FROM Remesas_View WHERE  (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY id_remesa DESC LIMIT $limite" ;
     $sql="SELECT  *  FROM Procedimientos "
            . " WHERE $where AND $where_c_coste  ORDER BY Numero LIMIT $limite" ;
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

echo   "<a class='btn btn-link btn-lg' href='../agenda/procedimiento_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Añadir Procedimiento</a>" ;

//echo $sql ;
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

//$links["f_vto"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa"] ;
//$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
//$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver remesa completa", "formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$links["Numero"] = ["../agenda/procedimiento_ficha.php?id_procedimiento=", "id_procedimiento",'', 'formato_sub'] ;


$updates=['Obsoleto', 'Tema','Procedimiento', 'hashtag']  ;
$tabla_update="Procedimientos" ;
$id_update="id_procedimiento" ;
$actions_row=[];
$actions_row["id"]="id_procedimiento";
$actions_row["delete_link"]="1";

// 
//$formats["Tarea"] = "text_edit" ;
$formats["Tema"] = "text_edit" ;
$formats["Procedimiento"] = "text_edit" ;
$formats["hashtag"] = "text_edit" ;
$formats["Texto"] = "textarea" ;
$formats["Obsoleto"] = "boolean" ;
//$formats["prioridad"] = "text_edit" ;
//$formats["Terminada"] = "boolean" ;
//$formats["vista"] = "semaforo" ;
//$formats["fecha_modificacion"] = "fecha_friendly" ;
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


$titulo="<h2>PROCEDIMIENTOS ({$result->num_rows})</h2>";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

 <br><br><br><br><br><br><br><br><br>...	
   
      footer
</div>

<!--************ FIN  *************  -->
	
	

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
