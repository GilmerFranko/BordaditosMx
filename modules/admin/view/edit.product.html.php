<?php defined('BORDAMEX') || exit;

/**
 * ========================================================
 * BORDAMEX Project
 *-------------------------------------------------------
 * @autor Gilmer Franco <gil2017.com@gmail.com>
 * ========================================================
 *
 * @Description Vista para editar un producto mejorada e interactiva
 */

require Core::view('head', 'core');

?>
<!-- Estilos para SCEditor y Personalización -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
<style>
  :root {
    --accent-color: #26a69a;
    --bg-body: #f4f7f6;
  }

  #adminEditProduct {
    background-color: var(--bg-body);
    padding-bottom: 50px;
    min-height: 100vh;
  }

  .page-header {
    background: white;
    padding: 20px 0;
    margin-bottom: 30px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }

  .card-form {
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 20px;
    background: white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  }

  .section-label {
    display: flex;
    align-items: center;
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
  }

  .section-label i {
    margin-right: 10px;
    color: var(--accent-color);
  }

  /* Estilo para la carga e imagen actual */
  .image-upload-wrapper {
    position: relative;
    width: 100%;
    height: 220px;
    border: 2px dashed #ccc;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    transition: all 0.3s ease;
    background: #fafafa;
    cursor: pointer;
  }

  .image-upload-wrapper:hover {
    border-color: var(--accent-color);
    background: #f0fdfa;
  }

  .image-preview-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
  }

  .upload-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 5px;
    text-align: center;
    font-size: 0.8rem;
  }

  /* Slug Preview */
  .slug-preview {
    background: #f1f3f4;
    padding: 8px 15px;
    border-radius: 6px;
    font-family: monospace;
    font-size: 0.9rem;
    margin-top: 10px;
    display: inline-block;
    color: #555;
  }

  .slug-preview span {
    color: var(--accent-color);
    font-weight: bold;
  }

  /* Botón de Variantes Destacado */
  .btn-variants {
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: bold;
  }

  /* Ajuste para SCEditor */
  .sceditor-container {
    border: 1px solid #ddd !important;
    border-radius: 8px !important;
  }
</style>

