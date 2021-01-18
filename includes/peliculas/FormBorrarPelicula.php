<?php
namespace es\fdi\ucm\aw;
/**
 * 
 */
class FormBorrarPelicula extends Form
{
    public function __construct()
    {
        parent::__construct('FormBorrarPelicula');
    }

	protected function generaCamposFormulario($datosIniciales)
    {
        $pelicula = DAOPelicula::read($_SESSION["pelicula"]);
        $resultado = '
        <div class="login">
        <div class="login-header">
        <h1>Borrar '. $pelicula->getTitulo() .'</h1>
        </div>
        <img src=' . $pelicula->getUrlImagen() . ' alt="imagen ' . $pelicula->getIdPelicula() . '"id="widthImgPel">
			<button class="login-button" type="submit">Borrar</button>

        </div>';
				
		
    return $resultado;
    }

    protected function procesaFormulario($datos){
        $erroresFormulario = array();
                
        if(DAOPelicula::delete($_SESSION["pelicula"])){
            $_SESSION['borrarPelicula'] = true;
            $erroresFormulario = 'peliculas.php';
        }
        else{
            $erroresFormulario[] = 'error al borrar la pelicula';
        }
        
        return $erroresFormulario;
    }
}
?>