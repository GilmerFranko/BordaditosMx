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
<li class="grey darken-4">
  <ul class="collapsible collapsible-accordion">
    <li <?php if ($sModule == 'admin')
        {
          echo ' class="active"';
        } ?>>
      <a class="collapsible-header white-text waves-effect waves-blue "><i class="material-icons white-text">settings_applications</i>Admin <i class="material-icons right white-text" style="margin-right:0;">arrow_drop_down</i></a>
      <div class="collapsible-body z-depth-1">
        <ul>
          <li><a href="#" class="waves-effect waves-blue grey-text">Sistema</a></li>
          <li <?php if ($sSection == 'configuration')
              {
                echo ' class="active"';
              } ?>>
            <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'configuration'); ?>">
              <i class="material-icons">settings</i>
              Configuraci&oacute;n
            </a>
          </li>
          <li <?php if ($sSection == 'members')
              {
                echo ' class="active"';
              } ?>>
            <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'members'); ?>">
              <i class="material-icons">group</i>
              Usuarios
            </a>
          </li>
          <li <?php if ($sSection == 'groups')
              {
                echo ' class="active"';
              } ?>>
            <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'groups'); ?>">
              <i class="material-icons">stars</i>
              Grupos
            </a>
          </li>

          <li><a href="#" class="waves-effect waves-blue grey-text">Productos</a></li>
          <li <?php if ($sSection == 'view.products')
              {
                echo ' class="active"';
              } ?>>
            <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'view.products'); ?>">
              <i class="material-icons">store</i>
              Productos
            </a>
          </li>
          <li <?php if ($sSection == 'view.orders')
              {
                echo ' class="active"';
              } ?>>
            <?php if ($pendingOrdersCount > 0)
            { ?>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'view.orders'); ?>">
                <i class="material-icons">category</i>
                Pedidos
                <span class="badge new white-text" data-badge=""><?php echo $pendingOrdersCount; ?></span>
              </a>
            <?php }
            else
            { ?>
              <a class="waves-effect waves-blue" href="<?php echo $extra->generateUrl('admin', 'view.orders'); ?>">
                <i class="material-icons">category</i>
                Pedidos
              </a>
            <?php } ?>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</li>