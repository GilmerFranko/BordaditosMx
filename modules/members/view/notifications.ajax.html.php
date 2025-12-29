<?php defined('BORDAMEX') || exit;
/**
 * 
 * REALIZADO POR CHATGPT - NO PROBADO
 */

?>1:<div id="viewNotificationsAjax">
  <ul class="list-group list-group-flush">
    <button class="btn btn-dark btn-lg w-100 mb-3" onclick="getNotifications('close');">Cerrar</button>
    <?php
    if (!empty($photos))
    {
      foreach ($photos as $photo)
      {
        echo '<li class="list-group-item d-flex align-items-start p-3 bg-warning">
                <div class="me-3">
                  <a href="' . Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $photo['author'])) . '">
                    <img src="' . Core::model('member', 'members')->getAvatar($photo['author']) . '" alt="Avatar" class="rounded-circle" style="width: 48px; height: 48px;">
                  </a>
                </div>
                <div class="flex-grow-1">
                  <p class="mb-1">' . $photo['content'] . '</p>
                </div>
              </li>';
      }
    }

    if (!empty($notifications))
    {
      foreach ($notifications as $notification)
      {
        echo '<li class="list-group-item d-flex align-items-start p-3 ' . ($notification['read_time'] > 0 ? 'bg-light' : 'bg-primary text-white') . '" id="not' . $notification['id'] . '">
                <div class="me-3">
                  <a href="' . Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $notification['from_member'])) . '">
                    <img src="' . Core::model('member', 'members')->getAvatar($notification['from_member']) . '" alt="Avatar" class="rounded-circle" style="width: 48px; height: 48px;">
                  </a>
                </div>
                <div class="flex-grow-1">
                  <p class="mb-1">
                    ' . (empty($notification['content']) ? Core::model('notifications', 'members')->generateNotification($notification['to_member'], $notification['from_member'], $notification['not_key'], $notification['item_id'], $notification['subitem_id']) : $notification['content']) . '
                  </p>
                </div>
              </li>';
      }
    }
    else
    {
      echo '<div class="alert alert-info text-center">No hay notificaciones</div>';
    }
    ?>
  </ul>
</div>