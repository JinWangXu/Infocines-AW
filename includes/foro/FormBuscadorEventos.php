<?php
namespace es\fdi\ucm\aw;

class FormBuscadorEventos extends Form
{
    public function __construct()
    {
        parent::__construct('FormBuscadorEventos');
    }
	
 
	

	protected function generaCamposFormulario($datosIniciales)
    {
        $result = '<h1 class="content"> Buscar eventos </h1>
							<label>Nombre: <input type="text" name="titulo"></label>
							<label>Fecha: <input type="date" name="fecha"></label>
							<label>Lugar: <input type="text" name="place"></label>
							<button class="buttonBuscar" type="submit"></button>
		';
		return $result;
    }

    protected function procesaFormulario($datos)
    {
		$erroresFormulario = array();
			
		if(isset($_POST["titulo"])){
			$titulo = htmlspecialchars(trim(strip_tags($_POST["titulo"])));
			$fecha = htmlspecialchars(trim(strip_tags($_POST["fecha"])));
			$lugar = htmlspecialchars(trim(strip_tags($_POST["place"])));
		
			
			$erroresFormulario = 'resultadoBuscarEventos.php?titulo='.$titulo.'&lugar='.$lugar.'&fecha='.$fecha;
		}	
		return $erroresFormulario;
    }
	
	
}

