<?php
require_once __DIR__.'/includes/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/grupos.js"></script>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/gruposForo.css">
	<title>
		Grupos
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
			
			
			<?php
				if(isset($_SESSION["login"])) {
						
						echo "<button class='buttonDefault' id='nuevo' onclick=\"location.href='crear_grupo.php'\">Nuevo grupo</button>";
						echo "<button class='buttonDefault' onclick=\"location.href='mis_grupos.php'\">Mis grupos</button>";
				}	
			?>	

			<form action="buscarGrupo.php" method="GET">
				<label>Buscar grupo:</label><input type="text" name="nombre">
				<button class="buttonBuscar" type="submit"></button>
			</form>
			
			
		<div id="mostrarGrupos">
		</div>

				
		

		</div>	

	</div>
</div>

</body>
</html>