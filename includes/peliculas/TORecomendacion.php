<?php

namespace es\fdi\ucm\aw;


class TORecomendacion {

	private $idPelicula;
	private $usuarioOrigen;
	private $usuarioDestino;
	private $id;

	function __construct(){
		$idPelicula = "";
		$usuarioOrigen = "";
		$usuarioDestino = "";
		$id = 0;
	}

	public function getidPelicula(){
		return $this->idPelicula;
	}

	public function getusuarioOrigen(){
		return $this->usuarioOrigen;
	}

	public function getusuarioDestino(){
		return $this->usuarioDestino;
	}

	public function getId(){
		return $this->id;
	}

	public function setidPelicula($idPeli){
		 $this->idPelicula = $idPeli;
	}

	public function setusuarioOrigen($user){
		 $this->usuarioOrigen = $user;
	}

	public function setusuarioDestino($user){
		 $this->usuarioDestino = $user;
	}

	public function setId($id){
		 $this->id = $id;
	}
}

	
	