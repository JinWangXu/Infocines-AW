<?php
namespace es\fdi\ucm\aw;
/**
 * 
 */
class FormSignin extends Form
{
    //const HTML5_EMAIL_REGEXP = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

    public function __construct()
    {
        parent::__construct('FormSignin');
    }

	protected function generaCamposFormulario($datosIniciales)
    {
        $resultado = '
        <div class="login">
        <div class="login-header">
        <h1>Registro</h1>
        </div>
        <div class="login-form">
		
		<h3>Nickname </h3>
		<input id="nick" type="text" placeholder="Nickname" name="usuario" required><img id="noUsuario" src="media/no.png" width=50 alt="no"><img id="okUsuario" src="media/ok.png" width=50 alt="ok">

		<h3>Contraseña </h3>
		<input id="passwd" type="password" placeholder="Contraseña" name="password" required>
			
		<h3>Nombre </h3>	
		<input id="nombrecompleto" type="text" placeholder="Nombre" name="nombre" required>
		
		<h3>Apellidos </h3>
		<input id="apellidos" type="text" placeholder="Apellidos" name="apellidos" required>
		
		<h3>Correo </h3>
		<input id="correo" type="email" placeholder="Email" name="email" required><img id="noCorreo"src="media/no.png" width=50 alt="no"><img id="okCorreo" src="media/ok.png" width=50 alt="ok">
		
		<h3>Tarjeta de crédito </h3>
		<input id="tarjeta" type="number" placeholder="Tarjeta de credito" name="ntarjeta" required>
		
		<h3>Tipo de abono </h3>';

				$abonos = DAOAbono::list();
				foreach ($abonos as $abono) {
					$resultado = $resultado . '<input type="radio" name="tipoAbono" value="' . $abono->getTipoAbono() . '" required>' . $abono->getTipoAbono();

				}
				
			$resultado = $resultado . '	
			
		<br>
		<br>
		<button type="submit" name="signin">Crear cuenta</button>
		<br>
        <a class="sign-up" href="index.php">Volver</a>
		</div>
		</div>';
    return $resultado;
    }

    protected function procesaFormulario($datos)
    {
    	if (! isset($datos['signin']) ) {
    		header('Location: signin.php');
    		exit();
    	}

    	$erroresFormulario = array();
        $correcto = true;
    	$nombreUsuario = isset($datos['usuario']) ? htmlspecialchars(trim(strip_tags($datos['usuario']))) : null;
        
        if ( !$nombreUsuario /*|| mb_ereg_match(self::HTML5_EMAIL_REGEXP, $nombreUsuario) */) {
            $erroresFormulario[] = 'El nombre de usuario introducido no es válido';
            $correcto = false;
        }
        
        $password = isset($datos['password']) ? htmlspecialchars(trim(strip_tags($datos['password']))) : null;

        if ( !$password ) {
            $erroresFormulario[] = 'La contraseña de usuario introducida no es válida o no tiene la longitud adecuada';
            $correcto = false;
        }

        $nombreCompleto = isset($datos['nombre']) ? htmlspecialchars(trim(strip_tags($datos['nombre']))) : null;

        if ( !$nombreCompleto ) {
            $erroresFormulario[] = 'El nombre introducido no es válido';
            $correcto = false;
        }

        $apellidos = isset($datos['apellidos']) ? htmlspecialchars(trim(strip_tags($datos['apellidos']))) : null;

        if ( !$apellidos ) {
            $erroresFormulario[] = 'Los apellidos introducidos no son válidos';
            $correcto = false;
        }

        $email = isset($datos['email']) ? htmlspecialchars(trim(strip_tags($datos['email']))) : null;

        if ( !$email ) {
            $erroresFormulario[] = 'El email introducido no es válido';
            $correcto = false;
        }

        $ntarjeta = isset($datos['ntarjeta']) ? htmlspecialchars(trim(strip_tags($datos['ntarjeta']))) : null;

        if ( !$ntarjeta ) {
            $erroresFormulario[] = 'La tarjeta de usuario introducida no es válida';
            $correcto = false;
        }

        $tipoAbono = isset($datos['tipoAbono']) ? htmlspecialchars(trim(strip_tags($datos['tipoAbono']))) : null;

        if ( !$tipoAbono ) {
            $erroresFormulario[] = 'El tipo de abono seleccionado no es correcto';
            $correcto = false;
        }
        

        if($correcto){
            $inicioAbono = date("Y") . "-" . date("m") . "-" . date("d") . " " . date("H") . ":" . date("i") . ":" . date("s");
            $creado = Usuario::crea($nombreUsuario, $password, $nombreCompleto, $apellidos, $email, $ntarjeta, $tipoAbono, $inicioAbono, 'user');

            if(!$creado) {
                $erroresFormulario[] = 'El usuario ' . $nombreUsuario . ' ya existe.';
            }
            else {
                $_SESSION["login"] = true;
                $_SESSION["usuario"] = $nombreUsuario;
                $erroresFormulario = 'index.php';
                
            }
	        
        }

        return $erroresFormulario;
	
    }
}

