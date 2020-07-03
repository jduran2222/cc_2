<?php
require_once("../include/session.php");
?>
<html>
<head>
<title>ConstruCloud</title>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />

<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"> </script>-->
<!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</head>

<body>

<?php 
require_once("../menu/topbar.php");
?>

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

<?php require '../include/footer.php'; ?>
</BODY>
</html>
