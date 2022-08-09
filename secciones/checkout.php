<?php
unset($_SESSION['carrito']);
?>
<section class="container">
	<div class="row">
		<h2 class="col-12 text-center pt-5 pb-5">Datos de Compra</h2>
	
		<form action="procesos/proceso_checkout.php" method="POST" class="col-12 col-md-8 m-auto pb-5">
            <div>
                <label for="nombre">Nombre *</label>
                <input class="w-100 p-3 mb-4" placeholder="Nombre" type="text" name="nombre" id ="nombre" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['nombre']) ?  $_SESSION['campos']['nombre'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['nombre'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['nombre'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="documento">DNI *</label>
                <input class="w-100 p-3 mb-4" placeholder="DNI" type="number" name="documento" id ="documento" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['documento']) ?  $_SESSION['campos']['documento'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['documento'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['documento'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="email">Email *</label>
                <input class="w-100 p-3 mb-4" placeholder="Email" type="email" name="email" id ="email" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['email']) ?  $_SESSION['campos']['email'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['email'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['email'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="direccion">Dirección *</label>
                <input class="w-100 p-3 mb-4" placeholder="Dirección" type="text" name="direccion" id ="direccion" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['direccion']) ?  $_SESSION['campos']['direccion'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['direccion'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['direccion'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="formaPago">Forma de Pago</label>
                <select name="formaPago" id="formaPago" class="w-100 p-3 mb-4">
                    <option value="efectivo" id="efectivo">Efectivo</option>
                    <option value="credito" id="credito">Crédito</option>
                    <option value="debito" id="debito">Débito</option>
                </select>
            </div>
            <div class="center">
                <input type="submit" class="w-50 mb-4 p-2 mt-4" value="Confirmar">
            </div>
            <div class="center">
                <a href="index.php?seccion=galeria" class="volver" >Volver</a>
            </div>  
		</form>	
	</div>
</section>