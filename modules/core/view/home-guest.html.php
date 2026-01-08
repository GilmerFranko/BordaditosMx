<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal de los creditos
 *
 *
 */
// HEADER
require Core::view('head', 'core');
// MENU
require Core::view('menu', 'core');
?>


<section class="first-section content" id="main">

	<!-- Main Promo Banner -->
	<div class="container my-3">
		<div class="promo-banner">
			<img src="<?= $config['products_url'] . '/' . $sectionHero['image_section'] ?>" alt="Tom & Jerry" class="banner-image">
			<?php if ($session->is_admod == 1) : ?>
				<a href="<?= gLink('admin/edit.section-hero') ?>" class="banner-edit">Editar</a>
			<?php endif; ?>
		</div>
	</div>

	<!-- Delivery Banner -->
	<div class="delivery-banner">
		<div class="container">
			<div class="d-flex align-items-center justify-content-center">
				<i class="bi bi-lightning-fill me-2"></i>
				<span>Compra hoy y recibe tu pedido en menos de 5 días</span>
				<i class="bi bi-truck ms-2"></i>
			</div>
		</div>
	</div>

	<!-- Product Grid -->
	<div class="container my-3">
		<?php require Core::view('products.area', 'products'); ?>
	</div>

	<!--paginador-->
	<?php echo $products['pages']['paginator']; ?>
	<!--fin_paginador-->

</section>


<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>