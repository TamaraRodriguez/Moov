<?php
require_once('../config/config.php');
require_once('../config/funciones.php');

$id = intval($_POST['id']);

if (empty($id)) {
    header("Location: ../index.php?seccion=galeria");
}

$id_detalle = mysqli_real_escape_string($conexion, $id);

$selec_producto = "SELECT * FROM productos WHERE productos_id = '$id_detalle'";
$result = mysqli_query($conexion, $selec_producto);

if ($result->num_rows) {
    //$_SESSION['detalle']['id'] = $id;
    while ($detalle = mysqli_fetch_assoc($result)) {
        $_SESSION['detalle'] = $detalle;
    }

} else {
    $_SESSION['error'] = 'No es posible mostrar el detalle de este producto';
    header("Location: ../index.php?seccion=galeria");
    exit;
}

header('Location: ../index.php?seccion=detalle');

?>