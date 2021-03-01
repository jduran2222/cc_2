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


 
 var data<?php echo $idtabla; ?> = new google.visualization.DataTable(
   {
     cols: [
            {id: 'task', label: 'Employee Name', type: 'string'},
            {id: 'startDate', label: 'Start Date', type: 'number'},
            {id: 'linea2', label: 'linea2 ID: <?php echo $idtabla; ?>', type: 'number'}
           ],
     rows: [
            { c: [  {v: 'Mike' }, {v: 15, f: 'etiqueta' }, {v: 15, f: 'etiqueta' }  ]    },
            { c: [  {v: 'Bob'  }, {v: 14 }, {v: 14 }    ] },
            { c: [  {v: 'Alice'}, {v: 18 }, {v: 38 }    ] },
            { c: [  {v: 'Frank'}, {v: 25 }, {v: 15 }    ] },
            { c: [  {v: 'Floyd'}, {v: 10 }, {v: 16 }    ] },
            { c: [  {v: 'Fritz'}, {v: 30 }, {v: 40 }    ] } 
           ]
   }
) 
//    pdte de configurar por AJAX
//     data<?php echo $idtabla; ?> = new google.visualization.DataTable(  <?php // echo "{ $json_cols_chart , $json_rows_chart } " ; ?> ) ;
  
  

    // Set chart options
     options<?php echo $idtabla; ?> = {'title':'<?php echo $titulo; ?> IDTABLA: <?php echo $idtabla; ?>',
                   'width':800,
                   'height':400 ,
                   seriesType: 'bars'
                   <?php // echo $serie_line_txt; ?>  };


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
