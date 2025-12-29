<?php defined('BORDAMEX') || exit;

require Core::view('head', 'core');

$product_name = isset($product['name']) ? $product['name'] : ('ID ' . $product_id);

?>
<section id="adminEditColorVariant">
  <div class="card-panel green lighten-4 green-text text-darken-4 flow-text center-align">Editar Variante — <?= $variant['color_name'] ?></div>
  <div class="container">
    <div class="row">
      <form class="col s12" id="editColorVariantForm" method="POST" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.color_variant', null, array('edit_variant' => 'true', 'variant_id' => $variant['id'])); ?>" enctype="multipart/form-data">

        <div class="input-field">
          <label for="color_name">Nombre del color</label>
          <input type="text" name="color_name" id="color_name" value="<?= $variant['color_name'] ?>" required>
        </div>

        <div class="input-field">
          <label for="size_available">Tamaños disponibles (separados por comas)</label>
          <input type="text" name="size_available" id="size_available" value="<?= $variant['size_available'] ?>" placeholder="S, M, L, XL">
        </div>

        <div class="input-field">
          <label class="active">Imagen de presentación actual</label>
          <?php if (!empty($variant['image'])): ?>
            <div><img src="<?= $config['products_url'] . $variant['image'] ?>" style="width:120px;height:auto" alt="presentacion"></div>
          <?php else: ?>

          <?php endif; ?>
          <input type="file" name="image" id="image" accept="image/*">
        </div>
        <br>
        <hr>
        <div class="input-field">
          <label class="active">Imágenes asociadas actuales</label>
          <p class="grey-text">Si subes nuevas imágenes, las imágenes anteriores serán borradas.</p>
        </div>

        <div class="input-field">
          <label for="hoodie1" class="active">Imagen Sudadera 1 (opcional)</label>
          <input type="file" name="hoodie1" id="hoodie1" accept="image/*">
        </div>
        <div>
          <?php if (!empty($variant_images)): ?>
            <?php foreach ($variant_images as $img): ?>
              <?php if ($img['num_image'] == 1): ?>
                <img src="<?= $config['products_url'] . $img['image_url'] ?>" style="width:100px;height:auto;margin:4px;border:1px solid #ccc;" alt="img">
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div>No hay imágenes asociadas.</div>
          <?php endif; ?>
        </div>
        <br>
        <div class="input-field">
          <label for="hoodie2" class="active">Imagen Sudadera 2 (opcional)</label>
          <input type="file" name="hoodie2" id="hoodie2" accept="image/*">
        </div>
        <div>
          <?php if (!empty($variant_images)): ?>
            <?php foreach ($variant_images as $img): ?>
              <?php if ($img['num_image'] == 2): ?>
                <img src="<?= $config['products_url'] . $img['image_url'] ?>" style="width:100px;height:auto;margin:4px;border:1px solid #ccc;" alt="img">
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <div>No hay imágenes asociadas.</div>
          <?php endif; ?>
        </div>
        <br>
        <button class="btn waves-effect waves-light green" type="submit"><i class="material-icons right notranslate">save</i>Guardar cambios</button>
        <a class="btn grey" href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'view.color_variants', null, ['product_id' => $product_id]); ?>">Volver</a>
      </form>
    </div>
  </div>
</section>

<?php require Core::view('footer', 'core'); ?>