<?php
require_once("../include/session.php");

$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<html>
<head>
<title>Buscar proveedor </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</head>

<body>

<?php 

require_once("../menu/topbar.php");
require_once("../menu/topbar.php");

?>

<?php   // determino las variables 'filtro' y 'limit' $_POST
      $muestroLRU=0 ;  //         para determinar si es la primera entrada y sugiero las LRU 
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
 

<div style="overflow:visible">	   
	
<div id="main" class="mainc"><h1>Buscar proveedor<br></h1>


<a class='btn btn-link btn-lg' href= '../proveedores/proveedores_anadir_form.php' ><i class='fas fa-plus-circle'></i> Añadir proveedor</a>
<BR><a class='btn btn-link btn-lg' href="../proveedores/proveedores_importar_XLS.php" ><span class="glyphicon glyphicon-open-file"></span> Importar proveedores de XLS</a>
<br><br>	
	<FORM action="../proveedores/proveedores_buscar.php" method="post" id="form1"  name="form1">
		<INPUT id="filtro" name="filtro" width="400" height="70" onkeyup="showHint(this.value)" placeholder="buscar..." value="<?php echo $filtro;?>">
		<INPUT type="submit" value="buscar" id="submit1" name="submit1">
		<div id="sugerir"></div>	
	</FORM>


<!-- EMPEZAMOS  EL AJAX    -->	

	<!-- STYLE DEL DESPLEGLABLE sugerir -->			
<style>
#sugerir ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 400px;
    background-color: #f1f1f1;
}

#sugerir li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
	text-align: left;
}

/* Change the link color on hover */
#sugerir li a:hover {
    background-color: #555;
    color: white;
}
</style>			
			
			
<script>
function showHint(str) {
  var xhttp;
  if (str.length == 0) { 
    document.getElementById("sugerir").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("sugerir").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "proveedores_ajax.php?filtro="+str, true);
  xhttp.send();   
}	
function onClickAjax_prov(val) {

window.location="proveedores_ficha.php?id_proveedor="+val;

}
</script>
	
<!-- FIN  EL AJAX    -->			
		

<?php require_once("../../conexion.php"); ?> 
<BR><B>proveedores</B><BR>

<?php 


if ($muestroLRU)      // pdte cambiar la primera sql por LRU Where id_c_coste and id_user, tipolru='obra'
  { $sql="Select ID_PROVEEDORES , PROVEEDOR FROM ProveedoresF WHERE filtro LIKE '%$filtro%' AND $where_c_coste ORDER BY PROVEEDOR $limit" ;}
 else
  { $sql="Select ID_PROVEEDORES , PROVEEDOR FROM ProveedoresF WHERE filtro LIKE '%$filtro%' AND $where_c_coste ORDER BY PROVEEDOR $limit" ;}
 
//echo $sql;
$result = $Conn->query($sql);
?>


<?php $cuenta=0;?>
<?php 
 if ($result->num_rows > 0) 
 {	 
  if ($result->num_rows==1 AND $filtro<>"" ) 
  { $rs = $result->fetch_array();
 ?>
 <script type="text/javascript">
	 window.location="proveedores_ficha.php?id_proveedor=<?php echo $rs['ID_PROVEEDORES'];?> ";
 </script>
 <?php
  }
   else
   { echo '<table>' ;
    while($rs = $result->fetch_array())
    {
	  $cuenta=$cuenta+1;
	  $proveedor=$rs["PROVEEDOR"];
	  $id_proveedor=$rs["ID_PROVEEDORES"]; 
	?>
	<tr><td><a class="enlace" href= "proveedores_ficha.php?_m=$_m&id_proveedor=<?php echo $rs['ID_PROVEEDORES'];?>&proveedor=<?php echo $rs["PROVEEDOR"];?>" ><?php echo $rs["PROVEEDOR"];?></a></td></tr>
	
<?php
	}
   echo '</table>' ;
   }
 }
  else
{ echo "No hay resultados." ;
}
	?>


</center>
<?php 
  if ($cuenta==20)
   { echo "<a class='enlace' href= '../proveedores/proveedores_buscar.php?filtro={$filtro}&limit=0' >Ver todos...</a>" ;
   }

    else
	{echo "$cuenta proveedores";
	}

$Conn->close();


?>

</div>
</div>

<?php require '../include/footer.php'; ?>
</BODY>
</html>
