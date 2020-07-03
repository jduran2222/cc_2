<?php
require_once("../include/session.php");


//            VERSION PARA IMPRESORA, PDF, EXCEL, WORD   

$ext = $_GET["ext"];

if ($ext <> "")
{

    $tipos["pdf"] = "pdf";
    $tipos["xls"] = "excel";
    $tipos["doc"] = "word";

    $tipo = $tipos[$ext];

    $app_tipo= ($ext=="pdf")? "pdf": "vnd.ms-$tipo" ;
            
    header("Content-Type: application/$app_tipo; name='$tipo'"); /* Indica que tipo de archivo es que va a descargar */
    header("Content-Disposition: attachment;filename=\"proyecto.$ext\""); /* El nombre del archivo y la extensiòn */
   // header("Content-Disposition:inline;filename=proyecto.$ext"); /* El nombre del archivo y la extensiòn */
    header('Content-Transfer-Encoding: binary'); // PROBANDO
    
    header("Pragma: no-cache");
    header("Expires: 0");
    
   // readfile("original.pdf");
}
else
{
    echo "<SCRIPT>window.print()</SCRIPT>" ;
}
?>



    



<HTML>
    <HEAD>
  <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	

    </HEAD>
    <BODY>
    
        <style>
            
            body{
                background-color: white;
                
            }
        </style>

<!--<input type="button" name="imprimir" value="Imprimir" onclick="window.print();">-->

<?php $id_obra = $_GET["id_obra"]; ?>

<?php //require("../menu/topbar.php");
?>


        <div id="main" class="mainc">
        <?php // require("obras_menutop_r.php");
        ?>	

            <h1>PROYECTO</h1>


<?php
require_once("../../conexion.php");

$result = $Conn->query("SELECT * from Proyecto_View WHERE ID_OBRA=" . $id_obra);
?>



            <TABLE>

<?php
$sumaCap = 0;
$PEM = 0;
$firstIdCapitulo = 0;

if ($result->num_rows > 0)
{
    while ($rs = $result->fetch_array())
    {
        if ($firstIdCapitulo != $rs["ID_CAPITULO"])   // cambiamos de Capitulo . encabezado y suma de capitulo.
        {
            if ($firstIdCapitulo)     // Si no es primer capitulo sumamos totales
            {
                ?>
                                <TR >
                                    <TD align=right>SUMA DE CAPITULO</TD>
                                    <TD></TD>
                                    <TD></TD>
                                    <TD></TD>
                                    <TD></TD>
                                    <TD></TD>
                                    <TD align=right><b><?php echo number_format($sumaCap, 2, ",", "."); ?></b></TD>
                                    <TD></TD>
                                </TR>
                <?php
                $PEM = $PEM + $sumaCap;
                $sumaCap = 0;
            } else
            {
                ?>
                                <TR>
                                    <TD style="font-size:10px;" > Unidad de Obra </TD>
                                    <TD style="font-size:10px;" > Med_proy </TD>
                                    <TD style="font-size:10px;" > Precio </TD>
                                    <TD style="font-size:10px;" > Coste_Est </TD>
                                    <TD style="font-size:10px;" > Estudio </TD>
                                    <TD style="font-size:10px;" > Importe </TD>
                                    <TD></TD>
                                    <TD style="font-size:10px;" > SubObra </TD>
                                </TR>



            <?php
            }
            $firstIdCapitulo = $rs["ID_CAPITULO"];
            ?>
                            <tr></tr>

                            <TR >
                                <TD >CAPITULO<b> <?php echo $rs["CAPITULO"]; ?></b></TD>
                                <TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD>
                            </TR>
                            <tr></tr>



        <?php } ?>

                        <TR>  
                            <TD ><?php echo $rs["ud"] . " " . $rs["UDO"]; ?> </TD>
                            <TD align=right> <?php echo number_format($rs["MED_PROYECTO"], 2, ",", "."); ?> </TD>
                            <TD align=right> <?php echo number_format($rs["PRECIO"], 2, ",", "."); ?> </TD>
                            <TD align=right> <?php echo number_format($rs["COSTE_EST"], 2, ",", "."); ?> </TD>
                            <TD > <?php echo $rs["Estudio_coste"]; ?> </TD>
        <?php $importe = $rs["MED_PROYECTO"] * $rs["PRECIO"]; ?> 
        <?php $sumaCap = $sumaCap + $importe; ?>
                            <TD align=right> <?php echo number_format($importe, 2, ",", "."); ?> </TD>
                            <TD></TD>
                            <TD style="color:grey;font-size:12px;"> <?php echo $rs["SUBOBRA"]; ?> </TD>
                        </TR>

                            <?php //$rs->movenext;  ?>
    <?php
    }
} else
{
    echo "Proyecto vacío";
}
?>

                <TR >
                    <TD></TD>
                    <TD></TD>
                    <TD></TD>
                    <TD></TD>
                    <TD></TD>
                    <TD align=right><b><?php echo number_format($sumaCap, 2, ",", "."); ?></b></TD>
                    <TD></TD>
                </TR>

<?php $PEM = $PEM + $sumaCap; ?>
                <TR >
                    <TD>TOTAL EJECUCION MATERIAL</TD>
                    <TD></TD>
                    <TD></TD>
                    <TD></TD>
                    <TD></TD>
                    <TD align=right><b><?php echo number_format($PEM, 2, ",", "."); ?></b></TD>
                    <TD></TD>
                </TR>

            </TABLE>

<?php
$Conn->close();
?>
        </div>
    </BODY>
</HTML>

