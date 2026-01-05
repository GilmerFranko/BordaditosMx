<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 * BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco
 *=======================================================
 *
 * @Description Vista mejorada del Top 20 con buscador dinámico y gestión visual
 */

require Core::view('head', 'core');
?>

<style>
  :root {
    --top-accent: #00897b;
    --bg-light: #f5f7f9;
  }

  #adminTopProducts {
    background-color: var(--bg-light);
    min-height: 100vh;
    padding-top: 20px;
  }

  .top-header {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  /* Lista de Productos */
  .top-list-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  }

  .top-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
  }

  .top-item:hover {
    background-color: #fcfcfc;
  }

  .pos-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: #ddd;
    min-width: 45px;
  }

  .top-item:nth-child(-n+4) .pos-number {
    color: var(--top-accent);
    font-size: 1.8rem;
  }

  .product-img-wrapper {
    margin: 0 15px;
  }

  .product-img-wrapper img {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background: #eee;
  }

  .product-info {
    flex-grow: 1;
  }

  .product-name {
    font-weight: 600;
    font-size: 1.1rem;
    display: block;
    color: #333;
  }

  .actions-wrapper {
    display: flex;
    gap: 5px;
  }

  /* Buscador */
  .search-card {
    position: sticky;
    top: 20px;
    border-radius: 12px;
  }

  .search-input-wrapper {
    position: relative;
  }

  #product-search {
    border: 2px solid #e0e0e0 !important;
    border-radius: 8px !important;
    padding: 0 15px !important;
    height: 45px !important;
    box-sizing: border-box !important;
    transition: border-color 0.3s;
  }

  #product-search:focus {
    border-color: var(--top-accent) !important;
    box-shadow: none !important;
  }

  /* Resultados de búsqueda */
  #search-results {
    max-height: 400px;
    overflow-y: auto;
    border: none;
  }

  .result-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #f5f5f5;
  }

  .result-item img {
    width: 40px;
    height: 40px;
    border-radius: 4px;
    object-fit: cover;
    margin-right: 12px;
    background: #eee;
  }

  /* Botones personalizados */
  .btn-action {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f5f5f5;
    color: #757575;
    cursor: pointer;
    transition: 0.2s;
  }

  .btn-action:hover {
    background: #eeeeee;
    color: #222;
  }

  .btn-delete:hover {
    background: #ffebee;
    color: #e53935;
  }
</style>

