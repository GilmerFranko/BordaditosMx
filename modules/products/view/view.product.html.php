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

require Core::view('head', 'core');
?>
<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->


<section class="first-section">

  <?php require Core::view('product.details', 'products'); ?>

  <div class="container py-4">
    <form action="<?= gLink('products/process.purchase') ?>" method="GET">
      <!-- Color Selection Section -->
      <div class="section-title mb-4">
        <h2 class="fw-bold">ELIGE LOS COLORES DE TU DUO</h2>
      </div>
      <div class="row g-3 mb-5">
        <?php foreach ($variants as $v): ?>
          <?php
          if ($variant_selected == null)
          {
            $variant_selected = $variants[0]['id'];
          }
          $is_selected = ($variant_selected == $v['id']) ? 'variant_selected' : '';
          ?>
          <div class="" onclick="window.location.href='<?= gLink('products/view.product', ['product_id' => $product_id, 'variant_selected' => $v['id']]) ?>'" style="width: 175px;">
            <div id="color-<?= $v['id'] ?>" class="color-option <?= $is_selected ?>">
              <div class="product-image1">
                <img src="<?= $config['products_url'] . '/' . $v['image'] ?>" alt="<?= $v['color_name'] ?>" class="img-fluid" width="300">
              </div>
              <p class="text-center mt-2 fw-semibold"><?= $v['color_name'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <hr class="my-4">
      <!-- Size Selection Section 1 -->
      <div class="section-title mb-3">
        <h2 class="fw-bold">INDICA LA TALLA DE LA SUDADERA 1</h2>
      </div>
      <?php foreach ($variants as $v): ?>
        <?php if ($v['id'] == $variant_selected): ?>
          <div class="size-selection mb-4">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="hoodie-preview">
                  <img src="<?= $config['products_url'] . '/' . $v['images']['data'][0]['image_url'] ?>" alt="Sudadera 1" class="img-fluid">
                </div>
              </div>
              <div class="col">
                <div class="d-flex align-items-center gap-3">
                  <span class="fs-4 fw-bold">Talla:</span>
                  <?php
                  $sizes = explode(',', $v['size_available']);
                  foreach ($sizes as $size)
                  {
                  ?>
                    <button class="btn-size active sweater-1"><?= $size ?></button>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php foreach ($variants as $v): ?>
        <?php if ($v['id'] == $variant_selected): ?>
          <?php
          $exist_size_2 = isset($v['images']['data'][1]['image_url']);
          // Si la variante no tiene una segunda sudadera, no mostrar esta sección
          if (!$exist_size_2)
          {
            break;
          }
          ?>
          <hr class="my-4">

          <!-- Size Selection Section 2 -->
          <div class="section-title mb-3">
            <h2 class="fw-bold">INDICA LA TALLA DE LA SUDADERA 2</h2>
          </div>

          <div class="size-selection mb-4">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="hoodie-preview">
                  <img src="<?= $config['products_url'] . '/' . $v['images']['data'][1]['image_url'] ?>" alt="Sudadera 2" class="img-fluid">
                </div>
              </div>
              <div class="col">
                <div class="d-flex align-items-center gap-3">
                  <span class="fs-4 fw-bold">Talla:</span>
                  <?php
                  $sizes = explode(',', $v['size_available']);
                  foreach ($sizes as $size)
                  {
                  ?>
                    <button class="btn-size active sweater-2"><?= $size ?></button>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
      <!-- Alert Banner -->
      <div class="alert-banner mb-3 active">
        <span class="alert-icon">🚨</span>
        <span class="alert-text">¡¡Alerta!! ¡ÚLTIMAS PIEZAS DISPONIBLES!</span>
        <span class="alert-icon">✓</span>
      </div>

      <!-- Buy Button -->
      <button class="btn-buy w-100">
        <svg class="shopping-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <path d="M16 10a4 4 0 0 1-8 0"></path>
        </svg>
        COMPRAR AHORA
      </button>
      <input type="text" name="product_id" value="<?= $product_id ?>" hidden>
      <input type="text" name="variant_id" value="<?= $variant_selected ?>" hidden>
    </form>
  </div>
</section>

<style>
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    background-color: #ffffff;
  }

  .section-title h2 {
    font-size: 1.25rem;
    letter-spacing: 0.5px;
  }

  /* Color Option Boxes */
  .color-option {
    border: 3px solid #000;
    padding: 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #fff;

    p {
      font-size: 12px;
    }
  }

  .color-option:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }

  .product-image1 {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
  }

  /* Hoodie Preview */
  .hoodie-preview {
    border: 2px solid #000;
    padding: 10px;
    background-color: #f8f9fa;
    min-width: 100px;
    min-height: 120px;
    width: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Size Button */
  .btn-size {
    background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
    color: white;
    border: none;
    padding: 8px 30px;
    border-radius: 25px;
    font-weight: bold;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(255, 20, 147, 0.3);
  }

  .btn-size:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 20, 147, 0.4);
  }

  .alert-banner.active {
    animation: pulse 2s infinite;
  }

  @keyframes pulse {

    0%,
    100% {
      transform: scale(1);
    }

    50% {
      transform: scale(1.05);
    }
  }

  /* Alert Banner */
  .alert-banner {
    background-color: #2c3e50;
    color: white;
    padding: 15px 20px;
    border-radius: 30px;
    text-align: center;
    font-weight: bold;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .alert-icon {
    font-size: 1.5rem;
  }

  /* Buy Button */
  .btn-buy {
    background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
    color: white;
    border: none;
    padding: 20px;
    border-radius: 15px;
    font-weight: bold;
    font-size: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    box-shadow: 0 6px 20px rgba(255, 20, 147, 0.4);
  }

  .btn-buy:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 20, 147, 0.5);
  }

  .shopping-icon {
    width: 35px;
    height: 35px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .section-title h2 {
      font-size: 1rem;
    }

    .btn-buy {
      font-size: 1.2rem;
      padding: 15px;
    }

    .size-selection .row {
      flex-direction: column;
      text-align: center;
    }

    .hoodie-preview {
      margin: 0 auto;
    }
  }

  .variant_selected {
    border-color: var(--pink-dark);
    box-shadow: 0 0 15px var(--pink-primary);
  }

  /* Estilo para el botón seleccionado */
  .btn-size.selected {
    background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
    color: #fff;
    border: 2px solid #ff69b4;
    box-shadow: 0 6px 15px rgba(255, 20, 147, 0.5);
    transform: scale(1.1);
  }
