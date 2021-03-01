<script>

$(document).ready(function(){
$('th.columna_ficha').hide() ;  // por defecto, ocultamos la COLUMNA_FICHA
$('td.columna_ficha').hide() ;

if (<?php echo $_SESSION["android"];?>) { show_FICHA_ON();}
//   $('#chart_button<?php // echo $idtabla; ?>').click();
//   console.log("LISTO!!");
});

function show_ID_<?php echo $idtabla;?>()
 { 
//     alert('<?php echo $idtabla;?>');
// $('table th.hide').each( function() { $(this).show() ; }   );
// $('table td.hide').each( function() { $(this).show() ; }   );
if ( typeof show_ID.show == 'undefined' ) {
        // It has not... perform the initialization
        show_ID.show = 1;
    }
 

if ( show_ID.show == 1) 
{   
 $('th.hide_id_<?php echo $idtabla;?>').show() ;
 $('td.hide_id_<?php echo $idtabla;?>').show() ;
 show_ID.show = 0 ;
 }
 else
{   
 $('th.hide_id_<?php echo $idtabla;?>').hide() ;
 $('td.hide_id_<?php echo $idtabla;?>').hide() ;
 show_ID.show = 1 ;
 }
     
//  alert(show_ID.show);
//   alert('hola') ;
 
 
  return ;
}
function show_ID()
 { 
// $('table th.hide').each( function() { $(this).show() ; }   );
// $('table td.hide').each( function() { $(this).show() ; }   );
if ( typeof show_ID.show == 'undefined' ) {
        // It has not... perform the initialization
        show_ID.show = 1;
    }
 

if ( show_ID.show == 1) 
{   
 $('th.hide_id').show() ;
 $('td.hide_id').show() ;
 show_ID.show = 0 ;
 }
 else
{   
 $('th.hide_id').hide() ;
 $('td.hide_id').hide() ;
 show_ID.show = 1 ;
 }
     
  return ;
}

function show_FICHA()
 { 
     
// $('table th.hide').each( function() { $(this).show() ; }   );
// $('table td.hide').each( function() { $(this).show() ; }   );
if ( typeof show_FICHA.show == 'undefined' ) {
        // It has not... perform the initialization
        show_FICHA.show = 1;
    }
 

if ( show_FICHA.show == 1) 
{   
 $('th').hide() ;   // quitamos todas
 $('td').hide() ;
 $('th.columna_ficha').show() ;         // ponemos solo las fichas
 $('td.columna_ficha').show() ;
 show_FICHA.show = 0 ;
 }
 else
{   
 $('th').show() ;   // ponemos todas
 $('td').show() ;   
 $('th.hide_id_<?php echo $idtabla;?>').hide() ;      // ocultamos las ocultas tipo ID
 $('td.hide_id_<?php echo $idtabla;?>').hide() ;
 $('th.columna_ficha').hide() ;  // quitamos las FICHA
 $('td.columna_ficha').hide() ;
 show_FICHA.show = 1 ;
 }
     
//  alert(show_ID.show);
//   alert('hola') ;
 
 
  return ;
}
function show_FICHA_ON()
 { 
     
 $('th.class_<?php echo $idtabla;?>').hide() ;   // quitamos todas
 $('td.class_<?php echo $idtabla;?>').hide() ;
 $('th.class_<?php echo $idtabla;?>columna_ficha').show() ;         // ponemos solo las fichas
 $('td.class_<?php echo $idtabla;?>columna_ficha').show() ;
 
  return ;
}


