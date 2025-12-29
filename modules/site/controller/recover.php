<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador de secci�n "Recuperador" del sitio
 *
 *
 */

$page['name'] = 'Recuperador';
$page['code'] = 'siteRecover';

// OBTENER HASH
if (isset($_GET['hash']) && !empty($_GET['hash']))
{
	$id = htmlspecialchars($_GET['hash']);
	// OBTENER REGISTRO
	$recover = Core::model('db', 'core')->getColumns('site_recovers', array('member_id', 'email', 'date', 'type'), array('id', $id));
	// COMPROBAR SI EXISTE
	if ($recover['member_id'] > 0)
	{
		// COMPROBAR TIPO
		if ($recover['type'] == 1)
		{
			// GENERAR CONTRASE�A ALEATORIA
			$password = Core::model('extra', 'core')->generateUUID(10);

			// ACTUALIZAR CONTRASE�A DE USUARIO
			$passwordKey = password_hash($password, PASSWORD_DEFAULT);

			// VALIDAR CUENTA DE USUARIO
			$updated = Core::model('account', 'members')->setMemberInput($passwordKey, 'password', $recover['member_id']);
			if ($updated == true)
			{
				// ENVIAR NUEVA CONTRASE�A AL USUARIO
				$email = Core::model('email', 'core')->sendEmail('newpassword', $recover['email'], array('name' => 'usuario', 'password' => $password));
				if ($email == true)
				{
					$message[] = array('Te hemos enviado por email la nueva contraseña por favor verifica tambien en la carpeta spam de tu correo', 'success');
				}
				else
				{
					$message[] = array('No hemos podido enviarte un email con la contraseña, así que te la mostramos aquí: <strong>' . $password . '</strong>. <a href="' . Core::model('extra', 'core')->generateUrl('members', 'login') .
						'">Inicia sesión y cámbiala</a>.', 'fatal');
				}
			}
			else
			{
				$message[] = array('No se ha podido actualizar la contraseña', 'error');
			}
		}
		else
		{
			// VALIDAR CUENTA DE USUARIO
			$validate = Core::model('account', 'members')->setMemberInput($config['reg_group'], 'group_id', $recover['member_id']);
			if ($validate == true)
			{
				$message[] = array('Cuenta validada. Inicie sesión.', 'success');
			}
			else
			{
				$message[] = array('No se ha podido validar la cuenta', 'error');
			}
		}

		// ELIMINAR REGISTRO
		Core::model('db', 'core')->deleteRow('site_recovers', $id);
	}
	else
	{
		$message[] = array('No se ha encontrado ninguna petición', 'error');
	}
}
else
{
	$message[] = array('Faltan parámetros', 'error');
}

if (isset($message[0][0]))
{
	// SI ES ERROR FATAL
	if ($message[0][1] == 'fatal')
	{
		die($message[0][0]);
	}

	// ESTABLECER MENSAJE EN LA SESION
	setTI($message);

	// REDIRECCIONAR A LA HOME
	Core::model('extra', 'core')->redirectTo($config['base_url']);
}

exit;
