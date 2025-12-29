<?php defined('BORDAMEX') || exit;

/**
 *-------------------------------------------------------/
 * @file        modules\members\view\profile.html.php    \
 * @package     One V                                     \

 * @Description Vista del perfil de un usuario
 *
 *
 */

?>
<!-- Header -->
<?php require Core::view('head', 'core'); ?>
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<section class="">

  <div class="container">
    <div class="row">
      <!-- Tarjeta de Perfil -->
      <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm" style="border:none;">
          <div class="card-body text-center">
            <!-- Imagen de Perfil -->
            <img src="<?= $config['avatar_url'] . '/' . $profileData['pp_main_photo']  ?>" alt="Foto de perfil" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">

            <!-- Nombre de Usuario -->
            <h3 class="mt-3"><?= $profileData['pp_full_name']; ?></h3>

            <!-- Género -->
            <p class="text-muted">
              <?= $profileData['pp_gender'] == '0' ? 'Hombre' : ($profileData['pp_gender'] == '1' ? 'Mujer' : 'Otro'); ?>
            </p>

            <h5 class="card-title">Información Básica</h5>
            <p><strong>Fecha de Nacimiento:</strong> <?= $profileData['birthday']; ?></p>
            <p><strong>Última Actividad:</strong> <?= date('d M, Y H:i', $profileData['last_activity']); ?></p>

            <!-- Botón de editar (solo visible si el perfil pertenece al usuario) -->
            <?php if ($isOwner): ?>
              <a href="<?= gLink('members/account', ['r_id' => $profileData['member_id']]) ?>" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Editar Perfil
              </a>
            <?php else: ?>
              <!-- Boton enviar mensaje con icono -->
              <a href="<?= gLink('members/view.messages', ['r_id' => $profileData['member_id']]) ?>" class="btn btn-primary">
                <i class="bi bi-envelope"></i> Enviar Mensaje
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <br>
    <br>
    <!-- Anuncios del usuario -->
    <div class="preAviso mt-4"></div>
    <div class="preAviso0" style="display: <?= (isset($_COOKIE['hasAcceptedAdultContent']) ? 'block' : 'none') ?>;">
      <?php if ($threads['rows'] > 0): ?>
        <div class="card-panel green lighten-4 green-text text-darken-4 flow-text center-align">Anuncios de <?= $profileData['pp_full_name']; ?></div>
        <br>
        <?php foreach ($threads['data'] as $thread): ?>
          <?php require Core::view('thread.piece', 'forums'); ?>
        <?php endforeach ?>
      <?php else: ?>
        <div class="card">
          <div class="card-content">
            <span class="card-title">
              No hay anuncios
            </span>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>




  <!-- Modal denunciar -->
  <?php require Core::view('report.modal', 'forums'); ?>

  <!-- Modal Renovar -->
  <?php require Core::view('renovar.modal', 'forums'); ?>

  <!-- Aviso -->
  <?php require Core::view('preaviso.modal', 'forums'); ?>

  <!-- Estadisticas -->
  <?php require Core::view('stats.modal', 'forums'); ?>

  <script>
    function adjustTextLength() {
      $('.thread-content').each(function() {
        var originalText = $(this).text().trim();
        var maxLength = window.innerWidth < 768 ? 100 : originalText.length;

        if (originalText.length > maxLength) {
          var truncatedText = originalText.substring(0, maxLength) + '...';
          $(this).text(truncatedText);
        } else {
          $(this).text(originalText); // Restaurar el texto completo si es necesario
        }
      });
    }

    // Ejecutar la función al cargar la página
    adjustTextLength();

    // Recalcular al cambiar el tamaño de la ventana
    $(window).resize(function() {
      adjustTextLength();
    });
  </script>


  <!-- Tarjeta adicional para acciones futuras o más detalles -->
  <!--<div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Acciones adicionales</h5>
          <p class="text-muted">Aquí puedes agregar más detalles, enlaces o funciones relacionadas con el perfil.</p>
        </div>
      </div>
    </div>
  </div>-->
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/profile.js"></script>