<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Archivo que incluye el pie de página
 *
 *
 */


if ($config['debug_mode'] == 1): ?>
	<span id="performance-data" class="grey-text text-lighten-4 right" style="position: fixed;right: 0;    bottom: 80px; background: rgba(0, 0, 0, 0.5); padding: 5px 5px 0 5px;">
		<?php Core::model('debug', 'core')->show($config['debug_mode']); ?>
		<br>
		<?php if (isset($_SESSION['models_used'])): ?>
			<?php foreach ($_SESSION['models_used'] as $key => $value): ?>
				<?php echo $value ?><br>
			<?php endforeach ?>
		<?php endif ?>
		<?php unset($_SESSION['models_used']); ?>
		<?php debugHTML() ?>
	</span>

<?php endif; ?>

<?php

?>

<?php // No mostrar en admin
if ($sModule != 'admin'): ?>
	<footer class="page-footer center" style="margin-bottom: 30px; padding: 5px 0">
		<!-- Bottom Navigation -->
		<nav class="bottom-nav">
			<div class="container-fluid">
				<div class="d-flex justify-content-around align-items-center">
					<div class="nav-item">
						<a href="" class="waves-effect waves-blue">
							<i class="bi bi-cart3"></i>
							<div class="small">Carrito</div>
						</a>
					</div>
					<div class="nav-item active">
						<a href="<?= gLink('core', 'home') ?>" class="waves-effect waves-blue">
							<i class="bi bi-house-fill"></i>
							<div class="small">Inicio</div>
						</a>
					</div>
					<div class="nav-item">
						<a href="<?= gLink('rastrear') ?>" class="waves-effect waves-blue">
							<i class="bi bi-truck"></i>
							<div class="small">Rastrear</div>
						</a>
					</div>
				</div>
			</div>
		</nav>
	</footer>
<?php endif ?>

<?php if ($config['debug_mode'] == 0 and $sSection === 'view_messages'): ?>
	<div id="google_translate_element2"></div>
	<script type="text/javascript">
		function googleTranslateElementInit2() {
			new google.translate.TranslateElement({
				pageLanguage: 'es',
				autoDisplay: true
			}, 'google_translate_element2');
		}
	</script>
	<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
	<!-- Translate -->
	<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/translate.js"></script>
<?php endif ?>
</body>

</html>
<?php

?>