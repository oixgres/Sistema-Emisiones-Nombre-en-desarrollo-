<?php
require_once "dataBaseLogin.php";
require_once "phpFunctions.php";

$id_user = $_COOKIE['Id'];
$operation = $_COOKIE['Button'];

$username = $_POST['user'];
$pass = $_POST['pass'];
$name = $_POST["name"];
$company = $_POST["company"];
$device = $_POST["device"];
$city = $_POST["city"];
$email = $_POST["email"];
$phone = $_POST["phone"];

/* Checamos el checkbox de Aprobado */
if(!empty($_POST['admitted']))
  $admitted = "Aprobado";
else
  $admitted = "No Aprobado";

/*Obtenemos datos previos del usuario */
$pastUsername = getFirstQueryElement(
  $connection,
  "Usuario",
  "Username",
  "idUsuario",
  $id_user
);

$pastEmail = getFirstQueryElement(
  $connection,
  "Usuario",
  "Correo",
  "idUsuario",
  $id_user
);

$pastPassword = getFirstQueryElement(
  $connection,
  "Usuario",
  "Password",
  "idUsuario",
  $id_user
);

$pastAdmitted = getFirstQueryElement(
  $connection,
  "Usuario",
  "Aprobado",
  "idUsuario",
  $id_user
);

/* Verificamos que el username no este registrado*/
$query = "SELECT * FROM Usuario WHERE Username='".$username."'";
$query_result = mysqli_query($connection, $query);
$nru = mysqli_num_rows($query_result);

$query = "SELECT * FROM Administrador WHERE Username='".$username."'";
$query_result = mysqli_query($connection, $query);
$nru = $nru + mysqli_num_rows($query_result);

/* Si el username esta registrado y si es diferente de si mismo */
if($nru > 0 && $username != $pastUsername && $username!='')
{
  echo json_encode(array(
    'input'=>'user',
    'type'=>'mail_error',
    'error'=>"Este usuario ya ha sido registrado"
  ));
}
else
{
  /* Verificamos que el correo no este repetido */
  $query = "SELECT * FROM Usuario WHERE Correo='$email'";
  $query_result = mysqli_query($connection, $query);
  $nre = mysqli_num_rows($query_result);

  /* Si el correo ya esta registrado */
  if($nre > 0 && $email != $pastEmail && $email != '')
  {
    echo json_encode(array(
      'input'=>'email',
      'type'=>'input_error',
      'error'=>'Este correo ya ha sido registrado'
    ));
  }
  else
  {
    /* Creamos Usuario */
    if ($operation == "Crear")
    {
      /*Registramos compañia*/
      $query = "INSERT INTO Empresa(Nombre) VALUES ('$company')";
      mysqli_query($connection, $query);

      /* Obtenemos el id de la empresa */
      $id_company = mysqli_insert_id($connection);

      /* Creamos el usuario */
      $query = "INSERT INTO Usuario(
        Username,
        Password,
        Nombre,
        Ciudad,
        Correo,
        Telefono,
        Aprobado,
        Empresa_idEmpresa
      ) VALUES (
        '$username',
        '$pass',
        '$name',
        '$city',
        '$email',
        '$phone',
        '$admitted',
        '$id_company'
      )";
      mysqli_query($connection, $query);
      
      /* Recuperamos el id del usuaro */
      $id_user = getFirstQueryElement(
        $connection,
        "Usuario",
        "idUsuario",
        "Correo",
        $email
      );

      /* Creamos el dispositivo */
      $query = "INSERT INTO Dispositivo(
        Codigo,
        Usuario_idUsuario
      )VALUES(
        '$device',
        '$id_user'
      )";
      mysqli_query($connection, $query);
      
      /* Enviamos correo */
      if(!empty($_POST["sendMail"]))
      {
        $message = "Bienvenido a hcarbono \n\r";
        $message.= "Se ha creado una cuenta en hcarbono.com \n\r";
        $message.= "Su username es: ".$username."\n";
        $message.= "Su contraseña es: ".$pass."\n\r";
        
        sendMail($email, "Nueva Cuenta hcarbono", $message);
      }
      echo json_encode(array(
        'location'=> 'adminPage.php'
      ));
    }
    else
      if($operation == "Editar")
      {
        /* Actualizamos Usuario */
        $id_company = intval(getFirstQueryElement(
          $connection,
          "Empresa",
          "idEmpresa",
          "Nombre",
          $company
        ));
        
        $query = "UPDATE Usuario SET
          Username='".$username."',
          Password='".$pass."',
          Nombre='".$name."',
          Ciudad='".$city."',
          Correo='".$email."',
          Telefono='".$phone."',
          Aprobado='".$admitted."',
          Empresa_idEmpresa='".$id_company."'
          WHERE idUsuario='".$id_user."'";
          
        mysqli_query($connection, $query);
        
        /* Actualizamos dispositivo */
        $id_device = intval(getFirstQueryElement(
          $connection,
          "Dispositivo",
          "idDispositivo",
          "Usuario_idUsuario",
          $id_user
        ));
        
        $query = "UPDATE Dispositivo SET Codigo='".$device."' WHERE idDispositivo='".$id_device."'";
        mysqli_query($connection, $query);
        
        /* Enviamos correo */
        if(!empty($_POST["sendMail"]))
        {
          /* Correo de usuario aceptado */
          if($pastAdmitted == "No Aprobado" && $admitted == "Aprobado")
          {
            $message = "Saludos de parte de hcarbono! \n\r";
            $message.= "Su solicitud de cuenta a sido aprobada.  \n\r";
            $message.= "Su username es: ".$username."\n";
            $message.= "Su contraseña es: ".$pass."\n\r";
            
            sendMail($email, "Cuenta aprobada hcarbono", $message);
          }
          else
            /* Correo de modificaciones */
            if($pastAdmitted == "Aprobado" && $admitted == "Aprobado")
            {
              $message = "Saludos de parte de hcarbono! \n\r";
              $message.= "Se han realizado modificaciones a sus datos. \n\r";
              $message.= "Su username es: ".$username."\n";
              $message.= "Su contraseña es: ".$pass."\n\r";
              
              sendMail($email, "Modificación de datos hcarbono", $message);
            }
        }
        echo json_encode(array(
          'location'=> 'adminPage.php'
        ));
      }
      else
        echo "No se pudo realizar ninguna operacion"; 
  }
}

?>
