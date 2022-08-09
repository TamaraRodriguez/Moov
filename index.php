<!DOCTYPE html>
<?php
require_once('config/config.php');
require_once('config/arrays.php');
require_once('config/funciones.php');

$title = 'MOOV';
$alumno = 'Chierichetti Nahuel Nicolás | Rodríguez Manzanero Tamara';
$materia = 'Programación II';

$totalcantidad = 0;
$cantidad_producto = 0;
$total = 0;

?>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?= $title ?></title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
    <meta name="author" content="Tamara Rodríguez Manznaero | Nahuel Nicolás Chierichetti"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css"/>
    <link rel="icon" href="img/favicon-min.png" type="image/png"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>
	<header>
	    <div class="container-fluid bg-light">
		    <nav class="menu navbar navbar-expand-md navbar-light">
			    <div>
			        <h1 class="logo"><a href="index.php?seccion=home"><?= $title ?></a></h1>
			    </div>
		          	
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#barra" aria-controls="barra" aria-expanded="false" aria-label="Menú Hamburguesa">
		            <span class="navbar-toggler-icon"></span>
		        </button>
					    
				<div class="collapse navbar-collapse" id="barra">
					<ul class="navbar-nav text-center ml-auto">
				        <?php foreach ($menu as $texto => $url): ?>
		                <li class="nav-item <?= section_active(explode('=', $url)[1]) ?>">
		                    <a class="nav-link" href='<?= $url ?>'><?= $texto ?></a>
		                </li>
		                <?php endforeach;?>

		                <?php if (!isset($_SESSION['usuario'])): ?>
		                <li class="nav-item">
                           <a href="index.php?seccion=login" class="nav-link">Login </a>
                       	</li>
                       	<?php endif; ?>
			            
			            <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item">
                           <a href="procesos/proceso_logout.php" class="nav-link"> Cerrar Sesión </a>
                        </li>
                        <li class="nav-item mt-2"><span>Bienvenido <?= $_SESSION['usuario']['usuario'] ?></span>
                        </li>
						<?php
						$totalcantidad = 0;
						$cantidad_producto = 0;
						if(isset($_SESSION['carrito'])){
						$mi_carrito = $_SESSION['carrito'];
						for($i=0;$i<=count($mi_carrito)-1;$i++){
								if($mi_carrito[$i]!=NULL){
									$total_cantidad = $cantidad_producto;
									$total_cantidad ++;
									$totalcantidad += $total_cantidad;
								}
							}
						} ?>
						<li>
							<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_cart"> Carrito <?= $totalcantidad ?></button>-->
							<a class="nav-link" data-toggle="modal" data-target="#modal_cart" style="color: #FF416C; cursor: pointer;"><i class="bi bi-bag"> </i><?= $totalcantidad ?></a>
						</li>
						<?php endif; ?>
			      	</ul>
			    </div>
			</nav>
	    </div>
	</header>

	<?php
		$seccion = $_GET['seccion'] ?? 'home';

		if (empty($seccion))
		    $seccion = 'home';

		$ruta = SECCIONES . $seccion . '.php';

		if (file_exists($ruta))
		    require_once($ruta);
		else
		    require_once(SECCIONES .'home.php');
	?>

	<!-- Ventana modal -->
	<div class="modal fade" id="modal_cart" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Carrito</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	         </button>
			</div>
			<div class="modal-body">
				<div>
					<div class="p-2">
						<ul class="list-group mb-3">
							<?php
							if(isset($_SESSION['carrito'])){
							$total = 0;
								for($i = 0; $i <= count($mi_carrito) -1; $i++){
									if($mi_carrito[$i] != NULL){
							?>
									<li class="list-group-item d-flex justify-content-between">
										<div class="row col-12">
											<div class="col-6 p-0" style="text-align: left; color: #000000;"><h6 class="my-0"><?= $mi_carrito[$i]['nombre'] ?></h6>
											</div>
											<div class="col-6 p-0" style="text-align: right; color: #000000;">
												<span class="text-muted" style="text-align: right; color: #000000">$<?= $mi_carrito[$i]['precio'] * $mi_carrito[$i]['cantidad']; ?></span>
											</div>
										</div>
									</li>
							<?php
									}
								}
							}
							?>
							<li class="list-group-item d-flex justify-content-between">
							<span style="text-align: left; color: #000000;">Total </span>
							<strong style="text-align: left; color: red;">$<?php
							if(isset($_SESSION['carrito'])){
								for($i = 0; $i <= count($mi_carrito) -1; $i++){
									if($mi_carrito[$i] != NULL){
									$total = $total + ($mi_carrito[$i]['precio'] * $mi_carrito[$i]['cantidad']);
									}	
								}
							}
							echo $total; ?></strong>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			<?php if($totalcantidad != 0) { ?>
				<a type="button" class="btn btn-eliminar" href="../moov/procesos/proceso_borrar_carrito.php">Vaciar Carrito</a>
				<a href="index.php?seccion=checkout" class="btn btn-moov w-50">Finalizar Compra</a>
			<?php } else { ?>
				<p >No hay productos seleccionados</p>
			<?php } ?>
			</div>
		</div>
	</div>
	</div>

	<footer class="container-fluid px-0 py-5">
	    <div class="row m-0 p-0">
	        <div class="col-12 px-0">
	            <p class="text-center m-0"><?= $materia ?> | <?= $alumno ?> | <?= $title ?></p>
	        </div>
	    </div>
	</footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>