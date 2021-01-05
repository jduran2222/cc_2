<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Añadir nuevo parte';

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

  ?>

<div style="overflow:visible">	   
 
<div id="main" class="mainc_100" style="background-color:#fff">

<?php 
    echo "<h1>PARTE DIARIO DE OBRA NUEVO<br></h1>"  ;
       

$fecha_hoy=date('Y-m-d');


//     echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
 
//  echo " <div class='container'>" ;
//  echo "  <div class='form-group' >" ;
  echo " <label for='fecha'><h1>FECHA:</h1></label>" ;
  echo "<INPUT type='date' id='fecha'     name='fecha'    value='$fecha_hoy'>" ;
  echo " <label for='id_obra'><h1>OBRA:</h1></label> " ;
  echo " <select class='form-control' id='id_obra' style='font-size:40px; width: 100%;height:150px;'>  " ;
  echo DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE $where_c_coste AND (tipo_subcentro='O' OR tipo_subcentro='G') AND activa ORDER BY activa DESC,NOMBRE_OBRA ") ;
  echo "    </select>"  ;
  echo "<label for='observaciones'><h1>OBSERVACIONES:</h1></label> " ;
  echo "<br><textarea id='observaciones' rows='10' cols='80'></textarea>"  ;
//  echo "    <br>"  ;
  echo "  <a  style='font-size: 60px;' class='btn btn-primary' href='#'  onclick='add_parte_obra_href();'>Crear Parte</a>" ;
//  echo "  </div>" ;
//  echo "</div>"  ;

 

$Conn->close();

?>
	 

</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
	
	
	</div>
 <script>       

 function add_parte_obra_href() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_obra=document.getElementById("id_obra").value ;
   var fecha=document.getElementById("fecha").value ;
   var id_obra=document.getElementById("id_obra").value ;
   var observaciones=document.getElementById("observaciones").value ;
    
//   var d= new Date() ;
//   var date_str=d.toISOString();
   
   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra+'&fecha='+fecha+'&observaciones='+observaciones);
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }
</script>
                
	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

