<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registro</title>
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
	<script src="https://cdn.jsdelivr.net/npm/firebase@10.8.0/firebase-app.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/firebase@10.8.0/firebase-auth.js"></script>
	
	<!-- Firebase config -->
	<script type="module">
		import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
		import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-analytics.js";
		import { getFirestore, collection, getDocs } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
		import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, signOut } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
		const firebaseConfig = {
		    apiKey: "AIzaSyCrLJd9s3TTMFmEGXCSqt63IW-PJIoZxeI",
		    authDomain: "parcial1depaula.firebaseapp.com",
		    databaseURL: "https://parcial1depaula-default-rtdb.firebaseio.com",
		    projectId: "parcial1depaula",
		    storageBucket: "parcial1depaula.firebasestorage.app",
		    messagingSenderId: "961778925822",
		    appId: "1:961778925822:web:88409a7fbda9d4dd1465af",
		    measurementId: "G-MLFQNNGT1L"
		  };
		const app = initializeApp(firebaseConfig);
		//const analytics = getAnalytics(app);
		const auth = getAuth(app);
		const db = getFirestore(app);
		$(document).ready(function() {
			$('#registrar').click(function() {
				let email = $('#email').val();
				let password = $('#password').val();
				let nombre = $('#Nombre').val();
				let apellido = $('#Apellido').val();
				let numeroTarjeta = $('#NumTarjeta').val();
				let nombreTarjeta = $('#NomTarjeta').val();
				//console.log("Email:", email, "Password:", password);
				if (!email || !password || !nombre || !apellido || !numeroTarjeta) {
					alert("Complete todos los campos!");
					return;
				}
				createUserWithEmailAndPassword(auth, email, password)
				.then((userCredential) => {
					console.log('Usuario registrado:', userCredential.user);
					alert('Registro exitoso');
					const userId = userCredential.user.uid; // Obtiene el ID del usuario
					const data = {
						email: email,
						nombre: nombre,
						apellido: apellido,
						numeroTarjeta: numeroTarjeta,
						nombreTarjeta: nombreTarjeta
					};
				 	//Envía los datos a Firebase Realtime Database
					$.post('firebase_cargardatos.php', {
						accion: 'carga',
						email: email,
						nombre: nombre,
						apellido: apellido,
						numeroTarjeta: numeroTarjeta,
						nombreTarjeta: nombreTarjeta
					}, function(data) {
						console.log(data);
						location.href = "index.php";
					}); //post
				})
				.catch((error) => {
			    console.error('Error en el registro:', error);
			    alert('Error en el registro: ' + error.message + ' (Código: ' + error.code + ')');
			    //Password tiene que tener 6 caracteres minimo!!!!!
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
				<li class="nav-item"><a class="nav-link active" >Registro</a></li>
				<li class="nav-item"><a href="index.php" class="nav-link" >Login</a></li>
			</ul>
		</header>
	</div>
</h6>
<h3>Registro</h3>
<h5></h5>
<form id="loginForm" method="POST">
	<section>
		<label>Email: </label>
		<input type="email" id="email" name="email" required> <br><br>
		<label>Contraseña: </label>
		<input type="password" id="password" name="password" minlength="5" maxlength="16" required> <br><br>
		<br><br>
		<label>Nombre: </label>
		<input type="text" id="Nombre" name="Nombre" required> <br><br>
		<label>Apellido: </label>
		<input type="text" id="Apellido" name="Apellido" required> <br><br>
		<label>Numero Tarjeta: </label>
		<input type="password" id="NumTarjeta" name="NumTarjeta" minlength="2" maxlength="20" required> <br><br>
		<label>Nombre Tarjeta: </label>
		<input type="text" id="NomTarjeta" name="NomTarjeta" required> <br><br>
		<button id="registrar" type="button" class="btn btn-light custom-btn mb-4">Registrarse</button><br>
		<button type="submit" class="btn btn-link" style="background-color: white;" onclick="location.href='index.php';" >¿Tiene cuenta? Logearse!
		</button>
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
