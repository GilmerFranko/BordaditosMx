<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de un pedido
 *
 */
$page['name'] = 'Pedido #' . $order['id'];
require Core::view('head', 'core');


?>

<style>
  :root {
    --primary-color: #26a69a;
    --status-pending: #ffa000;
    --status-paid: #1e88e5;
    --status-shipped: #8e24aa;
    --status-delivered: #43a047;
  }

  .order-header {
    margin-top: 2rem;
    margin-bottom: 2rem;
  }

  .status-badge {
    padding: 5px 15px;
    border-radius: 20px;
    color: white;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.8rem;
  }

  .status-Pending {
    background-color: var(--status-pending);
  }

  .status-Paid {
    background-color: var(--status-paid);
  }

  .status-Shipped {
    background-color: var(--status-shipped);
  }

  .status-Delivered {
    background-color: var(--status-delivered);
  }

  .info-card {
    border-radius: 8px;
    padding: 20px;
    height: 100%;
  }

  .section-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #444;
    border-bottom: 2px solid #e0e0e0;
    padding-bottom: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
  }

  .section-title i {
    margin-right: 10px;
  }

  .item-row:hover {
    background-color: #fafafa;
  }

  .variant-tag {
    background: #e0f2f1;
    color: #00695c;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.85rem;
    margin-right: 5px;
  }

  .whatsapp-link {
    color: #25d366;
    display: flex;
    align-items: center;
    font-weight: bold;
  }

  /* Order Stepper Visual */
  .order-stepper {
    display: flex;
    justify-content: space-between;
    margin: 30px 0;
    position: relative;
  }

  .order-stepper::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: #e0e0e0;
    z-index: 1;
  }

  .step {
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    transition: all 0.3s ease;
  }

  .step.active {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: scale(1.2);
    box-shadow: 0 0 10px rgba(38, 166, 154, 0.3);
  }

  .step.completed {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
  }

  .step-label {
    position: absolute;
    top: 45px;
    font-size: 0.75rem;
    font-weight: bold;
    text-align: center;
    width: 80px;
    left: 50%;
    transform: translateX(-50%);
  }

  .step-container {
    position: relative;
  }
</style>
<section id="sectionOrder">
  <div class="container">
    <div class="row order-header">
      <div class="col s12 m8">
        <h4 class="grey-text text-darken-3">Pedido #<?php echo $order['id']; ?></h4>
        <p class="grey-text">Realizado el: <?php echo date('d/m/Y', strtotime($order['created_at'])); ?> a las <?php echo $order['created_at']; ?></p>
      </div>
      <div class="col s12 m4 right-align">
        <span class="status-badge status-Paid"><?php echo $class_order_status[$order['order_status']]['text']; ?></span>
        <!--<div style="margin-top: 15px;">
          <a href="javascript:window.print()" class="btn-flat waves-effect"><i class="material-icons left">print</i>Imprimir</a>
        </div>-->
      </div>
    </div>

    <!-- Seguimiento Visual -->
    <div class="row">
      <div class="col s12">
        <div class="card-panel">
          <div class="order-stepper">
            <div class="step-container">
              <div class="step <?= $cos['Pending'] ?>"><i class="material-icons">receipt</i></div>
              <div class="step-label">Pendiente</div>
            </div>
            <div class="step-container">
              <div class="step <?= $cos['Paid'] ?>"><i class="material-icons">payment</i></div>
              <div class="step-label">Pagado</div>
            </div>
            <div class="step-container">
              <div class="step <?= $cos['Shipped'] ?>"><i class="material-icons">local_shipping</i></div>
              <div class="step-label">Enviado</div>
            </div>
            <div class="step-container">
              <div class="step <?= $cos['Delivered'] ?>"><i class="material-icons">check_circle</i></div>
              <div class="step-label">Entregado</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Información del Cliente -->
      <div class="col s12 l4">
        <div class="card info-card">
          <div class="section-title">
            <i class="material-icons">person</i> Cliente
          </div>
          <p><strong>Nombre:</strong> <?= $order['customer_name'] ?></p>
          <p class="whatsapp-link">
            <i class="material-icons tiny">chat</i> &nbsp; <?= $order['customer_whatsapp'] ?>
          </p>

          <div class="section-title" style="margin-top:30px">
            <i class="material-icons">location_on</i> Envío
          </div>
          <p><strong>Método:</strong> <?= $order['shipping_method'] ?></p>
          <p><strong>Dirección:</strong> <?= $order['shipping_address'] ?></p>
          <p><strong>Ciudad:</strong> <?= $order['shipping_city'] ?></p>
          <p><strong>Estado:</strong> <?= $order['shipping_state'] ?></p>
          <p><strong>Entrega Estimada:</strong> <?= $order['estimated_delivery'] ?></p>
        </div>
      </div>

      <!-- Tabla de Productos -->
      <div class="col s12 l8">
        <div class="card info-card">
          <div class="section-title">
            <i class="material-icons">shopping_basket</i> Artículos del Pedido
          </div>
          <table class="highlight responsive-table">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Variante/Tallas</th>
                <th class="center-align">Cant.</th>
                <th class="right-align">Precio</th>
                <th class="right-align">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr class="item-row">
                  <td>
                    <strong><?= $item['name'] ?></strong><br>
                    <small class="grey-text">ID: <?= $item['id'] ?></small>
                  </td>
                  <td>
                    <span class="variant-tag"><?= $item['color_name'] ?></span><br>
                    <span>T1: <?= $item['size_hoodie_1'] ?> | T2: <?= $item['size_hoodie_2'] ?></span>
                  </td>
                  <td class="center-align"><?= $item['quantity'] ?></td>
                  <td class="right-align">$<?= number_format($item['price_at_purchase'], 2, '.', ',') ?></td>
                  <td class="right-align"><strong>$<?= number_format($item['subtotal'], 2, '.', ',') ?></strong></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td class="right-align"><strong>TOTAL:</strong></td>
                <td class="right-align">
                  <h5 class="teal-text text-darken-2" style="margin:0">$<?= number_format(array_sum(array_column($items, 'subtotal')), 2, '.', ',') ?></h5>
                </td>
              </tr>
            </tfoot>
          </table>
          <div style="margin-top: 30px; border-top: 1px dashed #ccc; padding-top: 20px;">
            <p><strong>Método de Pago:</strong> <span class="blue-grey-text text-darken-2"><?= @$arr_methot_payment[$order['payment_method']] ?></span></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Botones de Acción -->
    <div class="row">
      <div class="col s12 right-align">
        <a href="<?= gLink('admin/view.orders') ?>" class="btn grey waves-effect waves-light">Regresar</a>
        <a href="<?= gLink('admin/edit.order', ['order_id' => $order['id']]) ?>" class="btn teal waves-effect waves-light">Editar Pedido</a>
        <!--<button class="btn blue waves-effect waves-light"><i class="material-icons left">email</i>Enviar Factura</button>-->
      </div>
    </div>
  </div>
</section>