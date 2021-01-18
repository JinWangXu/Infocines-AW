<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAONotificaciones as DAONotificaciones;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/notificaciones.js"></script>

	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/cssNotificaciones.css">
	<title>
		Notificaciones
	</title>
	<body>
		<div class="contenedor">
			<?php
			require('includes/comun/cabecera.php');
			?>
			<section class="contenido">

			<h1>Notificaciones</h1>
			
			<div id="mostrarNotificaciones">
			</div>


			</section>
		</div>
	</body>
	</html>