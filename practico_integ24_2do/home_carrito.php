<?php 
session_start(); 
//var_dump($_SESSION);
//session_start — Start new or resume existing session
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Principal</title>
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
	<td class="nombre"><?php echo $_SESSION['Nombre']; ?></td>
	<td class="apellido"><?php echo $_SESSION['Apellido']; ?></td>
	<script type="module">
		$(document).ready(function() {
			$('#r_compra').click(function() {
	            let precio = <?php echo $_SESSION['Precio']; ?>;
	            let dir = $('#dir').val();
	            //let Nombre = $('.nombre').text().trim();
        		//let Apellido = $('.apellido').text().trim();
        		let Nombre = "<?php echo ($_SESSION['Nombre']); ?>"; 
	            let Apellido = "<?php print $_SESSION['Apellido'] ?>";
	            //entre comillas (es string!)
	            $.post('mysqli_subir.php', {
	                accion: 'subir',
	                dir: dir,
	                Nombre: Nombre,
	                Apellido: Apellido,
	                precio: precio
	            }, function(response) {
	                alert("Subido");
	                console.log(response);
	            });
	        });
		}); //$document
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
				<li class="nav-item"><a class="nav-link" href="home_cliente.php" >Logout</a></li>
				<li class="nav-item"><a href="home_principal.php"  class="nav-link"aria-current="page">Principal</a></li>
				<li class="nav-item"><a class="nav-link active" >Carrito</a></li>
				<li class="nav-item"><a href="home_envios.php" class="nav-link disabled" >Envios</a></li>
			</ul>
		</header>
	</div>
	<h5>Carrito</h5>
	<section>
		<?php
			$firebaseUrl = "https://parcial1depaula-default-rtdb.firebaseio.com/Clientes.json"; //!!!! NO OLVIDAR .json !!!!

			$ch = curl_init();
			// Configurar cURL para hacer una petición GET
			curl_setopt($ch, CURLOPT_URL, $firebaseUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$usuarios = json_decode($response, true);
			$precioTotal = $_SESSION['Precio'];
			$correoSesion = $_SESSION['Correo'] ?? null;
			if (!empty($usuarios) && $correoSesion) {
			    echo "<table border='1' cellpadding='10' align='center'>";
			    echo "<tr>
			            <th>Nombre</th>
			            <th>Apellido</th>
			            <th>Email</th>
			            <th>Nombre Tarjeta</th>
			            <th>Tarjeta</th>
			          </tr>";

			    foreach ($usuarios as $usuario) {
			        if ($usuario['correo'] === $correoSesion) {
			            echo "<tr>";
			            echo "<td>" . $usuario['nombre'] . "</td>";
			            $_SESSION['Nombre'] = $usuario['nombre'];
			            echo "<td>" . $usuario['apellido'] . "</td>";
			            $_SESSION['Apellido'] = $usuario['apellido'];
			            echo "<td>" . $usuario['correo'] . "</td>";
			            echo "<td>" . $usuario['nombre_tarjeta'] . "</td>";
			            echo "<td>" . $usuario['tarjeta'] . "</td>";
			            echo "</tr>";
			        }
			    }
			    echo "</table>";
			    echo "<p align='center'><strong>Precio Total: $ " . number_format($precioTotal, 2) . "</strong></p>";
			} else {
			    echo "No se encontraron usuarios o el usuario no tiene la sesión iniciada.";
			}
		?>
	</section>
	<div>
		<label>Ingrese su dirección: </label>
		<input type="text" id="dir" name="dir" required> <br><br>
	</div>
	<button id="r_compra" onclick="alert('Compra realizada!');">
		Realizar compra
	</button>
</div>
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
