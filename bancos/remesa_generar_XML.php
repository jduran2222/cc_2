<?php
ini_set("session.use_trans_sid",true);
ini_set("session.gc_maxlifetime",180000);
session_start();
if (!isset($_SESSION["id_c_coste"]))  // si no estamos logueados volvemos a index.php
{ header('Location: ../index.php'); }
 // coletilla a añadir a todas las SQL para garantizar que nunca mezclamos datos de dos empresas
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;  

//            FICHERO PHP PARA GENERAR REMESA DESDE UN ID_PAGO AMPLIABLE A REMESA DE VARIOS ID_PAGOS

//$id_remesa = $_GET["id_remesa"]; 


header("Content-type: text/xml");
//header("Content-type: text/txt");



require_once("../../conexion.php");
require_once("../include/funciones.php"); 


if (!($id_remesa=Dfirst("id_remesa","Remesas_View", " $where_c_coste AND id_remesa={$_GET["id_remesa"]} " ))){cc_die("ERROR INCOHERENCIA EN DATOS");} 







if ($rs=DRow("Remesas_View","id_remesa=$id_remesa AND $where_c_coste"))
{
    $f_vto=$rs["f_vto"];   
    
    
    // firmamos de forma automática la Remesa para evitar duplicar pagos por error
     $sql_update= "UPDATE `Remesas` SET firmada='1'  WHERE  id_remesa=$id_remesa  ; "  ;
     $Conn->query($sql_update) ;

   // actualizamos las id_cta_banco de cada pago
//    $id_cta_banco=Dfirst("id_cta_banco","Remesas_View","$where_c_coste AND id_remesa=$id_remesa") ;
    $id_cta_banco=$rs["id_cta_banco"] ;
    $sql_update= "UPDATE `PAGOS` SET id_cta_banco=$id_cta_banco  WHERE  id_remesa=$id_remesa AND id_cta_banco IN (select id_cta_banco from ctas_bancos where $where_c_coste) ; "  ;
    $Conn->query($sql_update) ;
 
    // actualizamos la F_VTO si está activada la variable Actualizar_f_vto
    if ($rs["Actualizar_f_vto"])
    {
         $f_vto=date("Y-m-d");   
         $sql_update= "UPDATE `Remesas` SET f_vto='$f_vto'  WHERE  id_remesa=$id_remesa  ; "  ;
         $Conn->query($sql_update) ;
    }
 
    
  if ($rs["tipo_remesa"]=='P')  // REMESA TIPO PAGO
  { 
    // CABECERA FICHERO REMESA.XML
    $remesa= "Remesa Pagos " . substr( $rs["remesa"] , 0, 20) ;
    $id_cta_banco=$rs["id_cta_banco"] ;
    $fecha=date('Y-m-d').'T'.date('H:i:s') ;
    $fecha_cargo=$f_vto;
    $num_pagos=$rs["num_pagos"] ;
    $importe=round($rs["importe"],2) ;
    $empresa=$_SESSION["empresa"] ;
    $cif= quita_simbolos($_SESSION["cif"]) ;
    $iban=quita_simbolos(Dfirst("N_Cta","ctas_bancos","id_cta_banco=$id_cta_banco")) ;
    $bic=Dfirst("bic","ctas_bancos","id_cta_banco=$id_cta_banco") ; ;

    // INICIAMOS EL XML
    $xml = "<?xml version='1.0' encoding='UTF-8'?>" ;
    $xml .= "<Document xmlns='urn:iso:std:iso:20022:tech:xsd:pain.001.001.03'>";
      $xml .= "<CstmrCdtTrfInitn>";
        $xml .= "<GrpHdr>";
          $xml .= "<MsgId>$remesa</MsgId>";
          $xml .= "<CreDtTm>$fecha</CreDtTm>";
          $xml .= "<NbOfTxs>$num_pagos</NbOfTxs>";
          $xml .= "<CtrlSum>$importe</CtrlSum>";
          $xml .= "<InitgPty>";
            $xml .= "<Nm>$empresa</Nm>";
            $xml .= "<Id>";
              $xml .= "<OrgId>";
                $xml .= "<Othr>";
                  $xml .= "<Id>$cif"."000</Id>";
                $xml .= "</Othr>";
              $xml .= "</OrgId>";
            $xml .= "</Id>";
          $xml .= "</InitgPty>";
        $xml .= "</GrpHdr>";
        $xml .= "<PmtInf>";
          $xml .= "<PmtInfId>SEPA REMESA1</PmtInfId>";
          $xml .= "<PmtMtd>TRF</PmtMtd>";
          $xml .= "<BtchBookg>false</BtchBookg>";
          $xml .= "<NbOfTxs>$num_pagos</NbOfTxs>";
          $xml .= "<CtrlSum>$importe</CtrlSum>";
          $xml .= "<PmtTpInf>";
            $xml .= "<SvcLvl>";
              $xml .= "<Cd>SEPA</Cd>";
            $xml .= "</SvcLvl>";
          if($rs["remesa_nominas"])  { $xml .= "<CtgyPurp><Cd>SALA</Cd></CtgyPurp>"; }           // codigo para NOMINAS
          $xml .= "</PmtTpInf>";
          $xml .= "<ReqdExctnDt>$fecha_cargo</ReqdExctnDt>";
          $xml .= "<Dbtr>";
            $xml .= "<Nm>$empresa</Nm>";
            $xml .= "<PstlAdr/>";
          $xml .= "</Dbtr>";
          $xml .= "<DbtrAcct>";
            $xml .= "<Id>";
              $xml .= "<IBAN>$iban</IBAN>";
            $xml .= "</Id>";
          $xml .= "</DbtrAcct>";
          $xml .= "<DbtrAgt>";
            $xml .= "<FinInstnId>";
              $xml .= "<BIC>$bic</BIC>";
            $xml .= "</FinInstnId>";
          $xml .= "</DbtrAgt>";
     // incluimos los APUNTES DE LOS PROVEEDORES
           $result2 = $Conn->query("SELECT * from Pagos_View WHERE id_remesa=$id_remesa AND $where_c_coste ");

    if ($result2->num_rows > 0)
    {
        // CABECERA FICHERO REMESA.XML
        while( $rs = $result2->fetch_array(MYSQLI_ASSOC))
        {       

        $proveedor= ($rs["RAZON_SOCIAL"])? $rs["RAZON_SOCIAL"] : $rs["PROVEEDOR"] ;
        $importe=round($rs["importe"],2) ;
        $observaciones_cargo=substr($rs["observaciones"],0,34) ;
        $observaciones_abono="$empresa {$rs["observaciones"]}" ;
        $observaciones_abono=substr($observaciones_abono,0,34) ;
    //    $fecha=date('Y-m-d H:i:s') ;    
        $iban=quita_simbolos($rs["IBAN"]) ;
        $bic=quita_simbolos($rs["BIC"]) ;


            $xml .= "<CdtTrfTxInf>";
            $xml .= "<PmtId>";
            $xml .= "<InstrId>$observaciones_cargo</InstrId>";
            $xml .= "<EndToEndId>NOTPROVIDED</EndToEndId>";
            $xml .= "</PmtId>";
            $xml .= "<Amt>";
            $xml .= "<InstdAmt Ccy='EUR'>$importe</InstdAmt>";
            $xml .= "</Amt>";
            $xml .= "<ChrgBr>SLEV</ChrgBr>";
            $xml .= "<CdtrAgt>";
            $xml .= "<FinInstnId>";
            $xml .= "<BIC>$bic</BIC>";
            $xml .= "</FinInstnId>";
            $xml .= "</CdtrAgt>";
            $xml .= "<Cdtr>";
            $xml .= "<Nm>$proveedor</Nm>";
            $xml .= "</Cdtr>";
            $xml .= "<CdtrAcct>";
            $xml .= "<Id>";
            $xml .= "<IBAN>$iban</IBAN>";
            $xml .= "</Id>";
            $xml .= "</CdtrAcct>";
            $xml .= "<RmtInf>";
            $xml .= "<Ustrd>$observaciones_abono</Ustrd>";
            $xml .= "</RmtInf>";
            $xml .= "</CdtTrfTxInf>";

          }


        $xml .= "</PmtInf>";
      $xml .= "</CstmrCdtTrfInitn>";
    $xml .= "</Document>";       

    }

}elseif($rs["tipo_remesa"]=='C')         // remesa tipo COBROS
{ 
    // CABECERA FICHERO REMESA.XML
    $remesa= "Remesa Cobros " . substr( $rs["remesa"] , 0, 20) ;
    $id_cta_banco=$rs["id_cta_banco"] ;
    $fecha=date('Y-m-d').'T'.date('H:i:s') ;
    $fecha_cobro=$f_vto;
    $num_pagos=$rs["num_pagos"] ;
    $ingreso=round($rs["ingreso"],2) ;
    $empresa=$_SESSION["empresa"] ;
    $cif= quita_simbolos($_SESSION["cif"]) ;
    $iban=quita_simbolos(Dfirst("N_Cta","ctas_bancos","id_cta_banco=$id_cta_banco")) ;
    $bic=Dfirst("bic","ctas_bancos","id_cta_banco=$id_cta_banco") ; 
    
    $sufijo="000" ;                                                            // el SUFIJO lo determina la entadad bancaria, habitualmente es 000
    $id_pais="ES" ;                                                            // el Identificador de pais, en ESPAÑA es 'ES'
    $identificador_acreedor = $id_pais . digito_control($cif."ES00") . $sufijo . $cif ;

    
    // INICIAMOS EL XML
    $xml = "<?xml version='1.0' encoding='UTF-8'?>" ;
    $xml .= "<Document xmlns='urn:iso:std:iso:20022:tech:xsd:pain.008.001.02'>";
      $xml .= "<CstmrDrctDbtInitn>";
        $xml .= "<GrpHdr>";
          $xml .= "<MsgId>$remesa</MsgId>";
          $xml .= "<CreDtTm>$fecha</CreDtTm>";
          $xml .= "<NbOfTxs>$num_pagos</NbOfTxs>";
          $xml .= "<CtrlSum>$ingreso</CtrlSum>";
          $xml .= "<InitgPty>";
            $xml .= "<Nm>$empresa</Nm>";
            $xml .= "<Id>";
              $xml .= "<OrgId>";
                $xml .= "<Othr>";
                  $xml .= "<Id>$identificador_acreedor</Id>";
                $xml .= "</Othr>";
              $xml .= "</OrgId>";
            $xml .= "</Id>";
          $xml .= "</InitgPty>";
        $xml .= "</GrpHdr>";
        $xml .= "<PmtInf>";
          $xml .= "<PmtInfId>SEPA REMESA1</PmtInfId>";
          $xml .= "<PmtMtd>DD</PmtMtd>";                     // REMESA COBROS ( cambia con respecto a pagos)
          $xml .= "<BtchBookg>true</BtchBookg>";
          $xml .= "<NbOfTxs>$num_pagos</NbOfTxs>";
          $xml .= "<CtrlSum>$ingreso</CtrlSum>";
          $xml .= "<PmtTpInf>";
            $xml .= "<SvcLvl>";
              $xml .= "<Cd>SEPA</Cd>";
            $xml .= "</SvcLvl>";
            $xml .= "<LclInstrm><Cd>CORE</Cd></LclInstrm>";        // especial para COBROS
            $xml .= "<SeqTp>RCUR</SeqTp>";                          // especial para COBROS
            $xml .= "<CtgyPurp><Cd>TRAD</Cd></CtgyPurp>";            // especial para COBROS
          $xml .= "</PmtTpInf>";
          $xml .= "<ReqdColltnDt>$fecha_cobro</ReqdColltnDt>";           // fecha solicitada de cobro
          $xml .= "<Cdtr>";
            $xml .= "<Nm>$empresa</Nm>";
//            $xml .= "<PstlAdr/>";                                // la eliminamos, nmo aparece en la SEMILLA
          $xml .= "</Cdtr>";
          $xml .= "<CdtrAcct>";                                    // cambiamos a CdtrAcct
            $xml .= "<Id>";
              $xml .= "<IBAN>$iban</IBAN>";
            $xml .= "</Id>";
          $xml .= "</CdtrAcct>";
          $xml .= "<CdtrAgt>";
            $xml .= "<FinInstnId>";
              $xml .= "<BIC>$bic</BIC>";
            $xml .= "</FinInstnId>";
          $xml .= "</CdtrAgt>";
     // incluimos los APUNTES DE LOS CLIENTES
    $result2 = $Conn->query("SELECT * from Pagos_View WHERE id_remesa=$id_remesa AND $where_c_coste ");

    if ($result2->num_rows > 0)
    {
        // CABECERA FICHERO REMESA.XML
        while( $rs = $result2->fetch_array(MYSQLI_ASSOC))
        {       

        $cliente=$rs["CLIENTE"] ;
        $ingreso=round($rs["ingreso"],2) ;
        $observaciones_cargo=substr($rs["observaciones"],0,34) ;
        $observaciones_abono="$empresa {$rs["observaciones"]}" ;
        $observaciones_abono=substr($observaciones_abono,0,34) ;
    //    $fecha=date('Y-m-d H:i:s') ;    
        $iban=quita_simbolos($rs["IBAN"]) ;
        $bic=quita_simbolos($rs["BIC"]) ;
        
        $mandato='mandato_'.$rs["ID_CLIENTE"] ;
//        $sufijo="000" ;                                                            // el SUFIJO lo determina la entadad bancaria, habitualmente es 000
//        $id_pais="ES" ;                                                            // el Identificador de pais, en ESPAÑA es 'ES'
//        $identificador_acreedor = $id_pais . digito_control($cif."ES00") . $sufijo . $cif ;



//            $xml .= "<CdtTrfTxInf>";
            $xml .= "<DrctDbtTxInf>";
            $xml .= "<PmtId>";
            $xml .= "<InstrId>$observaciones_cargo</InstrId>";
            $xml .= "<EndToEndId>NOTPROVIDED</EndToEndId>";
            $xml .= "</PmtId>";
//            $xml .= "<Amt>";      
            $xml .= "<InstdAmt Ccy='EUR'>$ingreso</InstdAmt>";
//            $xml .= "</Amt>";
//            $xml .= "<ChrgBr>SLEV</ChrgBr>";
            
            // nuevo en COBROS  DD
            $xml .= "<DrctDbtTx>" ;
            
            // mandatos
            $xml .= "<MndtRltdInf><MndtId>$mandato</MndtId><DtOfSgntr>2020-01-01</DtOfSgntr><AmdmntInd>false</AmdmntInd></MndtRltdInf>" ;
            $xml .= "<CdtrSchmeId><Id><PrvtId><Othr><Id>$identificador_acreedor</Id><SchmeNm><Prtry>SEPA</Prtry></SchmeNm></Othr></PrvtId></Id></CdtrSchmeId>" ;
            $xml .= "</DrctDbtTx>" ;
            // fin mandatos
            
            
            
//            $xml .= "<CdtrAgt>";
            $xml .= "<DbtrAgt>";
            $xml .= "<FinInstnId>";
            $xml .= "<BIC>$bic</BIC>";
            $xml .= "</FinInstnId>";
//            $xml .= "</CdtrAgt>";
            $xml .= "</DbtrAgt>";
//            $xml .= "<Cdtr>";
            $xml .= "<Dbtr>";
            $xml .= "<Nm>$cliente</Nm>";
//            $xml .= "</Cdtr>";
            $xml .= "</Dbtr>";
            $xml .= "<DbtrAcct>";
            $xml .= "<Id>";
            $xml .= "<IBAN>$iban</IBAN>";
            $xml .= "</Id>";
            $xml .= "</DbtrAcct>";
            $xml .= "<RmtInf>";
            $xml .= "<Ustrd>$observaciones_abono</Ustrd>";
            $xml .= "</RmtInf>";
//            $xml .= "</CdtTrfTxInf>";
            $xml .= "</DrctDbtTxInf>";

          }


        $xml .= "</PmtInf>";
      $xml .= "</CstmrDrctDbtInitn>";
    $xml .= "</Document>";       

    }
  // fin remesa COBROS
}
//Generamos el archivo
//$contenido = "Hola Mundo.";
//$file = $remesa . ".xml" ;
$file = str_replace(array('"', "'", "\\", ',', '/', '*', '?', '<', '>', '|', ':', ';'), '_', $remesa)  . ".xml"  ;  // quitamos simbolos incompatible al nombre de fichero
$f=fopen($file,"w");
fwrite($f,$xml);
fclose($f);

//     \ / : ? *  < > |

//$enlace = $archivo; 
header ("Content-Disposition: attachment; filename=".$file); 
header ("Content-Type: application/octet-stream"); 
header ("Content-Length: ".filesize($file)); 
readfile($file); 

$Conn->close();
}
