<?php defined('BORDAMEX') || exit;

/**
 *=======================================================* BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Extensión de la vista de detalles de un producto
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
      <i class="text-warning">✈️</i>
      <strong>ENV&Iacute;O GRATIS &nbsp;<img src="https://cdn-icons-png.flaticon.com/512/5344/5344530.png" width="30" alt="México"></strong>
    </div>
    <div class="shipping-date">
      ⚡Compra hoy y recibe el día: <strong><?= getFiveDaysLater() ?></strong>
    </div>

    <!-- Description Section -->
    <div class="description-section">
      <div class="row">
        <div class="col-md-8">
          <h2 class="section-title">DESCRIPCION</h2>
          <p class="description-text" style="margin-bottom: 5px">
            <?= tobr($parser->getAsHTML()) ?>
          </p>
          <img src="<?= $config['images_url'] . '/tipos-de-telas.jpeg' ?>" alt="tipos de telas" width="260">
        </div>
        <div class="col-md-4 separator-hr">
          <!-- Beneficios con distribución mejorada -->
          <div class="feature-icons">
            <div class="feature-item">
              <i class="bi bi-shield-check"></i>
              <small>100% SEGURO</small>
            </div>
            <div class="feature-item">
              <i class="bi bi-truck"></i>
              <small>ENV&Iacute;O RAPIDO</small>
            </div>
            <div class="feature-item">
              <i class="bi bi-arrow-repeat"></i>
              <small>DEVOLUCIONES</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- New Payment Methods Section -->
    <div class="payment-section">
      <fieldset class="contenedor-pagos-nuevo">
        <legend class="titulo-pagos-nuevo">
          <svg class="icono-candado-nuevo" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
          </svg>
          Pago seguro garantizado
        </legend>

        <div class="iconos-flex-nuevo">
          <img class="metodo-pago-nuevo" src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa">
          <img class="metodo-pago-nuevo" src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
          <img class="metodo-pago-nuevo" src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
          <img class="metodo-pago-nuevo" src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Cash_App_RB_F1_Team_Logo.svg" alt="Amex" onerror="this.src='https://img.icons8.com/color/48/000000/amex.png'">
          <img class="metodo-pago-nuevo logo-oxxo-nuevo" src="https://upload.wikimedia.org/wikipedia/commons/6/66/Oxxo_Logo.svg" alt="OXXO">
        </div>
      </fieldset>
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
  }

  /* Pink Header Section */
  .pink-header {
    background-color: var(--pink-primary);
    padding: 30px 20px 40px;
    text-align: center;
    position: relative;
    border-radius: 0 0 30px 30px;
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
    padding: 15px 20px 5px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
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
    font-weight: 500;
    color: #666;
    font-family: Arial;
  }

  /* --- NUEVA SECCIÓN DE PAGOS --- */
  .payment-section {
    padding: 25px 20px;
    background-color: #fff;
    max-width: 450px;
  }

  .contenedor-pagos-nuevo {
    border: 1.5px solid #d1d5db;
    border-radius: 12px;
    padding: 20px 15px;
    background-color: white;
  }

  .titulo-pagos-nuevo {
    color: #4b5563;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0 10px;
    display: flex;
    align-items: center;
    gap: 5px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .icono-candado-nuevo {
    width: 14px;
    height: 14px;
    fill: #10b981;
  }

  .iconos-flex-nuevo {
    display: flex;
    justify-content: space-between;
    /* Distribución total */
    align-items: center;
    gap: 10px;
  }

  .metodo-pago-nuevo {
    height: 24px;
    width: auto;
    object-fit: contain;
  }

  .logo-oxxo-nuevo {
    height: 18px;
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
      flex-direction: row;
      justify-content: space-between;
      width: 100%;
    }

    .feature-item {
      flex-direction: column;
      text-align: center;
      gap: 5px;
      flex: 1;
    }

    .feature-item i {
      font-size: 1.5rem;
    }

    .payment-section {
      padding: 0;
      max-width: 100%;
    }

    .separator-hr {
      border-top: 2px solid #f0f0f0;
    }

    .description-section {
      border-bottom: unset;
    }
  }

  @media (min-width: 768px) {}
</style>