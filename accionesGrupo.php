<?php
	
	require_once __DIR__.'/includes/config.php';
	use es\fdi\ucm\aw\DAOGrupo as DAOGrupo;
	use es\fdi\ucm\aw\DAOMiembro as DAOMiembro;
	use es\fdi\ucm\aw\DAORespuesta as DAORespuesta;
	use es\fdi\ucm\aw\DAOTema as DAOTema;

function salir ($idGrupo, $user){
		$grupo = DAOGrupo::buscar($idGrupo);
		$nomGrupo = $grupo->getnombreGrupo();

		$deleted = DAOMiembro::deleteMember($user, $idGrupo);

		if ($deleted) {
		
			$propietario = DAOMiembro::getPropietario($idGrupo);
			
			if($propietario == NULL){
				
				if(DAOMiembro::seleccionarPropietario($idGrupo)){
					$prop = DAOMiembro::getPropietario($idGrupo);
					echo json_encode(['exito' => 1, 'mensaje' => "Has salido del grupo siendo el propietario",'tipo' => "w",'user' => $prop, 'info' => "Eres el nuevo propietario del grupo: ".$nomGrupo ]);
					

				}else{

					echo json_encode(['exito' => 1, 'mensaje' => "Has salido del grupo" ,'tipo' => "n"]);
				}
				
			}else{
			
				echo json_encode(['exito' => 1, 'mensaje' => "Has salido del grupo",'tipo' => "n" ]);
			}
					 
		}else{
		
			echo json_encode(['exito' => 0, 'mensaje' => "Error al salir del grupo" ]);
		}
	}

	function unirse($idGrupo){
		$date = date("Y") . "-" . date("m") . "-" . date("d") . " " . date("H") . ":" . date("i") . ":" . date("s");
		$user = $_SESSION["usuario"];
		
		$added = DAOMiembro::addmember($user, $idGrupo, $date,"usuario");
		if ($added) {
			echo json_encode(['exito' => 1, 'mensaje' => "Te has unido", 'tipo' => "x" ]);
		}else{
			echo json_encode(['exito' => 0, 'mensaje' => "Error al unirse al grupo",'tipo' => "x" ]);
		}
	}


	function cambiarRol($nomMiembro, $idGrupo, $rol){
		$member = DAOMiembro::buscar($nomMiembro,$idGrupo);
		$formerRol = $member->getrol();
		if(DAOMiembro::cambiarRol($nomMiembro, $idGrupo, $rol)){
			$gr = DAOGrupo::buscar($idGrupo);
			$nomGrupo = $gr->getnombreGrupo();
			if($rol == "ban"){
				echo json_encode(['exito' => 1, 'mensaje' => "Miembro expulsado y baneado" , 'tipo' => "r" ,'user' => $nomMiembro,'grupo' => $idGrupo, 'info' => "Te han expulsado y baneado del grupo: ".$nomGrupo]);
			}else if($formerRol == "ban"){
				echo json_encode(['exito' => 1, 'mensaje' => "Ban quitado", 'tipo' => "i" ,'user' => $nomMiembro,'grupo' => $idGrupo, 'info' => "Te han quitado el ban en el grupo: ".$nomGrupo]);
			}else{
				echo json_encode(['exito' => 1, 'mensaje' => "Rol cambiado", 'tipo' => "i" ,'user' => $nomMiembro,'grupo' => $idGrupo, 'info' => "Te han modificado el rol a ".$rol." en: ".$nomGrupo]);
			}
			
		}else{
			echo json_encode(['exito' => 0, 'mensaje' => "Error al cambiar rol" ]);
		}

	}

	function mostrarGrupo($grupo){
		

		$idGrupo = $grupo->getidGrupo();
		$nomGrupo  = $grupo->getnombreGrupo();
		if(isset($_SESSION["login"])){
			$user = $_SESSION["usuario"];
		}else{
			$user = NULL;
		}

		if($user != NULL){

			echo "<div>".$nomGrupo;
			echo "<div>";
			echo " [Nº Temas: ".DAOTema::numeroTemas($idGrupo)."]";
			$temas = DAOTema::listar($idGrupo);
			$numRespuestas = 0;
			if($temas != null){
				foreach ($temas as $tema) {
					$numRespuestas = $numRespuestas + DAORespuesta::numeroRespuestas($tema->getidTema());
				}
			}
			
			echo "[ Nº comentarios: ".$numRespuestas."]";
			echo "</div>";

			if(DAOMiembro::isBanned($user,$idGrupo)){
				
				echo sprintf("<button disabled id='btnban' disabled>Ban</button></div>");
				
			}else if(DAOMiembro::isMember($user,$idGrupo)){
			
				echo sprintf ("<button class='buttonDefault' id='btnver' onclick=\"location.href='GrupoConcreto.php?id=".$idGrupo."'\">Ver</button></div>");
			}else{
				
				echo sprintf ("<button class='buttonDefault' id = 'btnunirse' onclick=\"accionGrupo('%d', '%s', 'unirse', null)\" >Unirse</button>", $idGrupo, $user);
				echo "</div>";
			}
			
		}else{
			echo "<div>".$nomGrupo."</div>";
		}
			
	}




	function listarPublico(){
		$grupos = DAOGrupo::listarPublico();
		echo'<h3 class="content">Grupos públicos del foro</h3>';


		if(!isset($_SESSION["login"])){
			echo '<p>Para poder participar en los grupos, logueate!</p>';
		}

		if(isset($grupos)){
			echo "<div class='tabla'>";
			foreach ($grupos as $gr) {
				mostrarGrupo($gr);
			}
		}else{
			echo "<p>No hay grupos publicos</p>";
		}
		echo "</div>";
		
	}

	function listarBuscado($nombre){
		$grupos = DAOGrupo::listarPorNombre($nombre);
		echo'<h3 class="content">Grupos públicos del foro</h3>';

		if(!isset($_SESSION["login"])){
			echo '<p>Para poder participar en los grupos, logueate!</p>';
		}

		if(isset($grupos)){
			echo "<div class='tabla'>";
			foreach ($grupos as $gr) {
				mostrarGrupo($gr);
			}
		}else{
			echo "<p class='content'>No existe ningún grupo que contenga: ".$nombre."</p>";
		}
		echo "</div>";
		
	}

	
	function borrarRespuesta($id){
		if(DAORespuesta::delete($id)){
			echo json_encode(['exito' => 1, 'mensaje' => "Mensaje borrado", 'tipo' => "a"]);
		}else{
			echo json_encode(['exito' => 0]);
		}
		
	}

	function borrarTema($id){
		if(DAOTema::delete($id)){
			echo json_encode(['exito' => 1, 'mensaje' => "Mensaje borrado"]);
		}else{
			echo json_encode(['exito' => 0]);
		}
		
	}



	

	
	$grupo = isset($_POST["grupo"]) ? htmlspecialchars(trim(strip_tags($_POST["grupo"]))) : null;
	$user = isset($_POST["user"]) ? htmlspecialchars(trim(strip_tags($_POST["user"]))) : null;
	$accion = isset($_POST["accion"]) ? htmlspecialchars(trim(strip_tags($_POST["accion"]))) : null;
	$rol = isset($_POST["rol"]) ? htmlspecialchars(trim(strip_tags($_POST["rol"]))) : null;
	
	switch($accion){
	
		case "salir":{
			
			salir($grupo, $user);
		}
			
		break;

		case "unirse":{
			
			unirse($grupo);

		}
		break;

		case "echar":{
			
			cambiarRol($user,$grupo,"ban");

		}
			
		break;

		case "cambiarRol":{
			
			cambiarRol($user,$grupo,$rol);

		}
			
		break;
		case "listarPublico":{

			listarPublico();

		}
			
		break;

		case "borrarRespuesta":{

			borrarRespuesta($grupo);

		}
			
		break;

		case "borrarTema":{

			borrarTema($grupo);

		}
			
		break;

		case "quitarBan":{

			cambiarRol($user,$grupo,"usuario");

		}
			
		break;

		case "mostrarBuscado":{

			listarBuscado($grupo);

		}
			
		break;



	}
	
	
	
	
	
	
	
	
	
	
	
	

?>