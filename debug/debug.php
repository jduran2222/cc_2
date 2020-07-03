<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	
?>



<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<TITLE>Debug</TITLE>
	<link href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel=stylesheet type="text/css" hreflang="es">
	<!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>

<body>

<form action="debug.php" method="post" enctype="multipart/form-data" >
    Select image to upload:
    <!--<input type="file" style="width: 400px; height: 400px;" name="fileToUpload" id="fileToUpload">-->
    <input class="fileToUpload" type="file"  width="480" height="480" name="fileToUpload" id="fileToUpload"><br>
  
    <input type="submit" value="Upload Image" name="submit">
</form>    
    
<?php 



require_once("../../conexion.php");
require_once("../include/funciones.php");


 require_once("../menu/topbar.php");
 
// require_once("../menu/topbar.php");
// require_once("../obras/obras_menutop_r.php");
// require_once("../obras/obras_menutop_r.php");



//echo logs() ;

echo '<pre>';
print_r($_FILES);
echo '</pre>';
 
echo "<br><br><br><br><br><br><br><INPUT id='juan'  >hola</a>" ;
echo "<br><br><br><br><br><br><br><p id='div1'  >juan div</p>" ;
echo "<br><br><br><br><br><br><br><a onclick='alert(123);' style='cursor:pointer;' >alert</a>" ;
echo '<br><br><br><br><br><br><br><a onclick="dblclick_col(this, \'div1\');"  >dblclick java</a>' ;
echo '<br><br><br><br><br><br><br>' ;
 
?>

<div id="box" style="border: #000 1px solid;">
<h1>My Links</h1>
<p><a href="URL" title="Description">Text Description</a></p>
<p><a onclick='alert(123);' style='cursor:pointer;' href="URL" title="Description">Text Description2</a></p>
</div>

  <button onclick='alert($("#box").html());' style='cursor:pointer;'  >alert</button>  
    
<script type="text/javascript">
document.getElementById("box").contentEditable='true'; 
</script>    
    
<!--<a onclick="window.open('../debug/debug.php?url_raw=' + encodeURIComponent('tabla=`CONCEPTOS FINALES`&where=CONCEPTO=123&order_by=ID_OBRA'));" > BOTON </a>-->

 <?php

//parse_str( rawurldecode(  $_GET["url_raw"] ), $cc_GET) ;
//echo '<pre>';
//print_r($cc_GET);
//echo '</pre>';


?>
<script>
function dblclick_col(e,input_id) {
   var nuevo_valor=window.prompt("Nuevo valor numérico de" ,123456);
console.log(this.responseText);
   alert(nuevo_valor) ;
//  document.getElementById(input_id).value=$(e).text() ;
//  document.getElementById(input_id).value=$(e).text() ;
//  document.getElementById(input_id).innerHTML = this.responseText ;
//  document.getElementById(input_id).append('juan duran');
//  $get(input_id).append('<p>this test to add</p>');
//var newdiv = document.createElement("div");
//newdiv.innerHTML = 'juanillo duran';
//var container = document.getElementById(input_id);
//container.appendChild(newdiv);
$("#"+input_id).append("<b>Appended text2</b>");
}
</script>


    
    
    
</BODY>

</HTML>
