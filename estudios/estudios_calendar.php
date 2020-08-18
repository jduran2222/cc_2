<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Calendario Licitaciones';

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

<P align=center style="font-size:60px;"><i class="far fa-calendar-alt"></i> Calendario Licitaciones</p>



<?php 

// CALCULO DE FECHAS LUNES ANTES DE INCICIO MES Y DOMINGO DESPUES DE FINAL DE MES

//echo $_GET["fecha"] ;
$fecha0=date_create_from_format("Y-m-d", $_GET["fecha"]);                //fecha pasada por referencia
$fecha=date_create(date_format($fecha0,"Y")."-".date_format($fecha0,"m")."-01");          //primero de mes de la fecha0

//echo var_dump($fecha0);
//echo "<br>" ;
//echo var_dump($fecha);
//echo "<br>************************<br>" ;
//echo date_format($fecha, "w");
	

$fecha1=clone $fecha;                                    //creo el objeto Datatime $fecha1 con el lunes antes del primero de mes
//$fecha1=$fecha;
$dia_semana=date_format($fecha1,"w")-1 ; 
if($dia_semana==-1){$dia_semana=6; };
date_sub($fecha1,date_interval_create_from_date_string( "$dia_semana day"));  //resto los dias para situarme en el lunes


$fecha2=clone $fecha;                                    //creo el objeto Datatime $fecha2 con la fecha de domingo despues de ultimo de mes
//$fecha1=$fecha;
date_add($fecha2,date_interval_create_from_date_string("1 month"));  //sumo un mes al primero de mes
date_sub($fecha2,date_interval_create_from_date_string("1 day"));    //resto un dia, ya estoy en último de mes
$dia_semana=date_format($fecha2,"w")-1 ; 
if($dia_semana==-1){$dia_semana=6; };
date_sub($fecha2,date_interval_create_from_date_string( ($dia_semana-6)." day"));  //resto los dias para situarme en el lunes

$fecha1_1=clone $fecha1 ;
$fecha1_1->sub( new DateInterval('P1D') ) ;
$fecha2_2=clone $fecha2 ;
$fecha2_2->add( new DateInterval('P1D') ) ;
			   

//echo var_dump($fecha0);echo "<br>" ;echo var_dump($fecha);echo "<br>" ;echo var_dump($fecha1);echo "<br>" ;echo var_dump($fecha2);echo "<br>" ;


//$fecha2=date_create("01-".strftime("%m",$fecha+31)."-".strftime("%Y",$fecha+31))-1;
//$fecha2=$fecha2+7-strftime("%w",$fecha2)+1;



$cFecha1=date_format($fecha1, "Y-m-d");
$cFecha2=date_format($fecha2, "Y-m-d");

$filtro=isset($_POST["filtro"])?$_POST["filtro"]: (isset($_GET["filtro"])?$_GET["filtro"]:'' );
$chkDescartados= isset($_POST["chkDescartados"])?$_POST["chkDescartados"]:'';
$no_vamos= ($chkDescartados=='checked') ? 1 : 0;
//$no_vamos=0;

?>
<a class="btn btn-link btn-lg noprint"  href="../estudios/estudios_nuevo.php" target='_blank'><i class="fas fa-plus-circle"></i> añadir Estudio</a>
<a class="btn btn-link btn-lg noprint" target='_blank' href="../documentos/doc_upload_multiple_form.php?tipo_entidad=estudios_XML" ><i class="fas fa-plus-circle"></i>  añadir Estudios con ficheros .XML</a>

<FORM action="estudios_calendar.php?fecha=<?php echo date_format($fecha0,"Y-m-d");?>" method="POST" id="form1" name="form1">
  filtrar<INPUT type="text" id="filtro" name="filtro" value=<?php echo $filtro;?> ><button type="button" onclick="document.getElementById('filtro').value='' ; ">*</button>
  Descartados   <input type="checkbox" name="chkDescartados" value="checked" <?php echo $chkDescartados;?> >
  <INPUT type="submit" class='btn btn-success btn-lg' value="actualizar" id="submit1" name="submit1"> 
</FORM>
  

<?php 

require_once("../../conexion.php");

$TITULO="Calendario de Estudios";
//$sql="SELECT * FROM `Estudios_de_Obra` WHERE `PLAZO ENTREGA`>='$cFecha1' AND `PLAZO ENTREGA` <='$cFecha2' AND NOMBRE like '%$filtro%' ".
//  " AND `NO VAMOS`=$no_vamos AND $where_c_coste ORDER BY `PLAZO ENTREGA`";

$sql="SELECT * FROM Estudios_listado WHERE `PLAZO ENTREGA`>='$cFecha1' AND `PLAZO ENTREGA` <='$cFecha2' AND filtro2 like '%$filtro%' ".
  " AND `NO VAMOS`=$no_vamos AND $where_c_coste ORDER BY `PLAZO ENTREGA`";

//echo  "DEBUG: $sql" ;
$result=$Conn->Query($sql);

echo "<br><p size=1> Hay {$result->num_rows} estudios</p>" ;

setlocale(LC_TIME, "es_ES");

$mes_txt=ucwords(utf8_encode(strftime( '%B-%Y' , $fecha->getTimestamp() ))) ;         //  $fecha->format('F-Y')


?>

