<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista del sidebar de la administración
 *
 *
 */
$pendingOrdersCount = loadClass('admin/order')->getPendingOrdersCount();
?>
<style>
  .new-alert .material-icons {
    animation: growShrinkRotate 3s infinite;
    color: white !important;
  }

  .new-alert {
    color: white !important;
  }

  @keyframes growShrinkRotate {
    0% {
      transform: scale(1) rotate(0deg);
    }

    50% {
      transform: scale(1.2) rotate(180deg);
    }

    100% {
      transform: scale(1) rotate(360deg);
    }
  }
</style>
<!-- Menú Colapsable Admin -->
<li class="no-padding">
  <ul class="collapsible collapsible-accordion">
    <li <?php echo ($sModule == 'admin') ? 'class="active"' : ''; ?>>
      <a class="collapsible-header waves-effect">
        <i class="material-icons">settings_suggest</i> Gestión Admin
        <i class="material-icons right" style="margin-right:0;">expand_more</i>
      </a>
      <div class="collapsible-body">
        <ul>
          <!-- Sección Sistema -->
          <li>
            <div class="subheader">Sistema</div>
          </li>
          <li <?php echo ($sSection == 'configuration') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'configuration'); ?>">
              <i class="material-icons">settings</i> Configuración
            </a>
          </li>
          <li <?php echo ($sSection == 'members') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'members'); ?>">
              <i class="material-icons">group</i> Usuarios
            </a>
          </li>
          <li <?php echo ($sSection == 'groups') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'groups'); ?>">
              <i class="material-icons">stars</i> Grupos
            </a>
          </li>

          <li>
            <div class="divider" style="opacity: 0.05;"></div>
          </li>

          <!-- Sección Diseño -->
          <li>
            <div class="subheader">Apariencia</div>
          </li>
          <li <?php echo ($sSection == 'edit.section-hero') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'edit.section-hero'); ?>">
              <i class="material-icons">wallpaper</i> Foto Portada
            </a>
          </li>

          <li>
            <div class="divider" style="opacity: 0.05;"></div>
          </li>

          <!-- Sección Catálogo -->
          <li>
            <div class="subheader">Tienda</div>
          </li>
          <li <?php echo ($sSection == 'view.products') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'view.products'); ?>">
              <i class="material-icons">shopping_bag</i> Productos
            </a>
          </li>
          <li <?php echo ($sSection == 'view.orders') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'view.orders'); ?>">
              <i class="material-icons">receipt_long</i> Pedidos
              <?php if ($pendingOrdersCount > 0): ?>
                <span class="badge new white-text"><?php echo $pendingOrdersCount; ?></span>
              <?php endif; ?>
            </a>
          </li>
          <li <?php echo ($sSection == 'top20') ? 'class="active"' : ''; ?>>
            <a href="<?php echo $extra->generateUrl('admin', 'top20'); ?>">
              <i class="material-icons">analytics</i> Reporte Top 20
            </a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</li>