<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 * BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista mejorada del listado de pedidos con diseño de tarjetas
 *
 */
require Core::view('head', 'core');
?>

<style>
  #sectionOrders {
    padding: 20px 0;
    background-color: #f9f9f9;
    min-height: 100vh;
  }

  .order-card {
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
    margin-bottom: 20px;
    overflow: hidden;
  }

  .order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
  }

  .order-card .card-content {
    padding: 20px;
  }

  .order-id-badge {
    background: #26a69a;
    color: white;
    padding: 4px 12px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 0.9rem;
  }

  .status-pill {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
  }

  /* Clases dinámicas según tu backend */
  .status-Pending {
    background: #fff3e0;
    color: #ef6c00;
  }

  .status-Paid {
    background: #e3f2fd;
    color: #1565c0;
  }

  .status-Shipped {
    background: #f3e5f5;
    color: #7b1fa2;
  }

  .status-Delivered {
    background: #e8f5e9;
    color: #2e7d32;
  }

  .order-info-row {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    color: #616161;
  }

  .order-info-row i {
    margin-right: 10px;
    font-size: 1.2rem;
    color: #9e9e9e;
  }

  .price-tag {
    font-size: 1.4rem;
    font-weight: bold;
    color: #263238;
  }

  .filter-container {
    background: white;
    padding: 15px 25px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  }

  .wa-link {
    color: #25d366;
    text-decoration: none;
    font-weight: 500;
  }

  .wa-link:hover {
    text-decoration: underline;
  }
</style>

<section id="sectionOrders">
  <div class="container">
    <h3 class="grey-text text-darken-3 font-weight-light">Gestión de Pedidos</h3>

    <!-- Contenedor de Filtros -->
    <div class="filter-container">
      <div class="row" style="margin-bottom: 0;">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="get">
          <div class="input-field col s12 m4 l3">
            <i class="material-icons prefix">filter_list</i>
            <select name="filter_order_status" onchange="this.form.submit()">
              <option value="">Todos los estados</option>
              <option value="Pending" <?php if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] == 'Pending') echo 'selected'; ?>>Pendiente</option>
              <option value="Paid" <?php if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] == 'Paid') echo 'selected'; ?>>Pagado</option>
              <option value="Shipped" <?php if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] == 'Shipped') echo 'selected'; ?>>Enviado</option>
              <option value="Delivered" <?php if (isset($_GET['filter_order_status']) && $_GET['filter_order_status'] == 'Delivered') echo 'selected'; ?>>Entregado</option>
            </select>
            <label>Filtrar por Estado</label>
          </div>
          <!--<div class="input-field col s12 m8 l6">
            <i class="material-icons prefix">search</i>
            <input type="text" id="search_order" placeholder="Nombre del cliente o ID...">
            <label for="search_order">Buscar Pedido</label>
          </div>-->
        </form>
      </div>
    </div>

    <div id="contentOrders" class="row">
      <?php if (!empty($orders['data']) && is_array($orders['data'])) : ?>
        <?php foreach ($orders['data'] as $prod) :
          // Asignación de clase de color para el estado
          $statusClass = "status-" . $prod['order_status'];
        ?>
          <div class="col s12 m6 l4" id="order_<?php echo $prod['id']; ?>">
            <div class="card order-card z-depth-1">
              <div class="card-content">
                <div class="row" style="margin-bottom: 10px;">
                  <div class="col s6">
                    <span class="order-id-badge">#<?php echo $prod['id']; ?></span>
                  </div>
                  <div class="col s6 right-align">
                    <span class="status-pill <?php echo $statusClass; ?>">
                      <?= $class_order_status[$prod['order_status']]['text'] ?>
                    </span>
                  </div>
                </div>

                <span class="card-title grey-text text-darken-4 truncate" style="font-weight: 500; font-size: 1.1rem;">
                  <?php echo htmlspecialchars($prod['customer_name']); ?>
                </span>

                <div class="order-info-row">
                  <i class="material-icons">chat</i>
                  <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $prod['customer_whatsapp']); ?>" target="_blank" class="wa-link">
                    <?php echo htmlspecialchars($prod['customer_whatsapp']); ?>
                  </a>
                </div>

                <div class="order-info-row">
                  <i class="material-icons">local_shipping</i>
                  <span><?php echo htmlspecialchars($prod['shipping_method']); ?></span>
                </div>

                <div class="order-info-row">
                  <i class="material-icons">payment</i>
                  <span><?php echo htmlspecialchars($prod['payment_method']); ?></span>
                </div>

                <div class="row" style="margin-top: 20px; margin-bottom: 0; display: flex; align-items: center;">
                  <div class="col s7">
                    <span class="price-tag">$<?php echo number_format($prod['total_amount'], 2); ?></span>
                  </div>
                  <div class="col s5 right-align">
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'view.order', null, array('order_id' => $prod['id'])); ?>"
                      class="btn-floating waves-effect waves-light teal tooltipped"
                      data-position="top"
                      data-tooltip="Ver Detalle">
                      <i class="material-icons">visibility</i>
                    </a>
                    <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.order', null, array('order_id' => $prod['id'])); ?>"
                      class="btn-floating waves-effect waves-light orange darken-2 tooltipped"
                      data-position="top"
                      data-tooltip="Editar">
                      <i class="material-icons">edit</i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="col s12 center-align">
          <div class="card-panel">
            <i class="material-icons large grey-text">inventory_2</i>
            <h5 class="grey-text">No se encontraron pedidos con estos criterios</h5>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Paginador -->
    <div class="row center-align">
      <div class="col s12">
        <?php if (isset($orders['pages'])) echo $orders['pages']['paginator']; ?>
      </div>
    </div>
  </div>
</section>

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Inicializar componentes de Materialize
    M.FormSelect.init(document.querySelectorAll('select'));
    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
  });
</script>