function tabla_update_onchange(cadena_link, nuevo_valor, tipo_dato , elementId , idlabel_chk ) {
   //valores por defecto
     tipo_dato = tipo_dato || 'str'; 
     elementId = elementId || '';
     idlabel_chk = idlabel_chk || '';
      
//    alert(cadena_link+nuevo_valor) ; 
 
var refrescar=false ;  // en principio NO REFRESCAMOS , salvo que se necesite

 
// if (tipo_dato=='semaforo' || tipo_dato=='semaforo_not' || tipo_dato=='boolean')
 if (tipo_dato=='boolean')
 {
//        nuevo_valor= nuevo_valor ? 1 : 0  ;
        nuevo_valor= (nuevo_valor=='none') ? 1 : 0  ; // CAMBIO EL VALOR
        
        var display = (nuevo_valor) ? 'inline' : 'none'  ; // si es valor es 1 (true) 
        document.getElementById(elementId).style.display = display ;
       
    //    alert(document.getElementById(idlabel_chk).style.backgroundColor ) ;          //style.backgroundColor = "red"
        if (document.getElementById(idlabel_chk).style.backgroundColor == 'red')        // si es rojo lo pasamos a verde y al reves
            {document.getElementById(idlabel_chk).style.backgroundColor='green' ;}  
            else if (document.getElementById(idlabel_chk).style.backgroundColor=='green')
            { document.getElementById(idlabel_chk).style.backgroundColor='red' ;}   
            else if (document.getElementById(idlabel_chk).style.backgroundColor=='royalblue')
            { document.getElementById(idlabel_chk).style.backgroundColor='white' ;}   
            else if (document.getElementById(idlabel_chk).style.backgroundColor=='white')
            { document.getElementById(idlabel_chk).style.backgroundColor='royalblue' ;}   
 }
 else if (tipo_dato=='num')
 {
//   nuevo_valor=dbNumero(nuevo_valor)  ;
//   alert(nuevo_valor) ;
 } 
 
 
//  cadena_link=encodeURIComponent(cadena_link) ;
nuevo_valor=encodeURIComponent(nuevo_valor) ;
//alert(nuevo_valor) ;

     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange =
     function()
     {   if (this.readyState == 4 && this.status == 200)
         
         {    if (this.responseText.substr(0,5)=="ERROR")
               {
                   alert(this.responseText) ;
               }                   // mostramos el ERROR
               else
               {  
//                   alert(this.responseText) ;     //debug
                    if (elementId)
                    {
                      if (tipo_dato=='boolean'){
                          // repintamos el OK con el valor de la BD que ya hemos cambiado al inicio de la función
                        display = (this.responseText=='1') ? 'inline' : 'none'  ; // si es valor es 1 (true) 
                        document.getElementById(elementId).style.display = display ;
   
                      }else{
  //                        alert('dentro') ; 
                        document.getElementById(elementId).innerHTML = this.responseText ;
                        document.getElementById(elementId).value = this.responseText ;
                        }
                    }
                    if (refrescar)
                    {location.reload();
                    }                               // NO REFRESCOr la página (salvo  para comodidad del usuario 
                }  // refresco la pantalla tras edición
          }
      };

 xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+"&tipo_dato="+tipo_dato, true); 
 xhttp.send();   
   
}


function tabla_update_str(cadena_link, prompt, valor0, idcont,nuevo_valor, tipo_dato) {
    
 // apaño provisional y chapucero para calcular formulas en num   
     nuevo_valor = nuevo_valor || '';
     tipo_dato = tipo_dato || '';
     var cadena_tipo_dato='' ;   
    if (tipo_dato) {cadena_tipo_dato="&tipo_dato="+tipo_dato ;} // si es campo numérico lo paso a formato dbNumero  ej: 1254.51

//cadena_tipo_dato="&tipo_dato=num" ;

//        alert(idcont) ;
////    document.getElementById(idcont).innerHTML = 'FEDERICO' ;
//    alert( document.getElementById(idcont).innerHTML  );

    var refrescar=false ;  // en principio NO REFRESCAMOS , salvo que se necesite
    
    var valor0Num=dbNumero(valor0) ;
    var esNumero=(!isNaN(valor0Num)) ;
    //alert(esNumero) ;
    if (esNumero) {valor0=valor0Num ;} // si es campo numérico lo paso a formato dbNumero  ej: 1254.51
    
//    var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
    // el valor nuevo_valor es opcional, si no se pasa, se pregunta por él y se intenta NO REFRESCAR si todo va bien.
    if ( nuevo_valor === '' )
    {   
      nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
      refrescar=false ;  // NO REFRESCO la página para comodidad del usuario,comprobaré que el UPDATE ha sido exitoso por ajax.
    }   
   
    
    
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
//       if (esNumero) {nuevo_valor=dbNumero(nuevo_valor)  ;}        // vuelvo a dar formato dbNumero
         nuevo_valor=encodeURIComponent(nuevo_valor) ;

       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange =
     function()
     {   if (this.readyState == 4 && this.status == 200)
         
         {    if (this.responseText.substr(0,5)=="ERROR")
               { alert(this.responseText) ;
               }                   // mostramos el ERROR
               else
               {  
//                   alert(this.responseText) ;     //debug
                 document.getElementById(idcont).innerHTML = this.responseText ;
                 if (refrescar)
                 {location.reload();
                 }                               // NO REFRESCOr la página (salvo  para comodidad del usuario 
               }  // refresco la pantalla tras edición
          }
      };
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+cadena_tipo_dato, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

//funciones para el SELECT
function tabla_update_select_showHint_ENTER(pcont) {

// hago click en el primer elemento de la lista 'li'
document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0].click() ;

}   


