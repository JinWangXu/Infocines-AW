<?php 
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOGrupo as DAOGrupo;
use es\fdi\ucm\aw\DAOMiembro as DAOMiembro;
use es\fdi\ucm\aw\TOMiembro as TOMiembro;

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
	<title>Lista miembros</title>
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/notificaciones.js"></script>
	<script type="text/javascript" src="js/grupos.js"></script>

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
					$idGrupo = $_GET['idGrupo'];
					$miembro = $_GET['miembro'];
					$user = $_SESSION["usuario"];

					$miembroClick = new TOMiembro();

					$grupo = DAOGrupo::buscar($idGrupo);
					$nomGrupo = $grupo->getnombreGrupo();

					

					$miembroClick = DAOMiembro::buscar($miembro,$idGrupo);
					$rolClick = $miembroClick->getrol();
					$miembroPropio = DAOMiembro::buscar($user,$idGrupo);
					$rolPropio = $miembroPropio->getrol();

					echo "<h1 class='content'>Grupo: ".$nomGrupo. "</h1>";

					echo "<p class='content'>Apodo del participante: ".$miembro. "</p>";
					echo "<p class='content'>Rol de ".$miembro." en el grupo: ".$rolClick. "</p>";


					if($rolPropio == "propietario"){
						if($rolClick == "moderador"){

							echo sprintf ("<button class='buttonDefault' id = 'nuevo' onclick=\"accionGrupo('%d', '%s', 'cambiarRol', 'usuario')\" >Quitar de moderadores</button>", $idGrupo, $miembro);
							echo sprintf ("<button class='buttonDefault' id = 'exit' onclick=\"accionGrupo('%d', '%s', 'echar', null)\" >Expulsar del grupo</button>", $idGrupo, $miembro);
						}

						if($rolClick == "usuario"){
							echo sprintf ("<button class='buttonDefault' id = 'nuevo' onclick=\"accionGrupo('%d', '%s', 'cambiarRol', 'moderador')\" >Añadir a moderadores</button>", $idGrupo, $miembro);
							echo sprintf ("<button class='buttonDefault' id = 'exit' onclick=\"accionGrupo('%d', '%s', 'echar', null)\" >Expulsar del grupo</button>", $idGrupo, $miembro);
						}
					}else if($rolPropio == "moderador"){

						if($rolClick == "usuario"){
							echo sprintf ("<button class='buttonDefault' id = 'exit' onclick=\"accionGrupo('%d', '%s', 'echar', null)\" >Expulsar del grupo</button>", $idGrupo, $miembro);
						}
					}
					echo "<button class='buttonDefault' onclick=\"location.href='GrupoConcreto.php?id=".$idGrupo."'\">Volver</button>";	
				?>
			</div>
		</div>
	</div>
</body>
</html>