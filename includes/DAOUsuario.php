<?php
namespace es\fdi\ucm\aw;
/**
 * 
 */
class DAOUsuario
{
	public static function create($usuario) {

		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$apodo = $usuario->getApodo();
		$nombre = $usuario->getNombre();
		$apellidos = $usuario->getApellidos();
		$email = $usuario->getEmail();
		$ntarjeta = $usuario->getNtarjeta();
		$contrasena = $usuario->getContrasena();
		$tipoAbono = $usuario->getTipoAbono();
		$inicioAbono = $usuario->getInicioAbono();
		$rol = $usuario->getRol();
		$urlFoto = 'media/usuario/fotoVacia.jpg';

		$sql = sprintf("insert into usuario(apodo, nombre, apellidos, email, ntarjeta, contrasena, tipoAbono, rol, urlFoto) values('%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s')"
		, $conn->real_escape_string($apodo)
		, $conn->real_escape_string($nombre)
		, $conn->real_escape_string($apellidos)
		, $conn->real_escape_string($email)
		, $conn->real_escape_string($ntarjeta)
		, $conn->real_escape_string($contrasena)
		, $conn->real_escape_string($tipoAbono)
		, $conn->real_escape_string($rol)
		, $conn->real_escape_string($urlFoto));

		if(!$resultado = $conn->query($sql)){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public static function read($apodo) {

		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql=sprintf("select * from usuario where apodo='%s'", $conn->real_escape_string($apodo));
		$resultado = $conn->query($sql);

		if ($resultado->num_rows == 0)
			return NULL;

		$datos = $resultado->fetch_assoc();

		$usuario = new TOUsuario();

		$usuario->setApodo($datos['apodo']);
		$usuario->setNombre($datos['nombre']);
		$usuario->setApellidos($datos['apellidos']);
		$usuario->setEmail($datos['email']);
		$usuario->setNtarjeta($datos['ntarjeta']);
		$usuario->setContrasena($datos['contrasena']);
		$usuario->setTipoAbono($datos['tipoAbono']);
		$usuario->setInicioAbono($datos['inicioAbono']);
		$usuario->setRol($datos['rol']);
		$usuario->seturlFoto($datos['urlFoto']);

		return $usuario;
	}

	public static function update($usuario) {

		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		
		$apodo = $usuario->getApodo();
		$nombre = $usuario->getNombre();
		$apellidos = $usuario->getApellidos();
		$email = $usuario->getEmail();
		$ntarjeta = $usuario->getNtarjeta();
		$contrasena = $usuario->getContrasena();
		$tipoAbono = $usuario->getTipoAbono();
		$inicioAbono = $usuario->getInicioAbono();
		$rol = $usuario->getRol();
		$urlFoto = $usuario->geturlFoto();
		$sql = sprintf("update usuario set apodo='%s', nombre='%s', apellidos='%s', email='%s', ntarjeta='%d', contrasena='%s', tipoAbono='%s', inicioAbono='%s', rol='%s', urlfoto='%s' where apodo='%s'"
		, $conn->real_escape_string($apodo)
		, $conn->real_escape_string($nombre)
		, $conn->real_escape_string($apellidos)
		, $conn->real_escape_string($email)
		, $conn->real_escape_string($ntarjeta)
		, $conn->real_escape_string($contrasena)
		, $conn->real_escape_string($tipoAbono)
		, $conn->real_escape_string($inicioAbono)
		, $conn->real_escape_string($rol)
		, $conn->real_escape_string($urlFoto)
		, $conn->real_escape_string($apodo));

		if(!$conn->query($sql)){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public static function delete($apodo) {

		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		
		$sql = sprintf("delete from usuario where apodo='%s'"
		, $conn->real_escape_string($apodo));

		if(!$conn->query($sql)){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	public static function listarBusqueda($apodo){
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
		$apodoConsulta = $conn->real_escape_string($apodo);
		$sql = "SELECT * FROM usuario WHERE apodo LIKE '%$apodoConsulta%'";
		$resultado = $conn->query($sql);

		if ($resultado->num_rows == 0){
			return NULL;
		}

		while($fila = $resultado->fetch_assoc()){
			$usuario = new TOUsuario();

			$usuario->setApodo($fila['apodo']);
			$usuario->setNombre($fila['nombre']);
			$usuario->setApellidos($fila['apellidos']);
			$usuario->setEmail($fila['email']);
			$usuario->setNtarjeta($fila['ntarjeta']);
			$usuario->setContrasena($fila['contrasena']);
			$usuario->setTipoAbono($fila['tipoAbono']);
			$usuario->setInicioAbono($fila['inicioAbono']);
			$usuario->setRol($fila['rol']);
			$usuario->seturlFoto($fila['urlFoto']);
		$listaUsuarios[] = $usuario;
		}
		return $listaUsuarios;
	}
}

?>