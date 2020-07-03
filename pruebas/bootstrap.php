<!DOCTYPE html>
<html>
  <head>
    <title>Ejemplo de Bootstrap</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
  
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  </head>
 
  <body>
    <div class="container">
      <h1>Search</h1>
      <label>Ejemplo de un formulario sencillo de búsqueda.</label>

      <!-- Formulario de búsqueda con un campo de entrada (input) y un botón -->
      <form class="well form-search">
        <input type="text" class="input-medium search-query">
        <button type="submit" class="btn btn-primary">Buscar</button>
      </form>
 
      <h2>Results</h2>
 
      <!-- Tabla con celdas de color de fondo alternantes y con marco -->
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Título</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Lorem ipsum dolor sit amet</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Consetetur sadipscing elitr</td>
          </tr>
          <tr>
            <td>3</td>
            <td>At vero eos et accusam</td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- jQuery -->
    
     <div class="row">
      <div class="col-md-4"style="border-style:solid;">
        <div class="4"style="border-style:solid;">...</div>
        <div class="4"style="border-style:solid;">...</div>
        <div class="4"style="border-style:solid;">...</div>
      </div>
      <div class="col-md-8"style="border-style:solid;">...</div>
    </div>
    
  </body>
</html>