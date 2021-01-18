<?php
require_once __DIR__ . '/includes/config.php';

use es\fdi\ucm\aw\DAOComentario as DAOComentario;
use es\fdi\ucm\aw\Usuario as Usuario;
use es\fdi\ucm\aw\DAOValoracion as DAOValoracion;
use es\fdi\ucm\aw\TOComentario as TOComentario;

function addComentario()
{
    $error = '';
    $contenidoComentario = '';
    $contenidoComentario = isset($_POST['texto']) ? htmlspecialchars(trim(strip_tags($_POST['texto']))) : null;
    if (!isset($contenidoComentario)) {
        $error .= '<p> Se debe introducir contenido en el comentario</p>';
    }
    if ($error == '') {
        $comentario = new es\fdi\ucm\aw\TOComentario();

        $comentario->setidComentarioPadre($_POST['idComentario']);
        $comentario->settexto($contenidoComentario);
        $comentario->setidUsuario($_SESSION['usuario']);
        $comentario->setidPelicula($_SESSION['pelicula']);

        if (es\fdi\ucm\aw\DAOComentario::create($comentario)) {
            $error = '<label class="exito"> Comentario añadido </label>';
        } else {
            $error = '<label class="exito"> Error al añadir comentario </label>';
        }
    }

    $data = array(
        'error' => $error
    );

    echo json_encode($data);
}


function buscarComentario()
{
    $salida = '';
    $idPelicula = $_SESSION['pelicula'];

    $resultado = DAOComentario::readComentariosPelicula(0, $idPelicula);
    if (isset($resultado)) {
        foreach ($resultado as $fila) {
            $user = Usuario::buscaUsuario($fila->getIdUsuario());
            $valoracion = DAOValoracion::readValoracion($idPelicula, $user->getApodo());
            if (isset($valoracion)) {
                ($valoracion->getValoracion() >= 5) ?  $val5 = 'checked ="checked"' : $val5 = '';
                ($valoracion->getValoracion() >= 4 && $valoracion->getValoracion() < 5) ?  $val4 = 'checked ="checked"' : $val4 = '';
                ($valoracion->getValoracion() >= 3 && $valoracion->getValoracion() < 4) ?  $val3 = 'checked ="checked"' : $val3 = '';
                ($valoracion->getValoracion() >= 2 && $valoracion->getValoracion() < 3) ?  $val2 = 'checked ="checked"' : $val2 =  '';
                ($valoracion->getValoracion() >= 1 && $valoracion->getValoracion() < 2) ?  $val1 = 'checked ="checked"' : $val1 = '';
            } else {
                $val1 = ''; $val2 = ''; $val3 = ''; $val4 = '';  $val5 = ''; 

            }
            $salida .= '<img src=' . $user->geturlFoto() . ' alt="imagen ' . $user->getApodo() . '" id="avatar"">';
            $salida .= '<div class = "panelComentario">';

            $salida .=  '<div class = "cabeceraComentario">' . $fila->getIdUsuario() . ' <span> ' . $fila->getfecha() . '

       <button type="button" id="' . $fila->getidComentario() . '" class ="responder"> 
       <img src="media/responder.png" alt="imagen" id="iconoResponder"">
   </button>
        </span>';
            $salida .= '<form class="rate">
        <input type="radio" id="star5" name="estrellas" value= 5 ' . $val5 . '>
        <label for="star5"> &#9733; </label>
        <input type="radio" id="star4" name="estrellas" value= 4 ' . $val4 . '>
        <label for="star4"> &#9733;</label>
        <input type="radio" id="star3" name="estrellas" value= 3 ' . $val3 . '>
        <label for="star3"> &#9733;</label>
        <input type="radio" id="star2" name="estrellas" value= 2 ' . $val2 . '>
        <label for="star2"> &#9733;</label>
        <input type="radio" id="star1" name="estrellas" value= 1 ' . $val1 . '>
        <label for="star1"> &#9733;</label>
       </form> ';

            $salida .= '  </div> 
            <div class="contenidoComentario">' . $fila->getTexto() . ' </div> </div>';

            $salida .= cogerRespuestasAComentarios($fila->getidComentario());
        }
    }


    echo $salida;
}


function cogerRespuestasAComentarios($idPadre = 0, $margen = 0)
{
    $resultado = DAOComentario::readRespuestas($idPadre);
    if ($idPadre == 0) {
        $margen = 0;
    } else {
        $margen = $margen + 50;
    }
    $salida = '';
    if (isset($resultado)) {
        foreach ($resultado as $fila) {
            $user = Usuario::buscaUsuario($fila->getIdUsuario());
            $salida .= '<img src=' . $user->geturlFoto() . ' alt="imagen ' . $user->getApodo() . '" id="avatar"" style="margin-left:' . $margen . 'px">';
            $salida .= '<div class = "panelComentario" style="margin-left:' . $margen . 'px">';
            $salida .=  '<div class = "cabeceraComentario">' . $fila->getIdUsuario() . ' <span> ' . $fila->getfecha() . '</span> <button type="button" id="' . $fila->getidComentario() . '" class ="responder"> <img src="media/responder.png" alt="imagen" id="iconoResponder""></button></div> <div class="contenidoComentario">' . $fila->getTexto() . ' </div>';
            $salida .= '</div>';
            $salida .= cogerRespuestasAComentarios($fila->getidComentario(), $margen);
        }
    }
    return $salida;
}

//LLamamos a las funciones según qué queremos hacer
if (isset($_POST['accionComentario']) && !empty($_POST['accionComentario'])) {
    $accion = $_POST['accionComentario'];
    switch ($accion) {
        case 'addComentario':
            addComentario();
            break;
        case 'buscarComentario':
            buscarComentario();
            break;
    }
}
