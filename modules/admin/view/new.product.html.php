<?php defined('BORDAMEX') || exit;

/**
 * ========================================================
 * BORDAMEX Project
 *-------------------------------------------------------
 * @autor Gilmer Franco <gil2017.com@gmail.com>
 * ========================================================
 *
 * @Description Vista de nuevo producto mejorada e interactiva
 */

require Core::view('head', 'core');

$useExampleValues = false;

?>
<!-- Estilos para SCEditor y Personalización -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
<style>
  :root {
    --accent-color: #26a69a;
    --bg-body: #f4f7f6;
  }

  #adminNewProduct {
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

  /* Estilo para la carga de imagen */
  .image-upload-wrapper {
    position: relative;
    width: 100%;
    height: 200px;
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

  .image-upload-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: none;
  }

  .image-upload-wrapper .upload-placeholder {
    text-align: center;
    color: #888;
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

  /* Interruptor Switch personalizado */
  .switch label input[type=checkbox]:checked+.lever {
    background-color: #b2dfdb;
  }

  .switch label input[type=checkbox]:checked+.lever:after {
    background-color: var(--accent-color);
  }

  /* Ajuste para SCEditor */
  .sceditor-container {
    border: 1px solid #ddd !important;
    border-radius: 8px !important;
  }
</style>

<section id="adminNewProduct">
  <!-- Cabecera de Página -->
  <div class="page-header">
    <div class="container">
      <div class="row" style="margin:0">
        <div class="col s12 m8">
          <h4 style="margin:0; font-weight:700; color:#333;"><?= $page['name'] ?></h4>
          <p class="grey-text">Configura los detalles de tu nuevo artículo para la tienda</p>
        </div>
        <div class="col s12 m4 right-align">
          <a href="<?= gLink('admin/products') ?>" class="btn-flat waves-effect">Cancelar</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <form id="newProductForm" method="POST" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'new.product', null, array('do' => 'new')); ?>" enctype="multipart/form-data">
      <div class="row">

        <!-- Columna Izquierda: Información General -->
        <div class="col s12 l8">
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">info_outline</i> Información General
            </div>

            <div class="input-field">
              <i class="material-icons prefix">title</i>
              <input type="text" name="name" id="name" placeholder="Ej: Hoodie Bordado Dragón" value="<?php echo $useExampleValues ? 'Ejemplo de Producto' : Core::model('extra', 'core')->getInputValue('name', 'post'); ?>" required>
              <label for="name" class="active">Nombre del Producto</label>
            </div>

            <div style="margin-bottom: 30px;">
              <label class="grey-text">Enlace del producto (Slug)</label><br>
              <div class="slug-preview">
                <?= str_replace(['https://', 'http://'], '', $config['base_url']) ?>/producto/<span id="slug-text">...</span>
              </div>
              <input type="hidden" name="slug" id="slug" value="<?= Core::model('extra', 'core')->getInputValue('slug', 'post'); ?>">
            </div>

            <div class="input-field" style="margin-top: 40px;">
              <p class="grey-text" style="margin-bottom: 10px;">Descripción detallada</p>
              <textarea name="description" id="description" class="wysiwyg-editor"><?php echo $useExampleValues ? 'Descripción de ejemplo.' : Core::model('extra', 'core')->getInputValue('description', 'post'); ?></textarea>
            </div>
          </div>
        </div>

        <!-- Columna Derecha: Multimedia y Precios -->
        <div class="col s12 l4">

          <!-- Tarjeta de Imagen -->
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">image</i> Multimedia
            </div>
            <p class="grey-text" style="font-size:0.85rem">Imagen principal del producto</p>

            <div class="image-upload-wrapper" onclick="document.getElementById('image').click()">
              <div class="upload-placeholder" id="placeholder-box">
                <i class="material-icons" style="font-size: 3rem;">cloud_upload</i>
                <p>Haz clic para subir</p>
              </div>
              <img id="image-preview" src="#" alt="Vista previa">
            </div>
            <input id="image" type="file" name="image" required accept="image/jpg, image/jpeg, image/png" style="display:none">
          </div>

          <!-- Tarjeta de Precios -->
          <div class="card-form">
            <div class="section-label">
              <i class="material-icons">attach_money</i> Precios
            </div>

            <div class="input-field">
              <i class="material-icons prefix">sell</i>
              <input type="number" step="0.01" name="original_price" id="original_price" value="<?php echo $useExampleValues ? '100' : Core::model('extra', 'core')->getInputValue('original_price', 'post'); ?>" required>
              <label for="original_price">Precio Original</label>
            </div>

            <div class="input-field">
              <i class="material-icons prefix">shopping_cart</i>
              <input type="number" step="0.01" name="sale_price" id="sale_price" value="<?php echo $useExampleValues ? '100' : Core::model('extra', 'core')->getInputValue('sale_price', 'post'); ?>" required>
              <label for="sale_price">Precio de Venta</label>
            </div>
          </div>

          <!-- Tarjeta de Estado -->
          <!--<div class="card-form">
            <div class="section-label">
              <i class="material-icons">visibility</i> Visibilidad
            </div>
            <div class="switch" style="margin-top: 10px;">
              <label>
                Inactivo
                <input type="checkbox" name="status" id="status" value="1" <?php echo $useExampleValues ? 'checked' : (Core::model('extra', 'core')->getInputValue('status', 'post') ? 'checked' : ''); ?>>
                <span class="lever"></span>
                Activo
              </label>
            </div>
            <p class="grey-text" style="font-size:0.8rem; margin-top:15px;">Si está inactivo, no aparecerá en la tienda pública.</p>
          </div>-->

          <!-- Botón Guardar -->
          <button class="btn-large waves-effect waves-light teal darken-1 w-full" type="submit" style="width: 100%; border-radius: 12px; height: 55px; font-weight: 700;">
            <i class="material-icons left">save</i> GUARDAR PRODUCTO
          </button>
        </div>

      </div>
    </form>
  </div>
</section>

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

  // Generador de Slug dinámico
  $('#name').on('input', function() {
    let name = $(this).val();
    let slug = name.toLowerCase()
      .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // Quitar acentos
      .replace(/ /g, '-')
      .replace(/[^\w-]+/g, '');

    if (slug.length > 0) {
      let randomString = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
      let finalSlug = slug + '-' + randomString;
      $('#slug').val(finalSlug);
      $('#slug-text').text(finalSlug);
    } else {
      $('#slug-text').text('...');
    }
  });

  // Vista previa de imagen
  $('#image').on('change', function() {
    const file = this.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function(event) {
        $('#image-preview').attr('src', event.target.result).show();
        $('#placeholder-box').hide();
      }
      reader.readAsDataURL(file);
    }
  });
</script>

<?php require Core::view('footer', 'core'); ?>