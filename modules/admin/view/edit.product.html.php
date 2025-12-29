<?php defined('BORDAMEX') || exit;

/**
 * ========================================================
 *  VCO Project
 *-------------------------------------------------------
 * @autor Gilmer Franco <gil2017.com@gmail.com>
 * ========================================================
 *
 * @Description Vista para editar un producto
 *
 *
 */

require Core::view('head', 'core');

$useExampleValues = false; // Cambiar a true para usar valores de ejemplo

?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/formats/bbcode.min.js"></script>
<section id="adminNewProduct">
  <div class="card-panel green lighten-4 green-text text-darken-4 flow-text center-align"><?= $page['name'] ?></div>
  <br>
  <!-- Boton agregar variantes -->
  <div class="sectionProducts container">
    <a href="<?= glink('admin/view.color_variants', ['product_id' => $product['id']]) ?>" class="btn "> Ver variantes</a>
    <br><br>
    <div class="row">
      <form class="col s12" id="newProductForm" method="POST" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.product', null, array('edit_product' => 'true', 'product_id' => $product['id'])); ?>" enctype="multipart/form-data">

        <div class="input-field">
          <label for="name">Nombre</label>
          <input type="text" name="name" id="name" value="<?= $product['name']; ?>" required>
        </div>

        <div class="grid-container" style="display: flex;">
          <div class="grid-item">
            <p class="flow-text">
              <span class="grey-text" style="font-size: 13px;"><?php echo str_replace('https://', '', $config['base_url']) ?>/producto/</span><span class="black-text"></span>
            </p>
          </div>
          <div class="grid-item">
            <div class="input-field">
              <label id="labelslug" for="slug" style="top: 10px">Slug <small>(opcional)</small></label>
              <input type="text" name="slug" id="slug" value="<?= $product['slug']; ?>" required>
            </div>
          </div>
        </div>

        <div class="input-field">
          <label for="description">Descripci n</label>
          <textarea name="description" id="description" class="materialize-textarea wysiwyg-editor" required><?= $product['description']; ?></textarea>
        </div>

        <div class="input-field">
          <label for="original_price">Precio original</label>
          <input type="number" name="original_price" id="original_price" value="<?= $product['original_price']; ?>" required>
        </div>

        <div class="input-field">
          <label for="sale_price">Precio de venta</label>
          <input type="number" name="sale_price" id="sale_price" value="<?= $product['sale_price']; ?>" required>
        </div>

        <div class="">
          <input id="image" type="file" name="image" accept="image/jpg, image/jpeg, image/png">
          <label for="files">No es obligatorio</label>
        </div>
        <div>
          Imagen actual:
          <img class="responsive-img materialboxed" style="width: 100px; height: auto;" src="<?php echo $config['products_url'] . $product['image_url'] ?>" alt="<?php echo $product['name']; ?>">
        </div>
        <br>
        <!--<div class="card-image">
          <?php foreach ($products_images as $image): ?>
            <img class="responsive-img materialboxed" style="width: 100px; height: auto;" src="<?php echo $config['products_url'] . $image['image_url'] ?>" alt="<?php echo $product['name']; ?>">
          <?php endforeach; ?>
        </div>-->
        <br>

        <div class="switch">
          <label class="active">
            Activo
            <input type="checkbox" name="status" id="status" value="1" <?php echo $product['status'] == 1 ? 'checked' : ''; ?>>
            <span class="lever"></span>
          </label>
        </div>
        <br>
        <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons right notranslate">send</i>Editar producto</button>
      </form>
    </div>
  </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js"></script>
<script>
  // Inicializa SCEditor en el textarea
  const $textarea = $('.wysiwyg-editor');
  sceditor.create($textarea[0], {
    format: 'bbcode',
    style: 'https://cdn.jsdelivr.net/npm/sceditor@3/minimized/themes/content/default.min.css',
    locale: 'es', // Ajusta el idioma si es necesario
    width: '100%',
    height: '200px',
  });

  $('#name').on('keyup', function() {
    var name = $(this).val();
    var slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
    var randomString = Math.floor(Math.random() * 1000).toString().substr(0, 3);
    $('#slug').val(slug + '-' + randomString);
    $('#labelslug').addClass('active');
  });
</script>