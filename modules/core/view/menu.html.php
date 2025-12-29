<?php defined('BORDAMEX') || exit;

?>

<!-- Header -->
<header class="" style="background-color: var(--pink-primary);">
  <div class="container header-pink">
    <div class="container-fluid">
      <?php if ($session->is_admod == 1) : ?>
        <a class="nav-link active d-inline" href="<?php echo $extra->generateUrl('admin', 'configuration') ?>" role="tab" aria-controls="config-tab-pane" aria-selected="true">Configuraci&oacuten -</a>
        <a class="nav-link active d-inline" href="<?php echo $extra->generateUrl('members', 'account') ?>" role="tab" aria-controls="config-tab-pane" aria-selected="true">Cuenta</a>
      <?php endif; ?>
      <div class="d-flex justify-content-between align-items-center py-3 px-3">
        <a href="<?= gLink('core', 'home') ?>" style="text-decoration: none;">
          <div class="d-flex align-items-center">
            <div class="logo-circle me-2">
              <i class="bi bi-infinity"></i>
            </div>
            <div class="brand-text">
              <div class="fw-bold">Desaf&iacuteos Mexico</div>
              <div class="small">Web Oficial</div>
            </div>
          </div>
        </a>
        <!-- Search Bar -->
        <form action="<?= gLink('core/home-guest') ?>">
          <div id="search_container_1" class="search-container">
            <div class="container">
              <div class="search-bar">
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Buscar modelo">
              </div>
            </div>
          </div>
        </form>
        <div class="home-icon">
          <a href="<?= gLink('core', 'home') ?>" class="mx-1"><i class="bi bi-house-fill"></i></a>
          <?php if ($session->is_member == 1) : ?>
            <!-- Logout -->
            <a href="<?= Core::model('extra', 'core')->generateUrl('members', 'logout', null, ['token' => $session->token]); ?>" class="mx-1"><i class="bi bi-box-arrow-right"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <form action="<?= gLink('core/home-guest') ?>"></form>
    <!-- Search Bar -->
    <div id="search_container_2" class="search-container">
      <div class="container">
        <div class="search-bar">
          <i class="bi bi-search"></i>
          <input type="text" name="search" placeholder="Buscar modelo">
        </div>
      </div>
    </div>
    </
      </div>
</header>