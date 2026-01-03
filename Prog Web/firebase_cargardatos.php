<?php
function Sanear($datos){
	$datos = stripslashes($datos);
	$datos = addslashes($datos);
	$datos = strip_tags($datos);
	$datos = htmlspecialchars($datos);
	$datos = trim($datos);
	return $datos;
}

$accion = $_POST['accion'];
if ($accion == "carga"){
	$firebaseUrl = "https://parcial1depaula-default-rtdb.firebaseio.com/Clientes.json"; //NO OLVIDAR AGREGAR EL .JSON!!!!!!!!!!!!

	$email = Sanear ($_POST['email']);
	$nombre = Sanear ($_POST['nombre']);
	$apellido = Sanear ($_POST['apellido']);
	$numeroTarjeta = Sanear ($_POST['numeroTarjeta']);
	$nombreTarjeta = Sanear ($_POST['nombreTarjeta']);

	$data = [
	    'nombre' => $nombre,
	    'correo' => $email,
	    'apellido' => $apellido,
	    'nombre_tarjeta' => $nombreTarjeta,
	    'tarjeta' => $numeroTarjeta,
	    'tipo' => '1'
	];

	// Convertir los datos a formato JSON
	$dataJson = json_encode($data);
	// Inicializar cURL
	$ch = curl_init();
	// Configurar cURL para hacer una petición POST
	curl_setopt($ch, CURLOPT_URL, $firebaseUrl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Ejecutar la petición
	$response = curl_exec($ch);
	// Cerrar la conexión cURL
	curl_close($ch);
	// Mostrar la respuesta de Firebase
	echo "Respuesta de Firebase: " . $response;
}
?>