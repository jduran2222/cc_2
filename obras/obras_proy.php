<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="Py " . Dfirst("NOMBRE_OBRA","OBRAS", "ID_OBRA={$_GET["id_obra"]} AND $where_c_coste"  ) ;
$titulo = $titulo_pagina;

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

$id_obra=$_GET["id_obra"];

 require_once("../obras/obras_menutop_r.php");
//require_once("../menu/menu_migas.php");


 require_once("../include/funciones_js.php");

  ?>	
	   	 
	   
<div id="main" class="mainc_100">
 
	
<h1>PROYECTO</h1>
<br><br>


<?php 


$result=$Conn->query($sql="SELECT * from Proyecto_View WHERE ID_OBRA=".$id_obra);

$sql_update_precio = encrypt2("UPDATE Udos  SET  PRECIO=ROUND(PRECIO*_VARIABLE1_ , 2)  WHERE  ID_OBRA=".$id_obra ) ;

?>


<a class="btn btn-primary" title="añadir Capitulo al proyecto" href=# <?php echo "onclick=\"add_capitulo($id_obra)\" " ;?> ><i class="fas fa-plus-circle"></i> añadir capítulo</a>
<a class="btn btn-primary" title="Importar fichero formato BC3"  href="obras_importar_BC3.php?_m=<?php echo $_m;?>&id_obra=<?php echo $id_obra;?>" >importar .BC3</a>
<a class="btn btn-primary" title="Importar fichero formato XLS"  href="obras_importar_XLS.php?_m=<?php echo $_m;?>&id_obra=<?php echo $id_obra;?>" >importar .XLS</a>
<a class="btn btn-primary" title="Crear capítulo de COSTES INDIRECTOS" target="_blank"
          href=# onclick='js_href("../obras/obras_proy_add_CI.php?id_obra=<?php echo $id_obra;?>" )'><i class="fas fa-plus-circle"></i> Cap. Costes Indirectos</a>
<a class="btn btn-primary" title="Corregir precios con factor multiplicador. se redondearán a 2 decimales" target="_blank"
          href=# onclick='corregir_precios_proyecto("<?php echo $sql_update_precio;?>" )'>Corregir precios con factor</a>
<a class="btn btn-primary" title="imprimir proyecto" href="obras_proy_PDF.php?id_obra=<?php echo $id_obra;?>&ext=" target="_blank">imprimir</a>
<a class="btn btn-primary" title="exportar proyecto a PDF" href="obras_proy_PDF.php?id_obra=<?php echo $id_obra;?>&ext=pdf">pdf</a>
<a class="btn btn-primary" title="exportar proyecto a XLS" href="obras_proy_PDF.php?id_obra=<?php echo $id_obra;?>&ext=xls">xls</a>
<a class="btn btn-primary" title="exportar proyecto a DOC" href="obras_proy_PDF.php?id_obra=<?php echo $id_obra;?>&ext=doc">doc</a>
<a class="btn btn-danger" title="Borrar proyecto completo" href=# <?php echo "onclick=\"delete_proyecto($id_obra)\" " ;?> >Borrar proyecto</a><br>
<br><br>

  
 <script>
function corregir_precios_proyecto(sql)
 { 

    var variable1=window.prompt("¿Factor a multiplicar a cada PRECIO? \n ¡¡ATENCIÓN!! Esta operación modificará todos los precios del proyecto \n y todas las Relaciones Valoradas que existan ",1);
//    alert(sql) ;
   if (!(variable1 === null) && variable1)
   { 
//         alert(dbNumero(variable1)) ;
  
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert("ERROR: " +this.responseText) ;}                   // mostramos el ERROR
        else
        { 
//           alert(this.responseText) ;     //debug      
           location.reload(true); }  // refresco la pantalla tras edición
        }
     };  // fin de la función
  
  xhttp.open("GET", "../include/sql.php?code=1&sql=" + sql+"&variable1="+dbNumero(variable1) , true);
  xhttp.send(); 
//  alert("../include/sql.php?code=1&sql=" + sql+"&variable1="+dbNumero(variable1));
//  window.open("../include/sql.php?code=1&sql=" + sql+"&variable1="+dbNumero(variable1), '_blank');
//   location.reload();
   }
   else
   {return;}
 
}
function delete_proyecto(id_obra)
 { 

    var nuevo_valor=window.confirm("¿Borrar el proyecto completo? \n Recuerde borrar previamente todas las Relaciones Valoradas del proyecto ");
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
//       window.open("../obras/obras_proy_delete.php?id_obra="+id_obra , '_blank') ;
       var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200)
