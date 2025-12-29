<?php defined('BORDAMEX') || exit;

/**
 *=======================================================* BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Extiensión de la vista de Proceso de Compra
 *
 */
?>

<div class="purchase-details-section mb-4">
  <div class="section-header d-flex align-items-center mb-3">
    <svg class="home-icon me-2" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M15 5L5 13V25H11V19H19V25H25V13L15 5Z" fill="#FF1493" stroke="#FF1493" stroke-width="2" />
    </svg>
    <h2 class="section-title mb-0">DETALLES DE COMPRA</h2>
  </div>
  <div class="section-content">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= $product['name'] ?></td>
          <td>1</td>
          <td>$<?= $product['original_price'] ?></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Color</th>
          <th>Talla Sudadera 1</th>
          <?php if (!empty($size_sweater_2)): ?>
            <th>Talla Sudadera 2</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= $variant['data'][0]['color_name'] ?></td>
          <td><?= $size_sweater_1 ?></td>
          <?php if (!empty($size_sweater_2)): ?>
            <td><?= $size_sweater_2 ?></td>
          <?php endif; ?>
        </tr>
      </tbody>
    </table>
  </div>
</div>