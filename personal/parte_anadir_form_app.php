<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 
?>
<HTML>
<HEAD>
         <title>añadir parte</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
   <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
     
        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"> </script>-->
</HEAD>
<BODY>
<style>
 input,a { 
/*    border: 2px solid red;
    background-color: lightyellow;*/
    /*font-size:40px; width:400px; height:100px;*/
    font-size:40px; width:100%; height:150px;

}

@media only screen and (max-width:981px) {
 
input,button ,a, select, option
{
    font-size:40px; width:100%; height:150px;
}
/*input.input_mobile , a.input_mobile {       
     width: 100%;
     height: 15% ;
     font-size: 60px;
}*/
 

}
</style>

<?php 

require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
//require("../menu/topbar.php");


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
//function add_parte_obra_ajax() {
//    
//    //var valor0 = valor0_encode;
//    //var valor0 = JSON.parse(valor0_encode);
//   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
////    alert("el nuevo valor es: "+valor) ;
////   alert('debug') ;
////   var fecha=document.getElementById("fecha").value ;
////   var id_obra=document.getElementById("id_obra").value ;
////   var observaciones=document.getElementById("observaciones").value ;
////   
//   
////   var d= new Date() ;
////   var date_str=d.toISOString();
////   var sql="INSERT INTO PARTES (ID_OBRA,Fecha, Observaciones) VALUES ('"+id_obra+"','"+ date_str.substring(0, 10) +"')"    ;   
//   var sql="INSERT INTO PARTES (ID_OBRA,Fecha, Observaciones) VALUES ('"+id_obra+"','"+ fecha +"','"+ observaciones +')"    ;   
////   alert(sql) ;
//    var xhttp = new XMLHttpRequest();
//    xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
//        else
//        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
////            alert(this.responseText) ;   //debug
//              location.reload(true);  // refresco la pantalla tras edición
//        }
//      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
//      
//    }
//    }
//     xhttp.open("GET", "../include/insert_ajax.php?sql="+sql, true);
//     xhttp.send();   
//    
//    
//    return ;
// }
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
                
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

