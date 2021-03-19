<?php session_start(); ?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sistema Emisiones (Nombre en desarrollo)</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <link rel="stylesheet" href="../css/pageStyle.css">
  </head>

  <body class="page-settings">
    <?php
      include "dataBaseLogin.php";

      $connection = mysqli_connect($host, $user, $password, $bd);
      /* https://www.youtube.com/watch?v=xHbmHY9lJu4&t=71s&ab_channel=FacultadAutodidacta 3:43*/

    ?>

    <nav class="navbar navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">SISTEMA</a>
        <ul class="navbar-nav me-auto justify-content-end">
        </ul>
        <a class="btn btn-primary btn-sm button-settings "href="../../index.html">Salir</a>
      </div>
    </nav>

    <form id="form-param">
      <div class="container">
        <div>
          <input type="text" class="parametro" placeholder="parametro"><input type="number" class="valor" placeholder="valor">
        </div>
        <div>
          <input type="text" class="parametro" placeholder="parametro"><input type="number" class="valor" placeholder="valor">
        </div>
      </div>
      <div class="">
        <button type="button" class="addParam">Agregar parametro</button>
        <button type="button" class="showResults">Mostrar Resultados</button>
      </div>

      <?php echo $_SESSION['idUsuario']; ?>

      <div id="grafico"></div>
      <script src="../js/graph.js"></script>
    </form>
  </body>
</html>
