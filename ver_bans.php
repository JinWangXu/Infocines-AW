<?php 
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOGrupo as DAOGrupo;
use es\fdi\ucm\aw\DAOMiembro as DAOMiembro;


if (!isset($_SESSION["login"])) {
	header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/notificaciones.js"></script>
	<script type="text/javascript" src="js/grupos.js"></script>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/verMiembros.css">
	<title>Ver Bans</title>
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

				$miembros = DAOMiembro::listarMiembrosBaneados($idGrupo);

			echo "<h2 class='content'>Lista de miembros: </h2>";
			
			echo "<div class='cuadriculaVM'>";
				
			
					if($miembros == NULL){

						echo "<div>No hay miembros baneados</div>";
						
					}else{
						
							for ($i=0; $i < sizeof($miembros); $i++) { 
								$rol = $miembros[$i]->getrol();
									if($rol!='propietario'){
										$usuario = $miembros[$i]->getid_usuario();
										echo "<div>".$usuario."  ";
                                        echo sprintf ("<button class='buttonDefault' onclick=\"accionGrupo('%d', '%s', 'quitarBan', null)\">Quitar ban</button></div>"
                                        ,$idGrupo
                                        ,$miembros[$i]->getid_usuario());
									}
							}
						
					}
			echo "</div>";

			?>
</div>
</div>
</div>

</body>
</html>