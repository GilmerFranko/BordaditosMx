<?php defined('BORDAMEX') || exit;

/**
 *=======================================================* BORDAMEX Project
 * @Description Vista que enlista los productos
 */

require Core::view('head', 'core');
?>

<div class="row g-3">
  <?php if (!empty($products['total']) && $products['total'] > 0) : ?>
    <?php foreach ($products['data'] as $product) : ?>
      <div class="col-6 container-product" style="cursor: pointer;" onclick="window.location.href='<?= gLink('products/view.product', ['product_id' => $product['id']]) ?>'">
        <div class="product-card">

          <div class="product-image">
            <img
              src="<?= $config['products_url'] . '/' . $product['image_url'] ?>"
              alt="<?= htmlspecialchars($product['name']) ?>"
              loading="lazy"
              width="300"
              height="300"
              style="object-fit: cover; width: 100%; aspect-ratio: 1/1;">
          </div>

          <div class="product-info">
            <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
            <div class="shipping-badge">
              Envío gratis <img src="<?= $config['images_url'] . '/logo-mx.webp' ?>" width="24" alt="">
            </div>
          </div>

          <?php if (isset($session->is_admod) && $session->is_admod == 1) : ?>
            <div class="" onclick="event.stopPropagation();">
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