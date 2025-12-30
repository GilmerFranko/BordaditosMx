<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista del listado de productos para el admin (área/ajax)
 *
 */
require Core::view('head', 'core');
?>


<section id="sectionProducts">
  <h1 class="center-align margin-top margin-bottom" style="margin-top: 20px; margin-bottom: 20px;">Listado de productos</h1>


  <div class="fixed-action-btn-top">
    <a href="<?php echo gLink('admin/new.product') ?>" class="btn grey darken-4">
      <i class="material-icons">add</i>Agregar producto
    </a>
  </div>
  <br>
  <div id="contentProducts">
    <table class="striped responsive-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Slug</th>
          <th>Precio</th>
          <th>Activo</th>
          <th>Registrado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($products['data']) && is_array($products['data']))
        {
          foreach ($products['data'] as $prod)
          { ?>
            <tr id="product_<?php echo $prod['id']; ?>">
              <td><?php echo $prod['id']; ?></td>
              <td><?php echo Core::model('extra', 'core')->getHighlight($search, $prod['name']); ?></td>
              <td><?php echo htmlspecialchars($prod['slug']); ?></td>
              <td><?php echo isset($prod['sale_price']) ? $prod['sale_price'] : ''; ?></td>
              <td><?php echo ($prod['status'] == 1) ? 'Sí' : 'No'; ?></td>
              <td><?php echo isset($prod['created_at']) ? Core::model('date', 'core')->getTimeAgo($prod['created_at']) : ''; ?></td>
              <td>
                <div class="inline">
                  <a href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'edit.product', null, array('product_id' => $prod['id'])); ?>" title="Editar"><i class="material-icons">edit</i></a>
                  <a href="<?= gLink('admin/delete.product', ['product_id' => $prod['id']]) ?>"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?');"
                    title="Eliminar">
                    <i class="material-icons">delete</i>
                  </a>
                </div>
              </td>
            </tr>
        <?php }
        }
        else echo '<tr><td colspan="7">No hay resultados</td></tr>'; ?>
      </tbody>
    </table>
    <div class="fixed-action-btn">
      <a class="btn-floating btn-large grey darken-4" href="#" onclick="admin.forms.get('Product', 0); return false;">
        <i class="large material-icons">add</i>
      </a>
    </div>
    <!--paginador-->
    <?php if (isset($products['pages'])) echo $products['pages']['paginator']; ?>
    <!--fin_paginador-->
  </div>
</section>

<script>

</script>


<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js" />
</script>