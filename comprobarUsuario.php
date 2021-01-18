<?php

use es\fdi\ucm\aw\Usuario;

require_once __DIR__.'/includes/config.php';

$nombreUsuario = isset($_GET["user"]) ? htmlspecialchars(trim(strip_tags($_GET["user"]))) : null;

$toUser = Usuario::buscaUsuario($nombreUsuario);
if(isset($toUser)){
    echo 'existe';
}
else{
    echo 'disponible';
}
?>