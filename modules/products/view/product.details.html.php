<?php defined('BORDAMEX') || exit;

/**
 *=======================================================* BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Extiensión de la vista de detalles de un producto
 *
 */

?>

<div class="container" style="padding: 0;">
  <!-- Main Product Card -->
  <div class="product-detail-card">
    <!-- Pink Header Section -->
    <div class="pink-header">
      <div class="product-image-details-container">
        <img src="<?= $config['products_url'] . '/' . $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="product-image-details">
      </div>
      <h1 class="product-title"><?= $product['name'] ?></h1>
      <div class="price-section">
        <?php if ($product['sale_price'] > 0) : ?>
          <span class="price-from">De <span class="crossed-price">$<?= $product['sale_price'] ?></span></span>
        <?php endif; ?>
        <span class="price-main">A $<?= $product['original_price'] ?></span>
        <span class="fire-emoji">🔥</span>
      </div>
    </div>

    <!-- Shipping Section -->
    <div class="shipping-banner">
      <i class="bi bi-lightning-charge-fill text-warning"></i>
      <strong>ENVIO GRATIS 🇲🇽</strong>
    </div>
    <div class="shipping-date">
      Compra hoy y recibe el día: <strong>Lunes 08 De Diciembre</strong>
    </div>

    <!-- Description Section -->
    <div class="description-section">
      <div class="row">
        <div class="col-md-8">
          <h2 class="section-title">DESCRIPCION</h2>
          <p class="description-text">
            <?= $product['description'] ?>
          </p>
        </div>
        <div class="col-md-4">
          <div class="feature-icons">
            <div class="feature-item">
              <i class="bi bi-shield-check"></i>
              <small>100% SEGURO</small>
            </div>
            <div class="feature-item">
              <i class="bi bi-truck"></i>
              <small>ENVIO RAPIDO</small>
            </div>
            <div class="feature-item">
              <i class="bi bi-arrow-repeat"></i>
              <small>DEVOLUCIONES</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Methods -->
    <div class="payment-section">
      <div class="payment-box">
        <small class="text-muted">Pago según garantizado</small>
        <div class="payment-icons">
          <i class="bi bi-credit-card-2-front"></i>
          <span>VISA</span>
          <i class="bi bi-circle-fill text-danger"></i>
          <i class="bi bi-circle-fill text-warning"></i>
          <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_37x23.jpg" alt="PayPal" class="paypal-logo">
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: "Helvetica Neue", Arial, sans-serif;
    background-color: #f5f5f5;
  }

  .product-detail-card {
    width: 100%;
    background: white;
    overflow: hidden;
    padding: 0 !important;
    margin-top: 30px;
  }

  /* Pink Header Section */
  .pink-header {
    background-color: var(--pink-primary);
    padding: 30px 20px 40px;
    text-align: center;
    position: relative;
    border-radius: 30px;
  }

  .product-image-details-container {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
  }

  .product-image-details {
    width: 90%;
    max-width: 300px;
    border-radius: 2px;
  }

  .product-title {
    color: white;
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 15px;
  }

  .price-section {
    color: white;
    font-size: 1.8rem;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }

  .price-from {
    font-size: 1.5rem;
  }

  .crossed-price {
    text-decoration: line-through;
    font-size: 1.3rem;
  }

  .price-main {
    font-size: 2.5rem;
    text-shadow: 0 0 3px white;
  }

  .fire-emoji {
    font-size: 2.5rem;
  }

  /* Shipping Banner */
  .shipping-banner {
    background-color: #fff;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
    border-bottom: 2px solid #f0f0f0;
  }

  .shipping-banner i {
    font-size: 1.5rem;
  }

  .shipping-date {
    padding: 12px 20px;
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
    font-size: 0.9rem;
  }

  /* Description Section */
  .description-section {
    padding: 25px 20px;
    background-color: #fff;
    border-bottom: 2px solid #f0f0f0;
  }

  .section-title {
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #333;
  }

  .description-text {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #666;
  }

  .feature-icons {
    display: flex;
    flex-direction: column;
    gap: 15px;
    align-items: flex-start;
  }

  .feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .feature-item i {
    font-size: 1.8rem;
    color: #333;
  }

  .feature-item small {
    font-size: 0.75rem;
    font-weight: bold;
    color: #666;
  }

  /* Payment Section */
  .payment-section {
    padding: 20px;
    background-color: #fff;
  }

  .payment-box {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 15px;
    text-align: left;
  }

  .payment-icons {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
    font-size: 1.2rem;
    font-weight: bold;
  }

  .payment-icons i {
    font-size: 1.5rem;
  }

  .paypal-logo {
    height: 20px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .product-title {
      font-size: 2rem;
    }

    .price-main {
      font-size: 2rem;
    }

    .feature-icons {
      margin-top: 20px;
    }
  }
</style>