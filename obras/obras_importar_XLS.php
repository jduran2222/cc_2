<?php
require_once("../include/session.php");
?>

<HTML>
    <HEAD>
        <META NAME="GENERATOR" Content="NOTEPAD.EXE">
        <title>Importar XLS</title>

        <!--<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />-->
        <meta http-equiv="content-type" content="text/html; charset=windows-1252">
        <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>--> 
        <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />-->
        <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
        
        <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

    </HEAD>
    <BODY>



        <?php
        $id_obra = $_GET["id_obra"];

//        require("../../conexion.php");
//        require_once("../include/funciones.php");
        require_once("../menu/topbar.php");
        ?>


        <div id="main" class="mainc">
<?php require("obras_menutop_r.php"); ?>	
                    <br><br><br>

            <h1>IMPORTAR PROYECTO DESDE .XLS</h1>

<?php
//$result=$Conn->query("SELECT * from Proyecto_View WHERE ID_OBRA=".$id_obra);
?>
            <STYLE>
                table, th, td {
                    border: 1px solid black;
                    padding: 15px; 
                    margin: 10px; 
                    text-align: center;
                }
            </STYLE>


            <center>

                <form action="obras_importar_XLS.php?id_obra=<?php echo $id_obra; ?>" method="POST" enctype="multipart/form-data">

<!--    <input type="checkbox" id="borrar_proyecto" name="borrar_proyecto" value="OFF"  />
 Borrar proyecto actual<br>-->
                    <table >
                        <tr><td colspan='7'><p>Copia/pega las celdas del XLS donde está el proyecto al area de texto con el formato de columnas de abajo.</p>
                                <p>No hay que copiar el encabezado, solo las celdas</p>
                                <p>Eliminar columnas o filas de subtotales o celdas agrupadas para evitar conflictos</p>
                                <p>Una vez copiado y pegado pulsa 'Importar'</p>
                            </td></tr>

                        <tr ><td >CAPITULO</td><td>CODIGO</td><td>UD</td><td>UNIDAD DE OBRA (UDO)</td><td>TEXTO UDO</td><td>MEDICION</td><td>PRECIO</td></tr>
                    </table>

<!--    <input type="textarea" name="file_XLS" value="" width="400" height="400" required="" />-->
                    <textarea rows='10' cols='100' id='file_XLS' name='file_XLS' /></textarea>
                    <br>
                    <button  class='btn btn-primary btn-lg' type="submit" form="form1" value="Submit">Importar</button>

                </form>
            </center>


