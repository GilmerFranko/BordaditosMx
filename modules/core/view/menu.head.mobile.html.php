<!-- Cuenta -->
<div class="menu-head-left-mobile" style="display:none">
  <div class="menu-member">
    <?php if ($session->is_member): ?>
      <!-- Menu para miembros -->
      <!-- Cuenta -->
      <div class="dropdown btn btn-head-mobile">
        <a class="dropdown-toggle align-items-center" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
          <!-- Imagen del usuario -->
          <img src="<?= $config['avatar_url'] . '/' . $session->memberData['pp_main_photo']  ?>" alt="Imagen de perfil" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; margin-right: 8px;margin-bottom:4px" class="d-inline-block">

          <!-- Nombre del usuario (se oculta en pantallas pequeñas) -->
          <span class="d-none d-md-inline">
            <?php echo strtoupper($session->memberData['name']); ?>
          </span>
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
          <!-- MI CUENTA -->
          <li>
            <a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'profile'); ?>">Mi perfil</a>
          </li>
          <li>
            <a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('wallet', 'my_transactions'); ?>">Monedero</a>
          </li>
          <!-- Mis anuncios -->
          <li>
            <a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('mi-panel', 'anuncios'); ?>">Mis anuncios</a>
          </li>
          <!-- Favoritos -->
          <li>
            <a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('anuncios', 'favoritos'); ?>">Favoritos</a>
          </li>
          <li>
            <a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'account'); ?>">Mi cuenta</a>
          </li>
          <hr>
          <!-- CONFIGURACION (solo para admins) -->
          <?php if (loadClass('admin/members')->isAdmod($m_id) == 1): ?>
            <li><a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'configuration'); ?>">Configuraci&oacuten</a></li>
          <?php endif; ?>
          <hr>
          <!-- CERRAR SESION -->
          <li>
            <a class="dropdown-item" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'logout', null, ['token' => $session->token]); ?>">Salir</a>
          </li>
        </ul>


        <!-- Notificaciones -->
        <a class="btn btn-sm justify-content-center" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'notifications'); ?>">
          <i class="material-icons">notifications</i>
          <?php if ($session->memberData['notifications'] > 0)
          {
            echo "(" . $session->memberData['notifications'] . ")";
          } ?>
        </a>
        <!-- Mensajes -->
        <?php if (!isset($session->memberData['unread_messages']) or $session->memberData['unread_messages']  <= 0): ?>
          <a class="btn btn-sm justify-content-center" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'messages'); ?>">
            <i class="material-icons">mail</i>
          </a>
        <?php else: ?>
          <!-- Si hay mensajes sin leer -->
          <a class="btn btn-sm justify-content-center dark" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'messages'); ?>">
            <i class="material-icons">mail</i>
            <?php echo $session->memberData['unread_messages']; ?>
          </a>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <!-- Menu para no miembros -->

      <a class="btn btn-sm d-flex justify-content-center dark btn-head-mobile" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'login'); ?>"><strong>INICIAR&nbsp;SESION</strong>
      </a>
      <a class="btn btn-sm d-flex justify-content-center dark btn-head-mobile" href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'register'); ?>"><strong>REGISTRO</strong></a>

    <?php endif; ?>
  </div>
</div>