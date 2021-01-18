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
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/general.css">
	<link rel="stylesheet" type="text/css" href="css/verMiembros.css">
	<title>Lista miembros</title>
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

				$miembros = DAOMiembro::listarMiembros($idGrupo);
				$grupo = DAOGrupo::buscar($idGrupo);
				$creador = $grupo->getcreadorGrupo();

			   echo "<h2 class='content'>Creador original del grupo (".$grupo->getnombreGrupo()."): ".$grupo->getcreadorGrupo()."</h2>";
			   
			   echo "<h2 class='content'>Fecha creacion: ".$grupo->getfecha()."</h2>";
			   
					  
			echo "<h2 class='content'>Lista de miembros: </h2>";
			
			echo "<div class='cuadriculaVM'>";
				echo "<div>El propietario es:  ".DAOMiembro::getPropietario($idGrupo)."</div>";
				
			
					if(sizeof($miembros) < 2){

						echo "<div>No hay más miembros en el grupo. Puedes añadir nuevos miembros ";
						echo "<a href='addMiembro.php?&idGrupo=".$idGrupo."'>aquí</a></div>";
						
					}else{
						
						
							echo "<div>Los usuarios del grupo aparecerán a continuación: </div>";
							for ($i=0; $i < sizeof($miembros); $i++) { 
								$rol = $miembros[$i]->getrol();
									if($rol!='propietario'){
										if($rol != 'ban'){
											$usuario = $miembros[$i]->getid_usuario();
											echo "<div>".$usuario."  ";
											echo "<a href='ver_operaciones.php?miembro=".$usuario."&idGrupo=".$idGrupo."'>   Acceder al perfil</a></div>";
										}
										
									}
							}
						
					
					}
					if(DAOMiembro::isPropietario($_SESSION["usuario"],$idGrupo)){
						echo "<div>Aquí puedes ver los miembros baneados <button class='buttonDefault' onclick=\"location.href='ver_bans.php?idGrupo=".$idGrupo."'\">Ver Bans</button></div></div>";
					}	

			echo "</div>";

			?>
</div>
</div>
</div>

</body>
</html>