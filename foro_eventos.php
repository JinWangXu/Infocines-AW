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
	<title>
		Eventos
	</title>
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
		<div class="content">
			<h1 class="content">Próximos eventos cinematográficos: </h1>
			<?php
				if (isset($_SESSION["esAdmin"])) {
					echo '<p>Sube eventos a la página: ';
					echo '<button class="buttonCE" onclick="location.href=\'subirNoticias.php\'">Añadir</button></p>';
				}
				echo '<p>Busca eventos con filtros: ';
				echo '<button class="buttonCE" onclick="location.href=\'buscarEvento.php\'">Buscar</button></p>';
				
				$numEventos = DAOEvento::getRowCount();
				if($numEventos > 0){
				
					$event = new TOEvento();
					$listaEventos = DAOEvento::listarEventos();
			
					foreach ($listaEventos as $key) {
						echo '<div class="marco">';
						$event = $key;
						echo '<h2 class="content" id="highlight">'.$event->getTitulo().'</h2>';
						echo '<a href="foro_eventos_noticia.php?id='.$event->getIdEvento().'"> 
						<img class="miImagen" src=' . $event->getUrlImagen().' alt="imagen ' . $event->getTitulo().'" > </a> ';	
						echo '</div>';
					}
				}
				else{
					echo '<h2 class="content">Aún no hay eventos.</h2>';
					echo '<p class="content">¡Estate pendiente porque pronto publicaremos nuestros próximos eventos!</p>';
				}
			?>	
			
		</div>
	</div>
</div>
</body>
</html>