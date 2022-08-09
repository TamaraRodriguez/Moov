<?php
require_once('../../config/config.php');
require_once('../../config/funciones.php');

$id = intval($_POST['id']);
$sql_producto = "SELECT * FROM productos
    LEFT JOIN monedas ON monedas_id=monedas_id_fk
    LEFT JOIN productos_tienen_categorias ON productos_id = productos_id_fk
    LEFT JOIN categorias ON categorias_id=categorias_id_fk 
    WHERE productos_id=$id";

$sql_categoria = "SELECT * FROM categorias";

$db_producto = mysqli_query($conexion, $sql_producto);
$db_categoria = mysqli_query($conexion, $sql_categoria);

if (!$db_producto->num_rows) {
    header('Location: index.php?secciones=alta_producto&status=error');
    exit;
}

$errores = [];

if (empty($_POST['nombre'])) {
    $errores['nombre'] = 'El nombre no puede estar vacío';

} elseif (strlen($_POST['nombre']) > 80) {
    $errores['nombre'] = 'El nombre puede tener hasta 80 caracteres';
}

if (empty($_POST['descripcion'])) {
    $errores['descripcion'] = 'La descripción no puede estar vacía';

} elseif (strlen($_POST['descripcion']) > 400) {
    $errores['descripcion'] = 'La descripción puede tener hasta 400 caracteres';
}

if (empty($_POST['moneda'])) {
    $errores['moneda'] = 'Tienes que seleccionar un tipo de moneda';
}

if (empty($_POST['precio'])) {
    $errores['precio'] = 'El precio no puede estar vacío';
}

if (empty($_POST['stock'])) {
    $errores['stock'] = 'El stock no puede estar vacío';
}

if (empty($_POST['categoria'])) {
    $errores['categoria'] = 'La categoria no puede estar vacía';
}

$imagen = $_FILES['imagen'];

if (empty($imagen['type'])) {
    $errores['imagen'] = 'Debe subir una imagen';
}

if (count($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['campos'] = $_POST;

    header("Location: ../index.php?seccion=alta_producto&id=$id&status=error&tipo=producto");
    exit;
}

if (!empty($imagen)) {

    $img = $imagen;

    if ($img['type'] != "image/png" && $img['type'] != 'image/jpeg') {
        $errores['imagen'] = 'La imagen debe de ser de tipo .png o .jpg';

        header("Location: ../index.php?seccion=lista_productos&status=errortype");
        exit;
    }

    if ($img['type'] == "image/png") {
        $extension = 'png';
    } else {
        $extension = 'jpeg';
    }

    $funcion = "imagecreatefrom$extension";
    $original = $funcion($img['tmp_name']);

    $nombre_imagen = $img['name'];

    $alto_original = imagesy($original);
    $ancho_original = imagesx($original);

    $ancho = 450;
    $alto = round( $ancho * $alto_original / $ancho_original );

    $copia = imagecreatetruecolor($ancho, $alto);

    //Guarda la trasparencia del png
    imagesavealpha($copia, true);
    //Pierde trasparencia
    imagealphablending($copia, false);

    imagecopyresampled($copia, $original, 0, 0, 0, 0, $ancho, $alto, $ancho_original, $alto_original);

    if ($extension == 'png') {
        imagepng($copia, "../../img/zapatillas/".$nombre_imagen, 9);
    } else {
        imagejpeg($copia, "../../img/zapatillas/".$nombre_imagen, 100);
    }

    //Liberamos memoria
    imagedestroy($original);
    imagedestroy($copia);

    //move_uploaded_file($img['tmp_name'], "../../img/zapatillas/".$nombre_imagen);
}

// Escapamos valores antes de utilizarlos en la base de datos
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
$moneda_id_fk = intval($_POST['moneda']);
$precio = intval($_POST['precio']);
$stock = intval($_POST['stock']);
$destacado =  intval($_POST['destacado']) ?? 0;
$categoria =  $_POST['categoria'];
$imagen = $nombre_imagen;

//dd2($categoria);

if (!empty($nombre) && !empty($precio) && !empty($stock) && !empty($moneda_id_fk ) && !empty($imagen)) {
    
    unset($_SESSION['errores']);
    unset($_SESSION['campos']);

    $sql_update = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock', imagen='$imagen', destacado='$destacado', monedas_id_fk='$moneda_id_fk' WHERE productos_id = $id";
    $db_modificado = mysqli_query($conexion, $sql_update);

    if ($db_modificado) {

        $sql_categoria = "UPDATE productos_tienen_categorias SET categorias_id_fk='$categoria[0]' WHERE productos_id_fk=$id";
        $db_cat_modificada = mysqli_query($conexion, $sql_categoria);

        //Notificamos la ediciónn del producto
        if ($db_cat_modificada) {
            header("Location: ../index.php?seccion=lista_productos&status=ok&accion=modificado");
            exit;
        }else{
            header('Location: ../index.php?seccion=lista_productos&status=error&tipo=categoria"');   
            exti;
        }
    } else {
        header("Location: ../index.php?seccion=alta_producto&id=$id&status=error&tipo=producto");
        exit;
    }
}else {
    unset($_SESSION['errores']);

    header('Location: ../index.php?seccion=alta_producto&id=$id&status=error&tipo=producto');
}
