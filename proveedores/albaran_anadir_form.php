<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Albarán Añadir';

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

<?php                                       // determino las variables 'filtro' y 'limit' $_POST
      $muestroLRU=0 ;                      //         para determinar si es la primera entrada y sugiero las LRU 
      if (isset($_POST["filtro"])) 
	   { $filtro=$_POST["filtro"] ; 	     
	   }
        else
		{ if (isset($_GET["filtro"])) 
		    { $filtro=$_GET["filtro"] ;  } 
		 else
		    { $filtro='' ;
			  $muestroLRU=1 ;} 
		 }   ;
      if (isset($_GET["limit"])) { $limit='' ; } else  { $limit=' LIMIT 20' ; }
 ?>
 

	
    <div id="main" class="mainc"><br><h1>Vale nuevo</h1><h4><br>(albaran proveedor)</h4><br>
<?php //require("menu.inc"); 
	?> 

	<!-- INCLUIR AQUI CODIGO PARA LRU ENCIMA DEL FORM    -->	
	<!-- FIN CODIGO PARA LRU ENCIMA DEL FORM    -->
	
	<!-- FORM   CON   AJAX -->

	
	<FORM action="albaran_anadir.php" method="post" id="form1"  name="form1">
            
                <div >FECHA:</div><br>            
		<INPUT class="input_mobile"  id="fecha" name="fecha" required  value="<?php echo date("Y-m-d");?>"><br>
		
                <div id="nombre_obra">OBRA:</div><br>
                <INPUT class="input_mobile" id="filtro" name="filtro" required onkeyup="showHint(this.value)" onfocusout="cierra_div('sugerir_obra')" placeholder="Obra..." >
		<div class="sugerir" id="sugerir_obra"></div>
                
                <div  id="proveedor">PROVEEDOR:</div><br>
		<INPUT class="input_mobile" id="filtro_prov" name="filtro_prov" required width="400" height="70" onkeyup="showHint_prov(this.value)" onfocusout="cierra_div('sugerir_prov')" placeholder="Proveedor..." >
		<div class="sugerir" id="sugerir_prov"></div>
		
                <INPUT class="input_mobile" id="ref" name="ref" width="400" height="70"  placeholder="Referencia..." ><br>	
		<a class="boton input_mobile" href="#" onclick="document.form1.submit();return false">ACEPTAR</a>
                
		<!--<INPUT type="submit" value="Aceptar" id="submit1" name="submit1">-->
		
	</FORM>

<script>
function cierra_div(div) {                 // cerramos los div sugerir al salir del input
   //document.getElementById("sugerir_obra").innerHTML = "";
   //document.getElementById(div).innerHTML = "";
}
</script>
			
			
			
			
<script>
function showHint(str) {
  var xhttp;
  if (str.length == 0) { 
    //alert('vacio por cero')  ;
    document.getElementById("sugerir_obra").innerHTML = "";
    return;
  }
  //alert('hemos pulsado obra');
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // alert(this.responseText) ;
      document.getElementById("sugerir_obra").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../obras/obras_ajax.php?filtro="+str, true);
  xhttp.send();   
}	
	
function showHint_prov(str) {
  var xhttp;
  if (str.length == 0) { 
    document.getElementById("sugerir_prov").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       
      document.getElementById("sugerir_prov").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../proveedores/proveedores_ajax.php?filtro="+str, true);
  xhttp.send();   
}	
function onClickAjax(id_obra, nombre_obra) {
//alert(val);
document.getElementById("filtro").value = id_obra;
document.getElementById("nombre_obra").innerHTML = nombre_obra;
document.getElementById("sugerir_obra").innerHTML = "";
//window.location="obras_ficha.php?id_obra="+val;

//$("#txtHint").hide();
}
function onClickAjax_prov(id_proveedor, proveedor) {
//alert(val);
document.getElementById("filtro_prov").value = id_proveedor;
document.getElementById("proveedor").innerHTML = proveedor;
document.getElementById("sugerir_prov").innerHTML = "";
//window.location="obras_ficha.php?id_obra="+val;

//$("#txtHint").hide();
}
</script>
	
<!-- FIN  EL AJAX    -->			
		
			
			
			

</div>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');