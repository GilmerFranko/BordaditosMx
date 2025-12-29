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

$product_id = isset($_GET['product_id']) ? (int) $_GET['product_id'] : 0;
$product_name = isset($product['name']) ? $product['name'] : '';

?>
<section id="adminNewColorVariant">
  <div class="card-panel green lighten-4 green-text text-darken-4 flow-text center-align"><?= $page['name'] ?></div>
  <br>
  <div class="container">
    <div class="row">
      <form class="col s12" id="newColorVariantForm" method="POST" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'new.color_variant', null, array('do' => 'new', 'product_id' => $product_id)); ?>" enctype="multipart/form-data">

        <div class="input-field">
          <label for="product">Producto</label>
          <input type="text" id="product" value="<?= $product_name ?>" disabled>
        </div>

        <div class="input-field">
          <label for="color_name">Nombre del color</label>
          <input type="text" name="color_name" id="color_name" required>
        </div>

        <div class="input-field">
          <label for="size_available">Tamaños disponibles (separados por comas)</label>
          <input type="text" name="size_available" id="size_available" placeholder="S, M, L, XL">
        </div>

        <div class="input-field">
          <label for="image">Imagen de presentación (obligatoria)</label>
          <input type="file" name="image" id="image" accept="image/*" required>
        </div>
        <hr class="separador" style="border: 1px solid #ccc; margin: 20px 0;">
        <span class="separador-text">Sudadera 1</span>
        <div class="input-field">
          <label for="hoodie1">Imagen Sudadera 1</label>
          <input type="file" name="hoodie1" id="hoodie1" accept="image/*" required>

        </div>
        <hr class="separador" style="border: 1px solid #ccc; margin: 20px 0;">
        <span class="separador-text">Sudadera 2</span>
        <div class="input-field">
          <label for="hoodie2">Imagen Sudadera 2 (opcional)</label>
          <input type="file" name="hoodie2" id="hoodie2" accept="image/*">
        </div>
        <br>
        <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons right notranslate">send</i>Crear variante</button>
      </form>
    </div>
  </div>
</section>

<?php require Core::view('footer', 'core'); ?>