<?php defined('BORDAMEX') || exit;

/**
 *=======================================================

BORDAMEX Project
 *-------------------------------------------------------

@author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================

@Description Vista mejorada del listado de pedidos con filtros combinados

 */
require Core::view('head', 'core');

// Valores de filtros actuales
$current_status = isset($_GET['filter_order_status']) ? $_GET['filter_order_status'] : '';
$current_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

// Helper para fechas
$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime('-1 day'));
?>

<style>
  #sectionOrders {
    background-color: #f9f9f9;
    min-height: 100vh;
  }

  /* Contenedor de Filtros */
  .filter-container {
    background: white;
    padding: 20px 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  .filter-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-end;
  }

  .filter-item {
    flex: 1;
    min-width: 200px;
  }

  /* Botones rápidos de fecha */
  .date-quick-picks {
    display: flex;
    gap: 8px;
    margin-bottom: 8px;
  }

  .btn-quick {
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.75rem;
    background: #f0f0f0;
    color: #616161;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 0.2s;
    display: inline-block;
  }

  .btn-quick:hover,
  .btn-quick.active {
    background: #26a69a;
    color: #fff;
  }

  /* Tarjetas de Pedido */
  .order-card {
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid #e0e0e0;
    margin-bottom: 20px;
    overflow: hidden;
    background: white;
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

  .wa-link {
    color: #25d366;
    text-decoration: none;
    font-weight: 500;
  }

  .wa-link:hover {
    text-decoration: underline;
  }

  /* Ajuste para input date */
  .datepicker-custom {
    border: 1px solid #ddd !important;
    border-radius: 8px !important;
    padding: 0 10px !important;
    height: 40px !important;
    box-sizing: border-box !important;
    display: block;
    width: 100%;
    margin: 0 !important;
  }
</style>

<section id="sectionOrders">
  <div class="container-fluid">
    <div class="row" style="margin-bottom: 10px;">
      <div class="col s12 m6">
        <h3 class="grey-text text-darken-3 font-weight-light" style="margin: 0;">Gestión de Pedidos</h3>
      </div>
      <div class="col s12 m6 right-align">
        <a href="?" class="btn-flat grey-text"><i class="material-icons left">refresh</i> Restablecer todo</a>
      </div>
    </div>

    <!-- Contenedor de Filtros -->
    <div class="filter-container">
      <form action="" method="get" id="filterForm">
        <div class="filter-group">

          <!-- Filtro por Estado -->
          <div class="filter-item">
            <label class="grey-text">Filtrar por Estado</label>
            <select class="browser-default" name="filter_order_status" id="filter_order_status" style="border: 1px solid #ddd; border-radius: 8px; padding: 8px; width: 100%; height: 40px;">
              <option value="">Todos los estados</option>
              <option value="Pending" <?= ($current_status == 'Pending') ? 'selected' : '' ?>>Pendiente</option>
              <option value="Paid" <?= ($current_status == 'Paid') ? 'selected' : '' ?>>Pagado</option>
              <option value="Shipped" <?= ($current_status == 'Shipped') ? 'selected' : '' ?>>Enviado</option>
              <option value="Delivered" <?= ($current_status == 'Delivered') ? 'selected' : '' ?>>Entregado</option>
            </select>
          </div>

          <!-- Filtro por Fecha -->
          <div class="filter-item">
            <div class="date-quick-picks">
              <span class="btn-quick <?= ($current_date == $today) ? 'active' : '' ?>" onclick="setDate('<?= $today ?>')">Hoy</span>
              <span class="btn-quick <?= ($current_date == $yesterday) ? 'active' : '' ?>" onclick="setDate('<?= $yesterday ?>')">Ayer</span>
              <span class="btn-quick" onclick="setDate('')">Limpiar Fecha</span>
            </div>
            <label class="grey-text">Fecha específica</label>
            <input type="date" name="filter_date" id="filter_date" value="<?= $current_date ?>" class="datepicker-custom">
          </div>

          <!-- Botón Aplicar -->
          <div style="min-width: 150px;">
            <button type="submit" class="btn waves-effect waves-light teal darken-1" style="width: 100%; height: 40px; border-radius: 8px; text-transform: none;">
              <i class="material-icons left">search</i> Buscar Pedidos
            </button>
          </div>
        </div>
      </form>
    </div>

    <div id="contentOrders" class="row">
      <?php if (!empty($orders['data']) && is_array($orders['data'])) : ?>
        <?php foreach ($orders['data'] as $prod) :
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
                      <?= isset($class_order_status[$prod['order_status']]) ? $class_order_status[$prod['order_status']]['text'] : $prod['order_status'] ?>
                    </span>
                  </div>
                </div>

                <span class="card-title grey-text text-darken-4 truncate" style="font-weight: 500; font-size: 1.1rem; margin-top: 10px;" title="<?php echo htmlspecialchars($prod['customer_name']); ?>">
                  <?php echo htmlspecialchars($prod['customer_name']); ?>
                </span>

                <div class="order-info-row" style="margin-top: 10px;">
                  <i class="material-icons">calendar_today</i>
                  <span><?php echo date('d/m/Y H:i', strtotime($prod['created_at'])); ?></span>
                </div>

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
          <div class="card-panel" style="padding: 50px;">
            <i class="material-icons large grey-text" style="opacity: 0.3;">inventory_2</i>
            <h5 class="grey-text">No se encontraron pedidos</h5>
            <p class="grey-text text-lighten-1">Prueba cambiando los filtros de fecha o estado para ampliar la búsqueda.</p>
            <a href="?" class="btn teal waves-effect waves-light" style="margin-top: 15px;">Ver todos los pedidos</a>
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

<script type="text/javascript">
  /**
   * Establece la fecha en el input y gestiona la apariencia de los botones
   * @param {string} date - Fecha en formato YYYY-MM-DD o vacío para limpiar
   */
  function setDate(date) {
    // 1. Establecer el valor en el input de fecha
    $('#filter_date').val(date);

    // 2. Gestionar la clase 'active' visualmente
    $('.btn-quick').removeClass('active');

    if (date !== '') {
      // Buscamos el botón que tiene el atributo onclick con la fecha exacta
      $('.btn-quick[onclick*="' + date + '"]').addClass('active');
    }

    // 3. Opcional: Enviar el formulario automáticamente al hacer clic
    // Descomenta la siguiente línea si quieres que busque de inmediato:
    // $('#filterForm').submit();
  }

  $(document).ready(function() {
    // Inicializar tooltips de Materialize (si los usas)
    if ($('.tooltipped').length) {
      $('.tooltipped').tooltip();
    }
  });
</script>