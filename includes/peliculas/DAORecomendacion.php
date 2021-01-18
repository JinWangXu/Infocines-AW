<?php
namespace es\fdi\ucm\aw;

class DAORecomendacion {
	
	public static function create($tRecomendacion){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();		

		$idPelicula = $tRecomendacion->getidPelicula();
		$usuarioOrigen = $tRecomendacion->getusuarioOrigen();
		$usuarioDestino = $tRecomendacion->getusuarioDestino();

		$sql = sprintf("INSERT into recomendacion (idPelicula, usuarioOrigen, usuarioDestino)values('%s', '%s', '%s')"
		, $conn->real_escape_string($idPelicula)
		, $conn->real_escape_string($usuarioOrigen)
		, $conn->real_escape_string($usuarioDestino)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function read($idRecomendacion){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql = sprintf("SELECT * FROM recomendacion WHERE id = '%d'"
			, $conn->real_escape_string($idRecomendacion)
		);
		$resultado = $conn->query($sql);
		if ($resultado->num_rows == 0){
			return NULL;
		}
		else{
			$res = $resultado->fetch_assoc();
			$tRecomendacion = new TORecomendacion();
			$tRecomendacion->setidPelicula($res['idPelicula']);
			$tRecomendacion->setusuarioOrigen($res['usuarioOrigen']);
			$tRecomendacion->setusuarioDestino($res['usuarioDestino']);
			$tRecomendacion->setId($res['id']);
			return $tRecomendacion;		
	}
}

	public static function update($tRecomendacion){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$idPelicula = $tRecomendacion->getidPelicula();
		$usuarioOrigen = $tRecomendacion->getusuarioOrigen();
		$usuarioDestino = $tRecomendacion->getusuarioDestino();
		$id = $tRecomendacion->getId();

		$sql = sprintf("UPDATE recomendacion set idPelicula = '%s', usuarioOrigen='%s', usuarioDestino='%s', id='%d' where id='%d'"
			, $conn->real_escape_string($idPelicula)
			, $conn->real_escape_string($usuarioOrigen)
			, $conn->real_escape_string($usuarioDestino)
			, $conn->real_escape_string($id)
			, $conn->real_escape_string($id)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function delete($idRecomendacion){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$sql = sprintf("DELETE FROM recomendacion WHERE id = '%d'"
			, $conn->real_escape_string($idRecomendacion)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}




	public static function deleteRec($idPelicula, $usuarioDestino){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$sql = sprintf("DELETE FROM recomendacion WHERE idPelicula = '%s' AND usuarioDestino = '%s'"
			, $conn->real_escape_string($idPelicula)
			, $conn->real_escape_string($usuarioDestino)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function deleteAllRec($usuarioDestino){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$sql = sprintf("DELETE FROM recomendacion WHERE usuarioDestino = '%s'"
			, $conn->real_escape_string($usuarioDestino)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}





	
	public static function buscarRecomendacion($usuarioOrigen, $usuarioDestino, $idPelicula){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql = sprintf("SELECT * FROM recomendacion WHERE usuarioOrigen = '%s' AND usuarioDestino = '%s' AND idPelicula = '%s'"
			, $conn->real_escape_string($usuarioOrigen)
			, $conn->real_escape_string($usuarioDestino)
			, $conn->real_escape_string($idPelicula)
			);
		$resultado = $conn->query($sql);
		if ($resultado->num_rows == 0){
			return NULL;
		}
		else{
			$res = $resultado->fetch_assoc();
			$tRecomendacion = new TORecomendacion();
			$tRecomendacion->setidPelicula($res['idPelicula']);
			$tRecomendacion->setusuarioOrigen($res['usuarioOrigen']);
			$tRecomendacion->setusuarioDestino($res['usuarioDestino']);
			$tRecomendacion->setId($res['id']);
			return $tRecomendacion;		
		}
	}

	public static function listarRecomendaciones($usuario){
		$app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();

		$sql = sprintf("SELECT * FROM recomendacion WHERE usuarioDestino = '%s' ORDER BY idPelicula"
			, $conn->real_escape_string($usuario)
			);

		$resultado = $conn->query($sql);
		if ($resultado->num_rows == 0){
			return NULL;
		}

		while($fila = $resultado->fetch_assoc()){
			$tRecomendacion = new TORecomendacion();
			$tRecomendacion->setidPelicula($fila['idPelicula']);
			$tRecomendacion->setusuarioOrigen($fila['usuarioOrigen']);
			$tRecomendacion->setusuarioDestino($fila['usuarioDestino']);
			$tRecomendacion->setId($fila['id']);
			$listaRecomendacion[] = $tRecomendacion;
		}
		return $listaRecomendacion;
	}
	

}