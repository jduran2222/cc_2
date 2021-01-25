<?php

    // JUAND
// Creación de un trozo de código para la gestión de Fras. Proveedor.
function selectoresMenu($array_menus) {
  
  $html = '';

    
  $html .= '<div class="col">';
    // $html .= '    <div class="d-flex align-content-center flex-wrap bg-secondary">';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#aplicarFiltros" role="button" aria-expanded="false" aria-controls="aplicarFiltros">Aplicar filtros</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#operarFrasSeleccionadas" role="button" aria-expanded="false" aria-controls="operarFrasSeleccionadas">Operar con facturas seleccionadas</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#agruparResultados" role="button" aria-expanded="true" aria-controls="agruparResultados">Agrupar resultados</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#verResumen" role="button" aria-expanded="false" aria-controls="verResumen">Ver resumen</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#formatos" role="button" aria-expanded="false" aria-controls="formatos">Formatos</a>';
    // $html .= '    </div>';
  $html .= '    <div class="row mt-2 mb-4">';
  foreach ($array_menus as $k => $v) 
  {
    $html .= '          <div class="col-12 align-content-center">';
    $html .= "              <a class='mt-2 col-12 btn btn-secondary' data-toggle='collapse' href='#menu_$k' role='button' aria-expanded='false' aria-controls='menu_$k'>{$v[1]}</a>";
    $html .= '          </div>';
    $html .= '          <div class="col-12">';
    $html .= "              <div class='collapse' id='menu_$k'>";
    $html .= '              <div class="card card-body d-block">';
    $html .= '                  '.$v[0];
    $html .= '              </div>';
    $html .= '              </div>';
    $html .= '          </div>';
  }  
    
    $html .= '    </div>';
    $html .= '</div>';

    return $html;
}

// Creación del panel de "Agrupaciones" en facturas de proveedores
function panelAgrupaciones($agrupaciones=array(), $seleccionado=null) {
    $html = '';

    $html .= '<input type="hidden" id="agrupar" name="agrupar" value="'.$seleccionado.'"/>';
    $html .= '<div id="myDIV" class="noprint">';
    foreach ($agrupaciones as $k => $v) {
        $activo = (($k==$seleccionado) ? ' bg-dark cc_active ' : '');  
        if (substr($k,0,5)!='vacio') {
            $html .= "<button class='cc_btnt $activo' title='{$v[1]}' onclick=\"getElementById('agrupar').value = '$k' ; document.getElementById('form1').submit();\"> ";
            $html .=     ucwords($v[0]);
            $html .= '</button>';
        }
        else {
            $html .= '<span class="w50px"> </span>';
        }
        $html .= '';
    }
    $html .= '</div>';

    return $html;
}

// Label para filtrar o generar PDFs
function labelFormatos($array_fmt) {
    $html = '';

    foreach ($array_fmt as $fmt)
    {
        
    $html .= '<div class="col">';
    // $html .= '  <strong>Formato: </strong>';
    $html .= '  <div class="d-inline custom-control custom-checkbox mr-sm-2">';
    $html .= "      <input class='custom-control-input' type='checkbox' id='{$fmt[0]}' name='{$fmt[0]}' {$fmt[1]}>";
    $html .= "      <label class='custom-control-label' for='{$fmt[0]}' title='{$fmt[3]}'><em>{$fmt[2]}</em></label>";
    $html .= '  </div>';
    $html .= '</div>';
    }

    return $html;
}


