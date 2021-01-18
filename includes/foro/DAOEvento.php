<?php
namespace es\fdi\ucm\aw;

class DAOEvento
{
	public static function create($evento){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();
		
		$idEvento = $evento->getIdEvento();
		$titulo = $evento->getTitulo();
		$descripcion = $evento->getDescripcion();
		$fecha = $evento->getFecha();
		$urlImagen = $evento->getUrlImagen();
		$ciudad = $evento->getCiudad();
		$pais = $evento->getPais();
		$continente = $evento->getContinente();
		
		$query = sprintf("insert into evento(idEvento, titulo, descripcion, fecha, urlImagen, ciudad, pais, continente) 
			values('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
			$conection->real_escape_string($idEvento),
			$conection->real_escape_string($titulo),
			$conection->real_escape_string($descripcion),
			$conection->real_escape_string($fecha),
			$conection->real_escape_string($urlImagen),
			$conection->real_escape_string($ciudad),
			$conection->real_escape_string($pais),
			$conection->real_escape_string($continente)
		);

		if(! $conection->query($query)){
			return false;
		}
		else{
			return true;
		}
	}

	public static function read($id){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();
		
		$query = sprintf("SELECT * FROM evento WHERE idEvento = '%d'", $conection->real_escape_string($id));
		$result = $conection->query($query);
		
		if ($result->num_rows == 0){
			return NULL;
		}

		$ev = new TOEvento();
		$fila = $result->fetch_assoc();
		
		 $ev->setIdEvento($fila['idEvento']);
		 $ev->setTitulo($fila['titulo']);
		 $ev->setDescripcion($fila['descripcion']);
		 $ev->setFecha($fila['fecha']);
		 $ev->setUrlImagen($fila['urlImagen']);
		 $ev->setCiudad($fila['ciudad']);
		 $ev->setPais($fila['pais']);
		 $ev->setContinente($fila['continente']);
		
		return $ev;	
	}

	public static function update($evento){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();
		
		$idEvento = $evento->getIdEvento();
		$titulo = $evento->getTitulo();
		$descripcion = $evento->getDescripcion();
		$fecha = $evento->getFecha();
		$urlImagen = $evento->getUrlImagen();
		$ciudad = $evento->getCiudad();
		$pais = $evento->getPais();
		$continente = $evento->getContinente();
		
		$query = sprintf("update evento set idEvento='%d', titulo='%s', descripcion='%s', fecha='%s', urlImagen='%s',
			ciudad='%s', pais='%s', continente='%s'
			where idEvento='%d'",
			$conection->real_escape_string($idEvento),
			$conection->real_escape_string($titulo),
			$conection->real_escape_string($descripcion),
			$conection->real_escape_string($fecha),
			$conection->real_escape_string($urlImagen),
			$conection->real_escape_string($ciudad),
			$conection->real_escape_string($pais),
			$conection->real_escape_string($continente)
		);
		
		if(!$conection->query($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function delete($idEvento){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();
		
		$query = sprintf("delete from evento where idEvento='%d'", 
		$conection->real_escape_string($idEvento));

		if(!$conection->query($query)){
			return true;
		}
		else{
			return false;
		}
	}

	public static function listarEventos(){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();
		
		$query = sprintf("SELECT * FROM evento ");
		$result = $conection->query($query);

		if ($result->num_rows == 0){
			return NULL;
		}

		while($fila = $result->fetch_assoc()){
			$ev = new TOEvento();
			$ev->setIdEvento($fila['idEvento']);
			$ev->setTitulo($fila['titulo']);
			$ev->setDescripcion($fila['descripcion']);
			$ev->setFecha($fila['fecha']);
			$ev->setUrlImagen($fila['urlImagen']);
			$ev->setCiudad($fila['ciudad']);
			$ev->setPais($fila['pais']);
			$ev->setContinente($fila['continente']);
			$listaEventos[] = $ev;
		}
		return $listaEventos;
	}
	
	 public static function getRowCount(){
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();
		
      $query = sprintf("SELECT * FROM evento");
      $result = $conection->query($query);
      $n = 0;
      while($row = $result->fetch_assoc()){
        if ($n <= $row['idEvento']) {
          $n = $row['idEvento'] + 1;
        }
      }
      return $n;
    }
	
	public static function buscarEvento($titulo, $lugar, $fecha){	
		$aplication = Aplicacion::getSingleton();
        $conection = $aplication->conexionBd();

		$sql = sprintf("SELECT * FROM evento WHERE titulo LIKE '%%%s%%' AND fecha LIKE '%%%s%%' AND ( ciudad LIKE '%%%s%%' OR pais LIKE '%%%s%%' OR continente LIKE '%%%s%%')"
			, $conection->real_escape_string($titulo),
			$conection->real_escape_string($fecha),
			$conection->real_escape_string($lugar),
			$conection->real_escape_string($lugar),
			$conection->real_escape_string($lugar));
		
       $result = $conection->query($sql);

      $listaEventos = NULL;

		while($fila = $result->fetch_assoc()){	
			$ev = new TOEvento();
			$ev->setIdEvento($fila["idEvento"]);
			$ev->setTitulo($fila["titulo"]);
			$ev->setDescripcion($fila["descripcion"]);
			$ev->setFecha($fila["fecha"]);
			$ev->setUrlImagen($fila["urlImagen"]);
			$ev->setCiudad($fila["ciudad"]);
			$ev->setPais($fila["pais"]);
			$ev->setContinente($fila["continente"]);
			$listaEventos[] = $ev;
		}
		return $listaEventos;
		
	}
}

?>