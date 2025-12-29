<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador del cierre de sesión
 *
 *
 */

// COMPROBAR TOKEN
if (isset($_GET['get_token']))
{
	Core::model('access', 'members')->logout($session->memberData['member_id']);

	// REDIRIGIR
	Core::model('extra', 'core')->generateUrl('members', 'login', null, null, true);
}
if (isset($_GET['token']))
{
	if ($session->checkToken($_GET['token']) === true)
	{
		// CERRAR SESION
		Core::model('access', 'members')->logout($session->memberData['member_id']);

		// REDIRIGIR
		Core::model('extra', 'core')->generateUrl('core', 'home-guest', null, null, true);
	}
}
else
{
	$message[] = array('Token incorrecto', 'error');

	// ESTABLECER MENSAJE EN LA SESION
	$extra->setToast($message);

	// REDIRIGIR
	Core::model('extra', 'core')->generateUrl('members', 'profile', null, array('user' => $session->memberData['member_id'], 'save' => 'success'), true);
}
