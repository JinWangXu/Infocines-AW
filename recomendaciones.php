<?php

use es\fdi\ucm\aw\DAOPelicula;
use es\fdi\ucm\aw\DAORecomendacion;
use es\fdi\ucm\aw\DAORelacionUsuarios;
use es\fdi\ucm\aw\DAOUsuario;
use es\fdi\ucm\aw\TORecomendacion;
use es\fdi\ucm\aw\TORelacionUsuarios;
use es\fdi\ucm\aw\Usuario;

require_once __DIR__ . '/includes/config.php';

function mostrarBotonRecomendacion($otroUsuario)
{
    //funcion para buscar con session usuario, otro usuario y peli en DAO (otroUsuario, session, peli)
    $toRecomendacion = DAORecomendacion::buscarRecomendacion($_SESSION['usuario'], $otroUsuario, $_SESSION['pelicula']);
    if (isset($toRecomendacion)) {
        echo sprintf(
            "<td><button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'eliminarRecomendacion')\"> Eliminar recomendación </button>",
            $otroUsuario
        );
    } else {
        echo sprintf(
            "<td><button class=\"opcionesAmigos\" onclick=\"procesar('%s', 'recomendar')\"> Recomendar </button>",
            $otroUsuario
        );
    }
}

function mostrarUsuarios($texto)
{
    $relaciones = DAORelacionUsuarios::listUsuarios($_SESSION['usuario'], 'F');
    if (!isset($relaciones)) {
        echo '<p>No existe ningún usuario en esta lista.</p>';
    } else{
        echo '<table><br>';
        $i = 0;
        foreach ($relaciones as $relacion) {
            if ($_SESSION['usuario'] == $relacion->getusuario()) {
                $user = Usuario::buscaUsuario($relacion->getotroUsuario());
            } else {
                $user = Usuario::buscaUsuario($relacion->getusuario());
            }
            if ((stripos($user->getApodo(), $texto) !== FALSE) || $texto == '') {
                echo '<tr>';
                echo '<td><img src="'.$user->geturlFoto().'">' . '</td><td>'.$user->getNombre(). ' ' . $user->getApellidos().'</td>';
                mostrarBotonRecomendacion($user->getApodo());
                echo '</td></tr>';
                $i = $i + 1;
            }
        }
        if($i == 0){
            echo 'No existe ningún usuario en esta lista.';
        }
        echo '</table>';
    }
}

function eliminarRecomendacion($apodo)
{
    $toRecomendacion = DAORecomendacion::buscarRecomendacion($_SESSION['usuario'], $apodo, $_SESSION['pelicula']);

    if (DAORecomendacion::delete($toRecomendacion->getId())) {
        echo json_encode(['exito' => 1, 'mensaje' => 'La recomendación se ha eliminado correctamente']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al eliminar la recomendación, inténtelo más tarde']);
    }
}



//FUnciones de Jin



function eliminarPeliculaRecomendada($idPelicula)
{

    if (DAORecomendacion::deleteRec($idPelicula, $_SESSION['usuario'])) {
        echo json_encode(['exito' => 1, 'mensaje' => 'La recomendación se ha eliminado correctamente']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al eliminar la recomendación, inténtelo más tarde']);
    }
}

function eliminarAllPerliculasRecomendadas()
{

    if (DAORecomendacion::deleteAllRec($_SESSION['usuario'])) {
        echo json_encode(['exito' => 1, 'mensaje' => 'Las recomendaciones se han eliminado correctamente']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al eliminar la recomendación, inténtelo más tarde']);
    }
}

function mostrarPeliculas()
{
    $listaRec = DAORecomendacion::listarRecomendaciones($_SESSION['usuario']);
    if (isset($listaRec)) {
        $i = 0;
        $peliPrev = "";
        foreach ($listaRec as $rec) {

            if ($i == 0 || $peliPrev != $rec->getidPelicula()) {
                if ($i != 0) {
                    echo sprintf(
                        " <button id= \"borrarRecConcreta\" onclick=\"procesar('%s', 'eliminarPeliculaRecomendada')\"> Borrar Recomendación </button> </h4>",
                        $peliPrev
                    );
                }
                $peli = DAOPelicula::read($rec->getidPelicula());
                echo '<div class="grid-sub2Container">  
										<div class="tituloPelicula"> ' . $peli->getTitulo() . ' </div> 
										<div class="imagenPelicula" id="imagenPeli"> 
										<a class="nom" href="peliculaConcreta.php?id=' . $peli->getIdPelicula() . '"> 
										<img src=' . $peli->getUrlImagen() . ' alt="imagen ' . $peli->getIdPelicula() . '" id="widthImg""> </a>
										</div>
										</div> ';

                echo '<h4> Recomendado por: <br>';
            }
            echo '<br> <p> ' . $rec->getusuarioOrigen() . ' </p>';

            $peliPrev = $rec->getidPelicula();
            $i = $i + 1;
        }
        echo sprintf(
            " <button id= \"borrarRecConcreta\" onclick=\"procesar('%s', 'eliminarPeliculaRecomendada')\"> Borrar Recomendación </button> </h4>",
            $peliPrev
        );
    } else {
        echo '<h3> No tienes películas recomendadas </h3>';
    }
}





function recomendar($apodo)
{
    $toRecomendacion = new TORecomendacion;
    $toRecomendacion->setusuarioOrigen($_SESSION['usuario']);
    $toRecomendacion->setusuarioDestino($apodo);
    $toRecomendacion->setidPelicula($_SESSION['pelicula']);
    if (DAORecomendacion::create($toRecomendacion)) {
        echo json_encode(['exito' => 1, 'mensaje' => 'La recomendación se ha enviado correctamente']);
    } else {
        echo json_encode(['exito' => 0, 'mensaje' => 'Error al enviar la recomendación, inténtelo más tarde']);
    }
}

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['exito' => 0, 'mensaje' => "No tienes permisos de acceso"]);
} else {
    $peticion = isset($_POST['peticion']) ? htmlspecialchars(trim(strip_tags($_POST['peticion']))) : null;
    $apodo = isset($_POST['id']) ? htmlspecialchars(trim(strip_tags($_POST['id']))) : null;
    switch ($peticion) {
        case 'mostrarUsuarios':
            mostrarUsuarios($apodo);
            break;
        case 'recomendar':
            recomendar($apodo);
            break;
        case 'eliminarRecomendacion':
            eliminarRecomendacion($apodo);
            break;
        case 'eliminarPeliculaRecomendada':
            eliminarPeliculaRecomendada($apodo);
            break;
        case 'eliminarAllPerliculasRecomendadas':
            eliminarAllPerliculasRecomendadas();
            break;
        case 'mostrarPeliculas':
            mostrarPeliculas();
            break;
    }
}
