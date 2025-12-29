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
  .summary-order-id {
    font-size: 36px;
    font-weight: 700;
  }

  .summary-highlight {
    color: #ff1aa3;
  }

  .pay-option {
    background: #ff1aa3;
    color: #fff;
    border-radius: 14px;
    padding: 22px;
    margin-bottom: 18px;
  }

  .pay-option .title {
    font-size: 22px;
    font-weight: 700;
  }

  .pay-option img {
    max-width: 140px;
  }

  .cta-badge {
    background: #2b2b2b;
    color: #fff;
    padding: 12px 18px;
    border-radius: 28px;
    display: inline-block;
  }

  .product-thumb {
    max-width: 160px;
    display: block;
    margin: 0 auto 12px;
  }
</style>

<div class="container mt-4">
  <div class="text-center mb-3">
    <div class="summary-order-id">Tu pedido es el <span class="summary-highlight">#<?= isset($order['id']) ? $order['id'] : '---' ?></span></div>
    <div>A nombre de: <strong class="summary-highlight"><?= isset($order['customer_name']) ? $order['customer_name'] : 'Cliente' ?></strong></div>
  </div>

  <div class="text-center mb-3">
    <?php
    $img = '';
    if (!empty($items) && isset($items[0]['variant']['image']))
    {
      $img = $config['products_url'] . '/' . $items[0]['variant']['image'];
    }
    ?>
    <img src="<?= $img ?: $config['static_url'] . '/images/logo/logo2/product.jpg' ?>" alt="Producto" class="product-thumb img-fluid">
  </div>

  <div class="text-center mb-4">
    <span class="cta-badge"><i class="material-icons">alarm</i> Realiza tu pago ahora</span>
    <div class="mt-2 text-dark">¡ULTIMAS PIEZAS DISPONIBLES!</div>
  </div>

  <h5 class="text-center summary-highlight">SELECCIONA TU FORMA DE PAGO</h5>
  <p class="text-center text-muted">Indica tu forma de pago y confirma tu compra</p>

  <div class="row">
    <div class="col-12">
      <div class="pay-option">
        <div class="title">1. PAGO CON TARJETA <small class="d-block">CREDITO Y DEBITO</small></div>
        <div class="text-center mt-3"><img src="<?= $config['static_url'] ?>/images/payment_cards.png" alt="Tarjetas"></div>
      </div>
    </div>
    <div class="col-12">
      <div class="pay-option">
        <div class="title">2. DEPOSITO EN OXXO</div>
        <div class="text-center mt-3"><img src="<?= $config['static_url'] ?>/images/oxxo.png" alt="OXXO"></div>
      </div>
    </div>
    <div class="col-12">
      <div class="pay-option">
        <div class="title">3. TRANSFERENCIA</div>
        <div class="text-center mt-3"><img src="<?= $config['static_url'] ?>/images/transfer.png" alt="Transferencia"></div>
      </div>
    </div>
  </div>
</div>