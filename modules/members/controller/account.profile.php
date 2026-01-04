<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador de sección "Perfil" en la cuenta
 *
 *
 */

// ELEGIR NOMBRE COMPLETO
$profile['full_name'] = empty($_POST['full_name']) ? '' : htmlspecialchars($_POST['full_name']);
// SELECCIONAR ZONA HORARIA
$profile['timezone'] = empty($_POST['timezone']) ? 'America/Mexico_City' : $_POST['timezone'];
//
if (Core::model('account', 'members')->saveProfile($profile, $session->memberData['member_id']) === true)
{
    if (empty($message))
    {
        $message[] = array(
            'Información actualizada',
            'success'
        );
    }
}
else
{
    $message[] = array(
        'No se pudieron guardar algunos cambios',
        'error'
    );
}
