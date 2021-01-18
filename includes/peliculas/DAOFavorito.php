<?php
namespace es\fdi\ucm\aw;
class DAOFavorito{

	public static function create($tFavorito){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();		

		$idPelicula = $tFavorito->getIdPelicula();
		$apodo = $tFavorito->getApodo();

		$sql = sprintf("INSERT into favorito (idPelicula, apodo)values('%s', '%s')"
		, $conn->real_escape_string($idPelicula)
		, $conn->real_escape_string($apodo)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function read($idFavorito){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql = sprintf("SELECT * FROM favorito WHERE idFavorito = '%d'"
			, $conn->real_escape_string($idFavorito)
		);
		$resultado = $conn->query($sql);
		if ($resultado->num_rows == 0){
			return NULL;
		}
		else{
			$res = $resultado->fetch_assoc();
			$tFavorito = new TOFavorito();
			$tFavorito->setIdPelicula($res['idPelicula']);
			$tFavorito->setApodo($res['apodo']);
			$tFavorito->setidFavorito($res['idFavorito']);
		}
		return $tFavorito;
	}

	public static function update($tFavorito){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$idPelicula = $tFavorito->getIdPelicula();
		$apodo = $tFavorito->getApodo();
		$idFavorito = $tFavorito->getidFavorito();

		$sql = sprintf("UPDATE favorito set idPelicula = '%s', apodo='%s', idFavorito='%d' where idFavorito='%d'"
			, $conn->real_escape_string($idPelicula)
			, $conn->real_escape_string($apodo)
			, $conn->real_escape_string($idFavorito)
			, $conn->real_escape_string($idFavorito)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function delete($idFavorito){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$sql = sprintf("DELETE FROM favorito WHERE idFavorito = '%d'"
			, $conn->real_escape_string($idFavorito)
		);
		if($conn->query($sql)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function listar($idUsuario){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

		$sql = sprintf("SELECT * FROM favorito WHERE apodo = '%s'"
			, $conn->real_escape_string($idUsuario)
		);
		$resultado = $conn->query($sql);
		if ($resultado->num_rows == 0){
			return NULL;
		}
		else{
			while($fila = $resultado->fetch_assoc()) {
				$fav = new TOFavorito();
				$fav->setIdPelicula($fila['idPelicula']);
				$fav->setApodo($fila['apodo']);
				$fav->setidFavorito($fila['idFavorito']);
				$listaFav[] = $fav;
			}
		}
		return $listaFav;
	}

	public static function comparar($tFavorito){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();	
		$idPelicula = $tFavorito->getIdPelicula();
		$apodo = $tFavorito->getApodo();
		$idFavorito = $tFavorito->getidFavorito();
	    $sql = sprintf("SELECT * FROM favorito WHERE apodo = '%s' AND idPelicula = '%s'"
	        , $conn->real_escape_string($apodo)
	        , $conn->real_escape_string($idPelicula)
	        ); 
		$result = $conn->query($sql); 
		
		$res = $result->fetch_assoc();
	    if($result->num_rows > 0){ 
	        $state = 2; 
	       	self::delete($res['idFavorito']); 
	    }
	    else{
	    	$state = 1; 
	    	self::create($tFavorito);
	    }
	    return $state;
	}

	public static function existe($tFavorito){
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();	
		$idPelicula = $tFavorito->getIdPelicula();
		$apodo = $tFavorito->getApodo();
	    $sql = sprintf("SELECT * FROM favorito WHERE apodo = '%s' AND idPelicula = '%s'"
	        , $conn->real_escape_string($apodo)
	        , $conn->real_escape_string($idPelicula)
	        ); 
		$result = $conn->query($sql); 
	
	    if($result->num_rows > 0){ //si ya esta en la bbdd
	        $state = 2; 
	    }
	    else{ //si no esta
	    	$state = 1; 
	    }
	    return $state;
	}
}

?>