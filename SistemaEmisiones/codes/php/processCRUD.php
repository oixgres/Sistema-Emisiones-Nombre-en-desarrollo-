<?php
session_start();
include "dataBaseLogin.php";

$connection = mysqli_connect($host, $user, $password, $bd);

if($connection)
{
  if(isset($_GET['delete']))
  {
    $id = $_GET['delete'];
    mysqli_query($connection, "DELETE FROM Usuario WHERE idUsuario='".$id."'");
  }

  if(isset($_GET['edit']))
  {
    $id = $_GET['edit'];
    $result = mysqli_query($connection, "SELECT * FROM Usuario WHERE idUsuario='".$id."'");

    if(count($result) == 1)
    {
      $row = $result->fetch_array();
      $_SESSION['Id']=$row['idUsuario'];
      $_SESSION['Username']=$row['Username'];
      $_SESSION['Password']=$row['Password'];
      $_SESSION['Nombre']=$row['Nombre'];
      $_SESSION['Ciudad']=$row['Ciudad'];
      $_SESSION['Correo']=$row['Correo'];
      $_SESSION['Telefono']=$row['Telefono'];
      $_SESSION['Aprobado']=$row['Aprobado'];
      $_SESSION['IdEmpresa']=$row['Empresa_idEmpresa'];
      $_SESSION['Button'] = "Update";
      header("Location: updateUser.php");
      exit();
    }
  }

  if(isset($_GET['create']))
  {
    $_SESSION['Username']=NULL;
    $_SESSION['Password']=NULL;
    $_SESSION['Nombre']=NULL;
    $_SESSION['Ciudad']=NULL;
    $_SESSION['Correo']=NULL;
    $_SESSION['Telefono']=NULL;
    $_SESSION['Aprobado']=NULL;
    $_SESSION['IdEmpresa']=NULL;
    $_SESSION['Button'] = "Create";
    header("Location: updateUser.php");
    exit();
  }
}
else
{
  echo "No hay conexion";
}
?>