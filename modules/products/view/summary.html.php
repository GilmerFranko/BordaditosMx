<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Resumen de la compra
 *
 */
require Core::view('head', 'core');

?>
<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->
<style>
  .checkout-container {
    max-width: 500px;
    margin: 0 auto;
    background-color: white;
    border-radius: 12px;
    padding: 30px 20px;
  }

  /* Order Header */
  .order-header {
    border-bottom: 1px solid #e0e0e0;
  }

  .order-number {
    font-size: 22px;
    font-weight: 600;
    color: #000;
    margin-bottom: 8px;
  }

  .order-number .highlight {
    color: #ff1493;
    font-weight: 700;
  }

  .customer-name {
    font-size: 14px;
    color: #666;
    margin: 0;
  }

  .customer-name strong {
    color: #ff1493;
    font-weight: 700;
  }

  /* Product Showcase */
  .product-showcase {
    padding: 20px 0;
  }

  .product-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
  }

  /* CTA Button */
  .cta-button-container {
    display: flex;
    justify-content: center;
  }

  .cta-button {
    background-color: #1a1a1a;
    color: white;
    border: none;
    padding: 18px 40px;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    text-align: center;
  }

  .cta-button:hover {
    background-color: #333;
    transform: translateY(-2px);
  }

  .cta-button small {
    font-size: 12px;
    font-weight: 500;
  }

  .cta-button .icon {
    width: 20px;
    height: 20px;
  }

  /* Payment Header */
  .payment-header {
    margin-bottom: 30px;
  }

  .payment-icon-wrapper {
    display: inline;
    margin-bottom: 12px;
  }

  .payment-title {
    font-size: 18px;
    font-weight: 700;
    color: #ff1493;
    margin-bottom: 8px;
    letter-spacing: 0.5px;
  }

  .payment-subtitle {
    font-size: 13px;
    color: #666;
    margin: 0;
  }

  /* Payment Methods */
  .payment-methods {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .payment-option {
    background: var(--pink-dark)
      /*linear-gradient(135deg, var(--pink-dark) 0%, #e91e63 100%);*/
    ;
    border-radius: 24px;
    padding: 24px;
    color: white;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .payment-option:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(255, 20, 147, 0.3);
  }

  .payment-option-title {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
    letter-spacing: 0.3px;
  }

  .payment-option-subtitle {
    font-size: 15px;
    font-weight: 600;
    letter-spacing: 1px;
    margin: 0;
    opacity: 0.95;
  }

  /* Card Logos */
  .card-logos {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 12px;
  }

  .card-logo {
    height: 28px;
    width: auto;
    background-color: white;
    padding: 4px 8px;
    border-radius: 6px;
    object-fit: contain;
  }

  /* OXXO Logo */
  .oxxo-logo-container {
    margin-top: 8px;
  }

  .oxxo-logo {
    height: 36px;
    width: auto;
    object-fit: contain;
  }

  /* Transfer Icon */
  .transfer-icon-container {
    margin-top: 8px;
    display: flex;
    justify-content: center;
  }

  /* Responsive Design */
  @media (max-width: 600px) {
    .checkout-container {
      padding: 20px 16px;
    }

    .order-number {
      font-size: 20px;
    }

    .payment-option {
      min-height: 120px;
      padding: 20px 16px;
    }

    .payment-option-title {
      font-size: 16px;
    }

    .card-logo {
      height: 24px;
    }
  }

  .alert-banner.active {
    animation: pulse 2s infinite;
  }

  @keyframes pulse {

    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.05);
    }
  }

  /* Alert Banner */
  .alert-banner {
    background-color: #2c3e50;
    color: white;
    padding: 15px 20px;
    border-radius: 30px;
    text-align: center;
    font-weight: bold;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .alert-icon {
    font-size: 1.5rem;
  }
</style>

<section>
  <div class="checkout-container">
    <!-- Order Header -->
    <div class="order-header text-center py-4">
      <h2 class="order-number">Tu pedido es el <span class="highlight">#<?= isset($order['id']) ? $order['id'] : '---' ?></span></h2>
      <p class="customer-name">A nombre de: <strong><?= isset($order['customer_name']) ? $order['customer_name'] : 'Cliente' ?></strong></p>
    </div>

    <!-- Product Image -->
    <div class="product-showcase text-center mb-4">
      <?php
      $img = '';
      if (!empty($items) && isset($items[0]['variant']['image']))
      {
        $img = $config['products_url'] . '/' . $items[0]['variant']['image'];
      }
      ?>
      <img src="<?= $img ?: $config['static_url'] . '/images/logo/logo2/product.jpg' ?>"
        alt="<?= $items[0]['variant']['color_name'] ?>" class="product-img" width="150">
    </div>

    <!-- Call to Action Button -->
    <!-- Alert Banner -->
    <div class="alert-banner mb-3 active">
      <span class="alert-icon">🚨</span>
      <span class="alert-text" style="text-align: justify;"><span style="font-size: 13px;">Realiza tu pago ahora</span><br>¡ÚLTIMAS PIEZAS DISPONIBLES!</span>
      <span class="alert-icon">✓</span>
    </div>

    <!-- Payment Method Selection Header -->
    <div class="payment-header text-center mb-4">

      <h3 class="payment-title">
        <div class="payment-icon-wrapper">
          <svg width="28" height="28" viewBox="0 0 16 16" fill="#FF1493">
            <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
            <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z" />
          </svg>
        </div>
        SELECCIONA TU FORMA DE PAGO
      </h3>
      <p class="payment-subtitle">Indica tu forma de pago y confirma tu compra</p>
    </div>

    <!-- Payment Methods -->
    <div class="payment-methods">
      <!-- Card Payment -->
      <a href="<?= $config['card_pay_link'] ?>">
        <div class="payment-option">
          <h4 class="payment-option-title">1. PAGO CON TARJETA</h4>
          <p class="payment-option-subtitle">CREDITO Y DEBITO</p>
          <div class="card-logos">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/1280px-Visa_Inc._logo.svg.png" alt="Visa" class="card-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/2560px-MasterCard_Logo.svg.png" alt="Mastercard" class="card-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/4d/Maestro_logo.png" alt="Maestro" class="card-logo">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/American_Express_logo.svg/1200px-American_Express_logo.svg.png" alt="American Express" class="card-logo">
          </div>
        </div>
      </a>

      <!-- OXXO Payment -->
      <a href="https://wa.me/<?= $config['num_phone'] ?>?text=Hola%20deseo%20pagar%20mi%20pedido%20N°1%20con%20OXXO" target="_blank">
        <div class="payment-option">
          <h4 class="payment-option-title">2. DEPOSITO EN OXXO</h4>
          <div class="oxxo-logo-container">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Oxxo_Logo.svg/1200px-Oxxo_Logo.svg.png" alt="OXXO" class="oxxo-logo">
          </div>
        </div>
      </a>

      <!-- Bank Transfer -->
      <a href="https://wa.me/<?= $config['num_phone'] ?>?text=Hola%20deseo%20pagar%20mi%20pedido%20N°1%20con%20Transferencia" target="_blank">
        <div class="payment-option">
          <h4 class="payment-option-title">3. TRANSFERENCIA</h4>
          <div class="transfer-icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16">
              <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485-.62H.5a.498.498 0 0 1-.485-.62l.5-2A.5.5 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89zM3.777 3h8.447L8 1zM2 6v7h1V6zm2 0v7h2.5V6zm3.5 0v7h1V6zm2 0v7H12V6zM13 6v7h1V6zm2-1V4H1v1zm-.39 9H1.39l-.25 1h13.72z" />
            </svg>
          </div>
        </div>
      </a>
    </div>
  </div>
</section>