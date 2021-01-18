<?php 
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\FormCrearEvento as FormCrearEvento;
	if (!isset($_SESSION["login"])) {
			header("location:index.php");
	}

	$form = new FormCrearEvento;
$html = $form->gestiona();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/formularioForo.css">
	<title>
		Añadir evento
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
			<div id="content">

			<?= $html ?>

			</div>
		</div>
	</div>
</body>
</html>