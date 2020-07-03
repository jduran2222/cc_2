<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"ejemplo.pdf\"");
passthru("htmldoc --embedfonts --format pdf --left 2.5cm --right 1.5cm --top 1.5cm --bottom 1.5cm " .
"--headfootsize 5 --header 'l' --footer 't' '/' " .
" --linkcolor '#0000FF' " .
"--size 'a4' --fontsize 10 --bodyfont Verdana --charset 8859-15 " .
"--webpage http://construwin.sw24.es/web/personal/parte_pdf.php?id_parte=25859");