function tabla_update_select_showHint(cadena_select_enc, prompt, valor0, pcont, otro_where, str) {
//    var nuevo_valor=window.prompt("Filtre la búsqueda y seleccione en la lista el nuevo "+prompt , valor0);
    var nuevo_valor=str;
    
    if (str.length < 3) { 
      document.getElementById(pcont).innerHTML = "";
    return;
    }

    
//    alert("el nuevo valor es: "+valor) ;
         
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                    // hay un error y lo muestro en pantalla
        else
        {   
//            alert(this.responseText) ;                                // debug
//            document.getElementById("sugerir").innerHTML = this.responseText;
            document.getElementById(pcont).innerHTML = this.responseText ; }  // "pinto" en el <div> el select options
//  
      }
  };
  
  xhttp.open("GET", "../include/select_ajax_showhint.php?tipo_pagina=tabla&url_enc="+cadena_select_enc+"&url_raw="+encodeURIComponent( nuevo_valor+"&otro_where="+otro_where) , true);
  xhttp.send();   
 
}   

//function onClickAjax(id_obra, nombre_obra) {
////alert(val);
////document.getElementById("obra").value = val;
//window.location="obras_ficha.php?id_obra="+id_obra+"&nombre_obra="+nombre_obra;
//
////$("#txtHint").hide();
//}
function tabla_select_onchange_showHint(id,cadena_link,href) {
 
    
    // valores por defecto    
 href = href || ""     ;        // por defecto no hay msg

       nuevo_valor=id ;      // es el id_valor seleccionado
       //       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  
            
            if (href)  {js_href(href,1) ; }   // si hay algún href lo ejecutamos al terminar el UPDATE y refrescamos
            location.reload(true); }  // refresco la pantalla tras edición
       
      }
   };
   xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
   xhttp.send();   
   
}  

// FIN  SELECT  SHOHINT *************




function tabla_down_font_size(idtabla) {
    $( idtabla ).css( "font-size", "-=3" );
//    $( ".tabla2" ).css( "font-size", "-=3" );
}

function tabla_up_font_size(idtabla) {
    $( idtabla ).css( "font-size", "+=3" );
//    $( "table" ).css( "font-size", "+=3" );
}


//$( "#up" ).on( "click", function() {
//
//  // parse font size, if less than 50 increase font size
////  D1 if ((size + 2) <= 50) {
//   $( "table" ).css( "font-size", "+=3" );
////  d2  $( "th" ).css( "font-size", "+=3" );
////  d2  $( "td" ).css( "font-size", "+=3" );
//// D1   $( "#font-size" ).text(  size += 3 );
//// D1   }
//});
//
//$( "#down" ).on( "click", function() {
//// D1 if ((size - 2) >= 8) {
//    $( "table" ).css( "font-size", "-=3" );
////     $( "th" ).css( "font-size", "-=3" );
////    $( "td" ).css( "font-size", "-=3" );
////// D1   $( "#font-size" ).text(  size -= 3  );
//// D1 }
//});
////  ---------------- FIN FONT-SIZE -------------
//  
//  
//  
//  
    // seleccion automatica de toda la tabla  
    function selectElementContents(el) {
        var body = document.body, range, sel;
        if (document.createRange && window.getSelection)
        {
            range = document.createRange();
            sel = window.getSelection();
            sel.removeAllRanges();
            try {
                range.selectNodeContents(el);
                sel.addRange(range);
            } catch (e) {
                range.selectNode(el);
                sel.addRange(range);
            }
            document.execCommand("copy");   //copiamos al portapapeles toda la selección
        } else if (body.createTextRange) 
        {
//            alert("debug") ;
            range = body.createTextRange();
            range.moveToElementText(el);
            range.select();
            range.execCommand("Copy");
        }
    }


