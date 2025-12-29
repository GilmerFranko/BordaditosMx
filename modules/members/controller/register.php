<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador del registro de usuarios
 *
 *
 */

$page['name'] = 'Registro';
$page['code'] = 'membersRegister';
// Registro desabilitado temporalmente
if (isset($_POST['register']) and false)
{
    if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['email']))
    {
        // COMPROBAR NOMBRE Y EMAIL CORRECTOS
        if (preg_match("/^([a-zA-Z ]{4,30}+)$/isu", $_POST['name'])  && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            if (strlen($_POST['password']) > 5)
            {
                if ($_POST['password'] === $_POST['confirmPassword'])
                {
                    /* Se definen y limpian las variables */
                    $memberData = array_map('htmlspecialchars', $_POST);
                    // Generar contrase&ntilde;a
                    $memberData['password'] = password_hash($memberData['password'], PASSWORD_DEFAULT);
                    // Generar sexo
                    $memberData['gender'] = in_array($memberData['gender'], array(0, 1, 2)) ? $memberData['gender'] : 0;
                    // Email
                    $memberData['email'] = strtolower($memberData['email']);
                    // Foto de perfil
                    $memberData['pp_main_photo'] = ($memberData['gender'] == 0) ? $config['default_male_profile_photo'] : $config['default_female_profile_photo'];

                    //
                    if (Core::model('member', 'members')->checkUserExists($memberData['name'], $memberData['email']) === false)
                    {
                        $memberData['member_id'] = Core::model('access', 'members')->signIn($memberData);
                        //
                        if (is_numeric($memberData['member_id']))
                        {
                            // VALIDAR CUENTA POR CORREO
                            if ($config['reg_validate'] == '1')
                            {
                                if ($hash = Core::model('access', 'members')->setRecover($memberData['member_id'], $memberData['email'], 2))
                                {
                                    /* Enviamos el email de bienvenida / confirmación */
                                    Core::model('email', 'core')->sendEmail('welcome', $memberData['email'], array('name' => $memberData['name'], 'password' => $memberData['password'], 'hash' => $hash));
                                    $message[] = array('Has sido registrado. Recibir&aacute; instrucciones en su correo electr&oacute;nico para validar la cuenta', 'success');
                                }
                                else
                                {
                                    $message[] = array('Has sido registrado. Sin embargo, no hemos podido enviar la confirmaci&oacute;n de la cuenta. Por favor, solicita una nueva', 'warning');
                                }
                            }
                            else
                            {
                                // Identifica al usuario
                                Core::model('access', 'members')->login($memberData['member_id']);
                                // Redirige a la cuenta
                                Core::model('extra', 'core')->generateUrl('members', 'account', null, null, true);
                            }
                        }
                        else
                        {
                            $message[] = array('No hemos podido registrarte', 'error');
                        }
                    }
                    else
                    {
                        $message[] = array('Ya existe un usuario registrado con este nombre, o ha ocurrido un error. Int&eacute;ntalo m&aacute;s tarde.', 'error');
                    }
                }
                else
                {
                    $message[] = array('Las contrase&ntilde;as no coinciden', 'error');
                }
            }
            else
            {
                $message[] = array('Contrase&ntilde;a: m&iacute;nimo 4 caracteres.', 'error');
            }
        }
        else
        {
            $message[] = array('Nombre o email no v&aacute;lidos.', 'error');
        }
    }
    else
    {
        $message[] = array('Debes rellenar todos los campos', 'error');
    }

    // ESTABLECER MENSAJE EN LA SESION
    setTI($message);
}
