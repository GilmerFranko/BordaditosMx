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

<style>
  /* Estilos personalizados para el Sidenav */
  .sidenav {
    width: 280px;
    /* Un poco más ancho para mayor comodidad */
    background-color: #212121;
    /* grey darken-4 */
    border-right: 1px solid rgba(255, 255, 255, 0.1);
  }

  /* Encabezado de Usuario */
  .sidenav .user-view {
    padding: 32px 32px 16px;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #00796b 0%, #26a69a 100%);
  }

  .sidenav .user-view .circle {
    background-color: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
    color: white;
  }

  /* Elementos de Lista */
  .sidenav li>a {
    color: #b0bec5 !important;
    /* Blue-grey lighten-3 */
    font-weight: 500;
    display: flex;
    align-items: center;
    padding: 0 32px;
    transition: all 0.3s ease;
  }

  .sidenav li>a>i.material-icons {
    color: #b0bec5 !important;
    margin-right: 16px;
    font-size: 22px;
  }

  /* Estados Active y Hover */
  .sidenav li.active {
    background-color: rgba(38, 166, 154, 0.1);
  }

  .sidenav li.active>a,
  .sidenav li>a:hover {
    color: #ffffff !important;
    background-color: rgba(255, 255, 255, 0.05);
  }

  .sidenav li.active>a>i {
    color: #26a69a !important;
    /* Color de acento */
  }

  /* Collapsible Styles */
  .sidenav .collapsible-header {
    background-color: transparent;
    border: none;
    padding: 0 32px;
  }

  .sidenav .collapsible-body {
    background-color: #1a1a1a;
  }

  .sidenav .collapsible-body li a {
    padding-left: 64px;
    font-size: 0.9rem;
  }

  /* Subheaders */
  .sidenav .subheader {
    color: #546e7a !important;
    /* Blue-grey darken-1 */
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
    font-size: 0.75rem;
    height: 40px;
    line-height: 48px;
    margin-left: 35px;
  }

  /* Badge personalizado */
  .sidenav .badge.new {
    background-color: #ff5252 !important;
    font-weight: bold;
    border-radius: 4px;
    min-width: 20px;
    height: 18px;
    line-height: 18px;
  }
</style>


<ul id="user-menu" class="sidenav <?php echo $sidenav_fixed ?>">
  <!-- Encabezado de Identidad -->
  <li>
    <div class="user-view">
      <div class="background"></div>
      <a href="#user">
        <div class="circle">A</div>
      </a>
      <a href="#name"><span class="white-text name"><?php echo $session->memberData['name']; ?></span></a>
      <a href="#email"><span class="white-text email"><?php echo $session->memberData['email']; ?></span></a>
    </div>
  </li>

  <!-- Accesos Rápidos -->
  <li>
    <a href="<?php echo gLink('core', 'home-guest'); ?>" class="waves-effect">
      <i class="material-icons">public</i> Ir a la Web
    </a>
  </li>

  <li <?php echo ($sSection == 'dashboard') ? 'class="active"' : ''; ?>>
    <a href="<?php echo gLink('admin/dashboard') ?>" class="waves-effect">
      <i class="material-icons">dashboard</i> Dashboard
    </a>
  </li>

  <li class="divider" style="margin: 8px 0; opacity: 0.1;"></li>

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