//    {              
//           delete_capitulos(id_obra) ; 
//      }
//  };
  
////  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
//
  xhttp.open("GET", "../obras/obras_proy_delete.php?id_obra=" + id_obra , true);
  xhttp.send();   
   location.reload();
   }
   else
   {return;}
 
}
function delete_capitulos(id_obra)
 { 

//    var nuevo_valor=window.confirm("¿Borrar capitulos? ");
    var nuevo_valor=1;
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert("Error: Debe de borrar las Producciones previamente \n " +this.responseText) ;}                   // mostramos el ERROR
        else
        {  //alert(this.responseText) ;     //debug      
           location.reload(true); }  // refresco la pantalla tras edición
      }
  };
  
//  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 

  xhttp.open("GET", "../include/tabla_delete_row_ajax.php?tabla=Capitulos&wherecond=ID_OBRA=" + id_obra , true);
  xhttp.send();   
   }
   else
   {return;}
 
}
     
function add_capitulo(id_obra) {
    var nuevo_valor=window.prompt("Capítulo nuevo " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        { // alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla con el n uevo caoítulo creado
      }
  };
  xhttp.open("GET", "../obras/add_capitulo_ajax.php?id_obra="+id_obra+"&capitulo="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
function add_udo(id_capitulo,id_obra) {
    var nuevo_valor=window.prompt("Unidad de obra: " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        { //alert(this.responseText) ;     //debug
          location.reload(true); }  // refresco la pantalla con el n uevo capítulo creado
      }
  };
  xhttp.open("GET", "../obras/add_udo_ajax.php?id_obra="+id_obra+"&id_capitulo="+id_capitulo+"&udo="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

</script>

 <TABLE class='table table-bordered table-hover' >
   
    
    
<?php 


$sumaCap=0;
$PEM=0;
$firstIdCapitulo=0;

if ($result->num_rows > 0)
  {while($rs = $result->fetch_array())
   {
      if ($firstIdCapitulo!=$rs["ID_CAPITULO"])   // cambiamos de Capitulo . encabezado y suma de capitulo.
         {
          if ($firstIdCapitulo)     // Si no es primer capitulo sumamos totales
		  {
  ?>
	<TR >
	    <TD align=right>SUMA DE CAPITULO</TD>
		<TD></TD>
		<TD></TD>
		<TD></TD>
		<!--<TD></TD>-->
		<TD align=right><b><?php  echo number_format($sumaCap,2,".",",");?></b></TD>
		<TD></TD>
	</TR>
	<?php    
           	$PEM=$PEM+$sumaCap;
            $sumaCap=0;
		  }
	        $firstIdCapitulo=$rs["ID_CAPITULO"];
			  
			  ?>	
	
    <TR> 
	<TR>
	   <TD style="background-color:lightgreen;color:grey;font-size:14px;" > Unidad de Obra </TD>
	   <TD style="background-color:lightgreen;color:grey;font-size:14px;" > Med_proy </TD>
	   <TD style="background-color:lightgreen;color:grey;font-size:14px;" > Precio </TD>
	   <TD style="background-color:lightgreen;color:grey;font-size:14px;" > Coste_Est </TD>
	   <!--<TD style="background-color:lightgreen;color:grey;font-size:14px;" > Estudio coste </TD>-->
	   <TD style="background-color:lightgreen;color:grey;font-size:14px;" > Importe </TD>
	   <TD style="background-color:lightgreen;color:grey;font-size:14px;" > SubObra </TD>
	</TR>
	<TR >
          <TD colspan="7">CAPITULO<b> <?php echo "<a target='_blank'  href='../include/ficha_general.php?url_enc=".encrypt2("tabla=Capitulos&id_update=ID_CAPITULO")."&id_valor=$firstIdCapitulo'  >{$rs["CAPITULO"]}</a>";?></b>
              <a class="btn btn-link btn-xs" title="añadir unidad de obra al Capitulo" href=# <?php echo "onclick=\"add_udo({$rs["ID_CAPITULO"]},$id_obra)\" " ;?>  >  añadir udo</a></TD>
	</TR>
	
  <?php   } ?>
 
 <TR>  
  <TD ><a class="enlaceTabla" target='_blank' href="udo_prod.php?_m=<?php echo $_m ;?>&id_udo=<?php   echo $rs["ID_UDO"];?>"  title="<?php   echo $rs["TEXTO_UDO"];?>"> <?php   echo $rs["ud"]." ".$rs["UDO"];?>  </a> </TD>
  <TD align=right> <?php   echo $rs["MED_PROYECTO"];?> </TD>
  <TD align=right> <?php   echo cc_format($rs["PRECIO"],'moneda');?> </TD>
  <TD align=right> <?php   echo cc_format($rs["COSTE_EST"],'fijo');?>  </TD>
  <!--<TD > <?php //   echo cc_format($rs["Estudio_coste"],'textarealert');?> </TD>-->
       <?php   $importe=$rs["MED_PROYECTO"]*$rs["PRECIO"];?> 
       <?php   $sumaCap=$sumaCap+$importe;?>
  <TD align=right> <?php   echo cc_format($importe,'moneda');?> </TD>
  <TD style="color:grey;font-size:12px;"> <?php   echo $rs["SUBOBRA"];?> </TD>
 </TR>
  
  <?php   //$rs->movenext;  ?>
<?php } 
  }
 else { echo  "Proyecto vacío" ;}
	?>

<TR >
	    <TD></TD>
		<TD></TD>
	    <TD></TD>
		<TD></TD>
		<!--<TD></TD>-->
		<TD align=right><b><?php echo number_format($sumaCap,2,".",",");?></b></TD>
        <TD></TD>
	</TR>

<?php $PEM=$PEM+$sumaCap;?>
<TR >
	    <TD>TOTAL EJECUCION MATERIAL DEL PROYECTO</TD>
		<TD></TD>
		<TD></TD>
		<TD></TD>
		<!--<TD></TD>-->
		<TD align=right><b><?php echo number_format($PEM,2,".",",");?></b></TD>
		<TD></TD>
	</TR>

</TABLE>

<?php
           $gg_bi=Dfirst('GG_BI','OBRAS','ID_OBRA='.$id_obra);
           $iva_obra=Dfirst('iva_obra','OBRAS','ID_OBRA='.$id_obra);
           $coef_baja=Dfirst('COEF_BAJA','OBRAS','ID_OBRA='.$id_obra);
           $importe=Dfirst('IMPORTE','OBRAS','ID_OBRA='.$id_obra);
           
           $pem_proyecto=Dfirst('SUM(PRECIO*MED_PROYECTO)','Proyecto_View','ID_OBRA='.$id_obra) ;
           
           
           echo "<br><br><table class='table table-bordered'><tr><th>RESUMEN</th><th>IMPORTES</th></tr>" ;
           echo "<tr><td>PRESUP. EJEC. MATERIAL (PEM de Proyecto): </td><td>". cc_format($pem_proyecto, 'moneda')."</td></tr>" ;
           echo "<tr><td>PRESUP. EJEC. CONTRATA (PEC) (GG+BI - BAJA): </td><td>". cc_format($pem_proyecto*(1+$gg_bi)*$coef_baja, 'moneda')."</td></tr>"  ;
           echo "<tr><td>PRESUP. EJEC. CONTRATA iva inc. (del Proyecto): ".cc_format($iva_obra,'porcentaje0')."</td><td>". cc_format($pem_proyecto*$coef_baja*(1+$gg_bi)*(1+$iva_obra), 'moneda')."</td></tr>"  ;           
           echo "<tr><td></td><td></td></tr>" ;
           echo "<tr><td>PRESUPUESTO DE LA OBRA IVA INC. </td><td>". cc_format($importe, 'moneda')."</td></tr>"  ;   
           $pec_proyecto_iva=$pem_proyecto*$coef_baja*(1+$gg_bi)*(1+$iva_obra) ;
           
           if ($pec_proyecto_iva==$importe)
           {
              echo "<tr><td>PROYECTO CORRECTO</td></tr>" ;                  
           }
           else
           {
              echo "<tr><td>ERROR EN PROYECTO </td><td style='color:red;font-weight: bold;' title='Diferencia entre el Presupuesto del proyecto y en del Contrato'>".cc_format($importe-$pec_proyecto_iva, 'moneda'). "</td></tr>" ;                  
              echo "<tr><td>RATIO EN PROYECTO </td><td>".cc_format( $pec_proyecto_iva? ($importe/$pec_proyecto_iva) : 0, 'porcentaje'). "</td></tr>" ;                  
           }
               
              echo "</table>" ;                  

$Conn->close();

?>
<!--</div>-->
                <!--</div>-->
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
