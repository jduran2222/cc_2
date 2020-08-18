<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Producciones';

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



<!-- CONEXION CON LA BBDD Y MENUS -->
<?php 

// require("../bancos/bancos_menutop_r.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" style="background-color:#fff">
	
<?php 

$solo_form=0;
if (!isset($_POST["NOMBRE_OBRA"]))
{
//form vacio
  $solo_form=1;
//  $tipo_subcentro="OGAMEX";
  $NOMBRE_OBRA="";
  $PRODUCCION="";
  $CAPITULO="";
  $UDO="";
  $FECHA1="01-01-1980";
  $FECHA2="01-01-2030";
  $SUBOBRA="";
  $DETALLE="";

} 
 else {
$NOMBRE_OBRA=$_POST["NOMBRE_OBRA"];
$CAPITULO=$_POST["CAPITULO"];
$FECHA1=$_POST["FECHA1"];
$FECHA2=$_POST["FECHA2"];
$PRODUCCION=$_POST["PRODUCCION"];
$UDO=str_replace(" ","%",$_POST["UDO"]);

$SUBOBRA=$_POST["SUBOBRA"];
$DETALLE=$_POST["DETALLE"];
$agrupar=$_POST["agrupar"];   

     
 }


//Compruebo si viene por un link
if (isset($_GET["id_produccion"]))
{

//  $NOMBRE_OBRA=$_GET["NOMBRE_OBRA"];
  $ID_PRODUCCION=$_GET["id_produccion"];
  $PRODUCCION= Dfirst("PRODUCCION", "PRODUCCIONES","ID_PRODUCCION=$ID_PRODUCCION" ) ;
//  $PRODUCCION= 'hola' ;
//  $FECHA1=$_GET["FECHA1"];
//  $FECHA2=$_GET["FECHA2"];
  $solo_form=0;
}

 ?>

	
   <br>

   <form action="producciones.php" method="post" id="form1" name="form1">
<TABLE align="center">
<TR><TD color=red colspan=2 bgcolor=PapayaWhip align=center>SELECCION PRODUCCION</TD></TR>
<TR><TD>OBRA       </TD><TD><INPUT type="text" name="NOMBRE_OBRA" value="<?php echo $NOMBRE_OBRA;?>"></TD></TR>
<TR><TD>PRODUCCION  </TD><TD><INPUT type="text" name="PRODUCCION" value="<?php echo $PRODUCCION;?>"></TD></TR>
<TR><TD>CAPITULO   </TD><TD><INPUT type="text" name="CAPITULO" value="<?php echo $CAPITULO;?>"></TD></TR>
<TR><TD>Unidad de obra</TD><TD><INPUT type="text" name="UDO" value="<?php echo $UDO;?>"></TD></TR>
<TR><TD>FECHA1     </TD><TD><INPUT type="date" name="FECHA1" value="<?php echo $FECHA1;?>"></TD></TR>
<TR><TD>FECHA2     </TD><TD><INPUT type="date" name="FECHA2" value="<?php echo $FECHA2;?>"></TD></TR>
<TR><TD>SUBOBRA    </TD><TD><INPUT type="text" name="SUBOBRA" value="<?php echo $SUBOBRA;?>"></TD></TR>
<TR><TD>Detalle    </TD><TD><INPUT type="text" name="DETALLE" value="<?php echo $DETALLE;?>"></TD></TR>


</TABLE>
<center>Agrupar por:<br>
<button   onclick="getElementById('agrupar').value = 'costes'; getElementById('form1').submit();">costes</button>
<button   onclick="getElementById('agrupar').value = 'capitulos'; getElementById('form1').submit();">capitulos</button>
<button   onclick="getElementById('agrupar').value = 'meses'; getElementById('form1').submit();">meses</button>
<button   onclick="getElementById('agrupar').value = 'fechas'; getElementById('form1').submit();">fechas</button>
<button   onclick="getElementById('agrupar').value = 'udos'; getElementById('form1').submit();">unidad obra</button>
<button   onclick="getElementById('agrupar').value = 'detalle'; getElementById('form1').submit();">detalle</button>
<button   onclick="getElementById('agrupar').value = 'obras'; getElementById('form1').submit();">obras</button>

<input type="hidden"  id="agrupar"  name="agrupar">


