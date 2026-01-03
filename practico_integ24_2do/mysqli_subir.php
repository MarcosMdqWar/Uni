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
include('conexion.php');
// $conn = mysqli_connect("localhost", "root", "", "practico_integ_2do");
// if (empty($conn)) {
// 	die("mysqli_connect failed: " . mysqli_connect_error());
// 	mysqli_close($conn);
// }
// else
// 	//print "connected to " . mysqli_get_host_info($conn) . "\n";

$accion = $_POST['accion'];
if ($accion == "subir"){
	// $conn = mysqli_connect("localhost", "root", "", "practico_integ_2do");
	// if (!$conn){
	// 	print("Error conectando")
	// } //Ya lo hace include
	$stmt = $conn->prepare("INSERT INTO envios (nombre, apellido, precio, direccion) VALUES(?,?,?,?)");
	
	$apellido=$_POST['Apellido'];
	$nombre=$_POST['Nombre'];
	$direccion=Sanear($_POST['dir']);
	$precio=$_POST['precio'];
	
	$stmt->bind_param("ssds", $nombre, $apellido, $precio, $direccion);
	//$stmt->execute(); //Se ejecuta solo cuando esta en el if
	if ($stmt->execute()) { 
		echo "Datos subidos correctamente.";
	} else {
		echo "Error al subir los datos: " . $stmt->error;
	}
	$stmt->close();
	$conn->close();
};
?>