<section id="adminEditProduct">
  <!-- Cabecera de Página -->
  <div class="page-header">
    <div class="container">
      <div class="row" style="margin:0">
        <div class="col s12 m8">
          <h4 style="margin:0; font-weight:700; color:#333;">Editar: <?= $product['name'] ?></h4>
          <p class="grey-text">Actualiza los datos del producto o gestiona sus variantes</p>
        </div>
        <div class="col s12 m4 right-align" style="margin-top: 10px;">
          <a href="<?= glink('admin/view.color_variants', ['product_id' => $product['id']]) ?>" class="btn-large waves-effect waves-light blue-grey darken-3 btn-variants">
            <i class="material-icons left">palette</i> VER VARIANTES
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <form id="editProductForm" method="POST" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.product', null, array('edit_product' => 'true', 'product_id' => $product['id'])); ?>" enctype="multipart/form-data">
      <div class="row">

        <!-- Columna Izquierda: Información General -->
        <div class="col s12 l8">
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">edit</i> Detalles Básicos
            </div>

            <div class="input-field">
              <i class="material-icons prefix">title</i>
              <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']); ?>" required>
              <label for="name" class="active">Nombre del Producto</label>
            </div>

            <div style="margin-bottom: 30px;">
              <label class="grey-text">URL del producto (Slug)</label><br>
              <div class="slug-preview">
                <?= str_replace(['https://', 'http://'], '', $config['base_url']) ?>/producto/<span id="slug-text"><?= $product['slug']; ?></span>
              </div>
              <input type="hidden" name="slug" id="slug" value="<?= $product['slug']; ?>">
            </div>

            <div class="input-field" style="margin-top: 40px;">
              <p class="grey-text" style="margin-bottom: 10px;">Descripción detallada</p>
              <textarea name="description" id="description" class="wysiwyg-editor"><?= $product['description']; ?></textarea>
            </div>
          </div>
        </div>

        <!-- Columna Derecha: Multimedia y Precios -->
        <div class="col s12 l4">

          <!-- Tarjeta de Imagen -->
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">image</i> Imagen Principal
            </div>
            <p class="grey-text" style="font-size:0.85rem">Haz clic en la imagen para cambiarla</p>

            <div class="image-upload-wrapper" onclick="document.getElementById('image').click()">
              <img id="image-preview" src="<?php echo $config['products_url'] . $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="image-preview-img">
              <div class="upload-overlay">
                <i class="material-icons tiny">photo_camera</i> Cambiar foto
              </div>
            </div>
            <input id="image" type="file" name="image" accept="image/jpg, image/jpeg, image/png" style="display:none">
          </div>

          <!-- Tarjeta de Precios -->
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">payments</i> Precios
            </div>

            <div class="input-field">
              <i class="material-icons prefix">sell</i>
              <input type="number" step="0.01" name="original_price" id="original_price" value="<?= $product['original_price']; ?>" required>
              <label for="original_price" class="active">Precio Original ($)</label>
            </div>

            <div class="input-field">
              <i class="material-icons prefix">shopping_cart</i>
              <input type="number" step="0.01" name="sale_price" id="sale_price" value="<?= $product['sale_price']; ?>" required>
              <label for="sale_price" class="active">Precio de Venta ($)</label>
            </div>
          </div>

          <!-- Tarjeta de Estado -->
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">settings</i> Configuración
            </div>
            <div class="switch" style="margin: 15px 0;">
              <label>
                Inactivo
                <input type="checkbox" name="status" id="status" value="1" <?= $product['status'] == 1 ? 'checked' : ''; ?> disabled>
                <span class="lever"></span>
                Activo
              </label>
            </div>
            <p class="grey-text" style="font-size:0.8rem;">Estado actual del producto en la tienda.</p>
          </div>

          <!-- Botones de Acción -->
          <button class="btn-large waves-effect waves-light teal darken-1 w-full" type="submit" style="width: 100%; border-radius: 12px; height: 55px; font-weight: 700; margin-bottom: 15px;">
            <i class="material-icons left">check_circle</i> GUARDAR CAMBIOS
          </button>

          <a href="<?= gLink('admin/products') ?>" class="btn-large waves-effect waves-light grey lighten-2 black-text" style="width: 100%; border-radius: 12px; height: 55px; font-weight: 700; display: flex; align-items: center; justify-content: center; box-shadow: none;">
            REGRESAR
          </a>
        </div>

      </div>
    </form>
  </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/formats/bbcode.min.js"></script>
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js"></script>

<script>
  // Inicializar SCEditor
  const $textarea = document.getElementById('description');
  sceditor.create($textarea, {
    format: 'bbcode',
    style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minimized/themes/content/default.min.css',
    locale: 'es',
    width: '100%',
    height: '300px',
    toolbar: 'bold,italic,underline|font,size,color|left,center,right,justify|bulletlist,orderedlist|image,link|removeformat,maximize'
  });

  // Actualización de Slug (solo si el usuario cambia el nombre)
  $('#name').on('input', function() {
    let name = $(this).val();
    let slug = name.toLowerCase()
      .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
      .replace(/ /g, '-')
      .replace(/[^\w-]+/g, '');

    if (slug.length > 0) {
      let randomString = Math.floor(Math.random() * 100).toString().padStart(2, '0');
      let finalSlug = slug + '-' + randomString;
      $('#slug').val(finalSlug);
      $('#slug-text').text(finalSlug);
    }
  });

  // Vista previa de imagen al seleccionar nuevo archivo
  $('#image').on('change', function() {
    const file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function(event) {
        $('#image-preview').attr('src', event.target.result);
        $('.upload-overlay').html('<i class="material-icons tiny">check</i> Imagen seleccionada');
      }
      reader.readAsDataURL(file);
    }
  });
</script>

<?php require Core::view('footer', 'core'); ?>