// ANTIGUA FUNCION EXPORT_XLS , HOY FELIZMENTE ELIMINADA POR EXPORT_XLS.PHP DE FABRICACION PROPIA, juand, ene19     
//// function tabletoXLS(idtabla)
//// {
//////     var table_html = document.getElementById(idtabla).html() ;
////     window.open('data:application/vnd.ms-excel,' + table_html);
////      //window.open('data:application/csv,charset=utf-8,' +  $('#dvData').html());
////      e.preventDefault();   
////     
//     
//  $(document).ready(function() {
//$("#btnexport").click(function(e) {
//
//    var a = document.createElement('a');
//    //getting data from our div that contains the HTML table
//    var data_type = 'data:application/vnd.ms-excel';
////    var data_type = 'data:application/csv,charset=utf-8';
//    var table_div = document.getElementById('div3');
//    var table_html = table_div.outerHTML.replace(/ /g, '%20');
////    var n=(table_html.indexOf("JUAN"))+4 ;
////    var n=(table_html.indexOf(String.fromCharCode(8204))) ;
////    alert((n)) ;
////    alert(table_html.charCodeAt(n)) ;
//// 
//    var table_html = table_html.replace(/€/g, '');
////    var table_html = table_html.replace(/\u200C/g, "");  // quito characters limitador 
////    var table_html = table_html.replace(/'&zwnj;'/g, "Z");
//
////    alert(table_html.charCodeAt(n)) ;
////    alert(table_html.charAt(n)) ;
//    a.href = data_type + ', ' + table_html;
//    //setting the file name
//    a.download = 'download.xls';
//    //triggering the function
//    a.click();
//    //just in case, prevent default behaviour
//    e.preventDefault();
//});
//});
// 
     
     
     
     
   
   
   
     
function dblclick_col(e,input_id) {
  
//   alert(input_id) ;
//   alert($(e).prop('id')) ;
//   alert(typeof e) ;

var str = (typeof e === 'object') ? $(e).text() : e ;

//alert(str) ;

str = (str.match( /\d{4}-\d{2}-\d{2}/ ) ) ? str.substr(0,10) : str ;    //  si es FECHA solo cogemos el DATE, los prmeros 10 char

 if (input_id.indexOf("*"))                              // comprobamos si es del estiolo FECHA1 y FECHA2  (FECHA*)
 {
   document.getElementById(input_id.replace('*','1')).value=str ; 
   document.getElementById(input_id.replace('*','2')).value=str ; 
//   document.getElementById(input_id.replace('*','1')).value="2019-11-08" ; 
//   document.getElementById(input_id.replace('*','2')).value="2019-11-09" ; 
 }else
 {
  document.getElementById(input_id).value=str ;
//  document.getElementById("FECHA2").value="2019-11-08" ;
 }
 
// document.getElementById("form1").submit();
}

