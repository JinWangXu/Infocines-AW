<?php


require_once __DIR__.'/includes/config.php';

function addAmigos(){

    echo '<input type="text" id="buscador" name="buscador">';
    echo '<div id="resultadoBusqueda"> <p>Introduce un apodo de usuario para buscar</p> </div>';
}

function verAmigos($apodo){
    
}

function verPeticiones(){

}

function verBloqueados(){

}

if(!isset($_SESSION['usuario'])){
    echo json_encode(['exito' => 0, 'mensaje' => "No tienes permisos de acceso"]);
}
else {
    $peticion = isset($_POST['peticion']) ? htmlspecialchars(trim(strip_tags($_POST['peticion']))) : null;
    switch ($peticion) {
        case 'add':
            addAmigos();
            break;
        case 'verAmigos':
            verAmigos($apodo);
            break;
        case 'verPeticiones':
            verPeticiones();
            break;
        case 'verBloqueados':
            verBloqueados();
            break;
    }
}


?>