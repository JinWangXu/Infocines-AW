<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOGrupo as DAOGrupo;
use es\fdi\ucm\aw\DAOTema as DAOTema;
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
	<script type="text/javascript" src="js/grupos.js"></script>
	<script type="text/javascript" src="js/notificaciones.js"></script>


	
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/temasForo.css">
	<title>
		Grupo Concreto
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


			   $id = htmlspecialchars(trim(strip_tags($_GET['id'])));
			   $user = $_SESSION["usuario"];
			   
			   $grupo = DAOGrupo::buscar($id);


			   $tema = DAOTema::listar($id);
			   $_SESSION['grupo'] = $id;
				
			if(isset($_SESSION["login"])){
				echo"<button class='buttonDefault' id='nuevo' onclick=\"location.href='crear_tema.php'\">Nuevo Tema</button>";
			}
			
			#ver miembros
			echo"<button class='buttonDefault' onclick=\"location.href='ver_miembros.php?idGrupo=".$id."'\">Ver miembros</button>";
			

			#añadir miembro
			if(DAOMiembro::isPropietario($_SESSION["usuario"],$id)){
				echo"<button class='buttonDefault' id='nuevo' onclick=\"location.href='addMiembro.php?idGrupo=".$id."'\">Añadir miembro</button>";
			}	

			#salir del grupo
			echo sprintf ("<button class='buttonDefault' id = 'exit' onclick=\"accionGrupo('%d', '%s', 'salir', null)\" >Salir del grupo</button>", $id, $user);

			#volver
			echo "<button class='buttonDefault' onclick=\"location.href='foro_grupos.php'\">Volver</button>";

				
			   echo "<p class='content'>Temas del grupo (".$grupo->getnombreGrupo()."):</p>";

			   if ($tema == NULL) {

				echo "<p class='content'> No hay temas creados en este grupo. ¡Sé el primer@ en poner uno!</p>";

			   }else{
				echo "<div class='tabla'>";
					for ($i=0; $i < sizeof($tema); $i++) { 
				
					    $idT = $tema[$i]->getidTema();
					
						echo "<div>".$tema[$i]->gettitulo().
						"<div>".$tema[$i]->getdescripcion()."</div>".
						"<button class='buttonDefault' id='miBoton' onclick=\"location.href='temaConcreto.php?id=".$idT."'\">Ir</button></div>";

						
					}
				echo "</div>";
			   }   
			?>
		</div>
	</div>
</div>

</body>
</html>