function sortTable(n, idtabla, c_sel) {
  var tfoot, table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(idtabla);
//  alert( n +'-'+idtabla+'-'+c_sel) ;
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  
 // alert('entro a ordenar. switching='+switching)  ;

  
  
 rows = table.getElementsByTagName("TR");
 tfoot= table.getElementsByTagName("TFOOT")[0].getElementsByTagName("TR");   //COMPROBAMOS SI HAY ÚLTIMA ROWS tfoot (TOTALES)
  
// alert(tfoot.length)       ;
 
  while (switching)
  {
     // alert('entro al while')  ;
     
    // Start by saying: no switching is done:
    switching = false;
//    rows = table.getElementsByTagName("TR");
//   ANULAMOS EL CAMBIO DE ICONO EN CABECEROS POR CONSUMIR MUCHOS RECURSOS (juand, ene19)
//    // control de cabeceros y flechas de Sort (juand, marzo-18)
//    //alert(rows[0].getElementsByTagName("TH")[n].innerHTML) ;             //DEBUG
////    var th=rows[0].getElementsByTagName("TH") ;  // COJO EL ARRAY DE CABECEROS TH
//    //alert(th.length)  ;
//    for (i = 0; i <= (th.length - 1 ); i++) 
//    {  // les quito a todos los cabeceros TH las flechas
//        //alert(th[i].innerHTML) ;      //debug
//        th[i].innerHTML = th[i].innerHTML.replace("▲","") ;  
//        th[i].innerHTML = th[i].innerHTML.replace("▼","") ;
////        th[i].innerHTML = th[i].innerHTML + "<span class='glyphicon glyphicon-resize-vertical'></span>" ;
//    }
//    if ( dir == "asc")       // pongo la flecha correspondiente al cabecero que ordenamos
//       {th[n-c_sel].innerHTML = th[n-c_sel].innerHTML + "▲"  ;}
//      else
//       {th[n-c_sel].innerHTML = th[n-c_sel].innerHTML + "▼"  ;}
//      // fin ANULACION control cabeceros  , juand ene19
    
    /* Loop through all table rows (except the
    first, which contains table headers): */
//    tfoot= table.getElementsByTagName("TFOOT");   //COMPROBAMOS SI HAY ÚLTIMA ROWS tfoot (TOTALES)
    //alert(tfoot.length) ;
    for (i = 1; i < (rows.length - 1 -tfoot.length ); i++)   //recorremos todas las filas menos las de totales que están al final
//    for (i = 1; i < (rows.length - 3); i++)   //recorremos todas las filas menos las de totales que están al final
    { 
          // alert('entro al for')  ;

          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */

          // alert('i + 1 ='+(i+1)); 

          x =  rows[i].getElementsByTagName("TD")[n] ;
          y =  rows[i + 1].getElementsByTagName("TD")[n] ;

          // alert('valor de y.innerHTML.toLowerCase() ='+y.innerHTML.toLowerCase()); 

    //      x = rows[i].getElementsByTagName("TD")[n].getElementById("valor_sort");
    //      y = rows[i + 1].getElementsByTagName("TD")[n].getElementById("valor_sort");


          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == "asc")
          {
                // alert('entro al if ASC i=')  ;

                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase())
                    {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch= true;
                     // alert('voy a hacer break')  ;
                      break;
                    }

          } else if (dir == "desc")
          {
                // alert('entro al if DESC')  ;

                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())
                    {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch= true;
                      // alert('voy a hacer break en desc')  ;
                      break;
                    }
          }
          // alert('fin bucle for')  ;

    }
    // alert('salgo del for '+shouldSwitch)  ;

    if (shouldSwitch)
    {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
      // alert('hago cambio filas')  ;
      
    } else
    {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          // alert('intento cambiar orden')  ;

          if (switchcount == 0 && dir == "asc") 
          {
                // alert('cambio orden a DESC DESC DESC')  ;
                dir = "desc";
                switching = true;
          }
    }
  }

}





