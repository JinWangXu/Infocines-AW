<?php 
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOEvento as DAOEvento;
use es\fdi\ucm\aw\TOEvento as TOEvento;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<title>Evento</title>
</head>
<body id="foro">
<div class="contenedor">
		<?php
			require('includes/comun/cabecera.php');
		?>
	<div class="principal">
		<div class="nav">
			<?php
				require('includes/comun/menu_foro.php');
			?>
		</div>
		<div id="content">
			<?php
			$infoEvento = new TOEvento();
			$infoEvento = DAOEvento::read($_GET["id"]);

			echo '<h1 class="content">' . $infoEvento->getTitulo() . '</h1>';
			echo '<div id="evento">';
			echo '<h2 class="content"> Este evento tendrá lugar el ' . $infoEvento->getFecha() . 
				' en '. $infoEvento->getCiudad() .', '. $infoEvento->getPais() .'</h2>';
			echo '<img class="miImagen" src=' . $infoEvento->getUrlImagen(). ' >';
			echo '<p class="content">' . $infoEvento->getDescripcion() . '</p>';
			echo '</div>';
			?>
		</div>

	</div>
</div>
</body>
</html>