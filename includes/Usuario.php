<?php
namespace es\fdi\ucm\aw;

class Usuario
{

    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if (isset($user) && self::compruebaPassword($password, $user->getContrasena())) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $result = DAOUsuario::read($nombreUsuario);
        return $result;
    }
    
    public static function crea($nombreUsuario, $password, $nombreCompleto, $apellidos, $email, $ntarjeta, $tipoAbono, $inicioAbono, $rol)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if (isset($user)) {
            return false;
        }
        $usuario = new TOUsuario();

	    $usuario->setApodo($nombreUsuario);
	    $usuario->setContrasena(self::hashPassword($password));
	    $usuario->setNombre($nombreCompleto);
        $usuario->setApellidos($apellidos);
	    $usuario->setEmail($email);
	    $usuario->setNtarjeta($ntarjeta);
	    $usuario->setTipoAbono($tipoAbono);
	    $usuario->setInicioAbono($inicioAbono);
	    $usuario->setRol($rol);
        return self::inserta($usuario);
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, [rand()]);
    }
    
    private static function inserta($usuario)
    {
        $creado = DAOUsuario::create($usuario);
        return $creado;
    }
    
    public static function modificar($apodo, $nombreCompleto, $apellidos, $email, $ntarjeta, $tipoAbono, $nombreImagen){
            $usuario = DAOUsuario::read($_SESSION['usuario']);

            if (mb_strlen($nombreCompleto) > 0) {
                $usuario->setNombre($nombreCompleto);
            }
            if (mb_strlen($apellidos) > 0) {
                $usuario->setApellidos($apellidos);
            }
            if (mb_strlen($email) > 0) {
                $usuario->setEmail($email);
            }
            if (mb_strlen($ntarjeta) > 0) {
                $usuario->setNtarjeta($ntarjeta);
            }
            if (mb_strlen($tipoAbono) > 0) {
                $usuario->setTipoAbono($tipoAbono);
            }
            if (mb_strlen($nombreImagen) > 0) {
                $carpetaDestino = $_SERVER['DOCUMENT_ROOT'] . '/infocines/media/usuario/';
                move_uploaded_file($_FILES['avatar']['tmp_name'], $carpetaDestino . $nombreImagen);
                $nuevoNombre = $carpetaDestino;
                $nuevoNombre .= $apodo;
                $nuevoNombre .= '.';
                $nuevoNombre .= pathinfo($nombreImagen, PATHINFO_EXTENSION);
                rename($carpetaDestino.$nombreImagen, $nuevoNombre);
                $usuario->setUrlFoto('media/usuario/'. $apodo . '.' . pathinfo($nombreImagen, PATHINFO_EXTENSION));
            }
            
                
            return DAOUsuario::update($usuario);
    }
    /*private static function actualiza($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE Usuarios U SET nombreUsuario = '%s', nombre='%s', password='%s', rol='%s' WHERE U.id=%i"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $usuario->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $usuario;
    }*/

    public static function borrarUsuario($apodo)
    {                
        return DAOUsuario::delete($apodo);
    }

    public static function compruebaPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function cambiarPassword($apodo, $password){
        $usuario = self::buscaUsuario($apodo);

        $usuario->setContrasena(self::hashPassword($password));
        
        return DAOUsuario::update($usuario);
    }
}
