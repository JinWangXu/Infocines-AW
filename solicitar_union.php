<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOGrupo as DAOGrupo;

if (!isset($_SESSION["login"])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<title>Solicitar union</title>
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/grupos.js"></script>
	<script type="text/javascript" src="js/notificaciones.js"></script>
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
				<?php
					$idGrupo = $_GET['id'];
					$grupo = DAOGrupo::buscar($idGrupo);
					$user = $_SESSION["usuario"];
					echo "<h2 class='content'>No perteneces al grupo: ".$grupo->getnombreGrupo()."</h2>";
					echo "<p class='content'>Descripción:  ".$grupo->getDescripcion()."</p>";
					#echo "<button class='buttonDefault' id='nuevo' onclick=\"location.href='procesarUnionMiembro.php?id=".$idGrupo."'\" >Unirse al grupo</button>";
					echo sprintf ("<button class='buttonDefault' id = 'unirse' onclick=\"accionGrupo('%d', '%s', 'unirse', null)\" >Unir al grupo</button>", $idGrupo, $user);
				?>
			</div>

		</div>
	</div>
</body>
</html>