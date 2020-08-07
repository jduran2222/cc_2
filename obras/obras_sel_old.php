<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Listado de obras';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">

	   	 
	   
<div id="main" class="mainc">	
<div align=center class="encabezadopagina2">Listado de Obras</div>
<FONT size=1 color="silver"><?php echo $_SERVER["SCRIPT_NAME"];?> -- <?php echo date("d/m/Y - H:i:s");?></FONT>

<HR  size="2" width="100%" color="#990000">


<?php $filtro=$_POST["text1"];?>

<?php $hoy=time();?>

<?php require_once("../../conexion.php"); ?> 
<?php 
$sql="Select ID_OBRA,NOMBRE_OBRA,F_A_Recepcion FROM OBRAS WHERE NOMBRE_OBRA LIKE '%$filtro%' ORDER BY NOMBRE_OBRA" ;

$result = $Conn->query($sql);

?>


<center>

<?php $cuenta=0;?>
<?php if ($result->num_rows > 0) {
    while($rs = $result->fetch_array())
		{
?>
	<?php   $cuenta=$cuenta+1;?>
	<?php   $nombre_obra=$rs["NOMBRE_OBRA"];?>
	<?php   $id_obra=$rs["ID_OBRA"];?>
	<A class="enlace" href= "obras_ficha.php?id_obra=<?php   echo $id_obra;?>&nombre_obra=<?php   echo $nombre_obra;?>" ><?php   echo $nombre_obra;?></a><br>
	
<?php }
} ?>

<?php if ($cuenta==1)
{
?>
  <?php   header("Location: "."obras_ficha.php?id_obra=".$id_obra."&nombre_obra=".$nombre_obra);?>
<?php } ?>

</center>
<?php echo $cuenta . " resultados.";?>
<?php 


$Conn->close();


?>
</div>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
