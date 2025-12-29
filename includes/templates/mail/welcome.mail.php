<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Plantilla de correo para la bienvenida al usuario
 *
 *
 */

$subject = 'Bienvenido a ' . Core::config('script_name');
//
$content = 'Hola ' . $params['name'] .
    ', enviamos este correo porque hemos recibido una petici&oacute;n para validar su cuenta en <strong>' .
    Core::config('script_name') . '</strong>. Para ello, haga <a href="' . Core::model('extra', 'core')->generateUrl('site', 'recover', null, array('hash' => $params['hash'])) .
    '">clic aqu&iacute;</a>. <br /> <br /> Si no ha solicitado la activaci&oacute;n, ignore este mensaje.';
