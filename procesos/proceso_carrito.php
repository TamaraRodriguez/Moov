<?php session_start();

    if(isset ($_SESSION['carrito'])){
        $mi_carrito = $_SESSION['carrito'];
        if(isset($_POST['nombre'])){
            $nombre_producto = $_POST['nombre'];
            $precio_producto = $_POST['precio'];
            $cantidad_producto = $_POST['cantidad'];
            $num=0;
            $mi_carrito[]=array("nombre"=>$nombre_producto,"precio"=>$precio_producto,"cantidad"=>$cantidad_producto);
        }
    }else{
        $nombre_producto = $_POST['nombre'];
        $precio_producto = $_POST['precio'];
        $cantidad_producto = $_POST['cantidad'];
        $mi_carrito[]=array("nombre"=>$nombre_producto,"precio"=>$precio_producto,"cantidad"=>$cantidad_producto);   
    }

$_SESSION['carrito']=$mi_carrito;

header("Location: ".$_SERVER['HTTP_REFERER']."");

?>