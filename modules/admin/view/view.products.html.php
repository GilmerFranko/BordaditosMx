<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 * BORDAMEX Project
 *-------------------------------------------------------
 * @Description Vista modernizada del listado de productos para el administrador
 *=======================================================
 */
require Core::view('head', 'core');
?>

<style>
  :root {
    --primary-dark: #212121;
    --accent-color: #26a69a;
    --bg-body: #f4f7f6;
  }

  body {
    background-color: var(--bg-body);
  }

  /* Cabecera de página */
  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
  }

  .page-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin: 0;
  }

  /* Tabla Estilizada */
  .product-table-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    border: none;
  }

  table.dataTable {
    border-collapse: collapse;
    width: 100%;
  }

  thead th {
    background-color: #f8f9fa;
    color: #757575;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 1px;
    padding: 15px 20px !important;
    border-bottom: 1px solid #eee;
  }

  tbody td {
    padding: 15px 20px !important;
    vertical-align: middle;
    color: #424242;
    border-bottom: 1px solid #f1f1f1;
  }

  /* Badges de Estado */
  .status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
  }

  .status-active {
    background-color: #e8f5e9;
    color: #2e7d32;
  }

  .status-inactive {
    background-color: #ffebee;
    color: #c62828;
  }

  /* Estilo de Precios y Slug */
  .price-tag {
    font-weight: 700;
    color: var(--accent-color);
  }

  .slug-text {
    color: #9e9e9e;
    font-family: monospace;
    font-size: 0.85rem;
  }

  /* Acciones */
  .action-btns {
    display: flex;
    gap: 8px;
    justify-content: center;
  }

  .btn-action {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s;
    background: #f5f5f5;
    color: #616161;
  }

  .btn-action:hover {
    background: var(--primary-dark);
    color: #fff;
  }

  .btn-delete:hover {
    background: #e53935;
    color: #fff;
  }

  .btn-variant:hover {
    background: #1976d2;
    color: #fff;
  }

  /* Botón flotante y Principal */
  .btn-add-new {
    background-color: var(--primary-dark);
    text-transform: none;
    font-weight: 600;
    border-radius: 8px;
    display: flex;
    align-items: center;
  }

  /* Paginador */
  .pagination {
    margin-top: 25px;
    display: flex;
    justify-content: center;
  }

  .pagination li.active {
    background-color: var(--primary-dark);
  }
</style>


<section class="admin-container" id="sectionProducts">

  <div class="page-header">
    <div>
      <h1 class="page-title">Listado de Productos</h1>
      <p class="grey-text" style="margin: 5px 0 0 0;">Gestiona el inventario y visibilidad de tu catálogo.</p>
    </div>
    <a href="<?php echo gLink('admin/new.product') ?>" class="btn btn-add-new waves-effect waves-light">
      <i class="material-icons left">add_circle</i> Agregar Producto
    </a>
  </div>

  <div class="product-table-card">
    <table class="highlight responsive-table">
      <thead>
        <tr>
          <th width="50">ID</th>
          <th>Producto</th>
          <th>Identificador (Slug)</th>
          <th>Precio de Venta</th>
          <th class="center-align">Estado</th>
          <th>Registrado</th>
          <th class="center-align">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($products['data']) && is_array($products['data'])): ?>
          <?php foreach ($products['data'] as $prod): ?>
            <tr id="product_<?php echo $prod['id']; ?>">
              <td class="grey-text">#<?php echo $prod['id']; ?></td>
              <td>
                <span style="font-weight: 600; font-size: 1rem;">
                  <?php echo Core::model('extra', 'core')->getHighlight($search, $prod['name']); ?>
                </span>
              </td>
              <td><span class="slug-text"><?php echo htmlspecialchars($prod['slug']); ?></span></td>
              <td><span class="price-tag">$<?php echo isset($prod['sale_price']) ? number_format($prod['sale_price'], 2) : '0.00'; ?></span></td>
              <td class="center-align">
                <?php if ($prod['status'] == 1): ?>
                  <span class="status-badge status-active">Activo</span>
                <?php else: ?>
                  <span class="status-badge status-inactive">Inactivo</span>
                <?php endif; ?>
              </td>
              <td class="grey-text" style="font-size: 0.9rem;">
                <?php echo isset($prod['created_at']) ? Core::model('date', 'core')->getTimeAgo($prod['created_at']) : '---'; ?>
              </td>
              <td>
                <div class="action-btns">
                  <!-- Botón Variantes -->
                  <a href="<?= glink('admin/view.color_variants', ['product_id' => $prod['id']]) ?>"
                    class="btn-action btn-variant tooltipped" data-position="top" data-tooltip="Ver Variantes">
                    <i class="material-icons">layers</i>
                  </a>
                  <!-- Botón Editar -->
                  <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.product', null, array('product_id' => $prod['id'])); ?>"
                    class="btn-action tooltipped" data-position="top" data-tooltip="Editar">
                    <i class="material-icons">edit</i>
                  </a>
                  <!-- Botón Eliminar -->
                  <a href="<?= gLink('admin/delete.product', ['product_id' => $prod['id']]) ?>"
                    class="btn-action btn-delete tooltipped" data-position="top" data-tooltip="Eliminar"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">
                    <i class="material-icons">delete</i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="center-align grey-text" style="padding: 50px !important;">
              <i class="material-icons large d-block">inventory_2</i>
              <p>No se encontraron productos en la base de datos.</p>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Paginador -->
  <div class="row">
    <div class="col s12 center-align">
      <?php if (isset($products['pages'])) echo $products['pages']['paginator']; ?>
    </div>
  </div>

  <!-- Botón flotante de respaldo -->
  <div class="fixed-action-btn">
    <a class="btn-floating btn-large grey darken-4 waves-effect waves-light" href="<?php echo gLink('admin/new.product') ?>">
      <i class="large material-icons">add</i>
    </a>
  </div>
</section>

<!-- JS adicional -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js"></script>

<script>
  $(document).ready(function() {
    $('.tooltipped').tooltip();
  });
</script>

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>