<section id="adminTopProducts">
  <div class="container">

    <div class="top-header">
      <div>
        <h4 style="margin:0; font-weight: 700; color: #333;">Top 20 Productos</h4>
        <p class="grey-text" style="margin:0;">Organiza los productos destacados de la tienda</p>
      </div>
      <i class="material-icons large teal-text text-lighten-4">star</i>
    </div>

    <div class="row">
      <!-- Lista de Top 20 -->
      <div class="col s12 l8">
        <div class="top-list-card">
          <div style="padding: 15px 20px; background: #fafafa; border-bottom: 1px solid #eee;">
            <span class="grey-text text-darken-2" style="font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Posición, Imagen y Nombre</span>
          </div>
          <div id="sortable-list">
            <?php if (!empty($topProducts)): ?>
              <?php foreach ($topProducts as $index => $product): ?>
                <div id="li-<?= $product['product_id'] ?>" class="top-item">
                  <div class="pos-number"><?= $index + 1 ?></div>
                  <a href="<?= gLink('products/view.product', ['product_id' => $product['product_id']]) ?>">
                    <div class="product-img-wrapper">
                      <img src="<?= $config['products_url'] . '/' . $product['image_url'] ?: 'https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png' ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                  </a>
                  <div class="product-info">
                    <span class="product-name"><?= htmlspecialchars($product['name']) ?></span>
                    <small class="grey-text">ID: <?= $product['product_id'] ?></small>
                  </div>
                  <div class="actions-wrapper">
                    <div class="btn-action move-product tooltipped" data-id="<?= $product['product_id'] ?>" data-action="up" data-tooltip="Subir">
                      <i class="material-icons">expand_less</i>
                    </div>
                    <div class="btn-action move-product tooltipped" data-id="<?= $product['product_id'] ?>" data-action="down" data-tooltip="Bajar">
                      <i class="material-icons">expand_more</i>
                    </div>
                    <div class="btn-action btn-delete remove-product tooltipped" data-id="<?= $product['product_id'] ?>" data-tooltip="Eliminar">
                      <i class="material-icons">delete_outline</i>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="center-align" style="padding: 50px 20px;">
                <i class="material-icons grey-text text-lighten-2" style="font-size: 4rem;">inventory_2</i>
                <h5 class="grey-text">El Top 20 está vacío</h5>
                <p class="grey-text">Utiliza el buscador de la derecha para añadir productos.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Buscador dinámico -->
      <div class="col s12 l4">
        <div class="card search-card z-depth-2">
          <div class="card-content">
            <span class="card-title" style="font-weight: 700; font-size: 1.2rem;">Añadir Producto</span>
            <p class="grey-text" style="margin-bottom: 15px; font-size: 0.9rem;">Busca por nombre para agregarlo a la lista.</p>

            <div class="search-input-wrapper">
              <input type="text" id="product-search" placeholder="Escribe el nombre..." autocomplete="off">
            </div>

            <div id="search-results-container" style="margin-top: 10px;">
              <ul class="collection" id="search-results" style="border:none;">
                <!-- Resultados dinámicos -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    // Inicializar Tooltips
    $('.tooltipped').tooltip();

    // Búsqueda de productos
    $('#product-search').on('input', function() {
      const query = $(this).val();

      if (query.length > 2) {
        $.ajax({
          url: '<?= gLink('admin/top20') ?>',
          method: 'POST',
          data: {
            action: 'search',
            query
          },
          success: function(response) {
            let results = JSON.parse(response);
            let html = '';

            if (results.length) {
              results.forEach(product => {
                html += `
                                    <li class="collection-item result-item">
                                        <img src="${product.image_url || 'https://upload.wikimedia.org/wikipedia/commons/a/a3/Image-not-found.png'}" alt="">
                                        <div style="flex-grow:1">
                                            <span style="font-weight:500; display:block; line-height:1.2;">${product.name}</span>
                                            <small class="grey-text">Ref: ${product.id}</small>
                                        </div>
                                        <a href="#" class="add-product btn-floating btn-small waves-effect waves-light teal" data-id="${product.id}">
                                            <i class="material-icons">add</i>
                                        </a>
                                    </li>
                                `;
              });
            } else {
              html = '<li class="collection-item center-align grey-text">Sin coincidencias</li>';
            }
            $('#search-results').html(html);
          }
        });
      } else {
        $('#search-results').html('');
      }
    });

    // Manejo de AJAX para acciones (Add, Remove, Move)
    function performAction(actionData, successCallback) {
      $.ajax({
        url: '<?= gLink('admin/top20') ?>',
        method: 'POST',
        data: actionData,
        success: function(response) {
          const result = JSON.parse(response);
          M.toast({
            html: result.message,
            classes: result.success ? 'teal darken-1' : 'red'
          });
          if (result.success && successCallback) successCallback(result);
        }
      });
    }

    // Agregar producto
    $(document).on('click', '.add-product', function(e) {
      e.preventDefault();
      performAction({
        action: 'add',
        product_id: $(this).data('id')
      }, () => location.reload());
    });

    // Eliminar producto
    $(document).on('click', '.remove-product', function(e) {
      e.preventDefault();
      const id = $(this).data('id');
      performAction({
        action: 'remove',
        product_id: id
      }, () => {
        $(`#li-${id}`).fadeOut(300, function() {
          $(this).remove();
          updatePositions();
        });
      });
    });

    // Mover producto
    $(document).on('click', '.move-product', function(e) {
      e.preventDefault();
      const id = $(this).data('id');
      const direction = $(this).data('action');

      performAction({
        action: 'move',
        product_id: id,
        direction: direction
      }, () => {
        const currentItem = $('#li-' + id);
        if (direction === 'up') {
          const prev = currentItem.prev('.top-item');
          if (prev.length) currentItem.hide().insertBefore(prev).fadeIn(200);
        } else {
          const next = currentItem.next('.top-item');
          if (next.length) currentItem.hide().insertAfter(next).fadeIn(200);
        }
        updatePositions();
      });
    });

    function updatePositions() {
      $('.top-item').each(function(index) {
        $(this).find('.pos-number').text(index + 1);
      });
    }
  });
</script>

<?php require Core::view('footer', 'core'); ?>