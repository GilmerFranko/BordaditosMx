<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal para acceder al sitio como un usuario concreto
 *
 *
 */

if (isset($_GET['user']) && ctype_digit($_GET['user']) && isset($_GET['token']))
{
    if ($session->checkToken($_GET['token']) === true)
    {
        if (Core::model('access', 'members')->login($_GET['user']) === true)
        {
            Core::model('extra', 'core')->generateUrl('members', 'account', null, null, true);
            //$message = array('Identificado correctamente', 'success');
        }
        else
        {
            $message = array('Error al identificar', 'error');
        }
    }
    else
    {
        $message = array('El token de seguridad es incorrecto', 'error');
    }
}
else
{
    $message = array('Falta el ID de usuario', 'error');
}

if ($message[1] === 'error')
{
    // ESTABLECE UN MENSAJE EN CASO DE HABERLO
    Core::model('extra', 'core')->setToast($message);
    // REDIRIGIR
    Core::model('extra', 'core')->generateUrl('admin', 'members', NULL, array('default' => $message[1]), true);
}
