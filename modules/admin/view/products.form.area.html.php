<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Formulario para crear/editar productos (área modal)
 *
 */
?>
<div class="productNewEdit">
  <form action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'products', 'action', ['do' => isset($product) ? 'edit' : 'new']); ?>" method="post" enctype="multipart/form-data">
    <?php if (isset($product) && isset($product['id'])): ?>
      <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <?php endif; ?>

    <div class="row">
      <div class="input-field col s6">
        <input id="p_name" name="name" type="text" value="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : ''; ?>" required>
        <label class="active" for="p_name">Nombre</label>
      </div>
      <div class="input-field col s6">
        <input id="p_slug" name="slug" type="text" value="<?php echo isset($product['slug']) ? htmlspecialchars($product['slug']) : ''; ?>">
        <label class="active" for="p_slug">Slug (opcional)</label>
      </div>
    </div>

    <div class="row">
      <div class="input-field col s12">
        <textarea id="p_description" name="description" class="materialize-textarea"><?php echo isset($product['description']) ? htmlspecialchars($product['description']) : ''; ?></textarea>
        <label class="active" for="p_description">Descripción</label>
      </div>
    </div>

    <div class="row">
      <div class="input-field col s4">
        <input id="p_original" name="original_price" type="text" value="<?php echo isset($product['original_price']) ? $product['original_price'] : ''; ?>">
        <label class="active" for="p_original">Precio original</label>
      </div>
      <div class="input-field col s4">
        <input id="p_sale" name="sale_price" type="text" value="<?php echo isset($product['sale_price']) ? $product['sale_price'] : ''; ?>">
        <label class="active" for="p_sale">Precio de venta</label>
      </div>
      <div class="input-field col s4">
        <div class="file-field input-field">
          <div class="btn">
            <span>Imágenes</span>
            <input type="file" name="images[]" multiple accept="image/*">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Sube una o varias imágenes">
          </div>
        </div>
      </div>
    </div>

    <div class="control-group">
      <button type="submit" name="save" class="btn blue darken-4 w100"><?php echo isset($product) ? 'Guardar' : 'Crear producto'; ?></button>
    </div>
  </form>
</div>