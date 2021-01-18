<?php
namespace es\fdi\ucm\aw;
/**
 * 
 */
class DAORelacionUsuarios
{
	public static function create($relacionusuarios) {

		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$usuario = $relacionusuarios->getusuario();
		$otroUsuario = $relacionusuarios->getotroUsuario();
		$estado = $relacionusuarios->getestado();

		$sql = sprintf("insert into relacionusuarios(usuario, otroUsuario, estado) values('%s', '%s', '%s')"
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($otroUsuario)
		, $conn->real_escape_string($estado));

		if(!$resultado = $conn->query($sql)){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public static function read($usuario, $otroUsuario) {

		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql=sprintf("select * from relacionusuarios where usuario='%s' and otroUsuario='%s'"
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($otroUsuario));
		$resultado = $conn->query($sql);

		if ($resultado->num_rows == 0)
			return NULL;

		$datos = $resultado->fetch_assoc();

		$relacionusuarios = new TORelacionUsuarios();

		$relacionusuarios->setusuario($datos['usuario']);
		$relacionusuarios->setotroUsuario($datos['otroUsuario']);
		$relacionusuarios->setestado($datos['estado']);

		return $relacionusuarios;
	}

	public static function update($relacionusuarios) {

		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		
		$usuario = $relacionusuarios->getusuario();
		$otroUsuario = $relacionusuarios->getotroUsuario();
		$estado = $relacionusuarios->getestado();
		$sql = sprintf("update relacionusuarios set usuario='%s', otroUsuario='%s', estado='%s' where usuario='%s' and otroUsuario='%s'"
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($otroUsuario)
		, $conn->real_escape_string($estado)
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($otroUsuario));

		if(!$conn->query($sql)){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public static function delete($usuario, $otroUsuario) {

		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		
		$sql = sprintf("delete from relacionusuarios where usuario='%s' and otroUsuario='%s'"
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($otroUsuario));

		if(!$conn->query($sql) || $conn->affected_rows <= 0){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public static function listUsuarios($usuario, $estado) {

		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql=sprintf("select * from relacionusuarios where (usuario='%s' or otroUsuario='%s') and estado='%s'"
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($usuario)
		, $conn->real_escape_string($estado));
		$resultado = $conn->query($sql);

		if ($resultado->num_rows == 0)
			return NULL;

		while($datos = $resultado->fetch_assoc()){

			$relacionusuarios = new TORelacionUsuarios();

			$relacionusuarios->setusuario($datos['usuario']);
			$relacionusuarios->setotroUsuario($datos['otroUsuario']);
			$relacionusuarios->setestado($datos['estado']);
			$amigos[] = $relacionusuarios;
		}
		return $amigos;
	}
}

?>