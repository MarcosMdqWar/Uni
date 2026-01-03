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

if ($accion == "actualizar"){
	$_SESSION["Usuario"] = $_POST['usuario'];
	$_SESSION["Correo"] = Sanear ($_POST['email']);
	echo $_SESSION['Correo'];
}

if ($accion == "actualizar2"){
	$_SESSION['Articulo'] = $_POST['articulo'];
	$_SESSION['Precio'] = $_POST['precio'];
	$email = $_SESSION['Correo'];
	printf("Articulo seleccionado para $email");
	
	$firebaseUrl = "https://parcial1depaula-default-rtdb.firebaseio.com/Clientes.json"; //!!!! NO OLVIDAR .json !!!!

	$ch = curl_init();
	// Configurar cURL para hacer una petición GET
	curl_setopt($ch, CURLOPT_URL, $firebaseUrl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	$usuarios = json_decode($response, true);
	foreach ($usuarios as $usuario) {
		if ($usuario['correo'] === $email) {
			$_SESSION['Nombre'] = $usuario['nombre'];
			$_SESSION['Apellido'] = $usuario['apellido'];
		}
	}
}

?>