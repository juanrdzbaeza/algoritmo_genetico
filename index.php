<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Algoritmo Genético </title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"> </script>
  <script src="ie_eventsource.js"></script>
  <script src="script.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <div class="jumbotron">
    <h1> Algoritmo Genético </h1>
    <blockquote class="blockquote text-right">
      <p class="mb-0">
        La interfaz grafica del programa, que se presenta en html, nos muestra un
        pequeño formulario con un área de texto como entrada, y un botón para iniciar
        el programa. El campo de texto permite escribir una palabra o frase, o
        simplemente una secuencia de caracteres desordenados, una vez que apretemos
        el botón, la lógica comenzara a buscar la mejor solución, que en nuestro
        caso es reproducir lo mejor posible la cadena de texto que se haya escrito.
      </p>
      <br>
      <footer class="blockquote-footer">
        Método de selección utilizado:
        <cite title="Source Title">
          <a href="http://www.aic.uniovi.es/ssii/tutorial/Seleccion.htm">Elitismo</a>
        </cite>
      </footer>
      <br>
      <p class="text-info">Ver repositorio en &nbsp;&nbsp;<a class="btn btn-primary btn-lg" href="#" role="button">Github</a>
    </blockquote>
  </div>
  <div class="container">
    <form id="form1">
      <h4>Escriba una solución:</h4>
      <div contenteditable="true" class="large_text_input" id="my_solution">
        Hello World!
      </div>
      <br>
      <span class="input-group-btn">
        <button id="btnRun" type="submit" class="btn btn-primary">Go!</button>
      </span>
    </form>
    <div class="container">
      <div class="page-header">
        <span id="best_individual" class="large_text"> </span>
      </div>
    </div>
  </div>

  <div class="container">
    <hr>
    <div class="alert alert-info" role="alert">
      <p>Generaciones: <span id="generation" class="med_text"> </span></p>
    </div>
    <div class="alert alert-info" role="alert">
      <p>Generaciones estancadas: <span id="stagnant" class="med_text"> </span></p>
    </div>
    <div class="alert alert-info" role="alert">
      <p>Valor de fitness: <span id="best_fittest_value" class="med_text"> </span></p>
    </div>
    <div class="alert alert-info" role="alert">
      <p>Tiempo transcurrido: <span id="elapsed" class="med_text"> </span></p>
    </div>
    <hr>
  </div>

  <footer class="footer">
    <div class="container">
      <span id="message" class="text-muted"> </span>
      <br>
    </div>
  </footer>

</body>

</html>