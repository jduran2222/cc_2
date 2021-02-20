<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Estudio nuevo';

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



<h1 >CREAR LICITACION</h1>

<center>
    <BR>
<TABLE class="table-bordered table-hover" style="font-size: 20px">
<FORM action="../estudios/estudios_ficha_nueva.php?update=N" method=POST id=form1 name=form1 enctype="multipart/form-data">

    <TR><TD colspan="2" style="background: beige " ><h3><input type="radio" id="huey" name="drone"  >
                REGISTRO MANUAL <?php echo span_wiki("A%C3%B1adir_Estudio_o_Licitaci%C3%B3n"); ?></h3>  </TD></TR>    
<TR><TD >*NOMBRE   </TD><TD><INPUT type="text" name="NOMBRE"></TD></TR>
<TR><TD title='Fecha límite de entrega'>*PLAZO ENTREGA </TD><TD><INPUT type="date" name="F_Presentacion"></TD></TR>
<TR><TD title='Presupuesto tipo de licitación sin iva'>PRESUPUESTO TIPO  </TD><TD><INPUT type="text" name="PRESUPUESTO" ></TD></TR>
<TR><TD>Nombre completo   </TD><TD><INPUT type="text" name="nombre_completo"   ></TD></TR>
<TR><TD>Plazo de Obra   </TD><TD><INPUT type="text" name="plazo"   ></TD></TR>
<TR><TD>Observaciones  </TD><TD><INPUT type="text" name="Observaciones"  ></TD></TR>
</table>
<br><br>
<!--      // AULADO LA SUBIDA DE FICHEROS .XLM . CON EL URL ES SUFICIENTE
    <TABLE class="table-bordered table-hover" style="font-size: 30px"> 
    <TR><TD style="background: beige " ><h3 >REGISTRO FICHEROS ANUNCIO en .XLM </h3> <h5 align='center'>descargar desde plataforma <a target="_blank" href="https://contrataciondelestado.es">https://contrataciondelestado.es </a><small>(solo España)</small></h5>  </TD></TR>    

<TR><TD style="height: 80px">Datos en fichero XML <input type="file" name="xml_file"   /></TD></TR>
<TR><TD>Datos en texto XML </TD><TD><input type="text" name="target_text"  width="400" height="400"  /></TD></TR>
</table>
<br><br>-->


<HR>


<TABLE class="table-bordered table-hover" style="font-size: 30px"> 
    <TR><TD  style="background: beige " ><h3><input type="radio" id="huey" name="drone"
         checked>REGISTRO URL de ANUNCIO <?php echo span_wiki("A%C3%B1adir_Estudio_o_Licitaci%C3%B3n"); ?></h3> <h5 align='center'>copiar url de plataforma 
                <a target="_blank" href="https://contrataciondelestado.es">https://contrataciondelestado.es </a><small>(solo España)</small></h5>  </TD></TR>    

<TR><TD >pegar la url del Anuncio visto en formato xml <input type="text" name="xml_url_file" /></TD></TR>


</TABLE>
<BR><BR>
<INPUT type="submit" style="font-size: 80px;" class="btn btn-info btn-lg" value="CREAR ESTUDIO" id=submit1 name=submit1>
</FORM>

    </center>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');