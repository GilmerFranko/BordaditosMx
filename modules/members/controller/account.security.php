<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador de sección "Contraseña" en la cuenta
 *
 *
 */

// ACTUALIZAR EMAIL
// if ($session->memberData['email'] !== $_POST['email'])
// {
//     // Comprobar formato del email
//   if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
//   {
//     if (Core::model('member', 'members')->checkUserExists($session->memberData['name'], $_POST['email']) === false)
//     {
//       if( Core::model('account', 'members')->setMemberInput($_POST['email'], 'email', $session->memberData['member_id']) === true)
//       {
//         $message[] = array(
//           'Email actualizado',
//           'success'
//         );
//       }
//     }
//     else
//     {
//       $message[] = array(
//         'El email ya est&aacute; en uso',
//         'error'
//       );
//     }
//   }
//   else
//   {
//     $message[] = array(
//       'El email es incorrecto',
//       'error'
//     );
//   }
// }
// ACTUALIZAR PASSWORD
if (isset($_POST['currentPassword']) && !empty($_POST['currentPassword']))
{
  if (!empty($_POST['newPassword']) && !empty($_POST['confirmPassword']))
  {
    if (strlen($_POST['newPassword']) >= 6)
    {
      if ($_POST['newPassword'] == $_POST['confirmPassword'])
      {
        // Verificar que la contraseña actual sea la introducida
        if (password_verify($_POST['currentPassword'], $session->memberData['password']) === true)
        {
          if (Core::model('account', 'members')->setMemberInput(password_hash($_POST['newPassword'], PASSWORD_DEFAULT), 'password', $session->memberData['member_id']) === true)
          {
            $message[] = array(
              'Contraseña actualizada',
              'success'
            );
          }
          else
          {
            $message[] = array(
              'No se ha podido guardar la contraseña',
              'error'
            );
          }
        }
        else
        {
          $message[] = array(
            'La contraseña actual introducida es incorrecta',
            'error'
          );
        }
      }
      else
      {
        $message[] = array(
          'La nueva contraseña no coincide',
          'error'
        );
      }
    }
    else
    {
      $message[] = array(
        'La nueva contraseña debe tener al menos 6 caracteres',
        'error'
      );
    }
  }
  else
  {
    $message[] = array(
      'Para actualizar la contraseña debe rellenar todos los campos',
      'error'
    );
  }
}
