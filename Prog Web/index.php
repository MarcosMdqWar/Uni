<!-- https://getbootstrap.com/docs/4.0/components/ 
https://www.w3schools.com/css/
-->

<?php
session_start(); 
$_SESSION['Usuario'] = NULL;
$_SESSION['Correo'] = NULL;
$_SESSION['Articulo'] = NULL;
$_SESSION['Precio'] = NULL;
$_SESSION['Nombre'] = NULL;
$_SESSION['Apellido'] = NULL;
//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Cargar Vue.js + JQuery -->
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<!-- Bootstrap core CSS -->
	<!-- Custom styles for this template  -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

	<link rel="stylesheet" href="vista.css">

	<script type="module">
		import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-app.js";
		import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-analytics.js";
		import { getFirestore, collection, getDocs } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-firestore.js";
		import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, signOut } from "https://www.gstatic.com/firebasejs/10.13.2/firebase-auth.js";
		const firebaseConfig = {
			apiKey: "AIzaSyCrLJd9s3TTMFmEGXCSqt63IW-PJIoZxeI",
			authDomain: "parcial1depaula.firebaseapp.com",
			projectId: "parcial1depaula",
			storageBucket: "parcial1depaula.appspot.com",
			messagingSenderId: "961778925822",
			appId: "1:961778925822:web:88409a7fbda9d4dd1465af",
			measurementId: "G-MLFQNNGT1L"
		};
		const app = initializeApp(firebaseConfig);
		//const analytics = getAnalytics(app);
		const auth = getAuth(app);
		const db = getFirestore(app);
		$(document).ready(function() {
			$('#login').click(function() {
				event.preventDefault();
				let email = $('#email').val();
				let password = $('#password').val();
				let captcha = $('#captcha').val();
				$.post('verif_captcha.php',{
					accion:'sanear',
					captcha: captcha,
					email: email,
					password: password
				}, function(data) {
					console.log(data);
					$.post('verif_captcha.php', {
						accion: 'login',
						captcha: captcha
					}, function(data) {
						console.log(data);
						if (data.trim() == 'CaptchaCorrecto') {
							signInWithEmailAndPassword(auth, email, password)
							.then((userCredential) => {
								console.log('Sesión iniciada');
								alert('Sesión iniciada con éxito');
								if (email == "admin@hotmail.com"){
									<?php $_SESSION['Usuario'] = "Admin" ?>
									location.href = 'home_admin.php';
								}
								else{
									<?php 
									// $_SESSION['Usuario'] = "Cliente";
									?>
									$.post('act_sesion.php', {
										accion: 'actualizar',
										email: email,
										usuario: 'Cliente'
									});
									window.location.href = 'home_cliente.php';
								}
							})
							.catch((error) => {
								console.error('Error al iniciar sesión:', error);
								alert('Usuario o contraseña inválidos');
							});
						} else {
							alert('Usuario, contraseña o captcha inválidos');
						}
					}); //2° post
				}); //1° post
			}); //#iniciarsesion
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
				<li class="nav-item"><a href="index.php" class="nav-link active" >Login</a></li>
				<li class="nav-item"><a href="home.php"  class="nav-link disabled"aria-current="page">Principal</a></li>
				<!-- <li class="nav-item"><a href="home_carrito.php"class="nav-link disabled" >Carrito</a></li>
				<li class="nav-item"><a href="home_envios.php" class="nav-link disabled" >Envios</a></li> -->
			</ul>
		</header>
	</div>
<h3>Iniciar Sesión</h3>
<h5></h5>
<!-- Formulario de login -->
<form id="loginForm" method="POST">
	<section>
		<!-- Con validaciones HTML5 (minlenght & required) -->
		<label>Email: </label>
		<input type="email" id="email" name="email" required> <br><br>
		<label>Contraseña: </label>
		<input type="password" id="password" name="password" minlength="5" maxlength="16" required> <br><br>
		<label>Captcha: </label>
		<input type="text" id="captcha" name="captcha" required> <br><br>
		<img src="captcha.php">
		<br><br>
		<button id="login" type="submit" class="btn btn-light custom-btn mb-4">Ingresar</button><br>
	</section>
</form>
<form action="home_registro.php" method="POST">
	<button type="button" class="btn btn-link" style="background-color: white;" onclick="location.href='home_registro.php';" >Registrarse! (Nuevo Cliente)
	</button>
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
	</div></div>
</body>
</html>