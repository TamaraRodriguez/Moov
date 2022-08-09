<?php 

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
		<h2 class="col-12 text-center pt-5 pb-5">Detalle del producto</h2>
        <div class="card-body pb-1">
            <div class="row">
                <?php if (isset($_SESSION['detalle'])) {
                    $detalle = [];
                    $detalle = $_SESSION['detalle'];
                    //dd2($detalle);
                    $banderita = 0;
                    for ($i = 0; $i <= count($detalle); $i++ ) { 

                        if($detalle["productos_id"] != NULL && $banderita == 0){?>
                            <div class="col-12 col-md-6 p-2">
                            <?php if($detalle["imagen"] == NULL){ ?>
                                <img src="img/zapatillas/productosinfoto-min.png" class="card-img-top" alt="Producto sin foto">
                                <?php } else { ?>
                                <img src="<?= RUTA . $detalle["imagen"] ?>" class="card-img-top" alt="<?= $detalle["nombre"] ?>">
                            <?php } ?>
                            </div>
                            <div class="col-12 col-md-6 my-auto pl-5">
                                <h4 class="card-title">$<?= $detalle["precio"] ?></h4>
                                <h5 class="card-title"><?= $detalle["nombre"] ?></h5>
                                <p class="card-text"><?=$detalle["descripcion"] ?></p>
                                <p><?= stock($detalle["stock"])?></p>
                            </div>
                    <?php $banderita = 1; 
                        } 
                    }  
                }  ?>
            </div>
        </div>
	</div>
    <div class="center mt-4">
        <a href="index.php?seccion=galeria" class="btn btn-eliminar w-50 m-1 p-2">Atrás</a>
    </div>
</section>
<section class="container-fluid bg-light mt-5 py-5">
	<div class="row">
		<h4 class="col-12 text-center" id="enviogratis">¡COMPRAS SUPERIORES A LOS $15.000 ENVÍO GRATIS!</h4>
	</div>
</section>


                           
                            