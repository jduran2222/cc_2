

<script>
    

//
//// ejecuta un href por ajax con posibilidad de reload, msg y aviso de ERROR
//function js_sql( sql,var1, var2) {
//   //valores por defecto
//     var1 = var1 || '';   // por defecto refrescamos
//     var2 = var2 || ''     ;        // por defecto no hay msg
//   
//    
////    alert("href: "+href) ;
//
//   document.body.style.cursor = 'wait';
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//   if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}
//        else
//        {  //alert(this.responseText) ;     //debug
//           if(reload){ location.reload(true);}       // si hay reload, refresco pantalla
//         }  // refresco la pantalla tras editar Producción
//            document.body.style.cursor = 'auto';
//
//   }
//  };
//  xhttp.open("GET", "../include/sql.php?sql="+sql+"&variable1="+var1+"&variable2="+var2, true);
//  xhttp.send();   
//  
//  return ;
//
//}  

/**
* This will copy the innerHTML of an element to the clipboard
* @param element reference OR string
*/
function copyToClipboard(e) {
    var tempItem = document.createElement('input');

    tempItem.setAttribute('type','text');
    tempItem.setAttribute('display','none');
    
    let content = e;
    if (e instanceof HTMLElement) {
    		content = e.innerHTML;
    }
    
    tempItem.setAttribute('value',content);
    document.body.appendChild(tempItem);
    
    tempItem.select();
    document.execCommand('Copy');

    tempItem.parentElement.removeChild(tempItem);
}


// carga en el innerHTML del elemento 'id' el resultado de ejecutar href.php  vía AJAX
function carga_ajax(id,href)
{
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText!="0"){$("#"+id).text(this.responseText);}      // si el resultado es distinto de CERO, rellenamos el badget
//       $("#"+id).innerHTML=this.responseText ;
       document.getElementById(id).innerHTML=this.responseText ;
      }
  };
//  xhttp.open("GET", "../include/dfirst_ajax.php?field="+field+"&tabla="+tabla+"&wherecond="+wherecond+"", true);       //hacemos la consulta ajax
  xhttp.open("GET", href, true);       //hacemos la consulta ajax
  xhttp.send();   
 }



 
 // hacemos un href SIN AJAX 
function js_href2( href,reload, msg, var1, var2 , var1_prompt_default, var2_prompt_default  ) { 
   //valores por defecto
                                // href  :  link a realizar con window.open()
     reload = reload || 1  ;   // 0 o 1 indica si hay que REFRESCAR. por defecto refrescamos
     msg = msg || ""     ;        // Mensaje informando por defecto no hay msg
     var1 = var1 || ""   ;             // var1  VARIABLE a incorporar al link, si empieza por PROMPT_MSG pregunta al usuario
     var2 = var2 || ""   ;        // var2         IDEM
     var1_prompt_default = var1_prompt_default || ""   ;             // var1 valor por defecto a mostrar en el PROMPT
     var2_prompt_default = var2_prompt_default || ""   ;        //   IDEM
     

//INICIALIZAMOS VARIABLES
var ejecutar= 1  ;  // por defecto ejecutamos el href
var var1_link = "" ;
var var2_link = "" ;


// estudiamos las casuisticas posibles
if (msg)          // si hay mensaje de Cofirmación, confirmo
    {  ejecutar= confirm(msg);
}         // confirmo si hay que confirmar
else if (var1.startsWith("PROMPT"))     /// comprobamos si var1 es PROMPT 
{
     nuevo_valor= var1_prompt_default?    window.prompt(var1,var1_prompt_default) :  window.prompt(var1)   ;
     var1_link =  "&variable1=" + nuevo_valor ;
     var ejecutar = (!(nuevo_valor === null)) ; 

     // comprobamos  tambien la var2 es PROMPT
     if (var2.startsWith("PROMPT"))     // hay que preguntar el valor a pasar al link
     {
         nuevo_valor=window.prompt(var2)   ;
         var2_link =  "&variable2=" + nuevo_valor ;
         var ejecutar = (!(nuevo_valor === null)) ; 
     }

}else if (var2.startsWith("PROMPT"))     // comprobamos si var2 es PROMPT 
{
     nuevo_valor= var2_prompt_default?    window.prompt(var2,var2_prompt_default) :  window.prompt(var2)   ;
     var2_link =  "&variable2=" + nuevo_valor ;
     ejecutar = (!(nuevo_valor === null)) ; 
}   



              
  if (ejecutar)   // si todo ha ido bien, ejecutamos el href
  {
     // si empieza por id_ añado el valor del INPUT id_...   , si es igual a 'table_selection_IN()' le incorporo la seleccion table_selection_IN()
     if (var1_link == "" )
     { 
         var1_link = var1.startsWith("id_") ?  "&variable1=" + document.getElementById( var1 ).value : (  var1.startsWith("table_selection_IN()") ? "&variable1=" + table_selection_IN() : "" ) ;  
     } 
     if (var2_link == "" )
     {
         var2_link = var2.startsWith("id_") ?  "&variable2=" + document.getElementById( var2 ).value : (  var2.startsWith("table_selection_IN()") ? "&variable2=" + table_selection_IN() : "" ) ;     
     }  
      
//   document.body.style.cursor = 'wait';
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//   if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}
//        else
//        {  //alert(this.responseText) ;     //debug
////           if(reload){ location.reload(true);}       // si hay reload, refresco pantalla
//           if(reload==1){ location.reload();}       // si hay reload, refresco pantalla
//         }  // refresco la pantalla tras editar Producción
//            document.body.style.cursor = "auto";
//
//   }
//  };
//  alert(href + var1_link + var2_link);
//  alert(href );


// terminamos de contruir el HREF, cambiamos el carácter & por la etiqueta _JS_AND_
href = href.replace( /_JS_AND_/g ,  "&" ) ;


//sustituimos las _VARIABLES_ si es que usamos este sistema
if (href.match(/_VARIABLE1_/g))
{   // sustituimos _VARIABLE1_ por el valor del url var1_link
    href = href.replace( "_VARIABLE1_" ,  var1_link.replace("&variable1=","") ) ;
    var1_link = "" ;
//    alert("hay _VARIABLE1_");
}  
            
if (href.match(/_VARIABLE2_/g))
{   // sustituimos _VARIABLE1_ por el valor del url var1_link
    href = href.replace( "_VARIABLE2_" ,  var1_link.replace("&variable2=","") ) ;
    var2_link = "" ;
}  

//    alert("href: "+href) ;

            
//  xhttp.open("GET", href + var1_link + var2_link, true);  // hacemos el href y eventualmente le añadimos dos parametros llamados variable 1 y 2 que el PHP sabá interpretar
//  alert( href + var1_link + var2_link );  // debug
  window.open( href + var1_link + var2_link, '_blank');  // sistema de abrir PHP directamente sin AJAX
//  document.body.style.cursor = "wait" ;
//  xhttp.send();  

  }
  return ;
//}
}    







