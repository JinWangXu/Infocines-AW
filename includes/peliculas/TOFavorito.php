<?php
namespace es\fdi\ucm\aw;

class TOFavorito{

	private $idPelicula;
	private $apodo;
	private $idFavorito;

	function __construct(){
		
		 $idPelicula = "";
		 $apodo = "";
		 $idFavorito = "";
	}

	public function getidPelicula(){
		return $this->idPelicula;
	}

	public function getApodo(){
		return $this->apodo;
	}

	public function getidFavorito(){
		return $this->idFavorito;
	}

	public function setidPelicula($id){
		$this->idPelicula = $id;
	}

	public function setApodo($apodo){
		$this->apodo = $apodo;
	}

	public function setidFavorito($id){
		$this->idFavorito = $id;
	}

}

?>