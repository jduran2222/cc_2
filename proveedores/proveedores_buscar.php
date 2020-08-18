<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Proveedor Buscar';

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

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');