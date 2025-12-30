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
          <div class="d-flex align-items-center mb-2">
            <svg class="truck-icon me-2" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5 15H25V25H5V15Z" fill="WHITE" />
              <path d="M25 18H30L35 23V25H25V18Z" fill="WHITE" />
              <circle cx="10" cy="28" r="2" fill="WHITE" />
              <circle cx="30" cy="28" r="2" fill="WHITE" />
              <path d="M3 12H5L7 20L5 25" stroke="WHITE" stroke-width="1.5" />
            </svg>
            <h2 class="shipping-title mb-0">ENVIO GRATIS 🇲🇽</h2>
          </div>
          <p class="shipping-date mb-0">Recibes tu pedido el día: <strong>Lunes 08 De Diciembre</strong></p>
        </div>

        <!-- Delivery Options -->
        <div class="delivery-section mb-4">
          <h3 class="delivery-title">Recibe con DHL o Estafeta</h3>
          <input type="hidden" name="shipping_method" id="selected_shipping_method" value="">

          <div class="delivery-logos d-flex gap-4 justify-content-center mt-3">
            <div class="delivery-logo selectable-method" data-method="DHL">
              <div class="dhl-box">DHL</div>
            </div>
            <div class="delivery-logo selectable-method" data-method="Estafeta">
              <div class="estafeta-box">Estafeta</div>
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
            <svg class="whatsapp-icon me-2" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="15" cy="15" r="13" fill="#25D366" />
              <path d="M20 10C19 9 17.5 8.5 16 8.5C12.5 8.5 9.5 11.5 9.5 15C9.5 16.5 10 17.5 10.5 18.5L9.5 22L13 21C14 21.5 15 22 16 22C19.5 22 22.5 19 22.5 15.5C22.5 14 22 12.5 21 11.5L20 10Z" fill="white" />
              <path d="M18.5 17C18.5 17.5 18 18 17.5 18C16 18 14 17 12.5 15.5C11.5 14.5 10.5 12.5 11 11.5C11 11 11.5 10.5 12 10.5C12.5 10.5 12.5 11 12.5 11.5C13 12 13 12.5 13.5 13C13.5 13.5 13.5 13.5 13 14C13 14.5 14 15.5 14.5 16C15 16.5 15.5 16.5 16 16.5C16.5 16.5 16.5 16 17 16C17.5 16 17.5 16.5 18 17C18 17.5 18.5 17.5 18.5 17Z" fill="#25D366" />
            </svg>
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
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
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

  /* Header */
  .cart-icon {
    display: flex;
    justify-content: center;
    animation: slideDown 0.5s ease-out;
  }

  .checkout-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #0056b3;
    margin: 0;
  }

  /* Divider */
  .divider {
    border: 0;
    border-top: 2px solid #e0e0e0;
    margin: 1.5rem 0;
  }

  /* Free Shipping Section */
  .shipping-free-section {
    padding: 1rem;
    background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
    border-radius: 12px;
    color: white;
  }

  .truck-icon {
    flex-shrink: 0;
  }

  .shipping-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
  }

  .shipping-date {
    font-size: 0.95rem;
    padding-left: 48px;
  }

  /* Delivery Section */
  .delivery-section {
    text-align: center;
    padding: 1rem 0;
  }

  .delivery-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0056b3;
  }

  .delivery-logos {
    margin-top: 1rem;
  }

  .delivery-logo {
    padding: 1rem;
  }

  /* Estilo para el método seleccionado */
  .selectable-method {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 4px solid transparent;
    border-radius: 12px;
    padding: 5px;
    /* Espacio para el borde */
  }

  .selectable-method.selected {
    border-color: #ff1493;
    /* Color rosa del tema */
    transform: scale(1.05);
    background: rgba(255, 20, 147, 0.1);
  }

  .selectable-method:hover {
    transform: translateY(-5px);
  }

  .dhl-box {
    background: #ffcc00;
    color: #d40511;
    font-size: 1.5rem;
    font-weight: 900;
    padding: 1.5rem 3rem;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }

  .estafeta-box {
    background: #fff;
    color: #d32f2f;
    font-size: 1.25rem;
    font-weight: 700;
    padding: 1.5rem 2rem;
    border-radius: 8px;
    border: 3px solid #d32f2f;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }

  /* Address and WhatsApp Sections */
  .section-header {
    margin-bottom: 0.5rem;
  }

  .section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ff1493;
  }

  .whatsapp-title {
    color: #25d366;
  }

  .section-subtitle {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.4;
  }

  .home-icon,
  .whatsapp-icon {
    flex-shrink: 0;
  }

  /* Form Fields */
  .address-form,
  .whatsapp-form {
    padding-left: 0;
  }

  .form-field {
    margin-bottom: 1rem;
  }

  .form-label {
    display: block;
    font-size: 1rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 0;
  }

  /* Payment Button */
  .btn-payment {
    background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    padding: 1rem 3rem;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(255, 20, 147, 0.4);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    max-width: 400px;
  }

  .btn-payment:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 20, 147, 0.5);
  }

  .btn-payment:active {
    transform: translateY(0);
  }

  .arrow-icon {
    animation: arrowBounce 1s infinite;
  }

  /* Animations */
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes arrowBounce {

    0%,
    100% {
      transform: translateX(0);
    }

    50% {
      transform: translateX(5px);
    }
  }

  /* Responsive */
  @media (max-width: 576px) {
    .checkout-container {
      padding: 1.5rem;
    }

    .checkout-title {
      font-size: 1.5rem;
    }

    .delivery-logos {
      flex-direction: column;
      gap: 1rem !important;
    }

    .dhl-box,
    .estafeta-box {
      width: 100%;
    }

    .btn-payment {
      font-size: 1.25rem;
      padding: 0.875rem 2rem;
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