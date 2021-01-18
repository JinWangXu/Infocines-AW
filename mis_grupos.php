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
	<link rel="stylesheet" type="text/css" href="css/gruposForo.css">
	<title>
		Mis Grupos
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

				<?php
				if(isset($_SESSION["login"])){

					$grupos = DAOGrupo::listarGrupos($_SESSION["usuario"]);

					echo "<h2 class='content'>Esta es la lista de tus grupos:</h2>";
					
					if($grupos != NULL){
						echo "<div class='tabla'>";
							for ($i=0; $i < sizeof($grupos); $i++) { 
								$idGrupo = $grupos[$i]->getidGrupo();
								$nomGrupo  = $grupos[$i]->getnombreGrupo();
								$tipo = $grupos[$i]->gettipo();
								if($tipo == 'publico'){
									echo "<div><button class='buttonDefault' id='misGruposPublicos' onclick=\"location.href='GrupoConcreto.php?id=".$idGrupo."'\">".$nomGrupo."</button> (público)</div>";
								}
								else if($tipo == 'privado'){
									echo "<div><button class='buttonDefault' id='misGruposPrivados' onclick=\"location.href='GrupoConcreto.php?id=".$idGrupo."'\">".$nomGrupo."</button> (privado)</div>";
								}
							}
						echo "</div>";
					}else{
						echo"<p class='content'>No estás en ningún grupo</p>";
					}
				}
				else{
					echo "<p class='content'>No estás registrado.</p>";
				}
				?>

				<button class="buttonDefault" onclick="location.href='foro_grupos.php'">Volver</button>
			</div>
		</div>
	</div>
</body>
</html>