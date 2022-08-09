<?php
require_once('../config/config.php');
require_once('../config/funciones.php');

$errores = [];

// Comprobamos que los campos requeridos no estén vacios
if (empty($_POST['nombre']))
    $errores['nombre'] = 'El nombre no puede estar vacío';

if (empty($_POST['documento']))
    $errores['documento'] = 'El DNI no puede estar vacío';

if (empty($_POST['email']))
    $errores['email'] = 'El email no puede estar vacío';

if (empty($_POST['direccion']))
    $errores['direccion'] = 'La dirección no puede estar vacía';


if (count($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['campos'] = $_POST;

    header("Location: ../index.php?seccion=checkout");
    exit;

}

// Guardamos en las variables los datos que nos pasa el usuario al enviar
$nombre = $_POST['nombre'];
$documento = $_POST['documento'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$formaPago = $_POST['formaPago'];

//Evaluamos la forma de pago seleccionada
if($formaPago == 'debito') {
    header("Location: ../index.php?seccion=checkoutdeb");
    exit;
} elseif($formaPago == 'credito') {
    header("Location: ../index.php?seccion=checkoutcred");
    exit;
} else {
    header("Location: ../index.php?seccion=home");
}

// Verificamos si hay o no errores
if (!empty($nombre) && !empty($documento) && !empty($email) && !empty($direccion)) {
    unset($_SESSION['errores']);
    unset($_SESSION['campos']);

    $_SESSION['ok'] = 'Su compra fue realizada con éxito';

    header('Location: ../index.php?seccion=home');
} else {
    $_SESSION['campos'] = $_POST;
    unset($_SESSION['errores']);

    header('Location: ../index.php?seccion=checkout&status=error');
}