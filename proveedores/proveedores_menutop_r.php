

<?php 
//   require_once("../../conexion.php");
//    require_once("../include/funciones.php");

if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS
{


 
$proveedor=Dfirst("PROVEEDOR", "Proveedores", "ID_PROVEEDORES=$id_proveedor AND $where_c_coste") ; // SEGURIDAD DE DATOS

$active= isset($active)? $active : basename( $_SERVER['PHP_SELF'], ".php")  ;  // elemento a dejar activo

// entidades
$num_albaranes=Dfirst("COUNT(ID_VALE)", "VALES", "ID_PROVEEDORES='$id_proveedor' ") ;
$num_fras=Dfirst("COUNT(ID_FRA_PROV)", "FACTURAS_PROV", "ID_PROVEEDORES='$id_proveedor' ") ;
$num_pofs=Dfirst("COUNT(ID_POF)", "POF_DETALLE", "id_proveedor='$id_proveedor' ") ;
$num_subcontratos=Dfirst("COUNT(id_subcontrato)", "Subcontratos", "id_proveedor='$id_proveedor' ") ;
$num_conceptos=Dfirst("COUNT(ID_CONCEPTO)", "CONCEPTOS", "ID_PROVEEDOR='$id_proveedor' ") ;


$badge_albaranes="<sup class='small px-0 px-sm-1'>". badge($num_albaranes,'info')  ."</sup>" ;
$badge_fras="<sup class='small px-0 px-sm-1'>". badge($num_fras,'info')  ."</sup>" ;
$badge_pofs="<sup class='small px-0 px-sm-1'>". badge($num_pofs,'info')  ."</sup>" ;
$badge_subcontratos="<sup class='small px-0 px-sm-1'>". badge($num_subcontratos,'info')  ."</sup>" ;
$badge_conceptos="<sup class='small px-0 px-sm-1'>". badge($num_conceptos,'info')  ."</sup>" ;


?>

<div class="topnav" id="myTopnav">
	
  <!--<a href="javascript:void(0);" style="font-size:15px;cursor:pointer"  onclick="openNav()">Menu PPAL</a>-->  
  <?php // echo "<br><br><br><br><br><br><br><br><br><h1>Active: $active</h1>" ;
 ?>
   <a  <?php echo ($active=='proveedores_ficha'? "class='cc_active'" : "" );?>   href="proveedores_ficha.php?id_proveedor=<?php echo $id_proveedor;?>" >Proveedor: <font color='lightgreen'><?php echo $proveedor;?></font></a>
  <a  <?php echo ($active=='gastos'? "class='cc_active'" : "" );?> href="../obras/gastos.php?agrupar=albaranes_pdf&PROVEEDOR=<?php echo $proveedor;?>"  target='_blank' >Albaranes  <?php echo $badge_albaranes;?></a>
  <a  <?php echo ($active=='facturas_proveedores'? "class='cc_active'" : "" );?> href="facturas_proveedores.php?id_proveedor=<?php echo $id_proveedor;?>"  target='_blank'>Facturas  <?php echo $badge_fras;?></a>
  <a  <?php echo ($active=='proveedores_pofs'? "class='cc_active'" : "" );?> href="proveedores_pofs.php?id_proveedor=<?php echo $id_proveedor;?>" target='_blank'>POF  <?php echo $badge_pofs;?></a>
  <a  <?php echo ($active=='proveedores_subcontratos'? "class='cc_active'" : "" );?> href="proveedores_subcontratos.php?id_proveedor=<?php echo $id_proveedor;?>" target='_blank'>Subcontratos  <?php echo $badge_subcontratos;?></a>
  <a  <?php echo ($active=='tabla_general'? "class='cc_active'" : "" );?> target='_blank' href="../include/tabla_general.php?tabla=<?php echo encrypt2('Conceptos_suma_View');?>&where=<?php echo encrypt2("ID_PROVEEDOR=$id_proveedor");?>&link=<?php echo encrypt2('../proveedores/concepto_ficha.php?id_concepto=');?>&campo=<?php echo encrypt2('CONCEPTO');?>&campo_id=<?php echo encrypt2('ID_CONCEPTO');?>" target='_blank'>Conceptos  <?php echo $badge_conceptos;?></a>
  <a href="javascript:void(0);"  class="icon" onclick="myFunction()">&#9776;</a>
</div>



<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav noprint") {
        x.className += " responsive";
    } else {
        x.className = "topnav noprint";
    }
}
</script>


<?php
 
}
//echo "<br><br><br><br><br><br><br><br><br><h1>Active: $active</h1>" ;

?>
