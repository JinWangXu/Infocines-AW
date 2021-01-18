<?php
require_once __DIR__.'/includes/config.php';
use es\fdi\ucm\aw\FormSignin as FormSignin;

$formSignin = new FormSignin();
$html = $formSignin->gestiona();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script type="text/javascript" src="js/jquery-3.5.0.min.js"></script>
	<script type="text/javascript" src="js/validacionesForm.js"></script>
	<title>Crear cuenta</title>
</head>
<body>
		
	<section class="contenidoLogin">
	<?= $html ?>
</section>
</div>
</body>
</html>