// hacemos href con AJAX  
function js_href( href,reload, msg, var1, var2 , var1_prompt_default, var2_prompt_default  ) { 
   //valores por defecto
     reload = reload || 1  ;   // por defecto refrescamos
     msg = msg || ""     ;        // por defecto no hay msg
     var1 = var1 || ""   ;             // var 1  VARIABLE a incorporar al link
     var2 = var2 || ""   ;        // var 2
     var1_prompt_default = var1_prompt_default || ""   ;             // var 1  VARIABLE a incorporar al link
     var2_prompt_default = var2_prompt_default || ""   ;        // var 2
     
// ANULAMOS ESTE SISTEMA confuso. usamos la sustitucion de _VARIABLEX_ en el propio javascript
        // 
// por si usamos la modalidad de nombre de variable de URL
//     var1_name = var1_name || "variable1"   ;        // var 2
//     var2_name = var2_name || "variable2"   ;        // var 2
// 
//     var var1_url = "&" + var1_name + "="   ;        // var 2
//     var var2_url = "&" + var2_name + "="   ;        // var 2
 
 
 
 
//     var2 = var2 || ""   ;        // var 2
//     prompt = prompt || ''   ;        // var 2
// 
// 
// var nuevo_valor='' ;
    
//    alert("href: "+href) ;


//INICIALIZAMOS VARIABLES
var ejecutar= 1  ;  // por defecto ejecutamos el href
var var1_link = "" ;
var var2_link = "" ;


// estudiamos las casuisticas posibles
if (msg)          // si hay mensaje de Cofirmación, confirmo
    {  ejecutar= confirm(msg);
}         // confirmo si hay que confirmar
else if (var1.startsWith("PROMPT"))     /// comprobamos si var1 es PROMPT 
{
     nuevo_valor= var1_prompt_default?    window.prompt(var1,var1_prompt_default) :  window.prompt(var1)   ;
     var1_link =  "&variable1=" + nuevo_valor ;
     var ejecutar = (!(nuevo_valor === null)) ; 

     // comprobamos  tambien la var2 es PROMPT
     if (var2.startsWith("PROMPT"))     // hay que preguntar el valor a pasar al link
     {
         nuevo_valor=window.prompt(var2)   ;
         var2_link =  "&variable2=" + nuevo_valor ;
         var ejecutar = (!(nuevo_valor === null)) ; 
     }

}else if (var2.startsWith("PROMPT"))     // comprobamos si var2 es PROMPT 
{
     nuevo_valor= var2_prompt_default?    window.prompt(var2,var2_prompt_default) :  window.prompt(var2)   ;
     var2_link =  "&variable2=" + nuevo_valor ;
     ejecutar = (!(nuevo_valor === null)) ; 
}   



              
  if (ejecutar)   // si todo ha ido bien, ejecutamos el href
  {
     // si empieza por id_ añado el valor del INPUT id_...   , si es igual a 'table_selection_IN()' le incorporo la seleccion table_selection_IN()
     if (var1_link == "" )
     { 
         var1_link = var1.startsWith("id_") ?  "&variable1=" + document.getElementById( var1 ).value : (  var1.startsWith("table_selection_IN()") ? "&variable1=" + table_selection_IN() : "" ) ;  
     } 
     if (var2_link == "" )
     {
         var2_link = var2.startsWith("id_") ?  "&variable2=" + document.getElementById( var2 ).value : (  var2.startsWith("table_selection_IN()") ? "&variable2=" + table_selection_IN() : "" ) ;     
     }  
      
//   document.body.style.cursor = 'wait';
   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
   if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        {  //alert(this.responseText) ;     //debug
//           if(reload){ location.reload(true);}       // si hay reload, refresco pantalla
           if(reload==1){ location.reload();}       // si hay reload, refresco pantalla
         }  // refresco la pantalla tras editar Producción
            document.body.style.cursor = "auto";

   }
  };
