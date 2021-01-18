<?php
require_once __DIR__.'/includes/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/buscados.js"></script>
	
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/gruposForo.css">
	<title>
		Buscar Grupo
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
			<h1 class="content"> Resultados de la búsqueda:</h1>
			<p class="content"> Los grupos a los que perteneces aparecerán en verde (independientemente de si es público o privado). Los grupos a los que no perteneces pero puedes unirte 
			se mostrarán de color azul. Los grupos privados a los que no puedes acceder sin invitación, serán grises.</p>
			
	
				<script>
					$(document).ready(start('<?php $nombre = htmlspecialchars(trim(strip_tags($_GET['nombre']))); echo $nombre; ?>'));
				</script>

				<div id="mostrarGrupoBuscado">

				</div>
	</div>
</div>
</body>
</html>