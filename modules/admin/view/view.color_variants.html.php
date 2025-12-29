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

$product_name = isset($product['name']) ? $product['name'] : ('ID ' . $product_id);

?>
<section id="adminViewColorVariants">
  <div class="card-panel green lighten-4 green-text text-darken-4 flow-text center-align">Variantes de color — <?= ($product_name) ?></div>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <a class="btn green" href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'new.color_variant', null, ['product_id' => $product_id]); ?>">Nueva variante</a>
        <br><br>
        <table class="striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Color</th>
              <th>Imagen presentación</th>
              <th>Tamaños</th>
              <th>Imágenes</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($variants_list)): ?>
              <?php foreach ($variants_list as $v): ?>
                <tr>
                  <td><?= $v['id'] ?></td>
                  <td><?= $v['color_name'] ?></td>
                  <td>
                    <?php if (!empty($v['image'])): ?>
                      <img src="<?= $config['products_url'] . $v['image'] ?>?w=80" alt="<?= $v['color_name'] ?>" style="width:80px;height:auto;" />
                    <?php else: ?>
                      —
                    <?php endif; ?>
                  </td>
                  <td><?= $v['size_available'] ?></td>
                  <td><?= isset($v['images_count']) ? (int)$v['images_count'] : 0 ?></td>
                  <td>
                    <a class="btn blue" href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.color_variant', null, ['variant_id' => $v['id']]); ?>">Editar</a>
                    <a class="btn red" href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'delete.color_variant', null, ['variant_id' => $v['id'], 'product_id' => $product_id]); ?>">Eliminar</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6">No se han encontrado variantes.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    $('.btn-red').click(function(e) {
      e.preventDefault();
      var url = $(this).attr('href');
      var confirmDelete = confirm('¿Estás seguro de eliminar esta variante?');
      if (confirmDelete) {
        window.location.href = url;
      }
    });
  });
</script>

<?php require Core::view('footer', 'core'); ?>