<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;   // AND $where_c_coste 

?>
<HTML>
<HEAD>
	<META NAME="GENERATOR" Content="NOTEPAD.EXE">
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
 
<BODY>
<?php //if ($_SESSION['logado']=="0") {  header("Location: "."../cerrar_sesion.asp");} ?>
   
<div align=center class="encabezadopagina2">Estudio Ficha Nueva</div>

<P align=center>

<?php $update=$_GET["update"];
	
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
require_once("../documentos/doc_function.php");


// Creo ficha Nueva

  $titulo2="ESTUDIO (nueva)";
  $nombre=$_POST["NOMBRE"];
  $observaciones=$_POST["Observaciones"];
  $expediente='' ;
  
  
//  echo isset($_FILES["xml_file"])  ;
//  echo $_FILES["xml_file"]["name"]  ;
  
  
 // ACTUAMOS VIA XML DE la plataforma contrataciondelestado.es
// if ($_POST["target_text"] OR $_POST["xml_url_file"] OR (isset($_FILES["xml_file"]) ) ) 
// if ( $_POST["xml_url_file"] OR (isset($_FILES["xml_file"]) ) ) // ANULADO LA OPCION DE SUBIR XML, SOLO POR URL
 if ( $_POST["xml_url_file"]  ) 
 {    
             if ($_POST["xml_url_file"])  // importamos de URL del XML
             {
                $arrContextOptions=array(
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                ),
                );  

            // ATENCION!! para adaptarnos a la web https://contrataciondelestado.es cambiamos en la URL la cadena 'myconnect' por la cadena 'connect'   
            $xml_url_file=str_replace('myconnect','connect',$_POST["xml_url_file"])    ;

            $target_text = file_get_contents($xml_url_file, false, stream_context_create($arrContextOptions));

            //  die()  ;
            //    $target_text= file_get_contents_curl($_POST["xml_url_file"]) ;
            //  echo  $target_text; 

             }   
//             elseif ($_POST["target_text"])  // importamos de XML en una variable texto
//             {
//                $target_text=$_POST["target_text"];
//             }
           elseif (isset($_FILES["xml_file"]))     //      XML FILE   lo metemos automaticamente   por fichero XML
           {    
            //  echo $_FILES["xml_file"]["name"];
              $target_dir = "../../uploads/tmp";
             $target_file = $target_dir .strtotime("now"). basename($_FILES["xml_file"]["name"]);

             move_uploaded_file($_FILES["xml_file"]["tmp_name"], $target_file);

             echo "$target_file<BR>";
            //        $xml=simplexml_load_file($target_file) or die("Error: No se puede crear Objeto (juand)");


            //         $xml= simplexml_load_file($target_file);        // funcion original de PHP 
            //        $xml= simplexml_load_string_nons($target_file);       // funcin que evita los ns     simplexml_load_string_nons
                  $target_text= file_get_contents($target_file) ;
            //      $target_text= htmlspecialchars($target_text) ;




            //    }    
            // else
            //   {
            //        echo "Error al descargar archivo en el servidor: ".$_FILES["xml_file"]["error"];
            //    }
           }
            //    }
            //   }
           // EMPEZAMOS A IMPORTAR XML 

           $xml= simplexml_load_string(str_replace("c:","c_",  $target_text));       // funcin que evita los ns     simplexml_load_string_nons

            //          $xml= simplexml_load_file("https://contrataciondelestado.es/wps/wcm/connect/PLACE_es/Site/area/docAccCmpnt?srv=cmpnt&cmpntname=GetDocumentsById&source=library&DocumentIdParam=0b7d00fa-8fc3-4ee2-ad3f-8023f9ea7ede");
            //        $xml=simplexml_load_file('https://www.w3schools.com/xml/simplexsl.xml') or die("Error: No se puede crear Objeto (juand)");

                 // DEBUG
            //        echo "<pre>";
            //        print_r($xml);   
            //        echo "</pre>";


            //        foreach(libxml_get_errors() as $error) {
            //                echo "\t", $error->message;
            //                echo "error juand";
            //              }


                    // extraemos datos

            //        $f_presentacion=$xml->cac_TenderingProcess->cac_DocumentAvailabilityPeriod->cbc_EndDate ;
                    $f_presentacion= $xml->cac_TenderingProcess->cac_TenderSubmissionDeadlinePeriod->cbc_EndDate ?
                                      $xml->cac_TenderingProcess->cac_TenderSubmissionDeadlinePeriod->cbc_EndDate :
                                      $xml->cac_TenderingProcess->cac_ParticipationRequestReceptionPeriod->cbc_EndDate;       // prevemos que sea fecha de SOLICITUD en vez de ENTREGA
                                                            
