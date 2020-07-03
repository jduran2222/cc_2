<?php



 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
$sql= decrypt2($_GET["sql"]) ;
$titulo= $_GET["titulo"] ;


$filename = $titulo .  date_format(date_create(),"Y-m-d")   . ".xls" ;
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename);
        


//$sql="SELECT PROVEEDOR,  CIF,N_FRA, IMPORTE_IVA ,'123.45' ,'123123' ,FECHA , pagada FROM Fras_Prov_View  WHERE PROVEEDOR LIKE '%POLMELLI%' AND FECHA >'2016-01-01'  "  ;

$result=$Conn->query($sql);

$primera_vez=1 ;

echo "<table>";

$re = "~        #delimiter
    ^           # start of input
    -?          # minus, optional
    [0-9]+      # at least one digit
    (           # begin group
        \.      # a dot
        [0-9]+  # at least one digit
    )           # end of group
    ?           # group is optional
    $           # end of input
~xD";


while($rs = $result->fetch_array(MYSQLI_ASSOC))               // tabla de valores
{    
   
     
     if ($primera_vez) 
     {   echo  "<tr>"  ;
         foreach ($rs as $clave => $valor)     
          {
            echo "<td>$clave</td>"      ;
          }
              
          echo  "</tr>"  ;
           $primera_vez=0 ;
     }     
     
     echo  "<tr>"  ;
     foreach ($rs as $clave => $valor)     
     {
         $td_style='';

         if (is_numero($valor) ) 
           { $valor= str_replace(".", ",", $valor) ; 
           }
           elseif(is_fecha($valor) ) 
           {    
            $valor= date_format(date_create($valor),"d/m/Y") ; 
//            $valor= date_format($valor,"dd/mm/YY") ; 
//            $td_style= "style='mso-number-format:\"mm/dd/yyyy\" ; '  ";
           }
           
           
           $valor_UTF=utf8_decode($valor);        // adecuamos los caracteres tilde y demás signos puntuación
           echo "<td $td_style>$valor_UTF</td>"      ;
     }
             
     echo  "</tr>"  ;
          
          
//             echo implode("\t", array_keys($rs)) . "\n"; }         // encabezados
    
//    echo implode("\t", array_values($rs)) . "\n";
//      echo  "<tr><td>" . implode("</td><td style=\"mso-number-format: \"0.00\"  ; \"  >", array_values($rs)) . "</td></tr>";
    
}
   
   
     
        
echo "</table>";
    
        
  ?>      