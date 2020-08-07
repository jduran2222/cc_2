<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Prooveedor BBDD Ficha';

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
	



<FONT size=1 color="silver"><?php echo $_SERVER["SCRIPT_NAME"];?></FONT>
<!-- recibo el parametro -->
<?php 


$id_proveedor=$_GET["id_proveedor"];
// require("../proveedores/proveedores_menutop_r.php");
$result=$Conn->query($sql="SELECT * FROM ProveedoresBD WHERE id_proveedor=$id_proveedor ");
$rs = $result->fetch_array(MYSQLI_ASSOC) ;
	
 $titulo="PROVEEDOR PAGINAS AMARILLAS:<br>{$rs["NOMBRE"]}" ;
  //$updates=['NOMBRE_OBRA','NOMBRE_COMPLETO','GRUPOS','EXPEDIENTE', 'NOMBRE' ,'Nombre Completo', 'LUGAR', 'PROVINCIA', 'Presupuesto Tipo', 'Plazo Proyecto' ,'Observaciones']  ;
  $updates=["*"] ;
//  $selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes"] ;   // datos para clave foránea
  //$id_obra=$rs["ID_PROVEEDORES"] ;
  $tabla_update="ProveedoresBD" ;
  $id_update="ID_PROVEEDOR" ;
  $id_valor=$rs["ID_PROVEEDOR"] ;
  



  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>

<div class="right2">
	
  <?php 
 
  //COMPROBAMOS SI EXISTE VALE
 
   $sql_prov="INSERT INTO `Proveedores` ( id_c_coste,PROVEEDOR,RAZON_SOCIAL,CIF,DIRECCION,LOCALIDAD,CONTACTO,TEL1,TEL2,FAX,OBSERVACIONES,`user` ) "
           . " VALUES (  '{$_SESSION['id_c_coste']}','{$rs['NOMBRE']}','{$rs['RAZON_SOCIAL']}','{$rs['CIF']}' " 
           ." ,'{$rs['domicilio_calle']}','{$rs['Localidad']}','{$rs['CONTACTO']}' ,'{$rs['TEL1']}','{$rs['TEL2']}','{$rs['FAX']}','{$rs['OBSERVACIONES']}','{$_SESSION["user"]}' );" ;

   $sql_cliente="INSERT INTO `Clientes` ( id_c_coste,CLIENTE,NOMBRE_FISCAL,CIF,DOMICILIO_FISCAL,DOMICILIO_FACTURAS,CONTACTO,TEL,FAX,Observaciones,`user` "
           ." ,FACe_cod_contable,FACe_nombre_contable,FACe_cod_gestor,FACe_nombre_gestor,FACe_cod_tramitador,FACe_nombre_tramitador,Calle,Cod_postal,Municipio,Provincia  ) "
           . " VALUES (  '{$_SESSION['id_c_coste']}','{$rs['NOMBRE']}','{$rs['RAZON_SOCIAL']}','{$rs['CIF']}' " 
           ." ,'{$rs['domicilio_calle']}','{$rs['domicilio_calle']}','{$rs['CONTACTO']}' ,'{$rs['TEL1']}','{$rs['FAX']}','{$rs['OBSERVACIONES']}','{$_SESSION["user"]}' " 
           ." ,'{$rs['FACe_cod_contable']}','{$rs['FACe_nombre_contable']}','{$rs['FACe_cod_gestor']}','{$rs['FACe_nombre_gestor']}','{$rs['FACe_cod_tramitador']}','{$rs['FACe_nombre_tramitador']}'  "
            . " ,'{$rs['domicilio_calle']}','{$rs['Cod_postal']}','{$rs['Localidad']}','{$rs['Provincia']}' );" ;
//           
//   $sql_prov="INSERT INTO `Proveedores` ( id_c_coste,PROVEEDOR ) "
//           . " VALUES (  '{$_SESSION['id_c_coste']}','{$rs['NOMBRE']}' );" ;
//   echo $sql_cliente ;
           
   $sql_prov_64= encrypt2($sql_prov)      ;  
   $sql_cliente_64= encrypt2($sql_cliente)      ;  
   
   $titulo = "<h1 style='font-weight: bold; color:green;'>IMPORTAR A NUESTRA EMPRESA</h1>" ;
   $titulo .= "<a class='btn btn-primary' href='../include/sql.php?code=1&sql=$sql_prov_64' target='_blank'>Importar como Proveedor</a>" ; 
   $titulo .= "<a class='btn btn-primary' href='../include/sql.php?code=1&sql=$sql_cliente_64' target='_blank'>Importar como Cliente</a>" ;
//   $titulo .= "<a class='btn btn-primary' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte&id_vale=$id_vale' >Importar como Cliente</a>" ;
  
//   $titulo="<h1 style='font-weight: bold;color:red;'>NO CARGADO A OBRA</h1>" ;   
//   $titulo .= "<a class='btn btn-primary' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte' >Cargar a obra</a>" ;
 
   echo $titulo ;
 ?>
	 
  </div>      
	
	
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
