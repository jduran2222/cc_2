<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


$plantilla_html=isset($_GET["plantilla_html"])?  $_GET["plantilla_html"] : $_POST["plantilla_html"] ;
$array_plantilla_json=isset($_GET["array_plantilla_json"])?  $_GET["array_plantilla_json"] : $_POST["array_plantilla_json"] ;

$array_plantilla=json_decode($array_plantilla_json, true) ;        // decodificamos el JSON 


$ext=isset($_GET["ext"])? $_GET["ext"] : (isset($_POST["ext"])? $_POST["ext"] : "");
$tipo=isset($_GET["tipo"])? $_GET["tipo"] : (($ext=='.doc')?  "word" : (($ext=='.xls')?  "excel" : "" ) );
//$tipo=$_GET["tipo"];

$nombre_archivo=  str_replace(".html", "", $plantilla_html) ;

if ($ext==".doc" OR $ext==".xls" )         
{
 
header("Content-type: application/vnd.ms-$tipo; name='$tipo'"); /* Indica que tipo de archivo es que va a descargar */
header("Content-Disposition: attachment;filename={$nombre_archivo}{$ext}"); /* El nombre del archivo y la extensiòn */
header("Pragma: no-cache");
header("Expires: 0");
//header('Content-Type: text/html; charset=utf-8');
}
elseif ($ext==".pdf" )          // imprimimos directamente con un window.print(); 
{
echo "<script>window.print();</script>" ;     
}

 

require_once("../../conexion.php"); 
require_once("../include/funciones.php");



?>

<HTML>
<HEAD>
     <title>Generar doc</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>
<style type="text/css">
 
@page { margin: 1cm }
p { margin-bottom: 0cm; margin-top: 0cm; padding: 0cm; so-language: es-ES }
td p { margin-bottom: 0cm; so-language: es-ES }
a:link { so-language: es-ES }

    
    /******************** STYLE TABLA.php para poder dar formato a $TABLE ********************/

/*  <a> boton dentro_tabla prueba */ 
div.div_edit:hover {
  /*border: 1px solid lightblue;*/
    background-color: white;
    /*min-height: 50px;*/
}
div.div_edit {
  /*border: 1px solid lightblue;*/
    /*background-color: white;*/
    min-height: 50px;
}


.box_wiki{
    display: none;
    width: 100%;
}

a:hover + .box_wiki,.box_wiki:hover{
    display: block;
    /*position: relative;*/
    position: absolute;
    z-index: 100;
}

a.dentro_tabla {
    
  background: #eee; 
  color: grey; 
  /*display: inline-block;*/
  height: 20px;
  line-height: 20px;
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  -webkit-transition: color 0.2s;
  font-size: 7px ;
}
a.dentro_tabla_grande {
    
  background: #eee; 
  color: grey; 
  /*display: inline-block;*/
  height: 40px;
  line-height: 20px;
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  -webkit-transition: color 0.2s;
  font-size: 14px ;
}
a.dentro_tabla_ppal {
    
  background: #eee; 
  color: blue; 
  /*display: inline-block;*/
  /*height: 20px;*/
  /*line-height: 20px;*/
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  /*-webkit-transition: color 0.2s;*/
  font-size: 7px ;
}

	
	
table {
    /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
    /*font-family: "Verdana", Arial, Helvetica, sans-serif;*/
    border-collapse: collapse;
    /* tamaño fuente tabla */
    /*font-size: 0.8vw;*/                          
    width: 100%;
}

table td {
 
    /*text-align: center;*/
     border-bottom: 1px solid #ddd;
    padding: 3px;
    /*white-space: nowrap;*/
    /*height: 20px;*/
}

td.nowrap{
  white-space: nowrap;

}

 
 table  tr:hover {background-color: #ddd;}



table th {
        /*text-align: center;*/
     border: 1px solid #ddd;
    padding: 3px;
    /*height: 20px;*/

    /*cursor: pointer;*/
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center; 
    /*color del fondo de TH*/
    background-color: #F2F4F4;      
    /*color: white;*/
    font-weight: bold;
      white-space: nowrap;
  
    
 }
 
.float_left {
    /*border: 1px solid blue;*/
    float: left;
    cursor: pointer;
}

.textarea_tabla {
    /*height: 4em;*/
    width: auto;
    border-width: 0px ;

}

 
@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
   table {
    font-size: 4vw; 
  }
   div {
     overflow: scroll;
  }
  option {
   font-size: 4.2vw;   
  /*transform: scale(2);*/  
}
  
}

@media print{
    
    p { font-size: 1.7vw ; }
    
    a[href]:after {
      display: none;
      visibility: hidden;
   }
    
    textarea { border: none; resize: none;}
    
   .noprint{
       display:none;
   }
   .topnav{
       display:none;
   }
   
   .sidenav{
       display:none;
   }
   
/*   .glyphicon {
       display:none;
   }*/
   .dentro_tabla_ppal {
       display:none;
   }
   .dentro_tabla {
       display:none;
   }
   
   thead {
            display:table-header-group;
            margin-bottom:2px;
             /*padding-top: 500px ;*/
            
/*            top:8cm;*/
        }
   table td {
            border : none ;
            font-size: 8pt ;
            /*font-family:arial;*/
        }

} 

 
  @page
    {margin-top:3cm;
     margin-left:1.5cm;
     margin-right:1.5cm;
     margin-bottom:3cm;
     
    }
    
       @media print {
            div.divHeader {
                
                position: fixed;
                top: 0cm;
                /*padding-top: 500px ;*/
                padding-bottom: 500px ;
/*                height: 320px;
                display:block;*/
              
                
            }
            
            div.divFooter {
                position: fixed;
                bottom: 0cm;
                
                
            }
            
        }
        
           @media screen {
            div.divHeader {
                display: none;
            }
            
           div.divFooter {
                display: none;
            }
         }
   
  th.hide_id { display: none; }
  td.hide_id { display: none; }
  
     
    
  
    
    /******************** FIN STYLE TABLA ********************/

        @media print 
{
  a[href]:after { content: none !important; }
  img[src]:after { content: none !important; }
}


