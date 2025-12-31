<?php defined('BORDAMEX') || exit;

/**
 *=======================================================

BORDAMEX Project - Detalles de Compra Rediseñados
 *-------------------------------------------------------

@author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 */
?>

<style>
  /* Contenedor Principal con nombres de clase únicos */
  .bmx-purchase-card {
    background: #ffffff;
    border-radius: 15px;
    overflow: hidden;
    border: 1px solid #f0f0f0;
  }

  .bmx-header-wrapper {
    background: #fdf2f8;
    /* Un rosa muy sutil */
    padding: 1.25rem;
    border-bottom: 2px solid #ff1493;
  }

  .bmx-section-title {
    font-weight: 800;
    color: #ff1493;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
    margin: 0;
    display: flex;
    align-items: center;
  }

  .bmx-product-body {
    padding: 1.5rem;
  }

  /* Layout del producto */
  .bmx-item-row {
    display: flex;
    gap: 20px;
    align-items: flex-start;
  }

  .bmx-product-img-container {
    width: 120px;
    min-width: 120px;
    height: 120px;
    background: #f8f8f8;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #eee;
  }

  .bmx-product-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .bmx-product-info {
    flex-grow: 1;
  }

  .bmx-product-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2d3436;
    margin-bottom: 0.5rem;
  }

  /* Badge de precio */
  .bmx-price-tag {
    display: inline-block;
    background: #ff1493;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 1.1rem;
  }

  /* Grid de especificaciones (en lugar de tablas) */
  .bmx-specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 15px;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px dashed #e0e0e0;
  }

  .bmx-spec-item {
    background: #fafafa;
    padding: 10px;
    border-radius: 8px;
    text-align: center;
  }

  .bmx-spec-label {
    display: block;
    font-size: 0.75rem;
    color: #95a5a6;
    text-transform: uppercase;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .bmx-spec-value {
    display: block;
    font-size: 0.95rem;
    color: #2d3436;
    font-weight: 600;
  }

  .bmx-color-circle {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 5px;
    border: 1px solid #ccc;
  }

  @media (max-width: 576px) {
    .bmx-item-row {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .bmx-product-img-container {
      width: 150px;
      height: 150px;
    }
  }
</style>

<div class="bmx-purchase-card mb-4">
  <!-- Encabezado con Icono -->
  <div class="bmx-header-wrapper d-flex align-items-center justify-content-between">
    <h2 class="bmx-section-title">
      <svg class="me-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 2L3 9V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V9L12 2Z" fill="#FF1493" stroke="#FF1493" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M9 22V12H15V22" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      DETALLES DE COMPRA
    </h2>
    <!--<span class="text-muted small">ID Compra: #<?= time() ?></span>-->
  </div>

  <div class="bmx-product-body">
    <!-- Fila de Información Principal -->
    <div class="bmx-item-row">
      <!-- Imagen del Producto -->
      <div class="bmx-product-img-container">
        <?php
        // Asumamos que existe una URL de imagen, de lo contrario un placeholder
        $img_url = !empty($variant['data'][0]['image']) ? $config['products_url'] . '/' . $variant['data'][0]['image'] : 'https://via.placeholder.com/150?text=Producto';
        ?>
        <img src="<?= $img_url ?>" alt="<?= $product['name'] ?>">
      </div>

      <!-- Datos básicos -->
      <div class="bmx-product-info">
        <h3 class="bmx-product-name"><?= $product['name'] ?></h3>
        <div class="mb-2">
          <span class="text-muted me-2 small">Precio Unitario:</span>
          <span class="bmx-price-tag">$<?= number_format($product['original_price'], 2) ?></span>
        </div>
        <p class="text-muted small mb-0">
          <i class="fa fa-info-circle me-1"></i>
          Estás adquiriendo <strong>1 unidad</strong> de este modelo.
        </p>
      </div>
    </div>

    <!-- Fila de Especificaciones (Color y Tallas) -->
    <div class="bmx-specs-grid">
      <!-- Color -->
      <div class="bmx-spec-item">
        <span class="bmx-spec-label">Color Elegido</span>
        <span class="bmx-spec-value">
          <span class="bmx-color-circle" style="background-color: <?= $variant['data'][0]['color_hex'] ?? '#000' ?>;"></span>
          <?= $variant['data'][0]['color_name'] ?>
        </span>
      </div>

      <!-- Talla 1 -->
      <div class="bmx-spec-item">
        <span class="bmx-spec-label">Talla Sudadera 1</span>
        <span class="bmx-spec-value"><?= $size_sweater_1 ?></span>
      </div>

      <!-- Talla 2 (Condicional) -->
      <?php if (!empty($size_sweater_2)): ?>
        <div class="bmx-spec-item">
          <span class="bmx-spec-label">Talla Sudadera 2</span>
          <span class="bmx-spec-value"><?= $size_sweater_2 ?></span>
        </div>
      <?php endif; ?>

      <!-- Cantidad (Siempre 1 según tu código original) -->
      <div class="bmx-spec-item">
        <span class="bmx-spec-label">Cantidad</span>
        <span class="bmx-spec-value">1 pz.</span>
      </div>
    </div>
  </div>


</div>