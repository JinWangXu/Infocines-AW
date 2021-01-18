<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\FormCrearGrupo as FormCrearGrupo;

if (!isset($_SESSION["login"])) {
	header("location:index.php");
}

$form = new FormCrearGrupo();
$html = $form->gestiona();


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/formularioForo.css">
	<title>Crear grupo</title>
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
				


<?= $html ?>

				<br>

				<button onclick="location.href='foro_grupos.php'">Volver</button>
			</div>
		</div>
	</div>
</body>
</html>

