<?php  
$db_productos = 'SELECT * FROM productos;';
$datos_db = mysqli_query($conexion, $db_productos);

if (!empty($_SESSION['ok'])):
    ?>
    <div class="alert alert-success fade show" role="alert">
        <?= $_SESSION['ok'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php
elseif (!empty($_SESSION['error'] )):
    ?>
    <div class="alert alert-danger fade show" role="alert">
        <?= $_SESSION['error']  ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif;
unset($_SESSION['error']);
unset($_SESSION['ok']);
?>
<section class="container">
	<div class="row">
		<h2 class="col-12 text-center pt-5 pb-5">Productos</h2>
        <div class="col-12">
            <form action="procesos/proceso_buscador.php" class="text-right" method="POST">
                <label for="buscador" class="sr-only">Buscar Producto</label>
                <input type="text" name="buscador" id="buscador" class="p-2" placeholder="Buscar Producto" value="<?= isset($_SESSION['buscador']) ? $_SESSION['buscador']['palabra'] : '' ?>">
                <button type="submit" class="btn-moov px-5">Buscar</button>
            </form>
        </div>
		
       <?php 
        if (isset($_SESSION['buscador'])) {
            foreach ($_SESSION['buscador']['resultados'] as $producto): ?> 
            <div class="col-12 col-md-4 bg-light galeria">
                <?php if($producto['imagen'] == NULL){ ?>
                <img src="img/zapatillas/productosinfoto-min.png" class="card-img-top" alt="Producto sin foto">
                <?php } else { ?>
                <img src="<?= RUTA . $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                <?php } ?>
                <div class="card-body">
                    <h4 class="card-title">$<?= $producto['precio'] ?></h4>
                    <h5 class="card-title"><?= $producto['nombre'] ?></h5>
                    <p class="card-text"><?= $producto['descripcion'] ?></p>
                    <p><?= stock($producto['stock'])?></p>
                </div>
            </div>
        <?php endforeach;
        } else {   
            while($producto = mysqli_fetch_assoc($datos_db)): ?> 
            <div class="col-12 col-md-4 bg-light galeria">
                <form action="procesos/proceso_carrito.php" method="POST" >
                    <input name="precio" type="hidden" id="precio<?=$producto['productos_id']?>" value="<?= $producto['precio'] ?>">
                    <input name="nombre" type="hidden" id="nombre<?=$producto['productos_id']?>" value="<?= $producto['nombre'] ?>">
                    <input name="cantidad" type="hidden" id="cantidad<?=$producto['productos_id']?>" value="1">

                    <?php if($producto['imagen'] == NULL){ ?>
                    <img src="img/zapatillas/productosinfoto-min.png" class="card-img-top" alt="Producto sin foto">
                    <?php } else { ?>
                    <img src="<?= RUTA . $producto['imagen'] ?>" class="card-img-top" alt="<?= $producto['nombre'] ?>">
                    <?php } ?>
                    <div class="card-body pb-1">
                        <h4 class="card-title">$<?= $producto['precio'] ?></h4>
                        <h5 class="card-title"><?= $producto['nombre'] ?></h5>

                        <div class="row mt-3">                           

                            <?php if (isset($_SESSION['usuario'])): ?>
                                <button class="w-50 btn-moov col-12 m-1">Añadir al Carrito</button>
                            <?php endif; ?>

                        </div>                       
                    </div>
                </form>
                <form action="procesos/proceso_detalle.php" method="POST">
                    <input name="id" type="hidden" id="id_detalle<?= $producto['productos_id'] ?>" value="<?= $producto['productos_id'] ?>">
                    <input name="imagen_detalle" type="hidden" id="imagen_detalle<?=$producto['productos_id']?>">
                    <input name="precio_detalle" type="hidden" id="precio_detalle<?=$producto['productos_id']?>">
                    <input name="nombre_detalle" type="hidden" id="nombre_detalle<?=$producto['productos_id']?>" value="<?= $producto['nombre'] ?>">

                    <input name="descripcion_detalle" type="hidden" id="descripcion_detalle<?=$producto['productos_id']?>" value="<?= $producto['descripcion'] ?>">
                    <input name="stock_detalle" type="hidden" id="stock_detalle<?=$producto['productos_id']?>" value="<?= stock($producto['stock'])?>">
                    <div class="row mt-0 ml-1 mr-1 mb-3">
                        <button type="submit" class="w-50 btn-eliminar col-12 m-1 p-2" data-toggle="modal" data-target="#detalle<?= $producto['productos_id'] ?>">Ver detalles</button>
                    </div>
                </form>
            </div>
        <?php endwhile; } ?>
	</div>
</section>
<section class="container-fluid bg-light mt-5 py-5">
	<div class="row">
		<h4 class="col-12 text-center" id="enviogratis">¡COMPRAS SUPERIORES A LOS $15.000 ENVÍO GRATIS!</h4>
	</div>
</section>

            