<?php
namespace es\fdi\ucm\aw;
 class TONotificaciones {


 
 private $id_notificacion;
 private $user;
 private $info;
 private $tipo;


 
	public function __construct(){
		 $id_notificacion = 0;
 		 $user = "";
		 $info = "";
		 $tipo = "";
	}


	public function getid_notificacion(){
		return $this->id_notificacion;
	}
	public function setid_notificacion($_id_notificacion){
		$this->id_notificacion = $_id_notificacion;
	}
	public function getuser(){
		return $this->user;
	}
	public function setuser($_user){
		$this->user = $_user;
	}

	public function getinfo(){
		return $this->info;
	}
	public function setinfo($_info){
		$this->info = $_info;
	}

	public function gettipo(){
		return $this->tipo;
	}
	public function settipo($_tipo){
		$this->tipo = $_tipo;
	}


}