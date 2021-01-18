<?php

use es\fdi\ucm\aw\DAORelacionUsuarios;
use es\fdi\ucm\aw\DAOUsuario;
use es\fdi\ucm\aw\TORelacionUsuarios;
use es\fdi\ucm\aw\Usuario;

require_once __DIR__.'/includes/config.php';
/*
Una persona puede ser:
P => Peticion enviada
PR => Peticion recibida
B => el usuario a bloqueado a otro
BB => otro usuario te ha bloqueado
F => amigos (friends)
N => desconocido (nada)*/

//Esta busqueda de la relacion se podria hacer una sola vez si se hiciera en DAORelacionUsuarios.php
//pero he preferido mantener la estructura de las operaciones y mantener aqui toda la logica para la gestion
function getRelacion($usuario, $otroUsuario){
    $relacion = DAORelacionUsuarios::read($usuario, $otroUsuario);
    if (!isset($relacion)) {
        $relacion = DAORelacionUsuarios::read($otroUsuario, $usuario);
        if (!isset($relacion)) {
            $resultado = 'N';
        }
        else {
            switch ($relacion->getestado()) {
                case 'P':
                    $resultado = 'PR';
                    break;
                case 'B':
                    $resultado = 'BB';
                    break;
                case 'F':
                    $resultado = 'F';
                    break;
                default:
                    $resultado = 'N';
                    break;
            }
        }
    }
    else {
        switch ($relacion->getestado()) {
            case 'P':
                $resultado = 'P';
                break;
            case 'B':
                $resultado = 'B';
                break;
            case 'F':
                $resultado = 'F';
                break;
            default:
                $resultado = 'N';
                break;
        }
    }
    return $resultado;
}

function mostrarEstadoUsuarios($otroUsuario, $estado){
    switch ($estado) {
        case 'P':
            echo sprintf("<button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'cancelarPeticion')\">Cancelar </button> <button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'bloquear')\">Bloquear</button>",
            $otroUsuario, $otroUsuario);
            break;
        case 'PR':
            echo sprintf("<button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'aceptar')\">Aceptar </button> <button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'rechazar')\">Rechazar </button> <button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'bloquear')\">Bloquear</button>",
            $otroUsuario, $otroUsuario, $otroUsuario);
            break;
        case 'B':
            echo sprintf("<button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'desbloquear')\"> Desbloquear </button>",
            $otroUsuario);
            break;
        case 'BB':
            echo sprintf("Lo sentimos, el usuario le ha bloqueado");
            break;
        case 'F':
            echo sprintf("<button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'eliminarAmigo')\">Eliminar amigo </button> <button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'bloquear')\">Bloquear</button>",
            $otroUsuario, $otroUsuario);
            break;
        case 'N':
            echo sprintf("<button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'enviarPeticion')\">Enviar solicitud </button> <button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'bloquear')\">Bloquear</button>",
            $otroUsuario, $otroUsuario);
            break;
        default:
            # code...
            break;
    }
}
//funcion que se llama cuando cambiamos el texto en el buscador para encontrar amigos nuevos
function buscarAmigos($apodo){
    $usuarios = DAOUsuario::listarBusqueda($apodo);
    $estados = ['P' => 'Solicitud enviada',
                'PR' => 'Pendiente de confirmar',
                'B' => 'Bloqueado',
                'BB' => 'El usuario te ha bloqueado',
                'F' => 'Amigos',
                'N' => 'Desconocido'];
    if (!isset($usuarios)) {
        echo '<p> No existe ningún usuario que contenga esas letras </p>';
    }  elseif (count($usuarios) == 1 && $usuarios[0]->getApodo() == $_SESSION['usuario']) {
        echo '<p> No existe ningún usuario que contenga esas letras </p>';
    } 
    else {
        echo '<table>';

        foreach ($usuarios as $user) {
            if ($user->getApodo() != $_SESSION['usuario']) {
                echo '<tr>';
            echo '<td><img src="'.$user->geturlFoto().'">' . '</td><td>'.$user->getNombre(). ' ' . $user->getApellidos().'</td>';
            $estado = getRelacion($_SESSION['usuario'], $user->getApodo());
            echo sprintf('<td>%s</td><td>', $estados[$estado]);
            mostrarEstadoUsuarios($user->getApodo(), $estado);
            echo '</td></tr>';
            }
            
        }
        echo '</table>';
    }
    
    
}

function mostrarUsuarios($estado){
    $relaciones = DAORelacionUsuarios::listUsuarios($_SESSION['usuario'], $estado);
    $estados = ['P' => 'Solicitud enviada',
                'PR' => 'Pendiente de confirmar',
                'B' => 'Bloqueado',
                'BB' => 'El usuario te ha bloqueado',
                'F' => 'Amigos',
                'N' => 'Desconocido'];
    if (!isset($relaciones)) {
        echo '<p>No existe ningún usuario en esta lista.</p>';
    }
    else {
        echo '<table><br>';
        echo'<tr><td>Foto</td><td>Nombre</td><td>Estado</td>';
        echo '</tr>';
        foreach ($relaciones as $relacion) {
            if ($_SESSION['usuario'] == $relacion->getusuario()) {
                $user = Usuario::buscaUsuario($relacion->getotroUsuario());
            } else {
                $user = Usuario::buscaUsuario($relacion->getusuario());
            }
            echo '<tr>';
            echo '<td><img src="'.$user->geturlFoto().'">' . '</td><td>'.$user->getNombre(). ' ' . $user->getApellidos().'</td>';
            $estado = getRelacion($_SESSION['usuario'], $user->getApodo());
            echo sprintf('<td>%s</td><td>', $estados[$estado]);
            mostrarEstadoUsuarios($user->getApodo(), $estado);
            echo '</td></tr>';
        }
        echo '</table>';
    }
}

