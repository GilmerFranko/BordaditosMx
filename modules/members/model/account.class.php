<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar la configuración de la cuenta
 *
 *
 */

class Account extends Model
{

  public function __construct()
  {
    parent::__construct();
    $this->session = Core::model('session', 'core');
  }

  function __destruct()
  {
  }
  /**
   * Actualiza un único campo del usuario
   *
   * @param mixed   $value
   * @param string  $column
   * @param integer $member_id
   * @return boolean
   */
  function setMemberInput($value = NULL, $column = NULL, $member_id = 0)
  {
    $query = $this->db->query('UPDATE `members` SET `' . $column . '` = \'' . $this->db->real_escape_string($value) . '\' WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');
    //
    if ($query == true)
    {
      //unset($this->session[$column]);
      //$this->session[$column] = $value;
      //
      return true;
    }
    //
    return false;
  }

  /**
   * Actualiza las preferencias del perfil
   *
   * @param array   $values
   * @param integer $member_id
   * @return boolean
   */
  function saveProfile($values = array(), $member_id = 0)
  {
    $updates = Core::model('extra', 'core')->getIUP($values, 'pp_');
    //
    $query = $this->db->query('UPDATE `members` SET ' . $updates . ' WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');
    //
    if ($query == true)
    {
      return true;
    }
    //
    return false;
  }

  /**
   * Generar Selector de zona horaria
   *
   * @param string $selected (Selección predeterminada)
   * @return string / html
   */
  function getTimezones($selected = 'America/Los_Angeles')
  {
    $timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    // INICIAR SELECT
    $select = '<select name="timezone" id="timezone" class="browser-default">';
    foreach ($timezones as $timezone)
    {
      $select .= '<option value="' . $timezone . '" ' . ($selected == $timezone ? 'selected' : '') . '>' . $timezone . '</option>';
    }
    // FINALIZAR SELECT
    $select .= '</select>';

    // RETORNAR SELECT
    return $select;
  }


  /**
   * Genera el enlace del avatar de un usuario
   *
   * @param mixed    $value
   * @param integer  $type
   * @return string
   */
  function generateAvatar($value = 0, $thumb = '', $type = 0, $error = false)
  {
    if ($type === 0) // Subido desde el ordenador
    {
      $thumb = (!empty($thumb) ? '_thumb' : '');
      $avatar = $this->config['avatar_path'] . '/' . $value . $thumb . '.jpg';
      //
      if (file_exists($avatar))
      {
        return $value . $thumb . '.jpg?_r=' . time();
      }
      else
      {
        $message = 'El avatar no existe';
      }
    }
    elseif ($type === 1) // Mediante enlace
    {
      if (filter_var($value, FILTER_VALIDATE_URL))
      {
        $avatar_size = getimagesize($value);
        //
        if (!empty($avatar_size) && $avatar_size[0] > $this->config['avatar_min_x'] && $avatar_size[1] > $this->config['avatar_min_y'] && $avatar_size[0] < $this->config['avatar_max_x'] && $avatar_size[1] < $this->config['avatar_max_y'])
        {
          return $value;
        }
        else
        {
          $message = 'El avatar debe tener una dimensi&oacute;n de entre ' . $this->config['avatar_min_x'] . 'x' . $this->config['avatar_min_y'] . 'px y ' . $this->config['avatar_max_x'] . 'x' . $this->config['avatar_max_y'] . 'px';
        }
      }
      else
      {
        $message = 'La URL es inv&aacute;lida';
      }
    }
    elseif ($type === 2) // Obtenido con Gravatar
    {
      return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($value))) . '?s=200&r=g&d=identicon';
    }
    //
    if ($error === true)
    {
      return $message;
    }
    //
    return 'default_avatar.png';
  }

  /**
   * Registra en la base de datos el avatar de un usuario
   *
   * @param mixed    $value
   * @param integer  $type
   * @param integer  $member_id
   * @return string
   */
  function setAvatar($value = '', $thumb = '', $type = 2, $member_id = 0)
  {
    $query = $this->db->query('UPDATE `members` SET `pp_main_photo` = \'' . $this->db->real_escape_string($value) . '\', `pp_thumb_photo` = \'' . $this->db->real_escape_string($thumb) . '\', `pp_photo_type` = \'' . $type . '\' WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');
    //
    if ($query == true)
    {
      return true;
    }
    //
    return false;
  }

  /**
   * Sube el avatar mediante el PC
   *
   * @param array    $avatar
   * @param integer  $member_id
   * @return array with string and integer values
   */
  function uploadAvatar($avatar = array(), $member_id = 0)
  {

    $size = getimagesize($avatar['tmp_name']);
    //

    if ($avatar['type'] == 'image/jpeg' || $avatar['type'] == 'image/png')
    {
      // Crear miniatura 50x50 comprimida un 15%
      $avatar_thumb = Core::model('images', 'core')->resize($avatar['tmp_name'], $this->config['avatar_path'] . '/' . $member_id . '_thumb.jpg', 85, 150, 150);

      // Comprimir y redimensionar imagen original
      $avatar = Core::model('images', 'core')->resize($avatar['tmp_name'], $this->config['avatar_path'] . '/' . $member_id . '.jpg', 30, 500, 500);


      if ($avatar == true && $avatar_thumb == true)
      {
        if (Core::model('account', 'members')->setAvatar(Core::model('account', 'members')->generateAvatar($member_id), Core::model('account', 'members')->generateAvatar($member_id, true), 0, $member_id) === true)
        {
          $message = array('Avatar actualizado', 'success');
        }
        else
        {
          $message = array('Avatar subido, pero no actualizado', 'warning');
        }
      }
      else
      {
        $message = array('No se pudo subir el avatar', 'error');
      }
    }
    else
    {
      $message = array('Extensión ' . $avatar['type'] . ' no permitida (Sólo JPG y PNG)', 'error');
    }

    //
    return $message;
  }
}