<style>
  /*td.a { background-color:#ff0000; }*/
  td.a:hover { background-color:#f5f5f5; }
</style>


<TABLE  align=center width=95% style="border: 1px solid grey;">
   <TR>
     <TD><font size=5><A class='btn btn-primary' HREF="estudios_calendar.php?fecha=<?php echo $fecha1_1->format("Y-m-d");?>&filtro=<?php echo $filtro;?>"><<&nbsp;Anterior </A></font> </TD>
     <TD  bgcolor=Silver nowrap colspan=5 align=center><font size=7><?php echo $mes_txt ;?></font>&nbsp;</TD>
     <TD align=right><font size=5><A class='btn btn-primary' HREF="estudios_calendar.php?fecha=<?php echo $fecha2_2->format("Y-m-d");?>&filtro=<?php echo $filtro;?>">Siguiente>> </A></font> </TD>
   </TR>
</TABLE>
   <TABLE  align=center width=95% style="border: 1px solid grey;">
   <TR  height='50'> 
        <TD align=center width=15%><h2>L</h2></TD>
        <TD align=center width=15%><h2>M</h2></TD>
	<TD align=center width=15%><h2>X</h2></TD>
	<TD align=center width=15%><h2>J</h2></TD>
	<TD align=center width=15%><h2>V</h2></TD>
	<TD align=center  color='red' bgcolor=LightPink width=10%><h2>S</h2></TD>
	<TD align=center  color='red' bgcolor=LightPink width=10%><h2>D</h2></TD>
  </TR>

<TR height=80> 

<?php

$cont=0 ;
//$cont_hoy=($fecha1->diff(date_create())->days) +1 ;
$diff=date_diff($fecha1,date_create());                       // objeto datatime_interval
$cont_hoy=$diff->format("%R%a")+1 ;                          // cogemos la diferencia de días para pintar de amarillo el día de hoy. Objeto datatime
//echo "DIAS DE DIFERENCIA $cont_hoy  <BR>" ;                  // DEBUG

$mes=date_format($fecha,"m");

$intervalo=$fecha1->diff($fecha2)->days + 1;
$ff = clone $fecha1 ;
$rs = $result->fetch_array() ;
for ($c=1; $c<=$intervalo; $c++ )
{ 
     $cont=$cont+1;
     if ($c==$cont_hoy)
  {

    $color_fondo="yellow";
  }
    else
  if ($ff->format("m")!=$mes)
  {

    $color_fondo="Silver";
  }
    else
  {

    $color_fondo="white";
  } 

?>
<!--   <TD  class="a" valign="top" align="left"  nowrap bgcolor="<?php   echo $color_fondo;?>" style="border: 1px solid grey;"><font face=Arial size='2' ><strong>
           <a href="../include/tabla_general.php?tabla=`Estudios_view`&where=`PLAZO ENTREGA'='<?php   echo $ff->format("Y-m-d");?>' AND `NO VAMOS`=0"><?php   echo $ff->format("j");?></a></strong><br></font>-->
    <?php  
    
    $fecha_txt=$ff->format("Y-m-d") ;
    echo "<TD  class='a' valign='top' align='left'  nowrap bgcolor='$color_fondo' style='border: 1px solid grey;'><strong>"
            . " <a target='_blank' href=\"../include/tabla_general.php?url_enc="
            .encrypt2("link=../estudios/estudios_ficha.php?id_estudio=&campo=NOMBRE&campo_id=ID_ESTUDIO&select=ID_ESTUDIO,`PLAZO ENTREGA`,Estado,NUMERO,NOMBRE,`Presupuesto Tipo`&tabla=Estudios_listado&where=DATE_FORMAT(`PLAZO ENTREGA`,'%Y-%m-%d')='$fecha_txt' AND `NO VAMOS`=0")."\" >"
            . " {$ff->format("j")}</a></strong><br>" ;
     // anulamos el link para evitar error
//    echo "<TD  class='a' valign='top' align='left'  nowrap bgcolor='$color_fondo' style='border: 1px solid grey;'><p>"
//            . "  {$ff->format("j")}</p>" ;

    
     //echo "DEBUG: empezamos el dia: ".date("Y-m-d",strtotime($rs["PLAZO ENTREGA"]))."     -      {$ff->format("Y-m-d")}";
		while(date("Y-m-d",strtotime($rs["PLAZO ENTREGA"]))==($ff->format("Y-m-d")) )
       {        
		  //echo "DEBUG: entramos en el while";
			//echo var_dump($rs) ;

           $title=number_format($rs["Presupuesto Tipo"],2).$rs["Clasificacion"]." € \n".$rs["Nombre Completo"]." (Exp: ".$rs["EXPEDIENTE"].")\n".$rs["Organismo"]."\n".$rs["Requisitos"]."\n".$rs["Observaciones"];
		   ?>
           <?php $color=str2color($rs["Estado"]) ;  echo "<span class='c_text' style='color:$color;' > ({$rs["Estado"]})</span>" ;?> 
               <A  class="btn btn-xs cc_calendar" target="_blank" href="../estudios/estudios_ficha.php?id_estudio=<?php  echo $rs["ID_ESTUDIO"];?>" 
               title="<?php echo $title;?>" > <?php echo "{$rs["NUMERO"]}-".substr($rs["NOMBRE"],0,10)."<span class='c_text'>".substr($rs["NOMBRE"],10,100)."</span>";?> </A><br>
           <?php  if (!($rs = $result->fetch_array()))
                    {
                      break;
                     }
        }
        
		?>
   </TD>
   <?php 
  if ($cont==7 && $c!=$intervalo)
  {

    $cont=0;
    echo "</TR><TR height=80>";
  } 
 
  $ff->add(new DateInterval("P1D")) ; 
   
 }
?> 
  
</TABLE>


                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');


