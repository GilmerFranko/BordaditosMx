<?php defined('BORDAMEX') || exit;



$page['name'] = 'Notificaciones';
$page['code'] = 'viewNotifications';

/*if(isset($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast();
}*/

// OBTENER NOTIFICACIONES
$notifications = Core::model('notifications', 'members')->getNotifications(50);


// ELIMINAR ANTIGUAS - DE 7 D�AS (ESTA TAREA SE LE HA PUESTO AL BOT)
//Core::model('notifications', 'members')->removeOldNotifications($session->memberData['member_id'], 7);

// MARCAR COMO LE�DAS
Core::model('notifications', 'members')->setReadNotifications();

// MOSTRAR NOTIFICACIONES
if (isset($_POST['ajax']))
{
    include Core::view('notifications.ajax');
    exit;
}