<?php
if (isset($_POST["file_XLS"]))         //
{
    if (isset($_POST["borrar_proyecto"]))
    {
        if ($_POST["borrar_proyecto"])
        {//  BORRAMOS PROYECTO  
            // pendiente código para borrar proyecto  
        }
    }

    $file_XLS = $_POST["file_XLS"];


    if (!$file_XLS)
    {
        echo "XLS vacío, pruebe de nuevo<br>";
        // if everything is ok, try to upload file
    } else
    {

        $a_rowTxts = explode("\n", $file_XLS);
        echo "<br>INICIO DE IMPORTACIÓN";
        echo "<br>Número de filas encontradas:" . count($a_rowTxts);
        echo "<br>";

        $a_cells = [];
        $count = 0;        // contador
        //COLUMNAS:   CAPITULO   COD_PROYECTO   ud   UDO    TEXTO_UDO     MED_PROYECTO    PRECIO
        $capitulo0 = 'CAPITULO VACIO';
        foreach ($a_rowTxts as $a_rowTxt)
        {
            $a_cell = explode("\t", $a_rowTxt);         // explotamos cada fila a un array de celdas a_cell
            //control de fila
            if (count($a_cell) <> 7)
            {
                echo "<br>Error en fila. Faltan columnas: $a_rowTxt";
                $count++;
            } else
            {
//                   echo "<br>Error en fila. Capitulo vacío: $a_rowTxt";  
                // no hay capitulo, cojo el Capitulo anterior
                if ($a_cell[0] == '')
                {
                    $a_cell[0] = $capitulo0;
                } else
                {
                    // copio el capitulo a capitulo0 por si hay una linea vacia posteriomente
                    $capitulo0 = $a_cell[0];
                }
                $count++;

                $a_cells[] = $a_cell;           //añado la fila al arrray global
            }

            //     echo "<br>numero de celdas:". count($a_cell);
        }
        echo "<br><br><br>Filas importadas:" . count($a_cells);
        echo "<br><br><br>Filas con errores:" . $count;

        $count = 0;
        foreach ($a_cells as $c)
        {
            //COLUMNAS:   CAPITULO[0]   COD_PROYECTO[1]   ud[2]   UDO[3]    TEXTO_UDO[4]     MED_PROYECTO[5]    PRECIO[6]

            $capitulo = strtoupper(trim($c[0]));
            $id_capitulo = Dfirst("ID_CAPITULO", "Capitulos_View", "ID_OBRA=$id_obra AND UPPER(TRIM(CAPITULO))='$capitulo'");
//       $id_subobra= getVar("id_subobra_si") ;
            $id_subobra = Dfirst("id_subobra_auto", "OBRAS", "$where_c_coste AND ID_OBRA=$id_obra");
            $id_subobra = $id_subobra ? $id_subobra : getVar("id_subobra_si");


            $cod_proyecto = quita_simbolos_mysql($c[1]);
            $ud = quita_simbolos_mysql($c[2]);
            $udo = quita_simbolos_mysql($c[3]);
            $texto_udo = quita_simbolos_mysql($c[4]);


            $med_proyecto = dbNumero($c[5]);
            $precio = dbNumero($c[6]);


            // si el CAPITULO no existe lo creamos
            if (!$id_capitulo)
            {
                $values_insert_capitulo = "($id_obra , '$capitulo','{$_SESSION["user"]}')";
                $id_capitulo = DInsert_into("Capitulos", "(ID_OBRA, CAPITULO,user)", $values_insert_capitulo, "ID_CAPITULO", "ID_OBRA=$id_obra");
//       $id_subobra=DInsert_into("SubObras", "(ID_OBRA, SUBOBRA,user)", $values_insert , "ID_SUBOBRA", "ID_OBRA=$id_obra");
            }

            $values_insert = "($id_obra,$id_capitulo,$id_subobra,'$udo','$cod_proyecto','$ud','$texto_udo' ,'$precio','$precio','$med_proyecto' )";

            if (!DInsert_into("Udos", "(ID_OBRA,ID_CAPITULO,ID_SUBOBRA,UDO,COD_PROYECTO,ud,TEXTO_UDO,PRECIO,COSTE_EST,MED_PROYECTO)", $values_insert))  // ha existido error en la inserción
            {
                echo "<BR>ERROR insertando UDO. VALUES INSERT: $values_insert  ";
            } else
            {
//            echo "Insertada UDO OK. VALUES INSERT: $values_insert <BR>" ; 
                $count++;
            }
        }


//       if ($bc3 = file($target_file))
        if (0)
        {
//            $bc3[6]=utf8_encode($bc3[6]);//debug
//             $bc3[21]=utf8_encode($bc3[21]);//debug
//          //  echo ord($bc3[21][17]) ;//debug
//           echo '<BR>DEBUG<br>' ;//debug
//           echo ord($bc3[6][17]) ;//debug
//            echo ord($bc3[21][17]) ;//debug
//           echo '<BR>DEBUG<br>' ;//debug
//           //
            // inicializo arrays
            $capitulos = [];
            $udos = [];
            foreach ($bc3 as $key => $value)   // PRIMERA pasada al array para buscar capitulos, conceptos y textos
            {
                // $value=utf8_encode($value) ;
//               echo utf8_encode($value) ;  //debug
//                echo '<BR>' ;  //debug
                //$a = explode("|", $value) ;
                $cod_BC3 = substr($value, 0, 2);
                if ($cod_BC3 == "~C")           // estamos en un capítulo o concepto
                {
                    $a = explode("|", utf8_encode($value));
                    if (substr($a[1], -1) == "#")   // es capítulo
                    {
                        //$capitulos[str_replace("#","",$a[1])]["capitulo"]=$a[3] ;   //añado un capitulo con su key al array capitulos[]      //DEBUG JUAND
                        $capitulos[$a[1]]["capitulo"] = $a[3];   //añado un capitulo con su key al array capitulos[]      //DEBUG JUAND
                    } else                         // es un concepto. Lo registro en su array
                    {
                        $conceptos[$a[1]]["COD_PROYECTO"] = $a[1];
                        $conceptos[$a[1]]["ud"] = $a[2];
                        $conceptos[$a[1]]["UDO"] = $a[3];
                        $conceptos[$a[1]]["PRECIO"] = $a[4];
                    }
                }
                if ($cod_BC3 == "~T")           // estamos en un Texto de concepto
                {
                    $a = explode("|", utf8_encode($value));
                    //$conceptos[$a[1]]["TEXTO_UDO"] = $a[2] ; // mb_convert_encoding ( $cadena , "ASCII", "UTF-8");
                    //$conceptos[$a[1]]["TEXTO_UDO"] = mb_convert_encoding ( $a[2] , "ANSI", "UTF-8"); 
                    $conceptos[$a[1]]["TEXTO_UDO"] = $a[2];
                }
            }

            foreach ($capitulos as $key => $value)
            {
                $capitulo = substr($key, 0, -1) . " " . $value["capitulo"];
                $values_insert = "($id_obra , '$capitulo','{$_SESSION["user"]}')";
                echo "VALUES INSERT: $values_insert <BR>";
                $id_capitulo = DInsert_into("Capitulos", "(ID_OBRA, CAPITULO,user)", $values_insert, "ID_CAPITULO", "ID_OBRA=$id_obra");
                $id_subobra = DInsert_into("SubObras", "(ID_OBRA, SUBOBRA,user)", $values_insert, "ID_SUBOBRA", "ID_OBRA=$id_obra");

                echo "INSERTADO ID_CAPITULO $id_capitulo";
                $capitulos[$key]["id_capitulo"] = $id_capitulo;
                $capitulos[$key]["id_subobra"] = $id_subobra;
            }

            //   DEBUG
//           echo "<pre>" ;
//           print_r($capitulos) ;    
//           echo "</pre>" ;
//           echo "<pre>" ;
//           print_r($conceptos) ;    
//           echo "</pre>" ;
            //$id_subobra=getvar("id_subobra_si") ;

            $udos = [];
            foreach ($bc3 as $key => $value)   // SEGUNDA pasada al array para buscar ~D descompuestos (es decir, udos)
            {
                $cod_BC3 = substr($value, 0, 2);
                if ($cod_BC3 == "~D")           // estamos en un descompuesto (UDO)
                {
                    $a = explode("|", $value);
                    if (isset($capitulos[$a[1]]))     // es el descompuesto (udos) de un capítulo
                    {
                        $id_capitulo = $capitulos[$a[1]]["id_capitulo"];     // extraigo el id_capitulo 
                        $id_subobra = $capitulos[$a[1]]["id_subobra"];     // extraigo el id_subobra 
                        $d = explode("\\", $a[2]);       // fragmento el Descompuesto en un array donde cada 3 item es un udo
                        $i = 0;
                        while (isset($d[$i]))
                        {
                            if (isset($conceptos[$d[$i]]))           // si existe el concepto de la UDO , Inserto la UDO en su capítulo
                            {
                                $MED_PROYECTO = $d[$i + 2];
                                $c = $conceptos[$d[$i]];
                                $values_insert = "($id_obra,$id_capitulo,$id_subobra,'{$c["UDO"]}','{$c["COD_PROYECTO"]}','{$c["ud"]}','{$c["TEXTO_UDO"]}' ,{$c["PRECIO"]},{$c["PRECIO"]},$MED_PROYECTO )";

                                //$values_insert="($id_obra,$id_capitulo,$id_subobra,'UDO','ud','TEXTO_UDO' ,123,567 )";


                                if (!DInsert_into("Udos", "(ID_OBRA,ID_CAPITULO,ID_SUBOBRA,UDO,COD_PROYECTO,ud,TEXTO_UDO,PRECIO,COSTE_EST,MED_PROYECTO)", $values_insert))  // ha existido error en la inserción
                                {
                                    echo "ERROR insertando UDO. VALUES INSERT: $values_insert <BR>";
                                } else
                                {
                                    echo "Insertada UDO OK. VALUES INSERT: $values_insert <BR>";
                                }
                            } else
                            {
                                echo "ERROR Concepto no definido previamente en el BC3: id_capitulo=$id_capitulo , concepto: {$d[$i]} <BR>";
                            }
                            $i += 3;  //salto 3 índices
                        }
                    }
                }
            }

            // fin de importación
        }
    }
}
?>