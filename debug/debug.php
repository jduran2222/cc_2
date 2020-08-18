<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Debug';

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

<form action="debug.php" method="post" enctype="multipart/form-data" >
    Select image to upload:
    <!--<input type="file" style="width: 400px; height: 400px;" name="fileToUpload" id="fileToUpload">-->
    <input class="fileToUpload" type="file"  width="480" height="480" name="fileToUpload" id="fileToUpload"><br>
  
    <input type="submit" value="Upload Image" name="submit">
</form>    
    
<?php 

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


                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');