</style>

<!-- Script actualizado para validar tallas antes de enviar el formulario -->
<script>
  $(document).ready(function() {
    // Variables para guardar las tallas seleccionadas
    let selectedSize1 = null;
    let selectedSize2 = null;

    // Crear inputs ocultos para las tallas
    const inputSize1 = $('<input>', {
      type: 'hidden',
      name: 'size_sweater_1',
      id: 'size_sweater_1'
    });

    const inputSize2 = $('<input>', {
      type: 'hidden',
      name: 'size_sweater_2',
      id: 'size_sweater_2'
    });

    // Agregar los inputs al formulario
    $('form').append(inputSize1, inputSize2);

    // Evento para manejar la selección de talla de la sudadera 1
    $('.btn-size.sweater-1').on('click', function(e) {
      e.preventDefault();
      $('.btn-size.sweater-1').removeClass('selected');
      $(this).addClass('selected');
      selectedSize1 = $(this).text();
      $('#size_sweater_1').val(selectedSize1);
      console.log('Talla seleccionada para Sudadera 1:', selectedSize1);
    });

    // Evento para manejar la selección de talla de la sudadera 2
    $('.btn-size.sweater-2').on('click', function(e) {
      e.preventDefault();
      $('.btn-size.sweater-2').removeClass('selected');
      $(this).addClass('selected');
      selectedSize2 = $(this).text();
      $('#size_sweater_2').val(selectedSize2);
      console.log('Talla seleccionada para Sudadera 2:', selectedSize2);
    });

    // Validar el formulario antes de enviarlo
    $('form').on('submit', function(e) {
      if (!selectedSize1 <?php echo ($exist_size_2) ? '|| !selectedSize2' : '' ?>) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Faltan tallas',
          text: 'Por favor selecciona las tallas de ambas sudaderas antes de continuar.',
          confirmButtonText: 'Entendido'
        });
      }
    });
  });
</script>