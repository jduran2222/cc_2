<?php
// cambios
require_once("../include/session.php");


$titulo = 'Agenda';

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
 
//echo '<br>' ;echo '<br>' ;echo '<br>' ;echo '<br>' ;echo '<br>' ;
// echo isset($_GET["id_usuario"]); 
// echo '<br>' ;
//echo $_SESSION["admin"] ;
//echo '<br>' ;
//echo $_SESSION["id_usuario"] ;
//echo '<br>' ;

 
 $usuario=$_SESSION["user"] ;
 
 $sql="SELECT * FROM Tareas WHERE $where_c_coste AND usuarios LIKE '%$usuario%' " ;
// echo $sql ;
 
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

 
  $titulo="TAREAS" ;
  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
//  $selects["ID_CUENTA"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;   // datos para clave foránea
//  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDOR"] ;

  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $updates=['*']  ;
  $tabla_update="Tareas" ;
  $id_update="id" ;
//  $id_valor=$id ;
  
 
    $actions_row=[];                                    // ANULAMOS LA POSIBILIDAD DE BORRAR FACTURA EN EL LISTADO. HAY QUE ENTRAR Y BORRAR DESDE DENTRO POR SEGURIDAD.
    $actions_row["id"]="id";
    $actions_row["delete_link"]="1"; 

 
$links["Tarea"] = ["../agenda/tarea_ficha.php?id=", "id"] ;
    
    
//  $formats["password_hash"]='textarea_30' ;
//  $formats["autorizado"]='boolean' ;
//  $formats["activo"]='semaforo' ;
//  $tootips["activo"]='Si se desactiva al usuario éste no podrá acceder al sistema' ;
  
//  $delete_boton=1;

  ?>
  
                  
                    
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php 
  
//     echo "<a class='btn btn-primary' href='../personal/parte_pdf.php?id_parte=$id_parte' >imprimir PDF</a>" ;

  
  require("../include/tabla.php"); echo $TABLE ; ?>
   
      <!--// FIN     **********    FICHA.PHP-->
  </div>
      
    <div class="right2">
    </div>
	
	<!--  DOCUMENTOS  -->
	
  
	
	
<?php            // ----- div PARTES PERSONAL  tabla.php   -----<!--  DETALLE DEL PARTE -->



?>

        <!--<div id="main" class="mainc">-->
<div  style="background-color:Khaki;float:left;width:60%;padding:0 20px;" >


 <div class="container">
  <!--<h2>Vales donde aparece el Concepto</h2>-->

</div>

     
<?php 
//require("../include/tabla.php"); echo $TABLE ; 
?>
 
    <br><br><br>
</div>    
    <!--//////   MAQUINARIA PROPIA  ///////-->
    
 


	
<?php  

$Conn->close();

?>
	 


	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>


         
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
