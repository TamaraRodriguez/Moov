<?php
require_once('../config/config.php');
require_once('../config/funciones.php');

$errores = [];

// Comprobamos que los campos requeridos no estén vacios
if (empty($_POST['numero']))
    $errores['numero'] = 'El número no puede estar vacío';
elseif (strlen($_POST['numero']) == 15)
    $errores['numero'] = 'El número de su tarjeta debe tener 16 caracteres';

if (empty($_POST['vencimiento']))
    $errores['vencimiento'] = 'El vencimiento de su tarjeta no puede estar vacío';
elseif (strlen($_POST['vencimiento']) == 3)
    $errores['vencimiento'] = 'El vencimiento de su tarjeta debe tener 4 caracteres';

if (empty($_POST['codigo']))
    $errores['codigo'] = 'El código de seguridad no puede estar vacío';
elseif (strlen($_POST['numero']) == 2)
    $errores['numero'] = 'El código de su tarjeta debe tener 3 caracteres';

if (empty($_POST['titular']))
    $errores['titular'] = 'El nombre del titular no puede estar vacío';

if (empty($_POST['documento']))
    $errores['documento'] = 'El DNI no puede estar vacía';


if (count($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['campos'] = $_POST;

    header("Location: ../index.php?seccion=checkoutcred");
    exit;
}

// Guardamos en las variables los datos que nos pasa el usuario al enviar
$numeroTarjeta = $_POST['numero'];
$documento = $_POST['documento'];
$codigo = $_POST['codigo'];
$vencimiento = $_POST['vencimiento'];
$titularTarjeta = $_POST['titular'];
$cuotasCred = $_POST['cuotasCred'];

// Verificamos si hay o no errores
if (!empty($numeroTarjeta) && !empty($documento) && !empty($codigo) && !empty($vencimiento) && !empty($titularTarjeta)) {
    unset($_SESSION['errores']);
    unset($_SESSION['campos']);

    $_SESSION['ok'] = 'Su compra fue realizada con éxito';

    header('Location: ../index.php?seccion=home');

} else {
    $_SESSION['campos'] = $_POST;
    unset($_SESSION['errores']);

    header('Location: ../index.php?seccion=checkoutdeb&status=error');
}