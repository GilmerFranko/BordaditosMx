<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal del perfil
 *
 *
 */
if (isset($_GET['user']) && ctype_digit($_GET['user']))
{
    $user = escape($_GET['user']);
    // SE ASOCIA LA INFORMACIÓN DEL PERFIL
    $profileData = Core::model('profile', 'members')->getMemberProfile($user);
    //
    if (is_array($profileData))
    {
        // COMPROBAR SI ME TIENE BLOQUEADO
        if (Core::model('profile', 'members')->checkBlock($session->memberData['member_id'], $profileData['member_id']) === false)
        {

            // ESTABLECE EL TÍTULO DE LA PÁGINA
            $page['name'] = 'Perfil de ' . $profileData['name'];
            $page['code'] = 'memberProfile';

            $isOwner = ($profileData['member_id'] == $session->memberData['member_id']);

            if (!$threads = loadClass('forums/threads')->getThreadsByProfileId($profileData['member_id']))
            {
                $msg[] = 'No hay anuncios para mostrar';
            }

            if (!empty($msg))
            {
                setTI([$msg]);
                redirect('core/home-guest');
                exit;
            }
        }
        else
        {
            $message[] = array('El usuario no aparece', 'error');
        }
    }
    else
    {
        $message[] = array('El usuario no existe', 'error');
    }
    //
    if (!empty($message[0][0]))
    {
        require BG_TEMPLATES . 'error' . DS . '404.php';
    }
}
else
{
    // Si estoy registrado, me redirige a mi perfil, pero si no, me redirige a la pagina principal
    if ($session->is_member == true)
    {
        Core::model('extra', 'core')->generateUrl('members', 'profile', NULL, array('user' => $m_id), true);
    }
    else
    {
        Core::model('extra', 'core')->redirectTo(Core::config('base_url'));
    }
}
