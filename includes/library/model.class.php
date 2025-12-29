<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de incluir las clases que se utilizan en todos los modelos/clases
 *
 *
 */

class Model
{
  // Base de Datos 									(opc)
  public $db;

  // Configuración 									(opc)
  public $config;

  // Sesión actual 									(opc)
  public $session;

  // Atajo a cagador de controlador (opc)
  public $cController;

  // Atajo a cagador de modelo 			(opc)
  public $cModel;

  // Atajo a cagador de vista  			(opc)
  public $cView;

  // Modulo
  public static $module = 'core';

  // Constructor
  function __construct()
  {
    global $dbconnect;
    $this->db = $dbconnect;

    /* Se obtiene y establece la configuración */
    $query = $this->db->query('SELECT * FROM `site_configuration` ORDER BY `id` DESC LIMIT 1');
    //
    if ($query == true && $query->num_rows > 0)
    {
      $config = $query->fetch_assoc();
      require BG_CONF . 'config.site.php';
      //
      $this->config = $config;
      /* Almacena en la sesion el Modo Debug */
      $_SESSION['debug_mode'] = $this->config['debug_mode'];
    }

    $dbconnect->query("SET NAMES 'utf8mb4'");


    /* Se obtiene y se establece la sesión */
  }
  static function Model($file = '')
  {
    return Core::model($file, self::$module);
  }
}
