


<?php 

// CALCULO DE FECHAS LUNES ANTES DE INCICIO MES Y DOMINGO DESPUES DE FINAL DE MES

//echo $_GET["fecha"] ;

//$fecha0=date_create_from_format("Y-m-d", $_GET["fecha"]);                //fecha pasada por referencia
$fecha0=date_create_from_format("Y-m-d", $fecha_cal);                //fecha pasada por referencia
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

//$filtro=isset($_POST["filtro"])?$_POST["filtro"]:'';
//$chkDescartados= isset($_POST["chkDescartados"])?$_POST["chkDescartados"]:'';
//$no_vamos=$chkDescartados;
//$no_vamos=0;

?>
<!--
<FORM action="estudios_calendar.php?fecha=<?php // echo date_format($fecha0,"Y-m-d");?>" method="POST" id="form1" name="form1">
  filtrar<INPUT type="text" id=text1 name="filtro" value=<?php // echo $filtro;?>>
  Descartados<input type="checkbox" name="chkDescartados" value="checked" <?php // echo $chkDescartados;?> >
  <INPUT type="submit" value="actualizar" id="submit1" name="submit1"> 
</FORM>
  
<a class="boton" href="estudios_nuevo.php" >AÑADIR ESTUDIO</a>-->

<?php 

//require_once("../../conexion.php");

//$TITULO="Calendario de Estudios";
//$sql="SELECT * FROM `Estudios_de_Obra` WHERE `PLAZO ENTREGA`>='$cFecha1' AND `PLAZO ENTREGA` <='$cFecha2' AND NOMBRE like '%$filtro%' ".
//  " AND `NO VAMOS`=$no_vamos AND $where_c_coste ORDER BY `PLAZO ENTREGA`";

//echo  "DEBUG: $sql" ;
//$result=$Conn->Query($sql);

echo "<br><p size=1> Hay {$result->num_rows} filas</p>" ;
?>

