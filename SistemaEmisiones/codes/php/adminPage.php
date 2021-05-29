<?php
require_once "phpFunctions.php";

checkSession('admin', "../../index.html");
?>
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>H. Carbono | Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/pageStyle.css">
    <link rel="stylesheet" href="../css/popupStyle.css">
  </head>

  <body class="background-color">
    <nav class="navbar navbar-dark config-color">
      <div class="container-fluid">
        <a class="navbar-brand" href="../../index.html">H.CARBONO</a>
        <ul class="navbar-nav me-auto justify-content-end">
        </ul>
        <a class="btn btn-sm config-button-navbar "href="logout.php">Salir</a>
      </div>
    </nav>

    <section>
      <?php
        require_once "dataBaseLogin.php";
        require_once "processCRUD.php";
        require_once "phpFunctions.php";

        $result = mysqli_query($connection, "SELECT * FROM Usuario");
      ?>
      <!-- Tabla para mostrar los usuarios registrados -->
      <!-- <div class="mx-1 d-flex justify-content-center table-responsive"> -->
      <div class="mx-5 mt-5 table-responsive">
        <table class="table">
          <!--Cabeza de la tabla-->
          <thead>
            <tr>
              <th>Usuario</th>
              <th>Contraseña</th>
              <th>Nombre</th>
              <th>Ciudad</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>Estado</th>
              <th>Empresa</th>
              <th>Dispositivo</th>
              <th>Accion</th>
            </tr>
          </thead>

          <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $row['Username']; ?></td>
              <td><?php echo $row['Password']; ?></td>
              <td><?php echo $row['Nombre']; ?></td>
              <td><?php echo $row['Ciudad']; ?></td>
              <td><?php echo $row['Correo']; ?></td>
              <td><?php echo $row['Telefono']; ?></td>
              <td><?php echo $row['Aprobado']; ?></td>

              <!-- Obtenemos el nombre de la empresa -->
              <?php
                $company = getFirstQueryElement($connection, "Empresa", "Nombre", "idEmpresa", $row['Empresa_idEmpresa']);
              ?>
              <td><?php echo  $company?></td>

              <?php
                $device = getFirstQueryElement($connection, "Dispositivo", "Codigo", "Usuario_idUsuario", $row['idUsuario'])
              ?>
              <td><?php echo $device; ?></td>


              <td class="d-flex justify-content-end">
                <!-- Redireccion a pagina para editar el usuaro -->
                <a
                  href="adminPage.php?edit=<?php echo $row['idUsuario']; ?>"
                  class="btn config-button">Editar
                </a>

                <a
                  id="adminPage.php?delete=<?php echo $row['idUsuario']; ?>"
                  onclick="togglePopup(this)"
                  class="btn config-button-danger mx-3"
                >Borrar
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </table>
      </div>
    </section>

    <!-- Boton para crear usuarios -->
    <div class="d-flex justify-content-end">
      <a
        href="adminPage.php?create=<?php echo $row['idUsuario']; ?>"
        class="btn config-button mt-5 me-5 mb-5">Nuevo
      </a>
    </div>

    <!-- Popup eliminar usuarios -->
    <div class="popup" id="popup-delete">
      <div class="overlay"></div>
      <div class="content">
        <div id = "1" class="close-button" onclick="togglePopup(1)">&times;</div>
        <h1 class="danger-text">ADVERTENCIA</h1>
        <p>Una vez eliminado este usuario sus datos se perderan para siempre</p>
        <p>¿Desea continuar?</p>
        <div class="row">

        </div>
        <a
          id="popup-delete-button"
          href=""
          class="btn config-button-danger">Borrar
        </a>
      </div>
    </div>
    <script src="../js/popup.js" charset="utf-8"></script>
    <script src="../js/session.js"></script>
  </body>
</html>