function enviarPeticion($apodo){
    $toRelacion = new TORelacionUsuarios();
    $toRelacion->setusuario($_SESSION['usuario']);
    $toRelacion->setotroUsuario($apodo);
    $toRelacion->setestado('P');
    if (DAORelacionUsuarios::create($toRelacion)) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al enviar la solicitud de amistad, inténtelo más tarde']);
    }
    
}

function eliminarAmigo($apodo){
    $borrado = DAORelacionUsuarios::delete($apodo, $_SESSION['usuario']);
    if(!$borrado){
        $borrado = DAORelacionUsuarios::delete($_SESSION['usuario'], $apodo);
    }
    if ($borrado) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al eliminar el amigo, inténtelo más tarde']);
    }
}

//Esta relacion es direccional, a bloquea a b, b es bloqueado por a, por lo que hay que tener en cuenta
//distintos casos
function bloquear($apodo){
    $toRelacion = DAORelacionUsuarios::read($apodo, $_SESSION['usuario']); 
    if (!isset($toRelacion)) {
        $toRelacion = DAORelacionUsuarios::read($_SESSION['usuario'], $apodo); 
        if (!isset($toRelacion)) {
            $toRelacion = new TORelacionUsuarios();
            $toRelacion->setusuario($_SESSION['usuario']);
            $toRelacion->setotroUsuario($apodo);
            $toRelacion->setestado('B');
            if (DAORelacionUsuarios::create($toRelacion)) {
                echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
            } else {
                echo json_encode(['exito' => 0, 'mensaje' => 'Error al bloquear al usuario, inténtelo más tarde']);
            }
        } else {
            $toRelacion->setestado('B');
            if (DAORelacionUsuarios::update($toRelacion)) {
                echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
            } else {
                echo json_encode(['exito' => 0, 'mensaje' => 'Error al bloquear al usuario, inténtelo más tarde']);
            }
            
        }
        
    } else { //para este caso, tenemos que cambiar de sentido la relacion por lo que borramos la actual y creamos otra
        $borrado = DAORelacionUsuarios::delete($apodo, $_SESSION['usuario']);
        if ($borrado) {
            $toRelacion = new TORelacionUsuarios();
            $toRelacion->setusuario($_SESSION['usuario']);
            $toRelacion->setotroUsuario($apodo);
            $toRelacion->setestado('B');
            if (DAORelacionUsuarios::create($toRelacion)) {
                echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
            } else {
                echo json_encode(['exito' => 0, 'mensaje' => 'Error al bloquear al usuario, inténtelo más tarde']);
            }
        } else {
            echo json_encode(['exito' => 0, 'mensaje' => 'Error al bloquear al usuario, inténtelo más tarde']);
        }
        
        
    }
    
}

function desbloquear($apodo){
    $borrado = DAORelacionUsuarios::delete($_SESSION['usuario'], $apodo);
    if ($borrado) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al desbloquear al usuario, inténtelo más tarde']);
    }
}

function aceptarAmigo($apodo){
    $toRelacion = DAORelacionUsuarios::read($apodo, $_SESSION['usuario']); //leemos la peticion que han enviado al usuario
    $toRelacion->setestado('F');
    if (DAORelacionUsuarios::update($toRelacion)) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al aceptar la solicitud de amistad, inténtelo más tarde']);
    }
}

function rechazarAmigo($apodo){
    $borrado = DAORelacionUsuarios::delete($apodo, $_SESSION['usuario']);
    if ($borrado) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al eliminar la solicitud, inténtelo más tarde']);
    }
}

function cancelarPeticion($apodo){
    $borrado = DAORelacionUsuarios::delete($_SESSION['usuario'], $apodo);
    if ($borrado) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Exito']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al cancelar la solicitud, inténtelo más tarde']);
    }
}
if(!isset($_SESSION['usuario'])){
    echo json_encode(['exito' => 0, 'mensaje' => "No tienes permisos de acceso"]);
}
else {
    $peticion = isset($_POST['peticion']) ? htmlspecialchars(trim(strip_tags($_POST['peticion']))) : null;
    $apodo = isset($_POST['id']) ? htmlspecialchars(trim(strip_tags($_POST['id']))) : null;
    switch ($peticion) {
        case 'buscarAmigos':
            buscarAmigos($apodo);
            break;
        case 'mostrarUsuarios':
            mostrarUsuarios($apodo);
            break;
        case 'enviarPeticion':
            enviarPeticion($apodo);
            break;
        case 'eliminarAmigo':
            eliminarAmigo($apodo);
            break;
        case 'bloquear':
            bloquear($apodo);
            break;
        case 'desbloquear':
            desbloquear($apodo);
            break;
        case 'aceptar':
            aceptarAmigo($apodo);
            break;
        case 'rechazar':
            rechazarAmigo($apodo);
            break;
        case 'cancelarPeticion':
            cancelarPeticion($apodo);
            break;
    }
}


?>