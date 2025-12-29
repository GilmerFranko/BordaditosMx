<?php defined('BORDAMEX') || exit; ?>

<?php require Core::view('head', 'core'); ?>
<?php require Core::view('menu', 'core'); ?>

<!-- Body -->
<section id="viewNotifications" class="first-section">
  <div class="alert alert-success text-center mb-4">
    <h5 class="m-0">Notificaciones</h5>
  </div>

  <ul class="list-group list-group-flush">
    <?php if (!empty($notifications)): ?>
      <?php foreach ($notifications as $notification): ?>
        <?php
        // Verificación si la notificación es de la administración
        $isAdminNotification = ($notification['from_member'] == 0);
        $avatarUrl = $isAdminNotification
          ? '<img src="' . $config['images_url'] . '/engranaje.webp" alt="Admin Icon" class="rounded-circle" style="width: 48px; height: 48px;">'  // Imagen de engranaje
          : '<img src="' . $config['avatar_url'] . DS . Core::model('member', 'members')->getAvatar($notification['from_member']) . '" alt="Avatar" class="rounded-circle" style="width: 48px; height: 48px;">';
        ?>

        <li class="list-group-item d-flex align-items-start p-3 <?php echo ($notification['read_time'] > 0 ? 'bg-light' : ''); ?>" id="not<?php echo $notification['id']; ?>">
          <div class="me-3">
            <?php echo $avatarUrl; ?>
          </div>
          <div class="flex-grow-1">
            <p class="mb-1">
              <?php
              echo (empty($notification['content'])
                ? Core::model('notifications', 'members')->generateNotification($notification['to_member'], $notification['from_member'], $notification['not_key'], $notification['item_id'], $notification['subitem_id'])
                : $notification['content']);
              ?>
            </p>
            <small class="text-muted">
              <?php echo Core::model('date', 'core')->getFormattedDate($notification['sent_time']); ?>
            </small>
          </div>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="alert alert-info text-center">No hay notificaciones</div>
    <?php endif; ?>
  </ul>
</section>
<!-- / Body -->

<?php require Core::view('footer', 'core'); ?>