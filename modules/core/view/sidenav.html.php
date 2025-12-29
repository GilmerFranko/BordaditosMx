<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Archivo que incluye el ménú lateral
 *
 *
 */

$sidenav_fixed = ($sModule == 'admin' or $sModule == 'mod') ? 'sidenav-fixed' : '';
?>

<ul id="user-menu" class="sidenav <?php echo $sidenav_fixed ?>">
  <li>
    <a class="white-text" href="<?php echo gLink('core', 'home-guest'); ?>">
      <i class="material-icons">home</i>&nbsp;Ir a inicio
    </a>
  </li>
  <li>
    <a href="<?php echo gLink('admin/dashboard') ?>"><i class="material-icons">home</i>Principal</a>
  </li>
  <li class="divider" tabindex="-1"></li>

  <!-- ./MENU  -->
  <?php if ($session->is_admod == 1)
  {
    include Core::view('index.sidebar', 'admin'); // ADMINISTRACIÓN
  }
  if ($session->is_admod)
  {
    //include Core::view('index.sidebar', 'mod'); // MODERACIÓN
  } ?>

</ul>