<style>
  /*td.a { background-color:#ff0000; }*/
  td.a:hover { background-color:#f5f5f5; }
</style>

<?php
setlocale(LC_TIME, "es_ES");
$mes_txt=ucwords(utf8_encode(strftime( '%B-%Y' , $fecha->getTimestamp() ))) ;         //  $fecha->format('F-Y')
?>

<TABLE  align=center width=95% style="border: 1px solid grey;">
   <TR>
     <TD><button class='btn btn-primary btn-xl' onclick="getElementById('fecha_cal').value = '<?php echo $fecha1_1->format("Y-m-d");?>' ; "  type="submit" form="form1"><< ANTERIOR</button> </TD> 
       
     <TD  bgcolor=Silver nowrap colspan="5" align=center><font size=7><?php echo $mes_txt ;?></font>&nbsp;</TD>
     <TD align=right><button class='btn btn-primary btn-xl' onclick="getElementById('fecha_cal').value = '<?php echo $fecha2_2->format("Y-m-d");?>' ; "  type="submit" form="form1">SIGUIENTE >></button></TD>  

   </TR>
</TABLE>
   <TABLE  align=center width=95% style="border: 1px solid grey;">
   <TR  height='50'> 
        <TD align=center width=15%><h2>L2</h2></TD>
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

$fecha_db_cal= isset($fecha_db_cal) ? $fecha_db_cal : "fecha" ;

// avanzamos el $rs hasta que llegamos al primer Lunes del calendario

while($rs = $result->fetch_array(MYSQLI_ASSOC))
{   if (substr($rs[ $fecha_db_cal ],0,10)>=$ff->format("Y-m-d")) break ; }     
      
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

$fecha_txt=ucwords(utf8_encode(strftime( '%a, %e %b' , $ff->getTimestamp() ))) ;         //  $fecha->format('F-Y')

//DIBUJO CADA CASILLA DE UN DÍA con su color correspondiente. El numero de dia hace link a lo que queramos si  $link_calendar_dia está definido-->
if(isset($link_calendar_dia))
{ echo "<TD   valign='top' align='left'  nowrap bgcolor='$color_fondo' style='border: 3px solid black;'>"
          . "<a  href='{$link_calendar_dia}{$ff->format("Y-m-d")}' target='_blank' >$fecha_txt</a>" ;
}else
{
    echo "<TD   valign='top' align='left'  nowrap bgcolor='$color_fondo' style='border: 3px solid black;'>"
          . "$fecha_txt" ;
    
}    
  
     //echo "DEBUG: empezamos el dia: ".date("Y-m-d",strtotime($rs["PLAZO ENTREGA"]))."     -      {$ff->format("Y-m-d")}";
        echo "<table>";
//          echo "<br><br>valor 1:" . substr($rs[ "Fecha" ],0,10);
//          echo "<br>valor 2:" . $ff->format("Y-m-d");
          
//	while(date("Y-m-d",strtotime($rs[ "Fecha" ]))==($ff->format("Y-m-d")) )   // recorro todos los registros de esa fecha
	while(substr($rs[ $fecha_db_cal],0,10)==$ff->format("Y-m-d"))   // recorro todos los registros de esa fecha
       {        
		  //echo "DEBUG: entramos en el while";
			//echo var_dump($rs) ;

//           $title=number_format($rs["Presupuesto Tipo"],2).$rs["Clasificacion"]." € \n".$rs["Nombre Completo"]."\n".$rs["Observaciones"];
	
//           <font face=Arial size='1'><A  class="btn btn-link btn-xs_menu" HREF="estudios_ficha.php?id_estudio=<?php  echo $rs["ID_ESTUDIO"];" title="<?php       echo $title;>" target="_blank"> <?php       echo $rs["NUMERO"]."-".$rs["NOMBRE"];> </A><br></font> 
          
           echo "<tr><td >"; 
           foreach ($rs as $clave => $valor) //  encabezados
           {
	       $not_id_var= (strtoupper(substr($clave,0,2))<>"ID") ;
	       if ($not_id_var && !($clave==$fecha_db_cal) )                                     // descartamos los encabezados de campos ID y el campo &fecha_db
	        { 
                  if (isset($links[$clave]))                                 
                  { // hay link 
                       // title del link  por defecto 'ver ficha'  TOOLTIP
                     $title=(isset($links[$clave][2]))?   (isset($rs[$links[$clave][2]]) ? $rs[$links[$clave][2]]   :  "{$links[$clave][2]}" ) : "" ;
                     
//                     $tooltip_txt = $title ;       
//                     $tooltip_txt_alert= str_replace("\n","\\n", $title) ;
//                     $div_tooltip_html = ($tooltip_txt) ? "<div style='float:right;border:none;margin:5px 5px;' onclick=\"alert('$tooltip_txt_alert')\" >"
//                                        . "<i class='fas fa-info btn-link' style='opacity:0.3' title='$tooltip_txt'></i></div>"  : "" ; 
                     
                     $title=  str_replace(["<br>","<br/>"], "\n", $title)  ;
                     $title=  strip_tags($title); // quitamos las etiquetas html de las observaciones html
                     $div_tooltip_html="<div class='btn-link btn-xs' >".cc_format($title,'textarealert_200')."</div>"  ;
                     
                     echo "<a class='btn btn-default btn-xs' href= {$links[$clave][0]}{$rs[$links[$clave][1]]} title='$title' target='_blank'>$valor</a>"; 
                     echo '<br>'.$div_tooltip_html ;
                  }elseif (isset($formats[$clave]))
                  {
                      echo "".cc_format( $valor, $formats[$clave]).""; 
                  }else 
                  {
                     $valor=cc_format( $valor, 'auto', $format_style,$clave ) ;
                      echo "$valor"; 
                  }
                      
		}
		   
           }
            echo "</td></tr>";         
                    
             if (!($rs = $result->fetch_array(MYSQLI_ASSOC)))  {  break; }  // salimos del BUCLE
        }
          echo "</table>";
		
   echo "</TD>" ;
   
  if ($cont==7 && $c!=$intervalo)
  {

    $cont=0;
    echo "</TR><TR height=80>";
  } 
 
  $ff->add(new DateInterval("P1D")) ; 
   
 }
?> 
  
</TABLE>
<TABLE  align=center width=95% style="border: 1px solid grey;">
   <TR>
     <TD><button class='btn btn-primary btn-xl' onclick="getElementById('fecha_cal').value = '<?php echo $fecha1_1->format("Y-m-d");?>' ; "  type="submit" form="form1"><< ANTERIOR</button> </TD> 
       
     <TD  bgcolor=Silver nowrap colspan="5" align=center><font size=7><?php echo $mes_txt ;?></font>&nbsp;</TD>
     <TD align=right><button class='btn btn-primary btn-xl' onclick="getElementById('fecha_cal').value = '<?php echo $fecha2_2->format("Y-m-d");?>' ; "  type="submit" form="form1">SIGUIENTE >></button></TD>  

   </TR>
</TABLE>


<?php 
 
//$Conn->close;

?>

<?php // require '../include/footer.php'; ?>
</BODY>
</HTML>
