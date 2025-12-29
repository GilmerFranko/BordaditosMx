<?php defined('BORDAMEX') || exit;

class Notifications extends Session
{
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    /**
     * Obtiene las notificaciones de un usuario
     * 
     * @param int $limit
     * @param int $member
     * @return array
     */
    function getNotifications($limit = 10, $member = 0)
    {
        $member = empty($member) ? $this->session->memberData['member_id'] : $member;
        // CONSULTA A BD
        $query = $this->db->query('SELECT * FROM `members_notifications` WHERE `to_member` = \'' . $member . '\' && `sent_time` < UNIX_TIMESTAMP() ORDER BY `sent_time` DESC LIMIT ' . $limit);

        // RESETEAR NOTIFICACIONES
        $this->db->query('UPDATE `members` SET `notifications` = \'0\' WHERE `member_id` = \'' . $member . '\' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            while ($row = $query->fetch_assoc())
            {
                // CONVERTIR EN TEXTO
                $row['content'] = empty($row['content']) ? $this->generateNotification($row['to_member'], $row['from_member'], $row['not_key'], $row['item_id'], $row['subitem_id']) : $row['content'];
                $notification[] = $row;
            }

            return $notification;
        }
        //
        return false;
    }

    /**
     * Obtiene las fotos regaladas a un usuario
     * 
     * @param int $limit
     * @param int $member
     * @return array
     */
    function getPhotos($limit = 10)
    {
        // OBTENER LAS FOTOS QUE HAN REGALADO DE LAS AUTORAS QUE SIGO
        $query = $this->db->query('SELECT p.*, f.`follow_id` FROM `photos` AS p LEFT JOIN `members_follows` AS f ON p.`author` = f.`follow_to` WHERE f.`follow_from` = \'' . $this->session->memberData['member_id'] . '\' && p.`date_expires` > UNIX_TIMESTAMP() ORDER BY p.`id` DESC LIMIT ' . $limit);

        // GENERAR TEXTO DE LAS NOTIFICACIOENS
        if ($query == true && $query->num_rows > 0)
        {
            while ($row = $query->fetch_assoc())
            {
                // CONVERTIR EN TEXTO
                $row['content'] = $this->generateNotification($this->session->memberData['member_id'], $row['author'], 'photoGift', $row['id']);
                $notification[] = $row;
            }

            return $notification;
        }
        //
        return false;
    }

