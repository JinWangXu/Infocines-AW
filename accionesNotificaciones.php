<?php
	
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAONotificaciones as DAONotificaciones;
use es\fdi\ucm\aw\TONotificaciones as TONotificaciones;

	function delete($id){
		if(DAONotificaciones::delete($id)){
            echo json_encode(['exito' => 1, 'mensaje' => "Has borrado" ]);
		}else{
			echo json_encode(['exito' => 0, 'mensaje' => "Error al borrar" ]);
		}
	}

	//i = informacion (aparece la notificacion en azul)
	//r = warning (aparece en rojo)
	//a = success (aparece amarillo)
	function mostrarNotificacion($notificacion){
		switch ($notificacion->gettipo()) {
			case 'i':

				echo sprintf ("<div class=\"alert info\">
				<span class=\"closebtn\" onclick =\"accionNotificacion(%d,'delete')\">&times;</span>%s
				</div>",$notificacion->getid_notificacion(),$notificacion->getinfo());
				break;
			case 'r':

				echo sprintf ("<div class=\"alert warning\">
				<span class=\"closebtn\" onclick =\"accionNotificacion(%d,'delete')\">&times;</span>%s
				</div>",$notificacion->getid_notificacion(),$notificacion->getinfo());
				break;

			case 'a':

				echo sprintf ("<div class=\"alert success\">
				<span class=\"closebtn\" onclick =\"accionNotificacion(%d,'delete')\">&times;</span>%s
				</div>",$notificacion->getid_notificacion(),$notificacion->getinfo());
				break;

			default:
				# code...
				break;
		}
	}


	function listar(){
		$lista = DAONotificaciones::listar($_SESSION["usuario"]);
		if(isset($lista)){
			echo "<button id=\"borrarAll\" onclick = \"accionNotificacion(0, 'deleteAllUser')\">Borrar todas las notificaciones</button>";
			foreach ($lista as $noti) {
				mostrarNotificacion($noti);
			}
		}else{
			echo "<p>No hay notificaciones</p>";
		}
		
	}

	function crear($user, $info, $tipo){

		$notificacionTO = new TONotificaciones();
		$notificacionTO->setuser($user);
		$notificacionTO->setinfo($info);
		$notificacionTO->settipo($tipo);

		if(DAONotificaciones::create($notificacionTO)){
            echo json_encode(['exito' => 1, 'mensaje' => "Notificacion enviada" ]);
		}else{
			echo json_encode(['exito' => 0, 'mensaje' => "Error al enviar notificacion"]);
		}
	}



	function deleteAllUser(){
		if(DAONotificaciones::deleteAllFromUser($_SESSION["usuario"])){
            echo json_encode(['exito' => 1, 'mensaje' => "Borradas todas las notificaciones" ]);
		}else{
			echo json_encode(['exito' => 0, 'mensaje' => "Error al borrar las notificaciones" ]);
		}
	}

	function getContador(){
		$num = DAONotificaciones::getNumeroNotificaciones($_SESSION["usuario"]);
		echo json_encode(['contador' => $num]);
	}
	

    $accion = isset($_POST["accion"]) ? htmlspecialchars(trim(strip_tags($_POST["accion"]))) : null;
	$id = isset($_POST["id"]) ? htmlspecialchars(trim(strip_tags($_POST["id"]))) : null;

	$user = isset($_POST["user"]) ? htmlspecialchars(trim(strip_tags($_POST["user"]))) : null;
	$info = isset($_POST["info"]) ? htmlspecialchars(trim(strip_tags($_POST["info"]))) : null;
	$tipo = isset($_POST["tipo"]) ? htmlspecialchars(trim(strip_tags($_POST["tipo"]))) : null;

	
	switch($accion){

		case "listar":{
			
			listar();
		}
			
		break;
	
		case "delete":{
			
			delete($id);
		}
			
		break;

		case "deleteAllUser":{
			
			deleteAllUser();
		}
			
		break;

		case "crear":{
			
			crear($user, $info, $tipo);
		}
			
		break;

		case "getContador":{
			
			getContador();
		}
			
		break;




	
	}
	

?>