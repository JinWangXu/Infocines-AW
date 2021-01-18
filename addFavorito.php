<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\DAOFavorito as DAOFavorito;
use es\fdi\ucm\aw\TOFavorito as TOFavorito;
use es\fdi\ucm\aw\DAOPelicula as DAOPelicula;

if(!empty($_SESSION['pelicula']) && !empty($_SESSION['usuario'])){ 

    $tFavorito = new TOFavorito();
	$tFavorito->setIdPelicula($_SESSION['pelicula']);
	$tFavorito->setApodo($_SESSION['usuario']);

	$state = DAOFavorito::comparar($tFavorito);

	$response = array(
		'state' => $state
	);

	echo json_encode($response);
}
?>