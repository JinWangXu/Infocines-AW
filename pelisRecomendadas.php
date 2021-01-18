<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOPelicula as DAOPelicula;
use es\fdi\ucm\aw\DAOFavorito as DAOFavorito;
use es\fdi\ucm\aw\DAORecomendacion as DAORecomendacion;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/peliculasRecomendadas.js"></script>
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/cssIndex.css">
	<title>
		InfoCines
	</title>
	<body>
		<div class="contenedor">
			<?php
			require('includes/comun/cabecera.php');
			?>
			<section class="contenido">
			<?php
				if (isset($_SESSION['usuario'])) {
					echo '<h1 id="TituloBienvenida">Películas Recomendadas</h1>';
					echo '<h3 id="SubtituloBienvenida">¡Estas son las películas que te recomiendan tus amigos!</h3>';
			
							echo '<h3 id="SubtituloBienvenida">Borra aquí todas las recomendaciones';
							echo sprintf(" <button id= \"borrarTodo\" onclick=\"procesar('', 'eliminarAllPerliculasRecomendadas')\"> Borrar Todo </button> </h4>"); 
							echo '</h3>';
							echo '<div class="grid-container">';
							echo '<div class="grid-subContainer" id="contenedorPelis">';
					
							echo '</div></div>';
				}
				else{
					
				}

			?>
			</section>
		</div>
	</body>
	</html>