    /**
     * Se marcan como le�das las notificaciones de un usuario
     * 
     * @param int $member
     * @return boolean
     */
    function setReadNotifications($member = 0)
    {
        $member = empty($member) ? $this->session->memberData['member_id'] : $member;
        // CONSULTA A BD
        $query = $this->db->query('UPDATE `members_notifications` SET `read_time` = UNIX_TIMESTAMP() WHERE `to_member` = \'' . $member . '\' && `sent_time` < UNIX_TIMESTAMP()');

        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Se eliminan las notificaciones antiguas
     * 
     * @param int $member
     * @param int $days
     * @param boolean $all // Elimina todas o s�lo las le�das
     * @return boolean
     */
    function removeOldNotifications($member = 0, $days = 7, $all = false)
    {
        $member = empty($member) ? $this->session->memberData['member_id'] : $member;
        $time = time() - ($days * 86400); //24*60*60
        // CONSULTA A BD
        $query = $this->db->query('DELETE `members_notifications` WHERE `to_member` = \'' . $member . '\' && `' . ($all == true ? 'sent' : 'read') . '_time` < \'' . $time . '\' ');

        echo 'DELETE `members_notifications` WHERE `to_member` = \'' . $member . '\' && `' . ($all == true ? 'sent' : 'read') . '_time` < \'' . $time . '\' ';
        exit;

        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Se registra una notificaci�n
     * 
     * @param int $to_member
     * @param int $from_member
     * @param string $key
     * @param int $item
     * @param int $subitem
     * @param text $content
     * @param boolean $myself (soy yo)
     * @param boolean $check (comprobar si ya existe)
     * @param int $time (Fecha de notificaci�n)
     * @return boolean
     */
    function newNotification($to_member = null, $from_member = null, $key = 'general', $item = 0, $subitem = 0, $content = '', $myself = false, $check = false, $time = 'UNIX_TIMESTAMP()')
    {
        // EVITAR ENVIARME A M� MISMO
        //if($to_member != $from_member || $myself == true)
        if (true)
        {
            // GENERAR TEXTO DE NOTIFICACI�N
            //$content = $this->generateNotification($to_member, $from_member, $key, $item, $subitem);
            $content = '';

            // COMPROBAR SI YA EXISTE EN UN PERIODO DE UN MINUTO
            if ($check == true)
            {
                //$qcheck = $this->db->query('SELECT `id` FROM `members_notifications` WHERE `to_member` =  \''.$to_member.'\' && `from_member` = \''.$from_member.'\' && `not_key` = \'' . $this->db->real_escape_string($key) . '\' && `item_id` = \''.$item.'\' && `subitem_id` = \''.$subitem.'\' && `sent_time` > '.(time()-60).' LIMIT 1');
                $qcheck = $this->db->query('SELECT `id` FROM `members_notifications` WHERE `to_member` = \'' . $to_member . '\' && `sent_time` > ' . (time() - 60) . ' && `content` =  \'' . $this->db->real_escape_string($content) . '\' LIMIT 1');

                if ($qcheck->num_rows > 0)
                {
                    return true;
                }
            }

            // CONSULTA A BD
            $query = $this->db->query('INSERT INTO `members_notifications` (`to_member`, `from_member`, `not_key`, `item_id`, `subitem_id`, `content`, `sent_time`) VALUES (\'' . $to_member . '\', \'' . $from_member . '\', \'' . $this->db->real_escape_string($key) . '\', \'' . $item . '\', \'' . $subitem . '\', \'' . $this->db->real_escape_string($content) . '\', ' . $time . ') ');

            if ($query == true)
            {
                // SUMAR ESTAD�STICA A USUARIO
                $this->db->query('UPDATE `members` SET `notifications` = `notifications` + 1 WHERE `member_id` = \'' . $to_member . '\' LIMIT 1');

                // Envia notificaion por email //
                $to_member1 = getColumns('members', ['name', 'email'], ['member_id', $to_member]); //Core::model('extra', 'core')->getMemberData($to_member);
                $content = $this->generateNotification($to_member, $from_member, $key, $item, $subitem);
                loadClass('core/email')->sendEmail('notification', $to_member1['email'], array('to_member' => $to_member1, 'content' => $content));

                // TODO BIEN
                return true;
            }
        }
        //
        return false;
    }

    /**
     * Genera HTML de notificacion
     * 
     * @param int $to_member
     * @param int $from_member
     * @param string $key
     * @param int $item
     * @param int $subitem
     * @return string
     */
    function generateNotification($to_member = null, $from_member = null, $key = 'general', $item = 0, $subitem = 0)
    {
        $url['users'] = Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => '%1$s'));
        $url['photos'] = Core::model('extra', 'core')->generateUrl('site', 'photo', null, array('id' => '%1$s'));
        $url['deposit'] = Core::model('extra', 'core')->generateUrl('wallet', 'view_deposit', null, array('deposit_id' => '%1$s'));
        $url['withdrawal'] = Core::model('extra', 'core')->generateUrl('wallet', 'view_withdrawals', null, array('withdrawal_id' => '%1$s'));
        $msg = 'Contenido desconocido';
        switch ($key)
        {
            case 'general':
                $msg = 'Contenido perdido';
                break;
            // NUEVO SHOUT

            // NUEVA COMPRA
            case 'newBuy':
                $msg = 'Has comprado %1$s cr&eacute;ditos';
                break;

            // Pago rechazado al intentar renovar hilo, fondo insuficiente
            case 'renewalFail':
                $url['thread'] = loadClass('forums/threads')->getThreadUrl($item);
                $msg = 'No se ha podido renovar tu <a href="' . $url['thread'] . '">anuncio</a>. Fondos insuficientes';
                break;
            case 'renewalSuccess':
                $url['thread'] = loadClass('forums/threads')->getThreadUrl($item);
                $msg = 'Tu <a href="' . $url['thread'] . '">anuncio</a> ha sido renovado';
                break;
            case 'spamInThread':
                $url['thread'] = loadClass('forums/threads')->getThreadUrl($item);
                $msg = 'Tu <a href="' . $url['thread'] . '">anuncio</a> está  siendo revisado por posible spam, te notificaremos el resultado de nuestra revisión lo más pronto posible';
                break;
        }
        $msg = sprintf($msg, $item, $subitem);
        return $msg;
    }
}
