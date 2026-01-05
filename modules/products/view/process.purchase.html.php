<?php defined('BORDAMEX') || exit;

/**
 *=======================================================* BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página de un producto
 *
 */

$page['name'] = 'Proceso de compra - ' . $product['name'];

require Core::view('head', 'core');

?>


<section class="first-section">
  <div class="container py-4">
    <form action="<?= gLink('products/process.purchase', ['action' => 'process_purchase', 'product_id' => $product['id'], 'variant_id' => $variant_id, 'size_sweater_1' => $size_sweater_1, 'size_sweater_2' => $size_sweater_2]) ?>" method="POST">
      <div class="checkout-container">
        <!-- Header -->
        <div class="text-center mb-4">
          <div class="cart-icon mb-3">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="40" cy="40" r="38" stroke="#0056b3" stroke-width="2" fill="white" />
              <path d="M30 25L25 35V55C25 56.1 25.9 57 27 57H53C54.1 57 55 56.1 55 55V35L50 25H30Z" stroke="#0056b3" stroke-width="2" fill="none" />
              <path d="M25 35H55" stroke="#0056b3" stroke-width="2" />
              <path d="M35 40C35 42.8 37.2 45 40 45C42.8 45 45 42.8 45 40" stroke="#0056b3" stroke-width="2" fill="none" />
            </svg>
          </div>
          <h1 class="checkout-title">Realizando tu compra..</h1>
        </div>

        <hr class="divider">

        <!-- Free Shipping Section -->
        <div class="shipping-free-section mb-4">
          <div class="d-flex align-items-center mb-2  ">
            🚚
            &nbsp;
            <h2 class="shipping-title mb-0">ENV&Iacute;O GRATIS <img src="https://cdn-icons-png.flaticon.com/512/5344/5344530.png" width="24" alt="México"></h2>
          </div>
          <p class="shipping-date mb-0">Recibes tu pedido el día: <strong><?= getFiveDaysLater() ?></strong></p>
        </div>

        <!-- Delivery Options -->
        <div class="delivery-section mb-4">
          <h3 class="delivery-title">Selecciona tu paqueteria preferida</h3>
          <input type="hidden" name="shipping_method" id="selected_shipping_method" value="">

          <div class="delivery-logos d-flex gap-4 justify-content-center mt-3">
            <div class="delivery-logo selectable-method flex-fill" data-method="DHL">
              <div class="shipping-box">
                <img src="<?= $config['images_url'] . '/dhl.png' ?>" alt="DHL">
                <span class="delivery-arrival-text">Recibe el: <?= getFiveDaysLater(5) ?></span>
              </div>
            </div>
            <div class="delivery-logo selectable-method flex-fill" data-method="Estafeta">
              <div class="shipping-box">
                <img src="<?= $config['images_url'] . '/estafeta.png' ?>" alt="Estafeta">
                <span class="delivery-arrival-text">Recibe el: <?= getFiveDaysLater(7) ?></span>
              </div>
            </div>
          </div>
          <small id="shipping-error" style="color: red; display: none;">Por favor, selecciona un método de envío</small>
        </div>

        <hr class="divider">

        <!-- Shipping Address Section -->
        <div class="address-section mb-4">
          <div class="section-header d-flex align-items-center mb-3">
            <svg class="home-icon me-2" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 5L5 13V25H11V19H19V25H25V13L15 5Z" fill="#FF1493" stroke="#FF1493" stroke-width="2" />
            </svg>
            <h2 class="section-title mb-0">DIRECCION DE ENVIO</h2>
          </div>
          <p class="section-subtitle mb-3">Indica tu direccion donde recibiras tus sudaderas</p>

          <form class="address-form">
            <!-- Hidden inputs -->
            <input type="text" name="product_id" value="<?= $product['id'] ?>" hidden>
            <input type="text" name="variant_id" value="<?= $variant_id ?>" hidden>
            <input type="text" name="size_sweater_1" value="<?= $size_sweater_1 ?>" hidden>
            <input type="date" name="estimated_delivery" value="<?= date('Y-m-d', strtotime('+7 days')) ?>" hidden>
            <?php if (!empty($size_sweater_2)): ?>
              <input type="text" name="size_sweater_2" value="<?= $size_sweater_2 ?>" hidden>
            <?php endif; ?>

            <div class="form-field mb-3 d-flex align-items-center">
              <label class="form-label">Nombre</label>
              <input type="text" name="customer_name" id="" class="form-control mx-3" style="flex: 1;">
            </div>
            <div class="form-field mb-3 d-flex align-items-center">
              <label class="form-label">Direccion completa</label>
              <input type="text" name="shipping_address" id="" class="form-control mx-3" style="flex: 1;">
            </div>
            <div class="form-field mb-3 d-flex align-items-center">
              <label class="form-label">Estado</label>
              <input type="text" name="shipping_state" id="" class="form-control mx-3" style="flex: 1;">
            </div>
            <div class="form-field mb-3 d-flex align-items-center">
              <label class="form-label">Ciudad</label>
              <input type="text" name="shipping_city" id="" class="form-control mx-3" style="flex: 1;">
            </div>
          </form>
        </div>

        <hr class="divider">

        <!-- WhatsApp Contact Section -->
        <div class="whatsapp-section mb-4">
          <div class="section-header d-flex align-items-center mb-3">
            <img src="https://img.freepik.com/vector-premium/icono-logotipo-whatsapp-aplicacion-redes-sociales-aplicacion-red-marca-editorial-popular-ilustracion-vectorial_913857-391.jpg?semt=ais_hybrid&w=740&q=80" alt="logo whatsapp" width="64">
            <h2 class="section-title whatsapp-title mb-0">WHATSAPP DE CONTACTO</h2>
          </div>
          <p class="section-subtitle mb-3">Escribe tu WhatsApp donde un asesor te enviara toda la informacion de tu compra</p>

          <div class="form-field d-flex align-items-center">
            <label class="form-label">Numero de WhatsApp</label>
            <input type="text" name="customer_whatsapp" id="" class="form-control mx-3" style="flex: 1;">
          </div>
        </div>

        <hr class="divider">

        <!-- Detalles de compra -->
        <?php require Core::view('purchase.details', 'products'); ?>

        <!-- Payment Button -->
        <div class="text-center mt-4">
          <button class="btn-payment" onclick="handlePayment()">
            IR A PAGOS
            <svg class="arrow-icon ms-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" fill="white" />
              <path d="M10 8L14 12L10 16" stroke="#FF1493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </div>
      </div>
    </form>
  </div>
