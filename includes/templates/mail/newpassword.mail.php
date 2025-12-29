<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Plantilla de correo para enviar contraseña por email
 *
 *
 */

$subject = 'Recuperar acceso de ' . Core::config('script_name');
//
$content = 'Hola ' . $params['name'] .
    ', tu nueva contrase&ntilde;a es <strong>' . $params['password'] . '</strong> <br /> O haga <a href="' . Core::model('extra', 'core')->generateUrl('site', 'recover', null, array('hash' => $params['hash'])) .
    '">clic aqu&iacute;</a> <br /> Si no la ha solicitado, cambie su contrase&ntilde;a cuanto antes.';
