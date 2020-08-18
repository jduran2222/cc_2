<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="POFS " . Dfirst("NOMBRE_OBRA","OBRAS", "ID_OBRA={$_GET["id_obra"]} AND $where_c_coste"  ) ;
$titulo = $titulo_pagina;

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

 


<!-- recibo el parametro -->
<?php $id_obra=$_GET["id_obra"];?>

<!-- CONEXION CON LA BBDD Y MENUS -->
<?php 

require_once("../obras/obras_menutop_r.php");
//require_once("../menu/menu_migas.php");

 ?> 

<div style="overflow:visible">	   
    <br><br><br><br>  
	<!--************ INICIO POF *************  -->
<div id="main" class="mainc_100" style="background-color:#fff">
<h1>PETICIONES DE OFERTA</h1>
		
<!--<a class='btn btn-link' target='_blank' href='../pof/pof_anadir.php?id_obra=<?php echo $id_obra;?>'  ><i class="fas fa-plus-circle"></i> Añadir Peticion de Oferta</a>-->
<br><br><a class='btn btn-link'  href=# <?php echo "onclick=\"add_pof($id_obra)\" " ;?> ><i class="fas fa-plus-circle"></i> Añadir Peticion de Oferta</a>
	

<?php 
      if (isset($_POST["filtro"])) 
	   { $filtro=$_POST["filtro"] ;
	   }
        else
		{ $filtro='%' ;
		}   ;
$filtro=isset($_POST["filtro"])?$_POST["filtro"] : '' ;
$activa=isset($_POST["activa"])?$_POST["activa"] : '1' ;
                
                
 ?>
<FORM action="../obras/obras_peticiones.php?id_obra=<?php echo $id_obra;?>" method="post" id="form1" name="form1">
    <INPUT id="filtro" type="text" name="filtro" placeholder="filtrar"  >
<?php
                $radio=$activa ;
                $radio_name='activa' ;
                $chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
                if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
                //echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
                echo "<br>"
                     . "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
                     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />todas     </label> "
                     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />POF activas   </label>"
                     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />POF no activas</label>"
                     . "</div>"
                     . "" ;

?>
    
    <INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">
</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

$importe=Dfirst('IMPORTE/(1+iva_obra)','OBRAS',"$where_c_coste AND ID_OBRA=$id_obra") ;

$where = "True" ;
$where .=  $filtro ? " AND filtro LIKE '%$filtro%' " : "";
$where .= ($activa=='') ? '' : " AND activa=$activa"  ;



$result=$Conn->query(   $sql="SELECT ID_POF,NUMERO as Num,NOMBRE_POF,importe_estimado "
            . ", Prov_lista AS Prov_TOOLTIP, Env_lista AS Env_TOOLTIP, Resp_lista AS Re_TOOLTIP "
            . ", Proveedores as Prov,Enviados as Env,Respondidos as Re,Observaciones,activa, Subcontratos "
            . " FROM POF_lista WHERE ID_OBRA=$id_obra AND $where ORDER BY numero " );
$result_T=$Conn->query(   $sql_T="SELECT COUNT(ID_POF) as Num,'Suma' ,sum(importe_estimado) as importe,'' as aa4,'' as aa3,'' as aa2,'' as aa1 "
              . "FROM POF_lista WHERE ID_OBRA=$id_obra AND $where  " );
$result_T2=$Conn->query(   $sql_T2="SELECT '' as aa,'Porcentaje' as ppp,sum(importe_estimado)/$importe as porcentaje,'' as aa4,'' as aa3,'' as aa2,'' as aa1 "
              . "FROM POF_lista WHERE ID_OBRA=$id_obra AND $where  " );

//echo $sql;

$links["NOMBRE_POF"] = ["../pof/pof.php?id_pof=", "ID_POF",'abrir Peticion de Oferta' ,'formato_sub'] ;
$aligns["Num"] = "center" ;
$aligns["Prov"] = "center" ;
$aligns["Env"] = "center" ;
$aligns["Re"] = "center" ;
$aligns["Adj"] = "center" ;
$tooltips["Prov"] = "Proveedores seleccionados para pedirles presupuesto" ;
$tooltips["Env"] = "Proveedores a los que se ha enviado peticion de oferta" ;
$tooltips["Re"] = "Proveedores que han respondido y presupuestado la POF" ;
//$tooltips["Term"] = "Peticion de oferta terminada" ;
$formats["activa"]="boolean" ;

$updates=['activa','Observaciones','NUMERO']  ;
$tabla_update="PETICION DE OFERTAS" ;
$id_update="ID_POF" ;
$actions_row=[];
$actions_row["id"]="ID_POF";
$actions_row["delete_link"]="1";
 


$titulo="";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN POF *************  -->
	
	

<?php  

$Conn->close();

?>
<script>
function add_pof(id_obra) {
    var nuevo_valor=window.prompt("Nombre de la POF: " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
    window.open("../pof/pof_anadir.php?id_obra="+id_obra+"&nombre_pof="+nuevo_valor, '_blank' )   ;     
   }
   else
   {return;
   }
   
}

</script>	 

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');