<!-- https://getbootstrap.com/docs/4.0/components/ 
https://www.w3schools.com/css/
-->

<?php
session_start();
if (isset($_SESSION['Usuario'])) {
    $u = $_SESSION['Usuario'];
    if ($u != "Admin") {
        header('Location: index.php');
        exit();  // Always call exit after header redirect to ensure no further code is executed
    }
} else {
    // If the 'Usuario' session variable is not set, redirect to index.php
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
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
			$('#cerrar_sesion').click(function() {
				signOut(auth).then(() => {
					console.log('Sesión cerrada');
					alert('Sesión cerrada correctamente');
					<?php session_destroy();?>
					location.href = 'index.php';
				}).catch((error) => {
					console.error('Error al cerrar sesión:', error);
					alert('Error al cerrar sesión: ' + error.message);
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
				<li class="nav-item"><a class="nav-link active" >Logout</a></li>
				<li class="nav-item"><a href="home.php"  class="nav-link disabled"aria-current="page">Principal</a></li>
				<li class="nav-item"><a href="home_carrito.php"class="nav-link disabled" >Carrito</a></li>
				<li class="nav-item"><a href="home_envios.php" class="nav-link" >Envios</a></li>
			</ul>
		</header>
	</div>
<h3>Bienvenido Admin!</h3>
<h6>Ya puede ingresar a envios</h6>
<h5></h5>
<!-- Formulario de login -->
<button type="button" class="btn btn-danger" id="cerrar_sesion">
	Cerrar Sesión
</button>
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