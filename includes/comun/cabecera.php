<?php
use es\fdi\ucm\aw\DAOUsuario as DAOUsuario;
use es\fdi\ucm\aw\DAOAbono as DAOAbono;
use es\fdi\ucm\aw\TOUsuario as TOUsuario;
use es\fdi\ucm\aw\DAONotificaciones as DAONotificaciones;
?>
<header>
	<nav>
		<div class="logo">
			<img src="media/logo.jpg" alt="logo" width="50">
		</div>

		<a href='index.php'>Inicio</a>
		<a href='peliculas.php'>Películas</a>
		<a href='foro_inicio.php'>Foro</a>
		<a href='miembros.php'>Miembros</a>
		<!--<a href=”#”>Contacto</a>-->
		<?php
		if(isset($_SESSION["login"])){
			echo "<a href='amigos.php'>Amigos</a>";
			echo "<a href='pelisRecomendadas.php'>Recomendaciones</a>";
		}
		?>
		
	</nav>	


	<div>
		<?php
		if(isset($_SESSION["login"])){
		$num = DAONotificaciones::getNumeroNotificaciones($_SESSION["usuario"]);
		if($num!=0){
			echo '<a href="notificaciones.php" id="campana"><img src="media/notificaciones.png" alt="campana" id="notificacion"><span class="badge">'.$num.'</span></a>';
		} else{
			echo '<a href="notificaciones.php" id="campana"><img src="media/notificaciones.png" alt="campana" id="notificacion"></a>';
		}
		
	}
		?>
	</div>

		<?php

		if(!isset($_SESSION["login"])){
			echo ' <div>
			<a class="loginBot" href="login.php">Login</a>
			<a class="loginBot" href="signin.php">Registrarse</a>
			</div>';
		}
		else{
			$user = $_SESSION["usuario"];

			$miCuenta = new TOUsuario();
			$miCuenta = DAOUsuario::read( $user );
			echo '<a class="loginBot"> <img src=' . $miCuenta->geturlFoto() . ' alt="imagen ' . $miCuenta->getApodo() . '" id="avatarCabecera""> </a>';

			echo '<div>
			<ul class="menu">
			<li> '. $miCuenta->getApodo() .'
			<ul class="submenu">
			<li><a class="loginBot" href="miCuenta.php"> Mi Perfil </a></li>
			<li><a class="loginBot" href="modificarCuenta.php"> Modificar perfil</a></li>
			<li><a class="loginBot" href="modificarPassword.php"> Modificar contraseña </a></li>
			<li><a class="loginBot" href="logout.php"> Cerrar Sesión </a></li>
			</ul>
			</li>
			</ul>
			</div>';
			echo '<div> <a href="logout.php"> <img src="media/cerrar_sesion.png" alt="imagen" id="cerrarSesion""></a>
				</div>';
		}
		?>

</header>