//                    $hora_entrega=$xml->cac_TenderingProcess->cac_TenderSubmissionDeadlinePeriod->cbc_EndTime ;
                    $hora_entrega= $xml->cac_TenderingProcess->cac_TenderSubmissionDeadlinePeriod->cbc_EndTime ?
                                      $xml->cac_TenderingProcess->cac_TenderSubmissionDeadlinePeriod->cbc_EndTime :
                                      $xml->cac_TenderingProcess->cac_ParticipationRequestReceptionPeriod->cbc_EndTime;       // prevemos que sea fecha de SOLICITUD en vez de ENTREGA
                    
                    
                    $observaciones= '' ;
                    $observaciones .= $xml->cac_TenderingProcess->cac_ParticipationRequestReceptionPeriod->cbc_EndDate ? 'OJO: REQUIERE SOLICITUD PARTICIPACION\n' : '' ;
                   
                    
            //        $observaciones=$xml->cac_TendererQualificationRequest->cac_RequiredBusinessClassificationScheme->cac_ClassificationCategory->cbc_CodeValue ;

                    $nombre_completo=htmlspecialchars($xml->cac_ProcurementProject->cbc_Name) ;
                    $expediente=htmlspecialchars($xml->cbc_ContractFolderID) ;
                    $presupuesto=$xml->cac_ProcurementProject->cac_BudgetAmount->cbc_TaxExclusiveAmount ;
                    $plazo=$xml->cac_ProcurementProject->cac_PlannedPeriod->cbc_DurationMeasure  ;
            //        $observaciones.= $xml->cac_TenderingTerm->cac_TenderRecipientParty->cac_PartyName->cbc_Name ;
                    $xml_electronica=$xml->cac_TenderingProcess->cbc_SubmissionMethodCode ;
                    $observaciones.= $xml_electronica==1 ? ' ELECTRONICA ' :($xml_electronica==2 ? ' MANUAL(PAPEL) ' :($xml_electronica==3 ? ' MANUAL(PAPEL) y ELECTRONICA ' :'MODO PRESENTACION ERRONEO')) ;
                    $URL_licitacion=$xml->cac_TenderingProcess->cac_AdditionalDocumentReference->cac_Attachment->cac_ExternalReference->cbc_URI ;
                    $organismo=$xml->cac_ContractingParty->cac_Party->cac_PartyName->cbc_Name ;
                    $organismo_simple= strtoupper(  str_replace(['Ayuntamiento','Alcaldía','del','Gobierno','de','Junta','Pleno','Municipal','Local'],'',$organismo) );
                    $presupuesto_simple=trim(cc_format($presupuesto/1000,'fijo1')) ;

            //         $nombre= $nombre? $nombre : ( "es-".substr($nombre_completo, 0,40) );
                     $nombre= $nombre? $nombre : ( "ES-".substr($organismo_simple."->".$nombre_completo, 0,40-strlen($presupuesto_simple)-3).'..'.$presupuesto_simple.'k€' );

                    echo $f_presentacion ;  
                    echo '<br>' ;
                    echo $nombre_completo ; 
                    echo '<br>' ; 
                    echo $presupuesto ;
                    echo '<br>' ;

    
 
 }
