<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar sesión del usuario/visitante
 *
 *
 */

class Session extends Model
{
  var $memberData = array(); // SI EL USUARIO ES MIEMBRO CARGAMOS DATOS DE LA TABLA
  var $memberGroup = array(); // SI EL USUARIO ES MIEMBRO CARGAMOS DATOS DE LA TABLA
  var $is_member = false; // EL USUARIO ESTA IDENTIFICADO?
  var $is_vip = false; // EL USUARIO ES VIP
  var $is_admod = 0; // EL USUARIO ES MODERADOR/ADMINISTRADOR?
  var $is_banned = 0; // EL USUARIO ESTÁ BANEADO?
  var $token = 0; // CÓDIGO DE SEGURIDAD IDENTIFICATIVO PARA LA SESIÓN
  var $platform = 'pc'; // PLATAFORMA POR DEFECTO

  function __construct()
  {
    parent::__construct();
    $this->session = $this->getSession();
  }


  function __destruct()
  {
  }

  function getSession()
  {
    /* En caso de no retornar datos la sesión es de visitante */
    $this->memberData = array(
      'name' => 'Visitante',
      'email' => '',
      'group_id' => '0',
      'member_id' => '0',
      'permissions' => array(),
      'newbie' => true,
      'pp_timezone' => 'Europe/Madrid',
      'ip_address' => $this->getIp(),
    );

    //
    /*if(isset($_SESSION))
        {
                $this->memberData = $_SESSION;

            // ¿ES MIEMBRO?
                $this->is_member = $this->memberData['member_id'] != '0' ? 1 : 0;
                // CóDIGO DE SEGURIDAD
                $this->token = md5('token' . $this->memberData['session']);
                // ¿ES MODERADOR - ADMINISTRADOR?
                $this->is_admod = $this->getLevel();
        }
        else*/
    if (isset($_COOKIE[$this->config['cookie_name']]))
    {
      $query = $this->db->query('SELECT m.*, g.* FROM `members` AS m LEFT JOIN `members_groups` AS g ON m.`group_id` = g.`g_id` WHERE m.`session` = \'' . $this->db->real_escape_string($_COOKIE[$this->config['cookie_name']]) . '\' && m.`banned` = 0 LIMIT 1');
      //
      if ($query == true && $query->num_rows > 0)
      {
        $this->memberData = $query->fetch_assoc();
        // PERMISOS EN UN ARRAY
        $this->memberData['permissions'] = explode(',', $this->memberData['g_permissions']);
        // ¿ESTÁ BANEADO?
        $this->is_banned = $this->memberData['banned'] > 0 ? true : false;
        // ¿ES MIEMBRO?
        $this->is_member = $this->memberData['member_id'] != '0' ? true : false;
        // CóDIGO DE SEGURIDAD
        $this->token = md5('token' . $this->memberData['session']);
        // ¿ES MODERADOR - ADMINISTRADOR?
        $this->is_admod = $this->getLevel();
        // ZONA HORARIA PREDETERMINADA
        $this->memberData['pp_timezone'] = empty($this->memberData['pp_timezone']) ? 'Europe/Madrid' : $this->memberData['pp_timezone'];
        // Mensajes sin leer
        $this->memberData['unread_messages'] = $this->getUnreadMessagesCount($this->memberData['member_id']);
        // CANTIDAD DE NOTIFICACIONES TOTALES
        $this->memberData['notifications'] = $this->getNotificationsCount($this->memberData['member_id']);
        // CANTIDAD DE DÍAS REGISTRADO
        //$this->memberData['registered_days'] = round(((time()-$this->memberData['pp_joined'])/60/60/24), 0, PHP_ROUND_HALF_DOWN);
        $this->memberData['newbie'] = $this->memberData['pp_joined'] > (time() - 259200) ? true : false;
        // ACTUALIZAR ÚLTIMA ACTIVIDAD
        $query = $this->db->query('UPDATE `members` SET `last_activity` = UNIX_TIMESTAMP() WHERE `member_id` = \'' . $this->memberData['member_id'] . '\' LIMIT 1');

        //$_SESSION = serialize($this->memberData);
      }
    }
    //
    return $this->memberData;
  }

  function getNotificationsCount($member = null)
  {
    $query = $this->db->query('SELECT COUNT(`id`) FROM `members_notifications` WHERE `to_member` = \'' . $member . '\' && `read_time` = \'0\' && `sent_time` < UNIX_TIMESTAMP() LIMIT 50');

    if ($query == true && $query->num_rows > 0)
    {
      $nots = $query->fetch_row();
      return /*$this->memberData['notifications'] + */ $nots[0];
    }

    return 0;
  }

  function getLevel()
  {
    if ($this->isAllowed('admin') === true)
    {
      return 1;
    }
    elseif ($this->isAllowed('mod') === true)
    {
      return 2;
    }
    //
    return 0;
  }

  function isAllowed($permission = null)
  {
    if ($this->is_admod === 1 || in_array($permission, $this->memberData['permissions']))
    {
      return true;
    }
    //
    return false;
  }

  function checkToken($token = '')
  {
    $token = empty($token) && isset($_GET['token']) ? $_GET['token'] : $token;
    //
    if ($token == $this->token)
    {
      return true;
    }
    //
    return false;
  }

  /**
   * Devuelve la cantidad de mensajes sin leer de un usuario.
   *
   * @param int $member_id ID del usuario.
   * @return int La cantidad de mensajes sin leer del usuario.
   */
  public function getUnreadMessagesCount($member_id)
  {
    $query = $this->db->query('SELECT COUNT(`id`) FROM `members_messages` WHERE `to_member_id` = \'' . $member_id . '\' && `is_read` = 0');

    if ($query == true && $query->num_rows > 0)
    {
      $nots = $query->fetch_row();
      return $nots[0];
    }

    return 0;
  }

  function getIp()
  {
    return isset($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
  }
}