<!--<INPUT type="submit" value="EJECUTAR CONSULTA" id="submit" name="submit">-->
</center>
</form>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ;
$where="1=1 ";

//$where=$tipo_subcentro==""? $where : $where . " AND LOCATE(tipo_subcentro,'$tipo_subcentro')>0 " ;
$where=$NOMBRE_OBRA==""? $where : $where . " AND NOMBRE_OBRA LIKE '%$NOMBRE_OBRA%'" ;
$where=$PRODUCCION==""? $where : $where . " AND PRODUCCION LIKE '%$PRODUCCION%'" ;
$where=$CAPITULO==""? $where : $where . " AND CAPITULO LIKE '%$CAPITULO%'" ;
$where=$UDO==""? $where : $where . " AND UDO LIKE '%$UDO%'" ;
$where=$SUBOBRA==""? $where : $where . " AND SUBOBRA LIKE '%$SUBOBRA%'" ;
//$where=$TIPO_GASTO==""? $where : $where . " AND TIPO_GASTO LIKE '%$TIPO_GASTO%'" ;
//$where=$FECHA1=="01-01-1980"? $where : $where . " AND FECHA >= STR_TO_DATE($FECHA1,'%d-%m-%Y')" ;
$where=$FECHA1==""? $where : $where . " AND FECHA >= STR_TO_DATE('$FECHA1','%Y-%m-%d') " ;
$where=$FECHA2==""? $where : $where . " AND FECHA <= STR_TO_DATE('$FECHA2','%Y-%m-%d') " ;


//where de fechas    $FECHA1="";

if (isset($agrupar))   // si se ha activado el form
{
 switch ($agrupar) {
    case "costes":
     $sql="SELECT ID_OBRA,tipo_subcentro, NOMBRE_OBRA , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA" ;
     $sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
    case "capitulos":
     $sql="SELECT CAPITULO , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where   GROUP BY CAPITULO " ;
     $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
    break;
   case "udos":
     $sql="SELECT ID_OBRA,PRODUCCION,CAPITULO ,UDO,SUM(MEDICION) as medicion, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where   GROUP BY CAPITULO " ;
     $sql_T="SELECT '' as a12,'' as a31,'' as a14,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
   break;
   case "fechas":
    $sql="SELECT ID_CONCEPTO,ID_PROVEEDORES,PROVEEDOR ,CONCEPTO,SUM(CANTIDAD) AS CANTIDAD, COSTE, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_PROVEEDORES,ID_CONCEPTO  ORDER BY PROVEEDOR,CONCEPTO  " ;
    $sql_T="SELECT '' AS A,'' AS B,'' AS C,'' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "meses":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY MES  ORDER BY MES  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
    break;
   case "detalle":
   $sql="SELECT FECHA,CAPITULO,ID_UDO,UDO,MED_PROYECTO,MEDICION , PRECIO, IMPORTE  FROM ConsultaProd WHERE $where ORDER BY CAPITULO,ID_UDO " ;
     $sql_T="SELECT '' as a12,'' as a31,'' as a14,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
     break;
   case "obras":
   $sql="SELECT NOMBRE_OBRA,CAPITULO,ID_UDO,UDO,MED_PROYECTO, PRECIO  FROM ConsultaProd WHERE $where ORDER BY NOMBRE_OBRA " ;
     $sql_T="SELECT '' as a12,'' as a31,'' as a14,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
    break;
   case "producciones":
    $sql="SELECT  CUENTA,CUENTA_TEXTO,SUM(importe) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY CUENTA  ORDER BY CUENTA  " ;
    $sql_T="SELECT '' AS A,'' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   }

//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["importe"] = "moneda" ;
$formats["COSTE"] = "moneda" ;
$formats["ingreso_conc"] = "moneda" ;
$formats["ingreso"] = "moneda" ;
$formats["f_vto"] = "fecha" ;
$formats["conc"] = "boolean" ;
$formats["saldo"] = "moneda" ;
//$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
$tooltips["conc"] = "Indica si el pago está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


$titulo="PRODUCCION";
$msg_tabla_vacia="No hay.";

require("../include/tabla.php"); echo $TABLE ;
}

?>
</div>

<!--************ FIN  *************  -->
	
	

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

