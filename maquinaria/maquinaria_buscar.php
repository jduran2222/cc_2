<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Buscar maquinaria';

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


$tipo_subcentro=$_GET["tipo_subcentro"] ;
//require_once("obras_menutop_r.php");


$subcentro=Dfirst("subcentro","tipos_subcentro", "tipo_subcentro='$tipo_subcentro'" ) . "S" ;


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
		 }   
      if (isset($_GET["limit"])) { $limit='' ; } else  { $limit=' LIMIT 100' ; }
 ?>
 
                                    <!--align-content: center; align-items: center     class="mainc"-->
<center>	
<div id="main"  style="margin-top: 60px; "><h1><?php echo $subcentro ; ?><br></h1> 


    <a class="boton" href= '../obras/obras_anadir.php?&nombre_obra=maquinaria_nueva&tipo_subcentro=M' target='_blank' >Añadir <?php echo strtolower($subcentro) ; ?></a><br><br><br>
    
	<FORM action="maquinaria_buscar.php?tipo_subcentro=<?php echo $tipo_subcentro ; ?>" method="post" id="form1"  name="form1">
            <table>
            <tr><td><INPUT class="form-control input-sm" id="filtro" name="filtro" width="400" height="70" onkeyup="showHint(this.value,'<?php echo $tipo_subcentro ;?>' )" placeholder="buscar..." value="<?php echo $filtro;?>" >
            <INPUT  type="submit" value="buscar" id="submit1" name="submit1">
            </tr><tr><td><div class="sugerir" id="sugerir"></div>
                </td></tr>
                  </table>
	</FORM>
  

<!-- EMPEZAMOS  EL AJAX    -->	

	
			
<script>
function showHint(str,ts) {
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
  xhttp.open("GET", "../obras/obras_ajax.php?filtro="+str+"&tipo_subcentro="+ts, true);
  xhttp.send();   
}	
function onClickAjax(id_obra, nombre_obra) {
//alert(val);
//document.getElementById("obra").value = val;
window.location="maquinaria_ficha.php?id_obra="+id_obra+"&nombre_obra="+nombre_obra;

//$("#txtHint").hide();
}
</script>
	
<!-- FIN  EL AJAX    -->			
		

<?php 
//$sql="Select  ID_OBRA,NOMBRE_OBRA,F_A_Recepcion FROM obras WHERE NOMBRE_OBRA LIKE '%-MA-%' AND NOMBRE_OBRA NOT LIKE 'I%' ORDER BY ID_OBRA DESC LIMIT 15" ;

if ($muestroLRU)      // pdte cambiar la primera sql por LRU Where id_c_coste and id_user, tipolru='obra'
  { $sql="Select  ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE tipo_subcentro='$tipo_subcentro' AND NOMBRE_OBRA LIKE '%$filtro%' AND $where_c_coste ORDER BY activa DESC, NOMBRE_OBRA DESC $limit" ;}
 else
  { $sql="Select  ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE tipo_subcentro='$tipo_subcentro' AND NOMBRE_OBRA LIKE '%$filtro%' AND $where_c_coste ORDER BY activa DESC, NOMBRE_OBRA DESC $limit" ;}	
 
//echo $sql;
$result = $Conn->query($sql);
?>

<p><?php echo "<br><br><br>Listado de ".strtolower($subcentro) ; ?><br></p>

<?php $cuenta=0;?>
<?php 
 if ($result->num_rows > 0) 
 {	 
  if ($result->num_rows==1 AND $filtro<>"" ) 
  { $rs = $result->fetch_array();
 ?>
 <script type="text/javascript">
	 window.location="../maquinaria/maquinaria_ficha.php?id_obra=<?php echo $rs['ID_OBRA'];?> ";
 </script>
 <?php
  }
   else
   { echo '<table>' ;
    while($rs = $result->fetch_array())
    {
	  $cuenta=$cuenta+1;
	  $nombre_obra=$rs["NOMBRE_OBRA"];
	  $id_obra=$rs["ID_OBRA"]; 
	?>
 
	<tr><td><a  href= "../maquinaria/maquinaria_ficha.php?id_obra=<?php echo $id_obra;?>&nombre_obra=<?php echo $nombre_obra;?>" ><?php echo $nombre_obra;?></a></td></tr>
	
<?php
	}
   echo '</table>' ;
   }
 }
  else
{ echo "No hay resultados." ;
}
	?>



<?php 
  if ($cuenta==20)
   { echo "<br><a class='enlace' href= '../maquinaria/maquinaria_buscar.php?tipo_subcentro=$tipo_subcentro&filtro={$filtro}&limit=0' >Ver todas...</a>" ;
   }

    else
	{echo "<br>".$cuenta . " " . strtolower($subcentro);
	}

$Conn->close();


?>

</div>

</center>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');