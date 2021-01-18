<?php 
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOPelicula as DAOPelicula;
use es\fdi\ucm\aw\TOPelicula as TOPelicula;
use es\fdi\ucm\aw\DAOGenero as DAOGenero;
use es\fdi\ucm\aw\TOGenero as TOGenero;
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/pelicula.js"></script>

	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/cssPeliculas.css">
	<title>
		Películas
	</title>
</head>
<body>
	<div class="contenedor">
		<?php
		require('includes/comun/cabecera.php');
		?>
		<section class="main">
			<div class ="container">	
				<div class="flexbottomContainer">
					<?php
					if (isset($_SESSION["esAdmin"])) {
						echo '<a href="subirPelicula.php" class="bottomAdmin" > Añadir película </a>';
					}

					echo '<a href="buscarPelicula.php" class="bottomAdmin" > Buscar película </a>';
					?>
					
				</div>


				<!-- Buscador de peliculas -->
				<table>
				<tr>	
				<td>
				<p>Título: </p>
				<input type="text" id="tituloPeliBuscar" name="tituloPeliBuscar">
				</td>
				<?php
				$actual = intval(date('Y')); 
				$primerAnio = 1950; 
				echo '<td>';
				echo '<p> Año: </p>';
				echo '<select id="anioPeliBuscar" name="anioPeliBuscar">';
				echo '<option value="0" selected> </option>';
				foreach ( range( $actual, $primerAnio ) as $i ) {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
				echo '</select>';
				echo '</td>';

				echo '<td>';
				echo '<p> Género: </p>';
				echo '<select id="generoPeliBuscar" name="generoPeliBuscar">
                <option value="0" selected> </option>';
                $generos = DAOGenero::list();
				foreach ($generos as $genero) {
					echo '<option value="' . $genero->getIdGenero() . '" >' . $genero->getTipo() . '</option>';
				}

				echo '</select>';
				echo '</td>';
				?>
				

				<td>
				<p> Valoración: </p>
				<?php
				echo '<select id="valoracionPeliBuscar" name="valoracionPeliBuscar">';
				echo '<option value="0" selected> </option>';
				foreach ( range( 1, 5) as $i ) {
					//seleccionamos por defecto el anio actual
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
				echo '</select>';
				?>

				<td>
				<p>Director: </p>
				<input type="text" id="directorPeliBuscar" name="directorPeliBuscar">
				</td>
			</td>
				</tr>
				</table>
				<br>
				<!-- Fin buscador peliculas -->

				<div id="peliculasMostradas">
				<?php
				$listaGenero = DAOGenero::listarGeneros();
				foreach ($listaGenero as $key) {
					$gen = $key;
					echo'<div class="grid-container">
					<div class= "item1"> '.$gen.' </div>	
					<div class="grid-subContainer">';
					$listaPeliculas = DAOPelicula::listarPeliculaxGenero($gen);	
					if(isset($listaPeliculas)){
						foreach ($listaPeliculas as $key2) {
							$peli = $key2;
							echo '<div class="grid-sub2Container">  <div class="tituloPelicula"> '. $peli->getTitulo().' </div>  <div class="imagenPelicula"> <a class="nom" href="peliculaConcreta.php?id='.$peli->getIdPelicula().'"> <img src=' .$peli->getUrlImagen().' alt="imagen ' . $peli->getIdPelicula().'" id="widthImg""> </a> </div> </div>';	

						}
					}
					else{
						echo 'No hay películas de éste género aún';
					}
					echo '</div> </div>';
				}
				?>
				</div>
			</div>
		</div>
	</section>
</div>
</body>
</html>