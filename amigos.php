<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\Usuario as Usuario;

if (!isset($_SESSION["login"])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/amigos.css">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/relacionusuarios.js"></script>
	

	<title>Amigos</title>
</head>
<body>
	<div class="contenedor">
	<?php
		require('includes/comun/cabecera.php');
	?>

	<section class="form_wrap">
	
	<?php
		$miCuenta = Usuario::buscaUsuario($_SESSION['usuario']);
		?>

		<div class="form_contact">
		
		<button id="botonAdd" class="botonAmigos"> <span>Añadir amigo </span></button>
		<button id="botonVer" class="botonAmigos"> <span>Ver amigos </span></button>
		<button id="botonPeticiones" class="botonAmigos"> <span>Ver peticiones </span></button>
		<button id="botonBloqueados" class="botonAmigos"> <span>Bloqueados </span></button>
	<br><br>
		<div id="lista"></div>
	
		</div>
</section>
</div>
</body>
</html>
