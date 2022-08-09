<?php
require_once('../config/config.php');
require_once('../config/funciones.php');

if (empty($_POST['buscador'])) {
    header("Location: ../index.php?seccion=galeria");
}

$buscador = mysqli_real_escape_string($conexion, $_POST['buscador']);

$seleccionar_busc = "SELECT * FROM productos WHERE nombre LIKE '%$buscador%'";
$resul_seleccionar_busc = mysqli_query($conexion, $seleccionar_busc);

if ($resul_seleccionar_busc->num_rows) {
    unset($_SESSION['buscador']);
    $_SESSION['buscador']['palabra'] = $_POST['buscador'];
    while ($producto_buscado = mysqli_fetch_assoc($resul_seleccionar_busc)) {
        $_SESSION['buscador']['resultados'][] = $producto_buscado;
    }

} else {
    $_SESSION['error'] = 'Tu búsqueda no coincide con nuestros productos';
}

header('Location: ../index.php?seccion=galeria');


     

