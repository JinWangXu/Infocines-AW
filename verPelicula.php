<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOPelicula as DAOPelicula;
use es\fdi\ucm\aw\TOPelicula as TOPelicula;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/cssPeliculas.css">
	<title>Ver película</title>
</head>
<body id="modoOscuro">
	<?php
		require('includes/comun/cabecera.php');
	?>
	<div class="contenedor">
	<section class="main">
		<button class='tema'>Modo nocturno</button>
		<?php
			$infoPelicula = DAOPelicula::read($_GET["id"]);
			echo '<div id="verPContainer">
					<h3 class="tit">' . $infoPelicula->getTitulo() . '</h3>
					<video width="1000" height="600" controls>
					<source src="' . $infoPelicula->getUrlPelicula() . '" type="video/mp4">
						Video no soportado
					</video> 
				</div>';
		?>
		
	</section>
</div>
</body>
<script type="text/javascript" src="js/pelicula.js"></script>
</html>