.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: black;
  color: grey;
  text-align: center;
}

</style>
 
<?php

//require_once("../../conexion.php"); 
//require("../menu/topbar.php");
//require_once("../menu/topbar.php");



// Include the main TCPDF library (search for installation path).
//require_once('../include/tcpdf/examples/tcpdf_include.php');

//$plantilla_html=$_GET["plantilla"] ;
//
//echo "<pre>" ;
//print_r ($array_plantilla);
//echo "</pre>" ;





//// ANULADO TODO EL TCPDF POR AHORA. EL PINTAR E IMPRIMIR A PDF FUNCIONA BIEN (aunque no sabemos mandar por email, por ahora)
//if (0)
//{    
//    require_once('../include/tcpdf/tcpdf.php');
//
//    // create new PDF document
//    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//
//    // set document information
//    $pdf->SetCreator(PDF_CREATOR);
//    $pdf->SetAuthor('Nicola Asuni');
//    $pdf->SetTitle('TCPDF Example 001');
//    $pdf->SetSubject('TCPDF Tutorial');
//    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
//
//    // set default header data
//    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//    $pdf->setFooterData(array(0,64,0), array(0,64,128));
//
//    // set header and footer fonts
//    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//
//    // set default monospaced font
//    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//
//    // set margins
//    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//
//    // no imprimimos los HEADER ni FOOTER
//    $pdf->setPrintHeader(false);
//    $pdf->setPrintFooter(false);
//
//    // set auto page breaks
//    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//
//    // set image scale factor
//    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//
//    // set some language-dependent strings (optional)
//    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
//            require_once(dirname(__FILE__).'/lang/eng.php');
//            $pdf->setLanguageArray($l);
//          }
//
//    // ---------------------------------------------------------
//
//    // set default font subsetting mode
//    $pdf->setFontSubsetting(true);
//
//    // Set font
//    // dejavusans is a UTF-8 Unicode font, if you only need to
//    // print standard ASCII chars, you can use core fonts like
//    // helvetica or times to reduce file size.
//    //$pdf->SetFont('dejavusans', '', 14, '', true);
//    $pdf->SetFont('dejavusans', '', 10, '', true);
//
//    // Add a page
//    // This method has several options, check the source code documentation for more information.
//    $pdf->AddPage();
//
//    // set text shadow effect
//    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0, 'depth_h'=>0, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
//
//    // Set some content to print
//    //$html = <<<EOD
//    //<img src="../../../img/construcloud128.jpg" >
//    //<h1>JUAN DURAN .Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
//    //<i>This is the first example of TCPDF library.</i>
//    //<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
//    //<p>Please check the source code documentation and other examples for further information.</p>
//    //<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
//    //EOD;
//
//
//}

//////$html= file_get_contents( dirname(__FILE__) .'../../plantillas/p.html' ) ;
$html= file_get_contents( "../plantillas/$plantilla_html" ) ;

// sustituimos el LOGO_EMPRESA        
$path_logo_empresa = ( $path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste")) ? $path_logo_empresa : "../img/no_logo.jpg" ;

// TCPDF
//$img_logo="<img width=\"300\" src=\"$path_logo_empresa\" >" ;
//$html = str_replace('@@LOGO_EMPRESA@@',$img_logo , $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos


$html = str_replace('@@LOGO_EMPRESA@@',$path_logo_empresa , $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos

// sustituimos cada CAMPO
foreach ($array_plantilla as $clave => $valor)
{

 if (substr($clave,0,4)=="HTML")    { $valor= urldecode($valor)  ; }  //los HTML vienen en formato urlencode
 if ($ext==".doc" OR $ext==".xls" ) { $valor=utf8_decode($valor);  }      // adecuamos los caracteres tilde y demás signos puntuación

$localizador='/@@'.strtoupper($clave).'@@/i'  ;
//$html = str_replace($localizador, $valor, $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos
$html = preg_replace($localizador, $valor, $html)  ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos
//$html .= "<br> $clave - $valor "   ;          // sustituyo cada posible localizador del HTML por su valor en la base de datos


//
//$html= str_replace('@@CIUDAD@@', 'Málaga', $html)  ;
//$html= str_replace('@@FECHA_LARGA@@', '26 de Febrero de 2.019', $html)  ;
} 

echo $html ;



// Print text using writeHTMLCell()
//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

//$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
//$pdf->Output('example_001.pdf', 'I');
//$pdf->Output('example_001.pdf', 'I');
//$pdf->Output($_SERVER['DOCUMENT_ROOT'] .'example_0012.pdf', 'I');

//$pdf->Output($plantilla_html .'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