</section>

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background-color: #f5f5f5;
    color: #333;
  }

  .checkout-container {
    max-width: 500px;
    margin: 0 auto;
    background: white;
    padding: 2rem;
    border-radius: 8px;
  }

  .checkout-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0056b3;
  }

  .divider {
    border: 0;
    border-top: 2px solid #e0e0e0;
    margin: 1.5rem 0;
  }

  /* Envío Gratis Box */
  .shipping-free-section {
    padding: 1rem;
    background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
    border-radius: 12px;
    color: white;
  }

  .shipping-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
  }

  .shipping-date {
    font-size: 0.95rem;
  }

  /* Paqueterías Responsivas */
  .delivery-logos {
    display: flex !important;
    flex-wrap: nowrap !important;
  }

  .delivery-logo {
    flex: 1;
    min-width: 0;
    padding: 5px;
  }

  .shipping-box {
    background: #fff;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
  }

  .shipping-box img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    margin-bottom: 8px;
    border-radius: 4px;
  }

  .delivery-arrival-text {
    font-size: 0.75rem;
    color: #333;
    font-weight: 600;
    line-height: 1.2;
  }

  /* Selección de Paquetería */
  .selectable-method {
    cursor: pointer;
  }

  .selectable-method.selected .shipping-box {
    border-color: #ff1493;
    background: rgba(255, 20, 147, 0.05);
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(255, 20, 147, 0.2);
  }

  /* Formulario */
  .section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ff1493;
  }

  .whatsapp-title {
    color: #02c502;
  }

  .form-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #444;
  }

  /* Botón Pago */
  .btn-payment {
    background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
    color: white;
    font-size: 1.3rem;
    font-weight: 700;
    padding: 1rem 2rem;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(255, 20, 147, 0.3);
  }

  @media (max-width: 576px) {
    .checkout-container {
      padding: 1rem;
    }

    .delivery-arrival-text {
      font-size: 0.65rem;
    }

    .shipping-box {
      padding: 0 0 8px 0;
    }
  }
</style>

<script>
  $(document).ready(function() {
    // Manejar la selección del método
    $('.selectable-method').on('click', function() {
      // Quitar clase seleccionada de otros y poner al actual
      $('.selectable-method').removeClass('selected');
      $(this).addClass('selected');

      // Guardar el valor en el input oculto
      var method = $(this).data('method');
      $('#selected_shipping_method').val(method);

      // Ocultar error si existía
      $('#shipping-error').fadeOut();
    });
  });

  // Función que se llama al dar click en el botón "IR A PAGOS"
  function handlePayment() {
    event.preventDefault(); // Detener el envío automático

    var shippingMethod = $('#selected_shipping_method').val();
    var form = $('form')[0]; // Obtener el formulario principal

    // Validación básica de campos requeridos y método de envío
    if (!shippingMethod) {
      $('#shipping-error').fadeIn();
      $('html, body').animate({
        scrollTop: $(".delivery-section").offset().top - 100
      }, 500);
      return false;
    }

    // Si todo está bien, enviar el formulario
    form.submit();
  }
</script>