else         // lo metemos manualmente
{
                    echo "NO HAY FILES"; 
                  $nombre=$_POST["NOMBRE"];
                  $f_presentacion=$_POST["F_Presentacion"];
                  $presupuesto=$_POST["PRESUPUESTO"];
                  $nombre_completo=$_POST["nombre_completo"];
                  $observaciones=$_POST["Observaciones"];
                  $plazo=$_POST["plazo"];
                  $presupuesto=dbNumero($presupuesto)  ;
                  //resto valores
                  $URL_licitacion='';
                  $expediente ='';
                  $hora_entrega='';
                  $organismo='';

 }
 
// YA HEMOS DEFINIDO LAS VARIABLES, CREAMOS EL ESTUDIO
//Calculo el numero de Estudio mayor
  
  $result=$Conn->query("SELECT MAX(numero) AS max_numero FROM `Estudios_de_Obra` WHERE $where_c_coste");
  $rs = $result->fetch_array();
  $numero=$rs["max_numero"]+1 ;
  echo "NUMERO:".$numero;
  //$fecha = date_create_from_format('j/m/Y', $f_presentacion);   // con el input type='date' ya viene al formato mysql
  //echo $fecha->format('Y-m-d');
  //$f_presentacion2=$fecha->format('Y-m-d');
  
  if (!$f_presentacion) {echo "<br><br><br><h1><font color=red>ERROR: FECHA PLAZO ENTREGA VACIA</font> </h1><br><br>" ; }

  $sql="INSERT INTO `Estudios_de_Obra` (id_c_coste,URL_licitacion, NUMERO,NOMBRE,EXPEDIENTE, `PLAZO ENTREGA`,hora_entrega,`presupuesto tipo`,`Plazo Proyecto`,provincia,`Nombre completo`,observaciones,Organismo, user)"
     . " VALUES ({$_SESSION['id_c_coste']} ,'$URL_licitacion', '$numero','$nombre','$expediente', '$f_presentacion','$hora_entrega','$presupuesto','$plazo','provincia','$nombre_completo','$observaciones','$organismo','{$_SESSION['user']}')";
  
//  echo $sql ;    
   $id_estudio=0;  
  if ($result=$Conn->query($sql)) $id_estudio=Dfirst("ID_ESTUDIO", "Estudios_de_Obra", "NUMERO=$numero AND $where_c_coste" );
 
$nombre_completo_url= urlencode("$nombre_completo ($organismo)")  ;
$presupuesto_iva=$presupuesto*1.21 ;
$link_anadir_obra_estudio= "../obras/obras_anadir.php?NOMBRE_COMPLETO=$nombre_completo_url"
                          . "&nombre_obra=$nombre&IMPORTE=$presupuesto_iva&ID_ESTUDIO=$id_estudio&tipo_subcentro=E"  ;

echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=$link_anadir_obra_estudio'>" ;

  
  

//// ANULADO .  PASAMOS DIRECTAMENTE A LA FICHA DE ESTUDIO  , juan mayo20
//if(!$f_presentacion)
//    {$f_presentacion=date("Y-m-d");} 
//    else
//     {$f_presentacion=substr($f_presentacion,0,10);}     


//echo  $target_text; 

?>


<!--    <br><br><a href="../estudios/estudios_ficha.php?id_estudio=<?php // echo $id_estudio;?>" > VER Ficha de Estudio</a>
    <br><a href="../estudios/estudios_buscar.php?" > VER Listado</a>
    <br><a href="../estudios/estudios_calendar.php?fecha=<?php // echo $f_presentacion;?>" > VER Calendario</a>
<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=estudios_calendar.php?fecha=<?php // echo $f_presentacion;?>"> -->

    <!--<br><button  class='btn btn-warning btn-lg noprint'  onclick="window.close()"/><i class='far fa-window-close'></i> cerrar ventana</button>-->
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>



