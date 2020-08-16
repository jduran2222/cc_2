<?php
require_once("../include/session.php");
?>
<?php


require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
 


// miramos si viene del form o añadimos Vale vacío
//if (isset($_POST["filtro"]))
//{
//$fecha= $_POST["fecha"] ;  
//$id_obra= $_POST["filtro"] ;  
//$id_proveedor= $_POST["filtro_prov"] ;  
//$ref= $_POST["ref"] ;  
//}
// else {
     
//$id_proveedor= getVar('id_proveedor_auto');
//$fecha=date('Y-m-d');
 
$id_obra = isset($_POST["filtro"]) ? $_POST["filtro"] : isset($_GET["id_obra"])? $_GET["id_obra"] : getVar('id_obra_gg');
$id_proveedor = isset($_POST["filtro_prov"]) ? $_POST["filtro_prov"] :  isset($_GET["id_proveedor"])? $_GET["id_proveedor"] : getVar('id_proveedor_auto');
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : isset($_GET["fecha"])? $_GET["fecha"] : date('Y-m-d');
$ref = isset($_POST["ref"]) ? $_POST["ref"] : isset($_GET["ref"])? $_GET["ref"] : 'referencia';
$importe = isset($_GET["importe"])? $_GET["importe"] : '';
$observaciones = isset($_GET["observaciones"])? $_GET["observaciones"] : '';
$add_foto = isset($_GET["add_foto"])? $_GET["add_foto"] : '';


// valores en caso de que ya existe el albarán y vamos a añadir un detalle nuevo de un concepto nuevo
$id_vale = isset($_GET["id_vale"])? $_GET["id_vale"] : '';  // 
$id_concepto = isset($_GET["id_concepto"])? $_GET["id_concepto"] : '';  // 
$cantidad = isset($_GET["cantidad"])? $_GET["cantidad"] : '';  // 

// No enviamos el ID_CONCEPTO, si no que hay que crear uno nuevo
$concepto_nuevo = isset($_GET["concepto_nuevo"])? $_GET["concepto_nuevo"] : '';  // 
$coste = isset($_GET["coste"])? $_GET["coste"] : '';  // 
$id_cuenta= isset($_GET["id_cuenta"]) ? $_GET["id_cuenta"] : getVar('id_cuenta_auto') ;       // por si un día queremos usar la ID_CUENTA


if (!$id_concepto)      // No se indica el ID_CONCEPTO, entonces, o lo creamos si hay concepto_nuevo o usamos el id_concepto_auto del Proveedor


//}

// ID_VALE si no hemos pasado el id_vale es que hay que crearlo nuevo		
if (!$id_vale)
{    
    $sql="INSERT INTO `VALES` ( FECHA, ID_OBRA,ID_PROVEEDORES ,REF ,Observaciones, `user` )    VALUES ( '$fecha' , $id_obra, $id_proveedor  ,'$ref' , '$observaciones', '{$_SESSION["user"]}' );" ;
    //echo ($sql);
    logs($sql);
    $result=$Conn->query($sql);
    if ($result)
    {$id_vale=Dfirst( "MAX(ID_VALE)", "VALES", "ID_PROVEEDORES=$id_proveedor" ) ; }    // ID_VALE del albaran nuevo
    else
    { die("ERROR al crear albaran nuevo") ;}    
}

// ID_CONCEPTO : Si no se indica el ID_CONCEPTO, entonces, o lo creamos si hay concepto_nuevo o usamos el id_concepto_auto del Proveedor
if (!$id_concepto)   
{    
    if( !$importe AND $concepto_nuevo AND $coste)   // hay que crear concepto nuevo
    {
    $coste= dbNumero($coste)    ;
    $sql="INSERT INTO `CONCEPTOS` ( ID_OBRA,ID_PROVEEDOR,ID_CUENTA ,CONCEPTO ,COSTE, `user` )    VALUES ( '$id_obra', '$id_proveedor'  , '$id_cuenta'  ,'$concepto_nuevo' , '$coste', '{$_SESSION["user"]}' );" ;
    //echo ($sql);
    logs($sql);
    $result=$Conn->query($sql);
    if ($result)
        {$id_concepto=Dfirst( "MAX(ID_CONCEPTO)", "CONCEPTOS", "ID_PROVEEDOR=$id_proveedor" ) ;  logs("ID_CONCEPTO=$id_concepto"); }    // ID_VALE del albaran nuevo
        else
        { die("ERROR al crear concepto nuevo") ;}    
    
    }
    else  // cogemos el id_copncepto_auto del proveedor
    {
     $id_concepto=Dfirst("id_concepto_auto","Proveedores" ,"ID_PROVEEDORES=$id_proveedor AND $where_c_coste" )  ;  
     $cantidad=$importe ;       
    }        
}


//if ($importe)         // Añadimos directamente Detalle  de tal importe con el concepto
//{
////  $id_concepto_auto=Dfirst("id_concepto_auto","Proveedores" ,"ID_PROVEEDORES=$id_proveedor AND $where_c_coste" )  ;
////                  $id_subobra_auto=Dfirst("id_subobra_auto","OBRAS" ,"ID_OBRA=$id_obra AND $where_c_coste" )  ;
////                  $id_subobra_auto= getVar("id_subobra_si" )  ;
  $id_subobra_si = Dfirst("id_subobra_auto","OBRAS"," $where_c_coste AND ID_OBRA=$id_obra")  ;
  $id_subobra_si = $id_subobra_si ? $id_subobra_si :  getVar("id_subobra_si") ;  // en caso de que haya error usamos la predeterminada

  
 // evitamos que se genere una línea de detalle a CERO en albaranes solo con foto y proveedor pdte de registrar 
 if ($cantidad) 
 {    
  $sql="INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) VALUES ( '$id_vale' , '$id_concepto', '$cantidad'  ,   '$id_subobra_si' );" ;
//                 echo ($sql);
  logs($sql);  
  if (!$result=$Conn->query($sql)) { logs("ERROR EN:$sql"); die("ERROR: $sql") ;};
 }

 if ($add_foto)         // valoramos el Vale
{
//                  echo "<a class='btn btn-link noprint' href=\"../documentos/doc_upload_multiple_form.php?tipo_entidad=$tipo_entidad&id_subdir=$id_subdir&id_entidad=$id_entidad\" "
//                 . "target='_blank' ><i class='fas fa-cloud-upload-alt'></i> Subir doc.(pdf, jpg, xls...) </a>" ;
  echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../documentos/doc_upload_multiple_form.php?tipo_entidad=albaran&id_subdir=$id_proveedor&id_entidad=$id_vale'>" ;

}
else
{
  echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/albaran_proveedor.php?id_vale=$id_vale'>" ;                
}
         
         
	             // TODO OK-> Entramos a clientes_ficha.php
//	echo "VALE creado satisfactoriamente." ;
//	echo  "<a href=\"albaran_proveedor.php?id_vale=$id_vale\" title='ver vale'> Ir al ALBARAN  :  $ref</a>" ;

//	     }
//		  else
//		  {
//			echo "Error al crear VALE, inténtelo de nuevo " ;
//			echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
//	     }
//       

?>