<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
    <meta http-equiv="Last-Modified" content="0">
 
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
 
<meta http-equiv="Pragma" content="no-cache">
    
     <title>Documento</title>
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


$id_documento=$_GET["id_documento"];

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../include/funciones_js.php");
 require_once("../menu/topbar.php");
 //require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT id_documento,tipo_entidad,id_subdir,id_entidad,fecha_doc,documento,nombre_archivo,path_archivo,metadatos,tamano"
         . ",Observaciones,orden,'INFO IMAGEN' as EXPAND_info ,info_imagen, '' as FIN_EXPAND,user,fecha_creacion"
         . " FROM Documentos WHERE id_documento=$id_documento AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="DOCUMENTO" ;
 
  
$links["tipo_entidad"] =["../include/ficha_entidad.php?tipo_entidad={$rs["tipo_entidad"]}&id_entidad=", "id_entidad", "ver entidad asociada al documento (Factura, albarán, ...)", 'formato_sub'] ;
//  $links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//  $links["RAZON_SOCIAL"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea 
// $selects["id_linea_avales"]=["id_linea_avales","banco","Lineas_Avales"] ;   // datos para clave foránea 

 $formats["tamano"] = "kb" ;
 $id_documento=$rs["id_documento"] ;
 $path_archivo=$rs["path_archivo"] ;
 $tipo_entidad=$rs["tipo_entidad"] ;
 
 
// $rs["info_imagen"] = hex2bin($rs["info_imagen"]);

 $rs["info_imagen"] = json_decode(hex2bin($rs["info_imagen"]),true) ;  // decodifico de HEX a BIN y paso de strong_json a array
 
 
// $info_imagen= json_decode($rs["info_imagen"]) ;
 
//echo 'PRE:<BR/>'.'PRE:<BR/>'.'PRE:<BR/>'.'PRE:<BR/>'.'PRE:<BR/>'.'PRE:<BR/>'.$rs["info_imagen"]."<br>";
//echo '<pre>';
////print_r(exif_read_data($path_archivo));
//print_r($info_imagen);
//echo '</pre>';
//echo 'var_dump <br>';
//echo gettype ($rs["info_imagen"])."<br>" ;
echo strlen($rs["info_imagen"])."<br>" ;
//echo gettype ($info_imagen)."<br>" ;
//echo json_last_error_msg() ;

