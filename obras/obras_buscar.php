<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Buscador de obras';

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

//require("obras_menutop_r.php");


//$subcentro=Dfirst("subcentro","tipos_subcentro", "tipo_subcentro='$tipo_subcentro'" ) . "S" ;
$subcentro= like($tipo_subcentro , '%o%' )?  "OBRA" : (like($tipo_subcentro , '%m%' )? "MAQUINARIA" : "SUBCENTRO" );


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
	
<div id="main"  ><h1 style='font-size: 90px'><i class="fas fa-hard-hat"></i> <?php echo $subcentro ."S" ; ?><br></h1>
	
    <a class="btn btn-link btn-lg" style='text-align: left;font-size: 40px' href= 'obras_anadir_form.php' ><i class="fas fa-plus-circle"></i> Añadir <?php echo strtolower($subcentro) ; ?></a>
    
	<FORM action="../obras/obras_buscar.php?tipo_subcentro=<?php echo $tipo_subcentro ; ?>" method="post" id="form1"  name="form1">
            <table>
            <tr><td><INPUT  style='font-size:50px; width:100%; height:150px;' id="filtro" name="filtro"  onkeyup="showHint(this.value,'<?php echo $tipo_subcentro ;?>' )" placeholder="buscar..." value="<?php echo $filtro;?>" >
           <button type="submit"  style="font-size: 80px;" class="btn btn-info btn-lg"><i class="fas fa-search"></i> Buscar </button>
            </tr><tr><td><div class="sugerir" id="sugerir"></div>
                </td></tr>
                  </table>
	</FORM>
   
    <br><br><br>
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
window.location="../obras/obras_ficha.php?id_obra="+id_obra+"&nombre_obra="+nombre_obra;

//$("#txtHint").hide();
}
</script>
	
<!-- FIN  EL AJAX    -->			
		

<?php 
//$sql="Select  ID_OBRA,NOMBRE_OBRA,F_A_Recepcion FROM obras WHERE NOMBRE_OBRA LIKE '%-MA-%' AND NOMBRE_OBRA NOT LIKE 'I%' ORDER BY ID_OBRA DESC LIMIT 15" ;



if ($filtro)      // pdte cambiar la primera sql por LRU Where id_c_coste and id_user, tipolru='obra'
  { $sql="Select  ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE  NOMBRE_OBRA LIKE '%$filtro%' AND $where_c_coste ORDER BY activa DESC, NOMBRE_OBRA DESC $limit" ;}
 else
  { $sql="Select  ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE  LOCATE(tipo_subcentro,'$tipo_subcentro')>0 AND  activa AND $where_c_coste ORDER BY NOMBRE_OBRA  " ;}	
 
//echo $sql;
$result = $Conn->query($sql);
?>

<h1><?php echo "Listado de ".strtolower($subcentro)."s" ; ?><br></h1>

<?php $cuenta=0;?>
<?php 
 if ($result->num_rows > 0) 
 {	 
  if ($result->num_rows==1 AND $filtro<>"" ) 
  { $rs = $result->fetch_array();
 ?>
 <script type="text/javascript">
	 window.location="../obras/obras_ficha.php?id_obra=<?php echo $rs['ID_OBRA'];?> ";
 </script>
 <?php
  }
   else
   { echo "<table style='border: 1px solid grey'> " ;
    while($rs = $result->fetch_array())
    {
	  $cuenta=$cuenta+1;
	  $nombre_obra=$rs["NOMBRE_OBRA"];
	  $id_obra=$rs["ID_OBRA"]; 
	?>
 
	<tr style='border: 1px solid grey; height:200px'><td><a style="font-size: 60px;" href= "../obras/obras_ficha.php?id_obra=<?php echo $id_obra;?>&nombre_obra=<?php echo $nombre_obra;?>" ><?php echo $nombre_obra;?></a></td></tr>
	
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
   { echo "<br><a class='enlace' href= 'obras_buscar.php?_m=$_m&tipo_subcentro=$tipo_subcentro&filtro={$filtro}&limit=0' >Ver todas...</a>" ;
   }

    else
	{echo "<br>".$cuenta . " " . strtolower($subcentro);
	}

$Conn->close();


?>

</div>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');