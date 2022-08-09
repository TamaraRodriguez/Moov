<section class="container">
	<div class="row">
		<h2 class="col-12 text-center pt-5 pb-5">Datos de Crédito</h2>
	
		<form action="procesos/proceso_checkout_cred.php" method="POST" class="col-12 col-md-8 m-auto pb-5">
            <div>
                <label for="numero">Número de Tarjeta *</label>
                <input class="w-100 p-3 mb-4" placeholder="XXXX XXXX XXXX XXXX" type="number" name="numero" id ="numero" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['numero']) ?  $_SESSION['campos']['numero'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['numero'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['numero'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="cuotasCred">Cuotas</label>
                <select name="cuotasCred" id="cuotasCred" class="w-100 p-3 mb-4">
                    <option value="una" id="una">1 Cuota</option>
                    <option value="tres" id="tres">3 Cuotas</option>
                    <option value="seis" id="seis">6 Cuotas</option>
                    <option value="nueve" id="nueve">9 Cuotas</option>
                    <option value="doce" id="doce">12 Cuotas</option>
                </select>
            </div>
            <div>
                <label for="vencimiento">Vencimiento de Tarjeta *</label>
                <input class="w-100 p-3 mb-4" placeholder="XX/XX" type="number" name="vencimiento" id ="vencimiento" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['vencimiento']) ?  $_SESSION['campos']['vencimiento'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['vencimiento'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['vencimiento'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="codigo">Código de Seguridad *</label>
                <input class="w-100 p-3 mb-4" placeholder="XXX" type="number" name="codigo" id ="codigo" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['codigo']) ?  $_SESSION['campos']['codigo'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['codigo'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['codigo'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="titular">Titular de la Tarjeta *</label>
                <input class="w-100 p-3 mb-4" placeholder="Titular de la tarjeta" type="text" name="titular" id ="titular" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['titular']) ?  $_SESSION['campos']['titular'] : ''?>"/>
                <?php
                    if (isset($_SESSION['errores']) && isset($_SESSION['errores']['titular'])):
                    ?>
                    <div class="alert alert-danger fade show mt-2" role="alert">
                        <?= $_SESSION['errores']['titular'] ?>
                    </div>
                <?php
                endif;
                ?>
            </div>
            <div>
                <label for="documento">DNI del Titular*</label>
                <input class="w-100 p-3 mb-4" placeholder="DNI del Titular" type="number" name="documento" id ="documento" value="<?= isset($_SESSION['campos']) && isset($_SESSION['campos']['documento']) ?  $_SESSION['campos']['documento'] : ''?>"/>
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
            <div class="center">
                <input type="submit" class="w-50 mb-4 p-2 mt-4" value="Confirmar">
            </div>
            <div class="center">
                <a href="index.php?seccion=checkout" class="volver" >Volver</a>
            </div>
		</form>				
	</div>
</section>