//$json = mb_convert_encoding($json, "UTF-8");
//$rs["info_imagen"] = preg_replace('/[[:^print:]]/', '', $rs["info_imagen"]);
//var_dump(json_decode(mb_convert_encoding($rs["info_imagen"], "UTF-8"),true)) ;
//echo json_last_error_msg() ;




 if (like($tipo_entidad,'obra_%'))
 {
  $selects["id_entidad"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","id_entidad"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $etiquetas["id_entidad"]="OBRA" ;
 }      
 
 
 $visibles=["id_documento"] ;
 $etiquetas["id_documento"]="ID_DOCUMENTO" ;
 $tooltips["id_documento"]="El ID_DOCUMENTO puede utilizarse para importar un documento a una Entidad" ;
 $formats["info_imagen"]="array_pre" ;
 
  $updates=['fecha_doc','documento','Observaciones',"id_entidad", "orden"]  ;
//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="Documentos" ;
  $id_update="id_documento" ;
  $id_valor=$id_documento ;
//  $delete_boton=1 ;
  $boton_cerrar=1 ;
  

$href_90="../documentos/doc_rotar_ajax.php?id_documento=$id_documento&path_archivo=$path_archivo&grados=90" ;
$href_270="../documentos/doc_rotar_ajax.php?id_documento=$id_documento&path_archivo=$path_archivo&grados=270" ;
$href_OCR="../documentos/doc_texto_ocr.php?id_documento=$id_documento" ;
//        echo "<a class='btn btn-primary' href='$href' target='_blank'><span class='glyphicon glyphicon-trash' ></span> GIRAR 90G22</a> "; 
echo "<br><br><br><br><br><br><a class='btn btn-primary' href=# onclick=\"js_href( '$href_270'  )\"><i class='fas fa-undo'></i> GIRAR -90º</a> "; 
echo "<a class='btn btn-primary' href=# onclick=\"js_href( '$href_90'  )\"><i class='fas fa-redo'></i> GIRAR 90º</a> "; 
//echo "<a class='btn btn-primary' href=# onclick=\"js_href( '$href_OCR'  )\">OCR</a> "; 
echo "<a class='btn btn-primary' target='_blank' href='../documentos/doc_texto_ocr.php?id_documento=$id_documento'>OCR</a> "; 
echo "<a class='btn btn-danger' href=# onclick=\"delete_doc( {$rs["id_documento"]} ,'{$rs["path_archivo"]}')\"><i class='far fa-trash-alt'></i> ELIMINAR DOCUMENTO</a> "; 
 
 // proceso METADATOS
  
$patrones['cif']= "~\s([A-z])\s?[- \.]?\s?(\d{8})\s|(\d{8}[A-z])|([A-z])\s?[- \.]?\s?(\d{2})\s?[- \.]\s?(\d{3})\s?[- \.]\s?(\d{3})"
                                                        . "|(\d{2})\s?[- \.]?\s?(\d{3})\s?[- \.]?\s?(\d{3})\s?[- \.]?\s?([A-z])~" ;
$patrones['fecha']=  "~\s(\d{2})\s?([-])\s?(\d{2})\s?([-])\s?(\d{4}|\d{2})\s|\s(\d{2})\s?([ ])\s?(\d{2})\s?([ ])\s?(\d{4})\s"
                . "|(\d{2})\s?([\/])\s?(\d{2})\s?([\/])\s?(\d{4}|\d{2})\s|\s(\d{2})\s?([.])\s?(\d{2})\s?([.])\s?(\d{4}|\d{2})\s~";
$patrones['importe']= "~(\d{1,3}?)\s?\.?\s?(\d{1,3})\s?([\,\.])\s?(\d{2})\s(€)?~"  ;
$patrones['email']="/[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/"   ;
//$patrones['iban']="/(ES\d\d)\s?(\d{4})\s?(\d{4})\s?(\d{4})\s?(\d{4})\s?(\d{4})/"       ;
$patrones['iban']="~(ES\d\d)\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})\s?[-]?\s?(\d{4})|(ES\d\d)\s?(\d{4})\s?(\d{4})\s?(\d{2})\s?(\d{10})~"       ;
//$patrones['iban']="~(ES\d\d)\s?(\d{4})\s?(\d{4})\s?(\d{2})\s?(\d{10})~"       ;
$patrones['tel']= "~\s(\d{9})\s|\s(\d{3})\s?([- .])\s?(\d{3})\s?([- .])\s?(\d{3})\s|\s(\d{3})\s?([- .])\s?(\d{2})\s?([- .])\s?(\d{2})\s?([- .])\s?(\d{2})\s~";


//$palabras=explode(" ","FACTURA TOTAL IMPORTE FECHA SUMA BASE IMPONIBLE NUM FRA CIF IBAN CCC NUMERO LIQUIDO PERCIBIR"); 
//
////ILUMINAMOS EN NEGRITA LAS PALABRAS
$rs["metadatos"] = preg_replace("/(FACTURA)|(CLIENTE)|(TOTAL)|(IMPORTE)|(FECHA)|(SUMA)|(BASE)|(IMPONIBLE)"
        . "|(NUM)|(FRA)|(CIF)|(IBAN)|(CCC)|(NUMERO)|(LIQUIDO)|(PERCIBIR)/i"
        ,"<font color='green'>$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20</font>",$rs["metadatos"]);

//$patrones = [$patron_cif , $patron_fecha ,  $patron_tel  ,$patron_importe  , $patron_email , $patron_iban ]; 
       
$replaces = " <span style='color:blue;cursor:pointer;' title='copy' "
        . " onclick=\"copyToClipboard('$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20');this.style.color = 'grey'\" >$1$2$3$4$5$6$7$8$9$10$11$12$13$14$15$16$17$18$19$20</span> "; 

//HACEMOS LA SUSTITUCION
$rs["metadatos"] = preg_replace($patrones,$replaces,$rs["metadatos"]);
  
// fin metadatos  
 

  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" > 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
 <!--<div class="right2">-->
 
 <!--<div  style="background-color:black;float:left;width:60%;padding:0 20px;" >-->
 <div  style="background-color:white;float:left;width:60%;padding:0 20px;" >

	
<?php 


//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
// 
//header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado

////  WIDGET DOCUMENTOS 
//$tipo_entidad='aval' ;
//$id_entidad=$id_aval ;
////$id_subdir=$id_cliente ;
//$id_subdir=0 ;
//$size='400px' ;
//require("../include/widget_documentos.php");


//        $id_imagen="img_" . $rs["id_documento"] ;

//<img style="border:10px solid black;" src="http://www.html.am/images/image-codes/milford_sound_t.jpg" width="225" height="151" alt="Photo of Milford Sound in New Zealand" />


//        echo "<a class='btn btn-primary' href=\"{$rs["path_archivo"]}\" target='_blank' title='descargar Original'><i class='fas fa-cloud-download-alt'></i></a>" ;


//        $tamano=trim(cc_format(filesize("{$rs["path_archivo"]}")/1024,'fijo')) ;
//        $tamano=number_format(filesize("{$rs["path_archivo"]}")/1024,1,".",",") ;
//        number_format($valor,1,".",",")
        
        

        
//        $tamano=cc_format(filesize("{$rs["path_archivo"]}_small.jpg"),"kb") ;
//        echo "<br><br><h3>Tamaño Small ($tamano) </h3>" ;
//        echo "<button type='button' class='btn btn-default btn-sm' onclick=down_img_size(document.getElementById('small'))  title='disminuir tamaño imagen'><i class='fas fa-search-minus'></i></button>" ;
//        echo "<button type='button' class='btn btn-default btn-sm' onclick=up_img_size(document.getElementById('small')) title='aumentar tamaño imagen' ><i class='fas fa-search-plus'></i></button>" ;        
//        echo "<br><a href=\"{$rs["path_archivo"]}\" target='_blank' ><img id='small' style='border:3px solid red;' src=\"{$rs["path_archivo"]}_small.jpg\"></a>" ;

//        $tamano=number_format(filesize("{$rs["path_archivo"]}_medium.jpg")/1024,1,".",",") ;
        $tamano=cc_format(filesize("{$rs["path_archivo"]}_medium.jpg"),"kb") ;
        
        echo "<br><br><h3>Tamaño Medium ($tamano)</h3>" ;        
        echo "<button type='button' class='btn btn-default btn-sm' onclick=down_img_size(document.getElementById('medium'))  title='disminuir tamaño imagen'><i class='fas fa-search-minus'></i></button>" ;
        echo "<button type='button' class='btn btn-default btn-sm' onclick=up_img_size(document.getElementById('medium')) title='aumentar tamaño imagen' ><i class='fas fa-search-plus'></i></button>" ;
	echo "<br><a href=\"{$rs["path_archivo"]}_medium.jpg\" target='_blank' ><img id='medium'  style='border:3px solid red;'  src=\"{$rs["path_archivo"]}_medium.jpg\"></a>" ;
        
        
//        $tamano=number_format(filesize("{$rs["path_archivo"]}_large.jpg")/1024,1,".",",") ;
        $tamano=cc_format(filesize("{$rs["path_archivo"]}_large.jpg"),"kb") ;
        echo "<br><br><h3>Tamaño Large ($tamano)</h3>" ;                
        echo "<button type='button' class='btn btn-default btn-sm' onclick=down_img_size(document.getElementById('large'))  title='disminuir tamaño imagen'><i class='fas fa-search-minus'></i></button>" ;
        echo "<button type='button' class='btn btn-default btn-sm' onclick=up_img_size(document.getElementById('large')) title='aumentar tamaño imagen' ><i class='fas fa-search-plus'></i></button>" ;
	echo "<br><a href=\"{$rs["path_archivo"]}_large.jpg\" target='_blank' ><img id='large'  style='border:3px solid red;'  src=\"{$rs["path_archivo"]}_large.jpg\"></a>" ;

        if (file_exists($rs["path_archivo"]))
        {    
            $tamano=cc_format(filesize("{$rs["path_archivo"]}"),"kb") ;
            echo "<br><br><h3>Tamaño Original ($tamano) </h3>" ;
            echo "<button type='button' class='btn btn-default btn-sm' onclick=down_img_size(document.getElementById('original'))  title='disminuir tamaño imagen'><i class='fas fa-search-minus'></i></button>" ;
            echo "<button type='button' class='btn btn-default btn-sm' onclick=up_img_size(document.getElementById('original')) title='aumentar tamaño imagen' ><i class='fas fa-search-plus'></i></button>" ;
            echo "<button type='button' class='btn btn-danger btn-sm' onclick=js_href('../documentos/doc_borrar_original_ajax.php?id_documentos=$id_documento') title='borrar solo Original dejando las copias reducidas.\n Sirve para ahorrar espacio.' >Borrar solo Original</button>" ;
            echo "<br><a href=\"{$rs["path_archivo"]}\" target='_blank' ><img id='original'  style='border:3px solid red;'  src=\"{$rs["path_archivo"]}\"></a>" ;
        }
        else{
            echo "<br><br><h3> ORIGINAL NO ARCHIVADO </h3>" ;
        }
            
        


 ?>
	 
</div>	     
	
	
<?php  

$Conn->close();

?>
	 
<script>
function delete_doc(id_documento,path_archivo) {
    var nuevo_valor=window.confirm("¿Borrar documento? ");
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
       cadena_link="tabla='Documentos'&wherecond=id_documento=".id_documento ; 
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  
//            alert(this.responseText) ;     //debug
           location.reload(true); }  // refresco la pantalla tras edición
      }
  };
  xhttp.open("GET", "../documentos/delete_doc_ajax.php?id_documento="+id_documento+"&path_archivo="+path_archivo, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
    
function down_img_size(id_imagen) {
   
    $( id_imagen ).css( "width", "-=100" );
}

function up_img_size(id_imagen) {

    $( id_imagen ).css( "width", "+=100" );

}

</script>
</div>

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