//  alert(href + var1_link + var2_link);
//  alert(href );


// terminamos de contruir el HREF, cambiamos el carácter & por la etiqueta _JS_AND_
href = href.replace( /_JS_AND_/g ,  "&" ) ;


//sustituimos las _VARIABLES_ si es que usamos este sistema
if (href.match(/_VARIABLE1_/g))
{   // sustituimos _VARIABLE1_ por el valor del url var1_link
    href = href.replace( "_VARIABLE1_" ,  var1_link.replace("&variable1=","") ) ;
    var1_link = "" ;
//    alert("hay _VARIABLE1_");
}  
            
if (href.match(/_VARIABLE2_/g))
{   // sustituimos _VARIABLE1_ por el valor del url var1_link
    href = href.replace( "_VARIABLE2_" ,  var1_link.replace("&variable2=","") ) ;
    var2_link = "" ;
}  

//    alert("href: "+href) ;

            
  xhttp.open("GET", href + var1_link + var2_link, true);  // hacemos el href y eventualmente le añadimos dos parametros llamados variable 1 y 2 que el PHP sabá interpretar
//  alert( href + var1_link + var2_link );  // debug
//  windows.open( href + var1_link + var2_link, '_blank');  // sistema de abrir PHP directamente sin AJAX
  document.body.style.cursor = "wait" ;
  xhttp.send();  

  }
  return ;
//}
}    

  
function dbNumero(cifra)
{
//    /\d\d\d\d-\d\d-\d\d/.ejecutarc(text)
//    /\d\d\d\d-\d\d-\d\d/.test(text)  comprobamos si es fecha


  cifra=cifra.replace("€","");
  cifra=cifra.replace("eur","");
  cifra=cifra.replace("EUR","");
  cifra=cifra.replace("$","");
  cifra=cifra.replace(",",".");   // cambio comas por puntos
  cifra=cifra.replace(",",".");   // cambio comas por puntos
  cifra=cifra.replace(",",".");   // cambio comas por puntos
  cifra=cifra.replace(",",".");   // cambio comas por puntos
  cifra=cifra.replace(",",".");   // cambio comas por puntos
  cifra=cifra.replace(",",".");   // cambio comas por puntos

        cifra=cifra.trim() ;

  var n=cifra.lastIndexOf(".");
  
  if ( n == -1 ) //  no hay puntos decimales
  { 
      return cifra  ;
  }
  else
  {    
//  window.alert(n) ;
  
  cifra_entera = cifra.substr(0,n); 
  
//  window.alert(cifra_entera) ;
  
  
  cifra_entera=cifra_entera.replace(".","");   // quito puntos en parte enttera
  cifra_entera=cifra_entera.replace(".","");   // quito puntos en parte enttera
  cifra_entera=cifra_entera.replace(".","");   // quito puntos en parte enttera
  cifra_entera=cifra_entera.replace(".","");   // quito puntos en parte enttera
  cifra_entera=cifra_entera.replace(".","");   // quito puntos en parte enttera

//  window.alert(cifra_entera) ;

  cifra_final=cifra.substr(n,cifra.length);   

  return cifra_entera+cifra_final ;     
  }
//  return 1 ;     
 
  
//  
//  cifra_final= cifra.substr(-3,3);  //sacamos las últimas tres character
//  cifra_inicial= cifra.substr(0,cifra.length-3);  
//    
//  cifra_final=cifra_final.replace(",",".");
//  cifra_inicial=cifra_inicial.replace(",","");
//  cifra_inicial=cifra_inicial.replace(".",""); 
//            
  
  //alert(cifra_inicial+cifra_final) ;
    
}  


</script>

