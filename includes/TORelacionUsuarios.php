<?php
namespace es\fdi\ucm\aw;
/**
 * esta clase contiene los atributos de la tabla usuario
 */
class TORelacionUsuarios
{
	private $usuario;
	private $otroUsuario;
	private $estado;

	function __construct() {
		$usuario = '';
		$otroUsuario = '';
		$estado = '';
	}

	public function getusuario() {
		return $this->usuario;
	}

	public function getotroUsuario() {
		return $this->otroUsuario;
	}

	public function getestado() {
		return $this->estado;
	}

	public function setusuario($_usuario) {
		$this->usuario = $_usuario;
	}

	public function setotroUsuario($_otroUsuario) {
		$this->otroUsuario = $_otroUsuario;
	}

	public function setestado($_estado) {
		$this->estado = $_estado;
	}

}

?>