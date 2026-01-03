<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Envios</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Cargar Vue.js + JQuery -->
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	
	<!-- Custom styles for this template  -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="vista.css">
	
	<!-- Librerias firebase!! -->
	<script src="https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/10.13.2/firebase-analytics.js"></script>
	<script src="https://www.gstatic.com/firebasejs/10.13.2/firebase-auth.js"></script>
	
	<!-- Firebase config -->
	<script type="module">
	</script>
</head>
<body class="Todo">
	<div class="container">
		<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" id="Cab">
			<a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
				<svg class="bi me-2" width="32" height="32"><use xlink:href="#bootstrap"/></svg>
				<span class="fs-4">Practico Integral 2</span>
			</a>
			<ul class="nav nav-pills">
				<li class="nav-item"><a href="home_admin.php" class="nav-link " >Logout</a></li>
				<li class="nav-item"><a href="home_admin.php"  class="nav-link "aria-current="page">Principal</a></li>
				<li class="nav-item"><a href="home_carrito.php"class="nav-link disabled" >Carrito</a></li>
				<li class="nav-item"><a href="home_envios.php" class="nav-link active" >Envios</a></li> 
			</ul>
		</header>
	</div>
</h6>
<h3>Envios</h3>
<h5></h5>
<form id="Envios" method="POST">
    <section>
        <?php
        //Firebase Realtime:
        // URL de Firebase Realtime Database
        // $firebaseUrl = "https://parcial1depaula-default-rtdb.firebaseio.com/Clientes.json"; //!!!! NO OLVIDAR .json !!!!

        // // Inicializar cURL
        // $ch = curl_init();
        // // Configurar cURL para hacer una petición GET
        // curl_setopt($ch, CURLOPT_URL, $firebaseUrl);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // // Ejecutar la petición
        // $response = curl_exec($ch);
        // // Cerrar la conexión cURL
        // curl_close($ch);
        // // Decodificar la respuesta JSON
        // $usuarios = json_decode($response, true);

        // // if (!empty($usuarios)) {
        // //     foreach ($usuarios as $usuario) {
        // //         echo "Nombre: " . $usuario['nombre'] . "<br>";
        // //         echo "Apellido: " . $usuario['apellido'] . "<br>";
        // //         echo "Email: " . $usuario['correo'] . "<br>";
        // //         echo "NomTarjeta: " . $usuario['nombre_tarjeta'] . "<br><br>";
        // //     }
        // // } else {
        // //     echo "No se encontraron usuarios.";
        // // }
        
        // //Formato tabla:
        // // Verificar si se obtuvieron datos y mostrar la tabla
        // if (!empty($usuarios)) {
        //     echo "<table border='1' cellpadding='10' align='center'>";
        //     echo "<tr>
        //             <th>Nombre</th>
        //             <th>Apellido</th>
        //             <th>Email</th>
        //             <th>Nombre Tarjeta</th>
        //             <th>Tarjeta</th>
        //           </tr>";
            
        //     foreach ($usuarios as $usuario) {
        //         echo "<tr>";
        //         echo "<td>" . $usuario['nombre'] . "</td>";
        //         echo "<td>" . $usuario['apellido'] . "</td>";
        //         echo "<td>" . $usuario['correo'] . "</td>";
        //         echo "<td>" . $usuario['nombre_tarjeta'] . "</td>";
        //         echo "<td>" . $usuario['tarjeta'] . "</td>";
        //         echo "</tr>";
        //     }
        //     echo "</table>";
        // } else {
        //     echo "No se encontraron usuarios.";
        // }

        //MySQLi:
        include("conexion.php");
        // $stmt = $conn->prepare("SELECT * FROM envios");
		// $stmt->execute();
		// $stmt->bind_param("ssis", $nombre, $apellido, $precio, $dirección);
		$query = "SELECT * FROM envios limit 500 "; //Sin preparada
		$tabla = mysqli_query($conn, $query);
		echo '<table class="table">
			 	<th> NOMBRE </th>
			 	<th> APELLIDO </th>
			 	<th> PRECIO </th>
			 	<th> DIRECCION </th>';
		while ($aux = mysqli_fetch_array($tabla))
		{
			echo '<tr> 
				<td>'.$aux['nombre'].'</td>				 
				<td>'.$aux['apellido'].'</td>
				<td>'.$aux['precio'].'</td>
				<td>'.$aux['direccion'].'</td>
				<td><button class="btn-danger btn_eliminar"  data-dni="'.$aux['nombre'].'"> X </button></td>	
			 </tr>';
		}
		echo "</table>";
        ?>
    </section>
</form>
<div class="form-outline mb-4">
	<div class="container">
		<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
			<p class="col-md-4 mb-0 text-muted">&copy; X</p>
			<a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
				<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
			</a>
			<ul class="nav col-md-4 justify-content-end">
				<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">2024</a></li>
				<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
				<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
				<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
				<li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
			</ul>
		</footer>
	</div>
</body>
</html>