function filtroSimple($tipo=null, $nombre=null, $identificador=null, $clases=null, $label=null, $valor=null, $options=null) {
    $style = "style='font-size:x-small;color:silver;' " ;
    $html = '';

    $atributoFor = (!empty($identificador) ? ' for="'.$identificador.'"' : '');
    $atributoId = (!empty($identificador) ? ' id="'.$identificador.'"' : '');
    $atributoList = (!empty($identificador) ? ' list="'.$identificador.'"' : '');
    $atributoName = (!empty($nombre) ? ' name="'.$nombre.'"' : '');
    $atributoClass = (!empty($clases) ? ' class="'.$clases.'"' :  ' class="form-control form-control-sm"');
    $atributoValue = (!empty($valor) ? ' value="'.$valor.'"' : '');

//    $html .= '<div class="col-12 col-sm-4 float-left mt-2">';
    if ($tipo == 'radio') {
           // RADIO BUTTON CHK
    //Datos
    $radio=$valor ;
    $radio_name=$nombre ;
    $radio_options=$options;
    // código
    $chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
    if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
    //echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
        $html .=    '<div class="col-12">';
        $html .=        "<label $style  $atributoFor>$label</label> <br>";
        $html .=    '</div>';

    $html.= "<div class='btn-group btn-sm btn-group-toggle' data-toggle='buttons'>"
         . "<label class='btn btn-default btn-sm {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
         . "<label class='btn btn-default btn-sm {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
         . "<label class='btn btn-default btn-sm {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
         . "</div>"
         . "" ;
    // FIN PADIO BUTTON CHK
    }
    else if ($tipo == 'select') {
        $html .=    '<div class="col-12">';
        $html .=        "<label $style  $atributoFor>$label</label> <br>";
        $html .=    '</div>';
        $html .=    '<div class="col-12 input-group">';
        $html .=        '<select'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
        foreach ($options as $option) {
//            $checked = '';
//            if ($v[0] == $valor){
//                $checked = ' checked="checked"';
//            }
            $checked = ($option[0] == $valor)? ' selected '  : "";
//            $atributoIdOpt = (!empty($v['id']) ? ' id="'.$v['id'].'"' : '');
//            $atributoIdOpt = '';
            $atributoValueOpt = (!empty($option[0]) ? ' value="'.$option[0].'"' : '');
            $atributoTextoOpt = (!empty($option[1]) ? ''.$option[1].'' : '');
//            $html .=    '<option'.$checked.$atributoIdOpt.$atributoValueOpt.'>'.(!empty($atributoTextoOpt) ? $atributoTextoOpt : $atributoValueOpt).'</option>';
            $html .=    "<option $checked value='$atributoValueOpt' >$atributoTextoOpt</option>";
        }
        $html .=        '</select>';
        $html .=        '<div class="input-group-append">';
        $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i title="Limpiar filtro asociado" class="fas fa-xs fa-backspace"></i></span>';
        $html .=        '</div>';
        $html .=    '</div>';
    }
    else if ($tipo == 'text_list') {
        $html .=    '<div class="col-12">';
        $html .=        "<label $style  $atributoFor>$label</label> <br>";
        $html .=    '</div>';
        $html .=    '<div class="col-12 input-group">';
        $html .=      "<input type='text' $atributoList $atributoName $atributoClass $atributoValue'/>";
        $html .=        "<datalist $atributoId   '/>";
        foreach ($options as $option) {
//            $checked = '';
//            if ($v[0] == $valor){
//                $checked = ' checked="checked"';
//            }
//            $checked = ($option[0] == $valor)? ' selected '  : "";
//            $atributoIdOpt = (!empty($v['id']) ? ' id="'.$v['id'].'"' : '');
//            $atributoIdOpt = '';
//            $atributoValueOpt = (!empty($option[0]) ? ' value="'.$option[0].'"' : '');
//            $atributoTextoOpt = (!empty($option[1]) ? ''.$option[1].'' : '');
//            $html .=    '<option'.$checked.$atributoIdOpt.$atributoValueOpt.'>'.(!empty($atributoTextoOpt) ? $atributoTextoOpt : $atributoValueOpt).'</option>';
            $html .=    "<option >$option</option>";
        }
        $html .=        '</datalist>';
        $html .=        '<div class="input-group-append">';
        $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i title="Limpiar filtro asociado" class="fas fa-xs fa-backspace"></i></span>';
        $html .=        '</div>';
        $html .=    '</div>';
    }
    else {
        $html .=    '<div class="col-12">';
        $html .=        "<label $style  $atributoFor>$label</label> <br>";
        $html .=    '</div>';
        $html .=    '<div class="col-12 input-group">';
        $html .=        '<input type="'.$tipo.'"'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
        $html .=        '<div class="input-group-append">';
        $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i title="Limpiar filtro asociado" class="fas fa-xs fa-backspace"></i></span>';
        $html .=        '</div>';
        $html .=    '</div>';
    }
//    $html .= '</div>';


    return $html;
}
function panelFiltros( $filtros) {
    
    $bloque_abierto=false;   

    $html = '';

//    $html .= '<div class="col-12 small">';
    $html .= '<div class="row">';
    $html .=     '<div class="col-12 col-sm-4 mt-2">';  //primera columna siemper abierta
    
    foreach ($filtros as $filtro)
    {
        
        if ($filtro["type"]=='col')
        {
         logs("entramos en div col")   ;
        $html .= '</div>'                  // cierro columna anterior
                . '<div class="col-12 col-sm-4  mt-2">';  //inicio columna

        }elseif ($filtro["type"]=='block')       // fin bloque abro bloque
        {

            $html .= $bloque_abierto ? '</div>' : "";    
            $bloque_abierto=true;
            $html .= "{$filtro["titulo"]}" ;
            $html .= "<div  class='borde_gris'>";
            
        }else       // filtro normal
        {    
            // <TR><TD class='seleccion' >Núm. Factura/ID_FRA_PROV   </TD><TD class='seleccion' ><INPUT type='text' id='n_fra'   name='n_fra'  value='$n_fra'><button type='button' onclick=\"document.getElementById('n_fra').value='' \" >*</button></TD></TR>
            $html .=         filtroSimple($filtro["type"], $filtro["name"], $filtro["id"], $filtro["class"], $filtro["titulo"], $filtro["value"], $filtro["options"]);

        }
    }
    
    $html .= $bloque_abierto? '</div>' : "";    
    $html .= '</div>';

    $html .=    '<div class="clearfix"></div>';
    $html .=    '<div class="col-12 m-auto mt-3 pt-3 text-center">';
    $html .=       '<input class="btn btn-link" type="reset" value="Limpiar filtros"/> ';
    $html .=       '<input type="submit" class="btn btn-success noprint" value="Actualizar" id="submit" name="submit">';
    $html .=    '</div>';
    $html .= '</div>';  //

    return $html;
}
function div_row4($titulo='', $select='', $botones='', $col4='') {
    $html = '';
    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-3 pull-left">';
    $html .= "          $titulo";
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-3 pull-left">';
    $html .= '              '.$select;
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-3 pull-left">';
    $html .= '              '.$botones;
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-3 pull-right">';
    $html .= '          '.$col4;
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';
   
    return $html;
}
function div_row3($titulo='', $select='', $botones='') {
    $html = '';
    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= "          $titulo";
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '              '.$select;
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-right">';
    $html .= '          '.$botones;
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';
   
    return $html;
}

function div_row2($titulo='', $botones='') {
    $html = '';
    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-6 pull-left">';
    $html .= "          $titulo";
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-6 pull-right">';
    $html .= '          '.$botones;
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';
   
    return $html;
}

