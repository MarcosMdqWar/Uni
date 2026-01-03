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
	
	<!-- Firebase config -->
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
			$('.add-to-cart-btn').click(function() {
	            const selectedRadio = document.querySelector('input[name="product"]:checked');
	            if (selectedRadio) {
	                let articulo = selectedRadio.nextElementSibling.querySelector('p').innerText; // Obtiene el nombre del artículo (texto del <p>)
	                let precio = $(selectedRadio).data('precio');
	                $.post('act_sesion.php', {
	                    accion: 'actualizar2',
	                    articulo: articulo,
	                    precio: precio
	                }, function(response) {
	                    alert("Artículo seleccionado: " + articulo);
	                    console.log(response);
	                });
	            }
        	});
        	$('#view-cart-btn').click(function() {
	            const selectedRadio = document.querySelector('input[name="product"]:checked');
	            if (selectedRadio) {
	                location.href = ("home_carrito.php");
	            }
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
				<li class="nav-item"><a href="home_principal.php"  class="nav-link active"aria-current="page">Principal</a></li>
				<li class="nav-item"><a href="home_carrito.php"class="nav-link" >Carrito</a></li>
				<li class="nav-item"><a href="home_envios.php" class="nav-link disabled" >Envios</a></li>
			</ul>
		</header>
	</div>
	<h6>
	<?php  if (isset ($_SESSION['Articulo'])){
			echo "Articulo selccionado: ";
			echo $_SESSION['Articulo'];
		}
	?>
	</h6>
	<h5>Principal</h5>
	<h3> Elija su orden:
	</h3>
		<div class="container2">
		    <div class="product-card">
		        <input type="radio" name="product" id="product1" data-precio="1000" >
		        <label for="product1">
		            <img src="images/SSD.jpg" alt="Disco SSD" class="img">           
		            <p>Disco SSD</p> <!-- Esto lee el jquery -->
		            <button class="add-to-cart-btn" disabled>Agregar Carrito</button>
		        </label>
		    </div>
		    <div class="product-card">
		        <input type="radio" name="product" id="product2" data-precio="2000">
		        <label for="product2">
		            <img src="images/RAM.jpg" alt="Memoria RAM" class="img">       
		            <p>Memoria RAM</p>
		            <button class="add-to-cart-btn" disabled>Agregar Carrito</button>
		        </label>
		    </div>
		    <div class="product-card">
		        <input type="radio" name="product" id="product3" data-precio="3000">
		        <label for="product3">
		            <img src="images/MOTHER.png" alt="Placa Madre" class="img">
		            <p>Placa Madre</p>
		            <button class="add-to-cart-btn" disabled>Agregar Carrito</button>
		        </label>
		    </div>
		</div>
	    
	    <button id="view-cart-btn" disabled>Ver Carrito</button>
	    
	    <script>
		    // Seleccionar todos los radio buttons y botones de "Agregar Carrito"
		    const radios = document.querySelectorAll('input[name="product"]');
		    const viewCartButton = document.querySelector('#view-cart-btn'); //Sin "ALL" en queryselector
		    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

		    // Deshabilitar todos los botones "Agregar Carrito" si no hay un producto seleccionado
		    radios.forEach((radio, index) => {
		        radio.addEventListener('change', () => {
		            addToCartButtons.forEach(btn => btn.disabled = true); // Deshabilitar todos
		            if (radio.checked) {
		                addToCartButtons[index].disabled = false; // Habilitar solo el seleccionado
		               	viewCartButton.disabled = false;
		            }
		        });
		    });
		</script>
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
