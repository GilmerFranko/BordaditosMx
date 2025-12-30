<?php defined('BORDAMEX') || exit;

/**
 *=======================================================* BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página para rastrear pedido
 *
 */

require Core::view('head', 'core');

?>
<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<style>
  .container1 {
    width: 100%;
    max-width: 650px;
    margin: 0 auto;
    padding: 20px;
  }

  /* Buscador */
  .tracking-header {
    margin-bottom: 30px;
  }

  .tracking-header h2 {
    color: var(--pink-dark);
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 15px;
    text-align: center;
  }

  .search-order-container {
    position: relative;
    display: flex;
    background-color: #f0f0f0;
    border-radius: 30px;
    padding: 5px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
  }

  .search-order-container:focus-within {
    border-color: var(--pink-primary);
    background-color: white;
    box-shadow: 0 0 10px rgba(255, 102, 194, 0.2);
  }

  .search-order-container input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 10px 20px;
    outline: none;
    font-size: 16px;
  }

  .btn-search {
    background-color: var(--pink-primary);
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
  }

  .btn-search:hover {
    background-color: var(--pink-dark);
  }

  /* Tarjeta de Estatus (Estilo Oscuro) */
  .status-card {
    background-color: #2d2d2d;
    border-radius: 33px;
    padding: 25px;
    color: white;
    border: 4px solid white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }

  .order-meta {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 30px;
  }

  .order-id {
    font-weight: bold;
    font-size: 1.1rem;
  }

  .order-date {
    font-size: 12px;
    color: var(--pink-light);
    margin-top: 4px;
  }

  .status-badge {
    background-color: var(--pink-dark);
    padding: 6px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
  }

  /* Stepper Visual Administrativo */
  .stepper {
    display: flex;
    justify-content: space-around;
    position: relative;
    margin-bottom: 10px;
  }

  .stepper::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 10%;
    right: 10%;
    height: 3px;
    background-color: #444;
    z-index: 1;
  }

  .step {
    position: relative;
    z-index: 2;
    text-align: center;
    width: 25%;
  }

  .step-icon {
    width: 40px;
    height: 40px;
    background-color: #3d3d3d;
    border: 3px solid #444;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    color: #666;
    transition: all 0.3s ease;
  }

  .step-label {
    font-size: 10px;
    color: #888;
    font-weight: bold;
  }

  /* Estados Activos */
  .step.completed .step-icon {
    background-color: var(--pink-primary);
    border-color: var(--pink-primary);
    color: white;
  }

  .step.active .step-icon {
    background-color: white;
    border-color: var(--pink-dark);
    color: var(--pink-dark);
    box-shadow: 0 0 15px var(--pink-primary);
    transform: scale(1.1);
  }

  .step.active .step-label {
    color: white;
  }

  /* Detalles del Pedido */
  .details-section {
    padding: 0 10px;
  }

  .details-title {
    color: #333;
    font-weight: bold;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1rem;
  }

  .info-box {
    background-color: #f8f9fa;
    border-radius: 20px;
    padding: 20px;
    border: 1px solid #eee;
  }

  .info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px dashed #ddd;
  }

  .info-row:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
  }

  .info-label {
    font-size: 13px;
    color: #666;
    font-weight: 500;
  }

  .info-value {
    font-size: 13px;
    color: #000;
    font-weight: bold;
    text-align: right;
  }

  .product-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 15px;
    padding: 10px;
    background: white;
    border-radius: 12px;
    border: 1px solid #eee;
  }

  .product-img {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    background: #f0f0f0;
  }

  /* Colores dinámicos del backend para el detalle */
  .orange-text {
    color: #ff9800;
  }

  .blue-text {
    color: #2196f3;
  }

  .purple-text {
    color: #9c27b0;
  }

  .green-text {
    color: #4caf50;
  }

  @media (max-width: 500px) {
    .search-order-container {
      flex-direction: column;
      background: transparent;
      gap: 10px;
      padding: 0;
    }

    .search-order-container input {
      background: #f0f0f0;
      border-radius: 25px;
      width: 100%;
    }

    .btn-search {
      width: 100%;
    }

    .stepper::before {
      top: 17px;
    }

    .info-row {
      flex-direction: column;
      gap: 2px;
    }

    .info-value {
      text-align: left;
    }
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="container1">
  <!-- Buscador Siempre Visible -->
  <div class="tracking-header">
    <h2>ESTADO DE MI PEDIDO</h2>
    <form action="<?= gLink('rastrear') ?>" method="GET" class="search-order-container">
      <input type="text" name="order_id" placeholder="Número de pedido (ej: 7721)..." value="<?= isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : '' ?>" required>
      <button type="submit" class="btn-search">CONSULTAR</button>
    </form>
  </div>

  <?php if (isset($order) && $order): ?>
    <!-- Tarjeta de Estado Principal -->
    <div class="status-card">
      <div class="order-meta">
        <div>
          <div class="order-id">PEDIDO #<?= $order['id'] ?></div>
          <div class="order-date">Realizado el <?= $order['created_at'] ?></div>
        </div>
        <div class="status-badge"><?= $class_order_status[$currentStatus]['text'] ?></div>
      </div>

      <!-- Stepper Dinámico (4 pasos según backend) -->
      <div class="stepper">
        <div class="step <?= $cos['Pending'] ?>">
          <div class="step-icon"><i class="fa fa-clock"></i></div>
          <div class="step-label">PENDIENTE</div>
        </div>
        <div class="step <?= $cos['Paid'] ?>">
          <div class="step-icon"><i class="fas fa-receipt"></i></div>
          <div class="step-label">PAGADO</div>
        </div>
        <div class="step <?= $cos['Shipped'] ?>">
          <div class="step-icon"><i class="fas fa-paper-plane"></i></div>
          <div class="step-label">ENVIADO</div>
        </div>
      </div>
    </div>

    <!-- Información del Pedido -->
    <div class="details-section">
      <div class="details-title">
        <i class="fas fa-info-circle" style="color: var(--pink-dark);"></i>
        DETALLES DEL PEDIDO
      </div>

      <div class="info-box">
        <div class="info-row">
          <span class="info-label">Estatus Administrativo:</span>
          <span class="info-value <?= $class_order_status[$currentStatus]['class'] ?>">
            <?= $class_order_status[$currentStatus]['text'] ?>
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Método de pago:</span>
          <span class="info-value"><?= $arr_methot_payment[$order['payment_method']] ?? $order['payment_method'] ?></span>
        </div>
        <div class="info-row">
          <span class="info-label">Total del pedido:</span>
          <span class="info-value">$<?= number_format($order['total_amount'], 2) ?></span>
        </div>

        <?php if (!empty($items)): ?>
          <p class="info-label" style="margin-top: 15px; margin-bottom: 5px; font-weight: bold;">Artículos en este pedido:</p>
          <?php foreach ($items as $item): ?>
            <div class="product-item">
              <img src="<?= $item['image_url'] ? $config['products_url'] . $item['image_url'] : 'https://via.placeholder.com/60' ?>" alt="<?= $item['name'] ?>" class="product-img">
              <div style="flex: 1;">
                <div class="info-value" style="text-align: left;"><?= $item['name'] ?></div>
                <div class="info-label">Cantidad: <?= $item['quantity'] ?> | Precio: $<?= isset($item['sale_price']) ? number_format($item['sale_price'], 2) : number_format($item['original_price'], 2) ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  <?php elseif (isset($_GET['order_id'])): ?>
    <!-- Mensaje si no se encuentra el pedido (opcional, el backend ya redirecciona pero por seguridad) -->
    <p style="text-align: center; color: #666; margin-top: 20px;">El c&oacute;digo que indicaste no es v&aacute;ido, cons&uacute;ltalo con tu asesor v&iacutea WhatsApp <span style="font-size: 1.5em; color: #e25555;">&hearts;</span>.</p>
  <?php endif; ?>
</div>

<?php require Core::view('footer', 'core'); ?>