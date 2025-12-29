<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal de la eliminación de configuraciones
 *
 *
 */

if (isset($_GET['id']))
{
    if (ctype_digit($_GET['id']))
    {
        if (Core::model('configuration', 'admin')->deleteConfig($_GET['id']) === true)
        {
            $message[] = array('Se ha eliminado la configuraci&oacute;n', 'success');
        }
        else
        {
            $message[] = array('No se pudo eliminar la configuraci&oacute;n', 'error');
        }
    }
    else
    {
        $message[] = array('Est&aacute; intentando eliminar algo extra&ntilde;o', 'error');
    }
}
else
{
    $message[] = array('Debe especificar qu&eacute; configuraci&oacute;n eliminar', 'error');
}
// ESTABLECE UN MENSAJE EN CASO DE HABERLO
Core::model('extra', 'core')->setToast($message);
// REDIRIGIR
Core::model('extra', 'core')->generateUrl('admin', 'configuration', NULL, array('delete' => $message[0][1]), true);
