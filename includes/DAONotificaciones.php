<?php

namespace es\fdi\ucm\aw;

/**
 * 
 */


class DAONotificaciones
{

  public static function listar($user)
  {


    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();
    $sql = sprintf(
      "SELECT * FROM notificaciones  WHERE user = '%s'",
      $conn->real_escape_string($user)
    );
    $result = $conn->query($sql);

    if ($result->num_rows == 0)
      return NULL;

    while ($row = $result->fetch_assoc()) {

      $not = new TONotificaciones();

      $not->setid_notificacion($row['id_notificaciones']);
      $not->setuser($row['user']);
      $not->setinfo($row['info']);
      $not->settipo($row['tipo']);


      $listaNot[] = $not;
    }

    return $listaNot;
  }

  public static function create($notificacion)
  {
    $id = $notificacion->getid_notificacion();
    $user = $notificacion->getuser();
    $info = $notificacion->getinfo();
    $tipo = $notificacion->gettipo();



    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();

    $sql = sprintf(
      "INSERT INTO notificaciones(user, info, tipo) VALUES('%s', '%s', '%s')",
      $conn->real_escape_string($user),
      $conn->real_escape_string($info),
      $conn->real_escape_string($tipo),
    );



    if (!$conn->query($sql)) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public static function delete($id)
  {

    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();

    $sql = sprintf(
      "DELETE FROM notificaciones WHERE id_notificaciones = '%d'",
      $conn->real_escape_string($id)
    );


    if (!$conn->query($sql)) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public static function getNumeroNotificaciones($user)
  {
    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();

    $sql = sprintf("SELECT * FROM notificaciones  WHERE user = '%s'",
    $conn->real_escape_string($user));

    $result = $conn->query($sql);

    $num = 0;

    while ($row = $result->fetch_assoc()) {
        $num = $num + 1;
    }
    return $num;
  }


  public static function deleteAllFromUser($user)
  {

    $app = Aplicacion::getSingleton();
    $conn = $app->conexionBd();

    $sql = sprintf(
      "DELETE FROM notificaciones WHERE user = '%s'",
      $conn->real_escape_string($user)
    );


    if (!$conn->query($sql)) {
      return FALSE;
    } else {
      return TRUE;
    }
  }
}
