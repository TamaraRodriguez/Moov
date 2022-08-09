<?php
require_once('../../config/config.php');
require_once('../../config/funciones.php');

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
    $errores['moneda'] = 'Tenés que seleccionar un tipo de moneda';
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

    header("Location: ../index.php?seccion=alta_producto&status=error");
    exit;
}

if (!empty($imagen)) {

    $img = $imagen;

    if ($img['type'] != "image/png" && $img['type'] != 'image/jpeg') {
        $errores['imagen'] = 'La imagen debe de ser de tipo .png o .jpg';

        header("Location: ../index.php?seccion=alta_producto&status=errortype");
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

    /*header('Content-type: image/jpeg');

    move_uploaded_file($img['tmp_name'], "../../img/zapatillas/".$nombre_imagen);*/
}

// Escapamos valores antes de utilizarlos en la base de datos
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
$moneda_id_fk = intval($_POST['moneda']);
$precio = intval($_POST['precio']);
$stock = intval($_POST['stock']);
$destacado = intval($_POST['destacado']) ?? 0;
$imagen = $nombre_imagen;

if (!empty($nombre) && !empty($precio) && !empty($stock) && !empty($moneda_id_fk ) && !empty($imagen)) {
    
    unset($_SESSION['errores']);
    unset($_SESSION['campos']);

    $sql_crear = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, destacado, monedas_id_fk) VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$imagen', '$destacado', '$moneda_id_fk')";
    $db_crear = mysqli_query($conexion, $sql_crear);

    if ($db_crear) {

         if (empty($_POST['categoria'])) {
            header("Location: ../index.php?seccion=lista_productos&status=ok&accion=creado");
            exit;
        }

        $producto_id_fk = mysqli_insert_id($conexion);
        $categorias = $_POST['categoria'];

        $values = '';
        foreach ($categorias as $categoria_id_fk) {
            $values .= "($producto_id_fk,$categoria_id_fk),";
        }

        $values = substr($values, 0, -1);
        $values .= ';';

        $insert_cat = "INSERT INTO productos_tienen_categorias (productos_id_fk, categorias_id_fk) VALUES $values";
        $res_insert_cat = mysqli_query($conexion, $insert_cat);

        if ($res_insert_cat) {
            header("Location: ../index.php?seccion=lista_productos&status=ok&accion=creado");
            exit;
        } else {
            header("Location: ../index.php?seccion=lista_productos&status=error&tipo=categoria");
            exit;
        }
    } else {
        header("Location: ../index.php?seccion=alta_producto&status=error&tipo=producto");
        exit;
    }
}else {
    unset($_SESSION['errores']);

    header('Location: ../index.php?seccion=alta_producto&id=$id&status=error&tipo=producto');
}