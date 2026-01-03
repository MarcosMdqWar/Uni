<?php
session_start();
function Sanear($datos){
	$datos = stripslashes($datos);
	$datos = addslashes($datos);
	$datos = strip_tags($datos);
	$datos = htmlspecialchars($datos);
	$datos = trim($datos);
	return $datos;
}

$accion = $_POST['accion'];
if ($accion == "login"){
	$captcha = sanear ($_POST['captcha']);
		if($captcha==$_SESSION['captcha']){
			echo "CaptchaCorrecto";
		}
		else{
			echo "ErrorCaptcha";
		}
}
if ($accion == "sanear"){
	$email = sanear($_POST['email']);
	$password = sanear($_POST['password']);
	$captcha = sanear($_POST['captcha']);
	echo "Saneado";
}

?>
