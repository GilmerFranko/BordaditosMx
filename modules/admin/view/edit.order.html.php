<?php defined('BORDAMEX') || exit;

/**
 * ========================================================
 *  VCO Project
 *-------------------------------------------------------
 * @autor Gilmer Franco <gil2017.com@gmail.com>
 * ========================================================
 *
 * @Description Vista para editar un pedido
 *
 *
 */

require Core::view('head', 'core');

?>
<style>
  .edit-header {
    margin-top: 2rem;
    margin-bottom: 2rem;
  }

  .card-form {
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 20px;
  }

  .section-title {
    font-size: 1.3rem;
    font-weight: bold;
    color: #26a69a;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #e0e0e0;
    padding-bottom: 10px;
  }

  .section-title i {
    margin-right: 10px;
  }

  .product-item {
    background: #fafafa;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    position: relative;
  }

  .remove-item {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #e53935;
    cursor: pointer;
  }

  .total-section {
    background: #e0f2f1;
    padding: 20px;
    border-radius: 8px;
    text-align: right;
    margin-top: 20px;
  }

  .input-field small {
    color: #757575;
  }
</style>
<section>
  <div class="container">
    <div class="row edit-header">
      <div class="col s12">
        <nav class="clean z-depth-0" style="background: transparent;">
          <div class="nav-wrapper">
            <div class="col s12">
              <a href="<?= gLink('admin/view.orders') ?>" class="breadcrumb grey-text">Pedidos</a>
              <a href="#!" class="breadcrumb grey-text text-darken-3">Editar #10254</a>
            </div>
          </div>
        </nav>
        <h4 class="grey-text text-darken-3">Modificar Pedido</h4>
      </div>
    </div>

    <form id="editOrderForm" action="<?= gLink('admin/edit.order', ['action' => 'edit_order', 'order_id' => $order['id']]) ?>" method="POST">
      <div class="row">
        <input type="text" name="item_order_id" value="<?= $items[0]['item_id'] ?>" hidden>
        <!-- Columna Izquierda: Datos del Cliente y Envío -->
        <div class=" col s12 l6">
          <div class="card card-form">
            <div class="section-title">
              <i class="material-icons">person</i> Información del Cliente
            </div>

            <div class="input-field">
              <i class="material-icons prefix">account_circle</i>
              <input id="customer_name" name="customer_name" type="text" value="<?= $order['customer_name'] ?>" class="validate" required>
              <label for="customer_name">Nombre del Cliente</label>
            </div>

            <div class="input-field">
              <i class="material-icons prefix">phone</i>
              <input id="customer_whatsapp" name="customer_whatsapp" type="text" value="<?= $order['customer_whatsapp'] ?>" class="validate" required>
              <label for="customer_whatsapp">WhatsApp (Sin espacios)</label>
            </div>

            <div class="section-title" style="margin-top:40px">
              <i class="material-icons">local_shipping</i> Detalles de Entrega
            </div>

            <div class="input-field">
              <select id="shipping_method" name="shipping_method">
                <option value="DHL" <?= ($order['shipping_method'] == 'DHL') ? 'selected' : ''  ?>>DHL</option>
                <option value="Estafeta" <?= ($order['shipping_method'] == 'Estafeta') ? 'selected' : ''  ?>>Estafeta</option>
              </select>
              <label>Método de Envío</label>
            </div>

            <div class="input-field">
              <textarea id="shipping_address" name="shipping_address" value="<?= $order['shipping_address'] ?>" class="materialize-textarea"><?= $order['shipping_address'] ?></textarea>
              <label for="shipping_address">Dirección Completa</label>
            </div>

            <div class="row">
              <div class="input-field col s6">
                <input id="shipping_city" name="shipping_city" type="text" value="<?= $order['shipping_city'] ?>">
                <label for="shipping_city">Ciudad</label>
              </div>
              <div class="input-field col s6">
                <input id="shipping_state" name="shipping_state" type="text" value="<?= $order['shipping_state'] ?>">
                <label for="shipping_state">Estado</label>
              </div>
            </div>

            <div class="input-field">
              <i class="material-icons prefix">event</i>
              <input type="text" name="estimated_delivery" class="datepicker" id="estimated_delivery" value="<?= $order['estimated_delivery'] ?>">
              <label for="estimated_delivery">Fecha Estimada de Entrega</label>
            </div>
          </div>
        </div>

        <!-- Columna Derecha: Estado y Productos -->
        <div class="col s12 l6">
          <div class="card card-form">
            <div class="section-title">
              <i class="material-icons">info</i> Estado y Pago
            </div>

            <div class="row">
              <div class="input-field col s12">
                <select id="order_status" name="order_status">
                  <option value="Pending" <?= ($order['order_status'] == 'Pending') ? 'selected' : ''  ?>>Pendiente</option>
                  <option value="Paid" <?= ($order['order_status'] == 'Paid') ? 'selected' : ''  ?>>Pagado</option>
                  <option value="Shipped" <?= ($order['order_status'] == 'Shipped') ? 'selected' : ''  ?>>Enviado</option>
                  <option value="Delivered" <?= ($order['order_status'] == 'Delivered') ? 'selected' : ''  ?>>Entregado</option>
                </select>
                <label>Estado del Pedido</label>
              </div>

              <div class="input-field col s12">
                <select id="payment_method" name="payment_method">
                  <option value="Card" <?= ($order['payment_method'] == 'Card') ? 'selected' : ''  ?>>Tarjeta</option>
                  <option value="OXXO" <?= ($order['payment_method'] == 'OXXO') ? 'selected' : ''  ?>>OXXO</option>
                  <option value="Transfer" <?= ($order['payment_method'] == 'Transfer') ? 'selected' : ''  ?>>Transferencia</option>
                </select>
                <label>Método de Pago</label>
              </div>
            </div>

            <div class="section-title" style="margin-top:20px">
              <i class="material-icons">list</i> Productos en el Pedido
            </div>

            <div id="productsList">
              <!-- Item 1: Hoodie (Con tallas) -->
              <div class="product-item">
                <div class="row" style="margin-bottom:0">
                  <div class="input-field col s8">
                    <input type="text" value="Hoodie Duo Premium" placeholder="Producto" disabled>
                    <small>Variante: Black-Gold</small>
                  </div>
                  <div class="input-field col s4">
                    <input type="number" value="1" disabled>
                    <label>Cant.</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s6">
                    <input type="text" name="size_hoodie_1" value="<?= $items[0]['size_hoodie_1'] ?>" placeholder="Talla 1">
                    <label>Talla Hoodie 1</label>
                  </div>
                  <div class="input-field col s6">
                    <input type="text" name="size_hoodie_2" value="<?= $items[0]['size_hoodie_2'] ?>" placeholder="Talla 2">
                    <label>Talla Hoodie 2</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="total-section">
              <span class="grey-text">Total del Pedido:</span>
              <h4 class="teal-text text-darken-2" style="margin:5px 0">$<?= $order['total_amount'] ?></h4>
            </div>
          </div>
        </div>
      </div>

      <!-- Botones Flotantes / Acción -->
      <div class="row">
        <div class="col s12 center-align" style="margin-bottom: 50px;">
          <a href="order_viewer.html" class="btn-large white black-text waves-effect">Cancelar</a>
          <button type="submit" class="btn-large teal waves-effect waves-light">
            <i class="material-icons left">save</i> Guardar Cambios
          </button>
        </div>
      </div>
    </form>
  </div>
</section>
<!-- Materialize JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Selects
    var selects = document.querySelectorAll('select');
    M.FormSelect.init(selects);

    // Inicializar Datepicker
    var datepicker = document.querySelectorAll('.datepicker');
    M.Datepicker.init(datepicker, {
      format: 'yyyy-mm-dd',
      autoClose: true,
      i18n: {
        cancel: 'Cancelar',
        done: 'Ok',
        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
        weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
      }
    });
  });
</script>