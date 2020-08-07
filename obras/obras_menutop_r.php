
<?php 

$id_obra=isset($id_obra) ? $id_obra :( isset($_GET["id_obra"])? $_GET["id_obra"] : "" ) ;

if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS SI NO TIENEN ACCESO A ESA OBRA

{

//require_once("../include/funciones.php"); 


$rs_obra=DRow("OBRAS","id_obra=$id_obra AND $where_c_coste ") ;
$tipo_subcentro=$rs_obra["tipo_subcentro"];



$tipo_subcentro_texto=Dfirst("subcentro","tipos_subcentro","tipo_subcentro='$tipo_subcentro' ") ;

$nombre_obra=substr( $rs_obra["NOMBRE_OBRA"] , 0, 24) ;

$id_estudio=$rs_obra["ID_ESTUDIO"];

?>
   <!--NO CAMBIAR LAS CLASES DEL DIV SIN CAMBIAR LA FUNCION DE JAVASCRIPT--> 
<div class="topnav noprint" id="myTopnav">
	
  <!--<a href="javascript:void(0);" style="font-size:15px;cursor:pointer"  onclick="openNav()">MENU</a>-->  
  
  <?php // require_once("../menu/topbar.php"); ?>   
  
  <!--<a href="../menu/pagina_inicio.php" class="active">Inicio</a>-->
  <!--<a href="obras_buscar.php?tipo_subcentro=<?php // echo $tipo_subcentro;?>" >Buscar</a>-->

  <!--<a href="javascript:void(0);" style="font-size:80px;" class="icon" onclick="myFunction()">&#9776;</a>-->
  
 
  <?php
  
  
  $active= isset($active)? $active : basename( $_SERVER['PHP_SELF'], ".php")  ;  // elemento a dejar activo
//  $active=  '' ;  // 
  
// echo $active ;
    
// echo "<a></a>" ; // evitmos que en version mobile ocupe toda la pantalla el siguiente
 echo "<a ".($active=='obras_ficha'? "class='cc_active'" : "" ) ." href='../obras/obras_ficha.php?id_obra=$id_obra'><b>$tipo_subcentro_texto</b>: <font color=yellow> $nombre_obra</font></a>" ;
  
   switch ($tipo_subcentro) 
   {
   
    case 'O':
        echo  $id_estudio ?  "<a ".($active=='estudios_ficha'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../estudios/estudios_ficha.php?id_estudio=$id_estudio\">Licitación</a>  " : "";        
        echo "<a ".($active=='obras_proy'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_proy.php?id_obra=$id_obra\">Proyecto</a>  " ;
//        echo "<a target='_blank'  href=\"../obras\obras_proy2.php?id_obra=$id_obra\">Proyecto2</a>  " ;
        echo "<a ".($active=='obras_prod'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_prod.php?id_obra=$id_obra\"  title='Relaciones Valoradas (Producciones)'>Rel.Valoradas</a>  ";

        echo "<a ".($active=='obras_peticiones'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_peticiones.php?id_obra=$id_obra\"  title='Peticiones de Oferta'>POF</a>  ";
        echo "<a ".($active=='obras_subcontratos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_subcontratos.php?id_obra=$id_obra\">Subcontratos</a>  ";
        echo "<a ".($active=='partes'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../personal\partes.php?id_obra=$id_obra\">Partes</a>  ";
        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?id_obra=$id_obra\">Gastos</a>  ";
        echo "<a ".($active=='facturas_proveedores'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../proveedores/facturas_proveedores.php?id_obra=$id_obra&menu=obras&NOMBRE_OBRA=$nombre_obra\">Fras proveedores</a>  ";
//        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?importe1=0&importe2=0&agrupar=albaranes_pdf&id_obra=$id_obra\">Albaranes pdte valorar</a>  ";
        echo "<a ".($active=='obras_ventas'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_ventas.php?id_obra=$id_obra\" title='Factura a Clientes, certificaciones, Ventas...'>Ventas</a>  ";
        echo "<a ".($active=='obras_fotos'? "class='cc_active'" : "" ) ."  target='_blank'  href=\"../obras\obras_fotos.php?id_obra=$id_obra\">Fotos</a>  ";
        break;
    case 'A':
//        echo "<a target='_blank'  href=\"../obras\obras_proy.php?id_obra=$id_obra\">Proyecto</a>  " ;
//        echo "<a target='_blank'  href=\"../obras\obras_proy2.php?id_obra=$id_obra\">Proyecto2</a>  " ;
        echo "<a ".($active=='obras_peticiones'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_peticiones.php?id_obra=$id_obra\"  title='Peticiones de Oferta'>POF</a>  ";
//        echo "<a target='_blank'  href=\"../obras\obras_subcontratos.php?id_obra=$id_obra\">Subcontratos</a>  ";
        echo "<a ".($active=='partes'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../personal\partes.php?id_obra=$id_obra\">Partes</a>  ";
        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?id_obra=$id_obra\">Gastos</a>  ";
        echo "<a ".($active=='facturas_proveedores'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../proveedores/facturas_proveedores.php?NOMBRE_OBRA=$nombre_obra\">Fras proveedores</a>  ";
//        echo "<a target='_blank'  href=\"../obras\gastos.php?importe1=0&importe2=0&agrupar=albaranes_pdf&id_obra=$id_obra\">Vales pdte valorar</a>  ";
//        echo "<a target='_blank'  href=\"../obras\obras_prod.php?id_obra=$id_obra\">Producciones</a>  ";
        echo "<a ".($active=='obras_ventas'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_ventas.php?id_obra=$id_obra\">Facturacion</a>  ";
//        echo "<a target='_blank'  href=\"../obras\obras_fotos.php?id_obra=$id_obra\">Fotos</a>  ";
        break;
    case 'E':
        echo  $id_estudio ?  "<a ".($active=='estudios_ficha'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../estudios/estudios_ficha.php?id_estudio=$id_estudio\">Licitación</a>  " : "";        
        echo "<a ".($active=='obras_proy'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_proy.php?id_obra=$id_obra\">Proyecto</a>  " ;
        echo "<a ".($active=='obras_peticiones'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_peticiones.php?id_obra=$id_obra\"  title='Peticiones de Oferta'>POF</a>  ";
        echo "<a ".($active=='obras_prod'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_prod.php?id_obra=$id_obra\"  title='Relaciones Valoradas (Producciones)'>Rel.Valoradas</a>  ";
        echo "<a ".($active=='obras_fotos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_fotos.php?id_obra=$id_obra\">Fotos</a>  ";
        break;
    case 'M':
        //menu maq.: balance, amortiz...
        echo "<a ".($active=='obras_peticiones'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_peticiones.php?id_obra=$id_obra\"  title='Peticiones de Oferta'>POF</a>  ";
        echo "<a ".($active=='obras_subcontratos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_subcontratos.php?id_obra=$id_obra\">Subcontratos</a>  ";
        echo "<a ".($active=='partes'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../personal\partes.php?id_obra=$id_obra\">Partes</a>  ";
        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?id_obra=$id_obra\">Gastos</a>  ";
        echo "<a ".($active=='facturas_proveedores'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../proveedores/facturas_proveedores.php?NOMBRE_OBRA=$nombre_obra\">Fras proveedores</a>  ";        
        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?importe1=0&importe2=0&agrupar=albaranes_pdf&id_obra=$id_obra\">Vales pdte valorar</a>  ";
        echo "<a ".($active=='obras_fotos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_fotos.php?id_obra=$id_obra\">Fotos</a>  ";
        
        break;
    case 'G':
        //menu GG.: gastos fras_prov,Fras_cli,Docs...
        echo "<a ".($active=='obras_peticiones'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_peticiones.php?id_obra=$id_obra\"  title='Peticiones de Oferta'>POF</a>  ";
        echo "<a ".($active=='obras_subcontratos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_subcontratos.php?id_obra=$id_obra\">Subcontratos</a>  ";
        echo "<a ".($active=='partes'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../personal\partes.php?id_obra=$id_obra\">Partes</a>  ";
        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?id_obra=$id_obra\">Gastos</a>  ";
        echo "<a ".($active=='facturas_proveedores'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../proveedores/facturas_proveedores.php?NOMBRE_OBRA=$nombre_obra\">Fras proveedores</a>  ";
        echo "<a ".($active=='gastos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\gastos.php?importe1=0&importe2=0&agrupar=albaranes_pdf&id_obra=$id_obra\">Vales pdte valorar</a>  ";
        echo "<a ".($active=='obras_ventas'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_ventas.php?id_obra=$id_obra\">Facturacion</a>  ";
        echo "<a ".($active=='obras_fotos'? "class='cc_active'" : "" ) ." target='_blank'  href=\"../obras\obras_fotos.php?id_obra=$id_obra\">Fotos</a>  ";
       
        break;
  
   }
   
?>  

  <a href="javascript:void(0);"  class="icon" onclick="myFunction()">&#9776;</a>

  <!--<a href="javascript:void(0);" style="font-size:80px;" class="icon" onclick="myFunction()">&#9776;</a>-->
</div>

   <div class="solo_mobile"><br><br><br><br><br></div>
   
   

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
 
} // fin IF INVITADO

?>