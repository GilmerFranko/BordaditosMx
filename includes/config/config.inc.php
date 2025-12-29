<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Configuración extra
 *
 *
 */

/* Se obtiene la configuración */
$config = Core::model('config', 'core')->getConfig();
require BG_CONF . 'config.site.php';

/* Mensaje din&aacute;mico a mostrar en plantilla */
$message = array();

/* Número de página actual */
$page['number'] = isset($_GET['page']) && ctype_digit($_GET['page']) ? $_GET['page'] : 1;

/* Se inicializa la sesión */
session_start();

// Nombre de sesion
// session_id();

// Regenerar sesion
// session_regenerate_id();


/* Zona horaria por defecto */
date_default_timezone_set('Europe/Madrid');

/* Nivel de error */
if ($config['debug_mode'] == 1)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
