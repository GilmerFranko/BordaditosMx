<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para editar el section "Hero"
 *
 */

$page['name'] = 'Editar imagen de Sección Principal';
$page['code'] = 'adminEditSectionHero';


if (isset($_GET['save']))
{
  $msg = [];

  if (!isset($_FILES['image_section']) or $_FILES['image_section']['error'] != 0)
  {
    $msg[] = 'Debes introducir una imagen';
  }

  if (empty($msg))
  {
    // Optener la imagen antigua si existe
    $img = getColumns('configuration', ['id', 'image_section'], ['id', 1]);

    // Borrar la image
    if (isset($img['image_section']) && !empty($img['image_section']))
    {
      loadClass('core/extra')->deleteImage($img['image_section'], $config['products_path']);
    }
    else
    {
      //$msg[] = 'No se ha podido encontrar la imagen de la sección principal.';
    }

    // Guardar la nueva imagen
    $image_url = loadClass('core/extra')->uploadImage($_FILES['image_section'], $config['products_path']);

    if ($image_url)
    {
      // Actualizar la imagen en la bd
      if ($db->smartInsert('configuration', ['image_section' => $image_url], ['id', 1]))
      {
        $msg[] = 'La imagen se ha actualizado correctamente';
      }
      else
      {
        $msg[] = 'No se ha podido actualizar la imagen';
      }
    }
    else
    {
      $msg[] = 'No se ha podido cargar la imagen';
    }
    setToast([$msg]);
    redirect('admin/configuration');
    exit;
  }
  else
  {
    setToast([$msg]);
    redirect('admin/configuration');
    exit;
  }
}


$img = [];

// Optiene la imagen
if (!$img = getColumns('configuration', ['id', 'image_section'], ['id', 1]))
{
  setToast([['No se ha podido encontrar la imagen de la sección principal.']]);
  redirect('admin/configuration');
  exit;
}