function tabla_delete_row(cadena_link, id , confirm) {
    //valores por defecto
     id = id || '';
     confirm = confirm || '1';
   
    
    if (confirm=='1')                 // variable que permite no confirmar y borrar diectamente la fila
    {   var nuevo_valor=window.confirm("¿Borrar fila? "); }
   else {  var nuevo_valor=1; }
   
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  //alert(this.responseText) ;     //debug
          // si existe TR es que vamos a ocultar la fila TR sin refrescar , en otro caso, refrescamos
          if (id!='') {    $("#" + id).toggle('fast')  ;     }     // ocultamos la TR de forma transitoria
          else  {  location.reload(true); }
        }   
       
      }
  };
  xhttp.open("GET", "../include/delete_row_ajax.php?url_enc="+cadena_link, true);
  xhttp.send();   
   }
   else
   {return;}
   
}


 function table_selection()
 { var array_str="" ;
 $('table input:checkbox:checked').each(
    function() {
        
        if (!(array_str=="" )) array_str+= "-" ;
        if ($(this).val()!=0) array_str+= $(this).val() ;
        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
  
//   alert(array_str) ;
 
 
  return array_str;
}

function ver_table_selection()
 { var array_str="" ;
 $('table input:checkbox:checked').each(
    function() {
        
        if (!(array_str=="" )) array_str+= "-" ;
        array_str+= $(this).val() ;
        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
  
   alert(array_str) ;
 
 
  return array_str;
}



function table_selection_IN()
 { var array_str="(" ;
 $('table input:checkbox:checked').each(
    function() {
        
        if (!(array_str=="(" )) array_str+= "," ;   // meto el separador
        array_str+= "'" + $(this).val() + "'"  ;
        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
  
  array_str+= ")"  ;
//   alert(array_str) ;
 
 
  return array_str;
}

function selection_todoF(idtabla)
 { 
// var valor = document.getElementById("selection_todo").checked;

//alert("select todo");


// $('.table2 input:checkbox').each(
 $( '#' + idtabla + ' input:checkbox').each(
    function() {
         $(this)[0].checked = document.getElementById("selection_todo").checked ;
//        alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
   
  return ;
}

 
 
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!--GRAFICOS--> 


<script type="text/javascript">

  // GRAFICOS   Load the Visualization API and the corechart package.
  google.charts.load('current', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
//  google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  
//var data = new google.visualization.DataTable();

//    var options = {'title':'Gráfico',
//                   'width':2000,
//                   'height':1200};

  var data<?php echo $idtabla; ?>;
  var options<?php echo $idtabla; ?>;
  var chart<?php echo $idtabla; ?>;

  function drawChart<?php echo $idtabla; ?>() {

    // Create the data table.
//     data = new google.visualization.DataTable();
//    data.addColumn('string', 'Año');
//    data.addColumn('number', 'Facturacion');
//    data.addRows([
//      ['Setas', 3],
//      ['Onions', 1],
//      ['Aceitunas', 1],
//      ['Zucchini', 1],
//    ]);


 
// var data = new google.visualization.DataTable(
//   {
//     cols: [
//            {id: 'task', label: 'Employee Name', type: 'string'},
//            {id: 'startDate', label: 'Start Date', type: 'number'},
//            {id: 'linea2', label: 'linea2', type: 'number'}
//           ],
//     rows: [
//            { c: [  {v: 'Mike' }, {v: 15, f: 'etiqueta' }, {v: 15, f: 'etiqueta' }  ]    },
//            { c: [  {v: 'Bob'  }, {v: 14 }, {v: 14 }    ] },
//            { c: [  {v: 'Alice'}, {v: 18 }, {v: 38 }    ] },
//            { c: [  {v: 'Frank'}, {v: 25 }, {v: 15 }    ] },
//            { c: [  {v: 'Floyd'}, {v: 10 }, {v: 16 }    ] },
//            { c: [  {v: 'Fritz'}, {v: 30 }, {v: 40 }    ] } 
//           ]
//   }
//) 
//  
     data<?php echo $idtabla; ?> = new google.visualization.DataTable(  <?php echo "{ $json_cols_chart , $json_rows_chart } " ; ?> ) ;
  
  

    // Set chart options
     options<?php echo $idtabla; ?> = {'title':'<?php echo $titulo; ?>',
                   'width':800,
                   'height':400 ,
                   seriesType: 'bars'
                   <?php echo $serie_line_txt; ?>  };
//
    // Instantiate and draw our chart, passing in some options.
//    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
//    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
//     chart = new google.visualization.LineChart(document.getElementById('chart_div<?php echo $idtabla; ?>'));
//    chart<?php echo $idtabla; ?> = new google.visualization.ColumnChart(document.getElementById('chart_div<?php echo $idtabla; ?>'));
    chart<?php echo $idtabla; ?> = new google.visualization.ComboChart(document.getElementById('chart_div<?php echo $idtabla; ?>'));
    chart<?php echo $idtabla; ?>.draw(data<?php echo $idtabla; ?>, options<?php echo $idtabla; ?>);
  }
  
function boton_chart<?php echo $idtabla; ?>() {
    
//     data.addRows([
//      ['PSOE', 3],
//      ['IU', 1],
//      ['VOX', 1],
//      ['PODEMOS', 1],
//      ['UPYD', 4]
//    ]);

   //dataResponse is your Datatable with A,B,C,D columns        
var view<?php echo $idtabla; ?> = new google.visualization.DataView(data<?php echo $idtabla; ?>);
view<?php echo $idtabla; ?>.setColumns( JSON.parse( "["+ document.getElementById('view_setColumns<?php echo $idtabla; ?>').value + "]" ) ); //here you set the columns you want to display
//view.setColumns([ 0,1  ]); //here you set the columns you want to display

//Visualization Go draw!
//visualizationPlot.draw(view, options);
chart<?php echo $idtabla; ?>.draw(view<?php echo $idtabla; ?>, options<?php echo $idtabla; ?>);
//alert(document.getElementById('view_setColumns').value);  

}
  
  
  
//   PARA PODER OCULTAR COLUMNAS CON CHECKBOX
//   var hideSal = document.getElementById("hideSales");
//   hideSal.onclick = function()
//   {
//      view = new google.visualization.DataView(data);
//      view.hideColumns([1]); 
//      chart.draw(view, options);
//   }
//   var hideExp = document.getElementById("hideExpenses");
//   hideExp.onclick = function()
//   {
//      view = new google.visualization.DataView(data);
//      view.hideColumns([2]); 
//      chart.draw(view, options);
//   }

  
</script>
