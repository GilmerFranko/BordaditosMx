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
			<img src="https://tse3.mm.bing.net/th/id/OIP.eJjylp2wemhUFAQ9CFozEAHaFV?rs=1&pid=ImgDetMain&o=7&rm=3" alt="Tom & Jerry" class="banner-image">
			<div class="promo-badge">
				<div class="promo-text">
					<div class="fw-bold">PROMOCIÓN</div>
					<div class="fw-bold">NAVIDEÑA</div>
				</div>
				<div class="promo-circle">2x1</div>
			</div>
			<img src="https://tse3.mm.bing.net/th/id/OIP.eJjylp2wemhUFAQ9CFozEAHaFV?rs=1&pid=ImgDetMain&o=7&rm=3" alt="Santa" class="santa-image">
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
		<div class="row g-3">
			<?php if ($products['total'] > 0) : ?>
				<?php foreach ($products['data'] as $product) : ?>
					<div class="col-6" style="cursor: pointer;" onclick="window.location.href='<?= gLink('products/view.product', ['product_id' => $product['id']]) ?>'">
						<div class="product-card">
							<div class="product-image">
								<img src="<?= $config['products_url'] . '/' . $product['image_url'] ?>" alt="<?= $product['name'] ?>">
							</div>
							<div class="product-info">
								<h3 class="product-title"><?= $product['name'] ?></h3>
								<div class="shipping-badge">
									Envío gratis <img src="https://images.emojiterra.com/twitter/512px/1f1f2-1f1fd.png" width="24" alt="">
								</div>
							</div>
							<?php if ($session->is_admod == 1) : ?>
								<div class="">
									<a href="<?= gLink('admin/edit.product', ['product_id' => $product['id']]) ?>" class="">Editar producto</a>
								</div>
							<?php endif; ?>
							<div class="price-container d-flex align-items-center justify-content-center">
								<div class="price-container">
									<?php if ($product['sale_price'] > 0) : ?>
										<span class="price-old">$<?= $product['sale_price'] ?></span>
									<?php endif; ?>
									<span class="price-new">$<?= $product['original_price'] ?></span>
								</div>
								<div class="fire-icon">🔥</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>

</section>


<!-- FOOTER -->
<?php require Core::view('footer', 'core'); ?>