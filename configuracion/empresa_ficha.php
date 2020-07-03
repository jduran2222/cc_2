<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Config. Empresa</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>



<?php 
 


 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
 require_once("../menu/topbar.php");

 $id_c_coste=$_SESSION['id_c_coste'];

 echo '<br><br><br><br>';

 if($_SESSION['admin'])
 {
   $id_empresa= isset($_GET["id_empresa"]) ? $_GET["id_empresa"] : $id_c_coste ;     
   
   echo "<br><br><a class='btn btn_link' target='_blank' href='../registro/login_as.php?id_empresa=$id_empresa' >login as...</a>    "  ;
   $sql="SELECT * FROM Empresas_View_ext WHERE  id_c_coste=$id_empresa";
 $updates=['*']  ; 
 }
elseif ($_SESSION['autorizado'])
{
   $id_empresa= $id_c_coste ;       
   $sql="SELECT id_c_coste,C_Coste_Texto,nombre_centro_coste,domicilio,cod_postal,Municipio,Provincia,Estado_Pais,Moneda_simbolo,tels"
         . ",cif,email,web,Banco_fras,IBAN_fras,BIC_fras,id_doc_logo,id_doc_clave_privada,id_doc_clave_publica,pais,fecha_creacion FROM C_COSTES WHERE  id_c_coste=$id_empresa";
//   $no_updates=['C_Coste_Texto']  ;  // no permitimos cambiar el nombre de la empersa. Puede entrar en conflicto con otra empresa
   $updates=['*']  ; 
}else
{
   $id_empresa= $id_c_coste ;       
   $sql="SELECT id_c_coste,C_Coste_Texto,nombre_centro_coste,domicilio,cod_postal,Municipio,Provincia,Estado_Pais,tels"
         . ",cif,pais,fecha_creacion FROM C_COSTES WHERE  id_c_coste=$id_empresa";
    $updates=[]  ; // el no autorizado no puede cambiar nada
}    
 
$etiquetas['C_Coste_Texto']='Empresa';
$etiquetas['nombre_centro_coste']='Nombre completo Empresa';
//  $etiquetas['C_Coste_Texto']='Empresa';
//  $etiquetas['C_Coste_Texto']='Empresa';
$tooltips["id_doc_logo"]='Para disponer de un logo, suba el logo con añadir Doc y posteriormente selecciónelo en este campo.  '  ;
$tooltips["Moneda_simbolo"]='Símbolo de moneda: € , $ , COP, MXN... '  ;




 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
$titulo="EMPRESA" ;
  
   
  

//  $id_pago=$rs["id_remesa"] ;
$tabla_update="C_COSTES" ;
$id_update="id_c_coste" ; 
$id_valor=$id_empresa ; 
//  $delete_boton=1 ;


$wikis["id_doc_clave_privada"]="doc_clave_privada";
$wikis["id_doc_clave_publica"]="doc_clave_publica";

$selects["id_doc_logo"]=["id_documento","nombre_archivo","Documentos","","../documentos/documento_ficha.php?id_documento=","id_doc_logo"," AND tipo_entidad=\'empresa\' "] ;   // datos para clave foránea
$selects["id_doc_clave_privada"]=["id_documento","nombre_archivo","Documentos","","../documentos/documento_ficha.php?id_documento=","id_doc_clave_privada"," AND tipo_entidad=\'empresa\' "] ;   // datos para clave foránea
$selects["id_doc_clave_publica"]=["id_documento","nombre_archivo","Documentos","","../documentos/documento_ficha.php?id_documento=","id_doc_clave_publica"," AND tipo_entidad=\'empresa\' "] ;   // datos para clave foránea
//  $selects["id_doc_clave_privada"]=["id_documento","nombre_archivo","Documentos","","../documentos/documento_ficha.php?id_documento=","id_doc_clave_privada"] ;   // datos para clave foránea
//  $selects["id_produccion_obra"]=["ID_PRODUCCION","PRODUCCION","Prod_view","../obras/prod_anadir_form.php","../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","id_produccion_obra","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea

//  $ocultos=["json_geoip"] ;

// $formats["json_geoip"]='text_edit' ;
$formats["tamano_total_docs"]='mb' ;
$formats["tamano_medio_docs"]='mb' ;
$formats["tamano_max"]='mb' ;
$formats["primer_acceso"]='fecha' ;
$formats["ultimo_acceso"]='fecha' ;
// $formats["json_geoip"]='textarea_20' ;
  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
 
 <div class="right2">
	
<?php 
//  WIDGET DOCUMENTOS 
$tipo_entidad='empresa' ;
$id_entidad=$id_empresa ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='400px' ;
require("../include/widget_documentos.php");

 ?>
	 
</div>	     
	      
      
<?php   // Iniciamos tabla_div  de ************ PRODUCCIONES *************

$sql="SELECT id_licencia,licencia,fecha_contrato,fecha_caducidad,importe FROM Licencias WHERE  $where_c_coste ORDER BY fecha_contrato DESC LIMIT 50 ";
//$sql_T="SELECT '' AS AA, SUM(Ej_Material)  from prod_PEM_f_view WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY PRODUCCION LIMIT 7 ";

//$formats["Ej_Material"]='moneda' ;

//$links["licencia"] = ["../obras/obras_prod_detalle.php?id_obra={$id_obra}&id_produccion=", "id_licencia" ,'','formato_sub'] ;
$links["licencia"] = ["../include/ficha_general.php?url_enc=".encrypt2("tabla=Licencias&id_update=id_licencia&no_update=1")."&id_valor=", "id_licencia",'', 'formato_sub'] ;

//echo $sql;
$result=$Conn->query($sql );
//$result_T=$Conn->query($sql_T );

$titulo="Licencias contratadas";
$msg_tabla_vacia="No hay";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php require("../include/tabla.php"); echo $TABLE ; 

//echo "<a class='btn btn-link btn-xs' href=\"../obras/obras_prod.php?_m=$_m&id_obra=$id_obra\">ver todas las Relaciones Valoradas</a>" ;

?>


<!--  </div> -->
 </div>
	      
      

  <?php 
///  ESTADISTICAS
$result=$Conn->query($sql="SELECT * FROM Empresas_View WHERE id_c_coste=$id_empresa");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="ESTADISTICAS DE LA EMPRESA" ;
  
   
  
  $updates=[]  ; 
//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="C_COSTES" ;
  $id_update="id_c_coste" ; 
  $id_valor=$id_empresa ; 
      
      
 ?>
      
      
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      

	
<?php  

$Conn->close();

?>
	 

</div>

	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

