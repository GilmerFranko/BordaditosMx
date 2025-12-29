<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 * @Description Controlador de sección "Contacto" del sitio
 *
 */

$page['name'] = 'Contacto';
$page['code'] = 'siteContact';

if (isset($_SESSION['message']) && !empty($_SESSION['message']))
{
	echo Core::model('extra', 'core')->getTI($_SESSION['message']);
}

// SI SE RECIBE EL FORMULARIO
if (isset($_POST['contact']))
{
	// Verificar el token secreto de hCaptcha
	$secretKey = 'ES_ac505bbd560a43648780f7f59f41ce04';
	$response = $_POST['h-captcha-response'];

	// Enviar una solicitud POST para verificar el token secreto de hCaptcha
	$url = 'https://hcaptcha.com/siteverify';
	$data = array(
		'secret' => $secretKey,
		'response' => $response
	);

	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);

	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$resultJson = json_decode($result);

	// Verificar la respuesta del servidor hCaptcha
	if ($resultJson->success)
	{
		if ($session->is_member == true)
		{
			$contact['member_id'] = $session->memberData['member_id'];
			$contact['name'] = $session->memberData['name'];
			$contact['email'] = $session->memberData['email'];
		}
		else
		{
			$contact['member_id'] = 0;

			if (isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{

				$contact['name'] = Core::model('extra', 'core')->cleanVar($_POST['name']);
				$contact['email'] = Core::model('extra', 'core')->cleanVar($_POST['email']);
			}
			else
			{
				$message[] = array('Debes indicar tu nombre y email', 'error');
			}
		}
		if (isset($_POST['title']) && !empty($_POST['title']) && isset($_POST['content']) && !empty($_POST['content']))
		{
			$contact['title'] = Core::model('extra', 'core')->cleanVar($_POST['title']);
			$contact['content'] = Core::model('extra', 'core')->cleanVar($_POST['content']);

			// REGISTRAR CONTACTO SIN AVISAR POR EMAIL
			$contact = Core::model('site', 'site')->newContact($contact, false);

			// SI SE HA REGISTRADO
			if ($contact > 0)
			{
				$message[] = array('Hemos recibido tu consulta', 'success');
			}
			else
			{
				$message[] = array('No hemos podido registrar la consulta', 'error');
			}
		}
		else
		{
			$message[] = array('Debe ingresar t&iacute;tulo y mensaje', 'error');
		}
	}
	else
	{
		// Token secreto de hCaptcha inválido
		$message[] = array('Captcha inválido', 'error');
	}

	if (isset($message[0][0]))
	{
		// ESTABLECER MENSAJE EN LA SESION
		Core::model('extra', 'core')->setTI($message);

		if ($message[0][1] == 'success')
		{
			// REDIRECCIONAR
			//Core::model('extra', 'core')->generateUrl('members', 'account', NULL, NULL, true);
		}
	}
}
