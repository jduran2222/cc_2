<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Imputar a subobra';

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
<?php 


 //echo "El filtro es:{$_GET["filtro"]}";

//$id_obra=$_GET["id_obra"]  ;
$id_obra=$_GET["id_obra"]  ;
$id_subobra=$_GET["id_subobra"]  ;
$table_selection_IN=$_GET["table_selection_IN"]  ;


//$fecha=$_GET["fecha"]  ;
//$fecha=date('Y-m-d');


require_once("../../conexion.php");
require_once("../include/funciones.php");

//confirmamos coherencia de datos (id_obra y id_subobra) por seguridad
$result=$Conn->query("SELECT * FROM Subobra_View WHERE ID_OBRA=$id_obra AND ID_SUBOBRA=$id_subobra AND $where_c_coste ");
$rs = $result->fetch_array() ;

$id_obra=$rs["ID_OBRA"]  ;
$id_subobra=$rs["ID_SUBOBRA"]  ;


 if($id_subobra)   // CONFIRMAMOS QUE LA ID_PRODUCCION ES DEL ID_C_COSTE
 {

  $sql="UPDATE GASTOS_T SET ID_SUBOBRA = $id_subobra  " 
               ."WHERE id IN  $table_selection_IN  ; " ;

//  $sql = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION ) "
//        . "SELECT $id_produccion AS ID_PRODUCCION, '$fecha' AS Fecha , ID_UDO , med_completar AS MEDICION "
//        . "FROM Prod_detalle_completar "
//        . " WHERE ID_PRODUCCION=$id_produccion AND ID_UDO IN  $table_selection_IN " ;

  if ($result=$Conn->query($sql))
  {        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 
  }
  else {
        if (  $table_selection_IN =='()')
        {
            echo "<br><br><br><br><br><br><br><br><br><br><H1>ERROR: NO HA SELECCIONADO NINGÚN DETALLE A IMPUTAR A LA SUBOBRA {$rs["SUBOBRA"]}</H1>" ; 
        }  
        else
        {    
          echo "<br><br><br><br><br><br><br><br><br><br><H1>ERROR INESPERADO: $sql</H1>" ; 
        }  
          echo "<center><button  class='btn btn-warning btn-lg noprint'  onclick='window.close()'/>" 
                 ."<i class='far fa-window-close'></i> cerrar ventana</button></center>" ; 
  }
 }
 
  

//
//
// if ($result) //compruebo si se ha creado la obra
//             { 	
//              $id_produccion2=Dfirst( "MAX(ID_PRODUCCION)", "PRODUCCIONES", "ID_OBRA=$id_obra" ) ; 
//	        // TODO OK-> Entramos a pagina_inicio.php
////	       echo "factura proveedor creada satisfactoriamente." ;
////		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
////                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/aval_ficha.php?id_aval=$id_aval'>" ;
//
//            $sql2 = "INSERT INTO PRODUCCIONES_DETALLE ( ID_PRODUCCION, Fecha, ID_UDO, MEDICION, Observaciones ) "
//               . "SELECT $id_produccion2 as ID_PRODUCCION,  '$fecha' AS Fecha, ID_UDO, MEDICION,Observaciones  "
//               . " FROM PRODUCCIONES_DETALLE WHERE ID_PRODUCCION=$id_produccion  ; "  ;
//      
//             if (!$Conn->query($sql2)) { echo "ERROR añadiendo detalles: $sql2" ; }; 
//             
//	     }
//	       else
//	     {
//		echo "ERROR creando produccion: $sql2" ;
////		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
//	     }
//            


?>
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');