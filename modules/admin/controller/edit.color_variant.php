<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para editar una variante de color
 *
 */

$page['name'] = 'Editar Variante de Color';
$page['code'] = 'adminEditColorVariant';

// Validar variant_id
if (!isset($_GET['variant_id']) || !is_numeric($_GET['variant_id']))
{
  setToast([['Has introducido un ID de variante inválido']]);
  redirect('admin/view.products');
  exit;
}

$variant_id = (int) $_GET['variant_id'];

global $config;

// Cargar variante
$variant = Core::model('db', 'core')->getRows('color_variants', ['id', 'product_id', 'color_name', 'image', 'size_available'], ['id', $variant_id], 0, 1);
if (!$variant || empty($variant['data'][0]))
{
  setToast([['Variante no encontrada']]);
  redirect('admin/view.products');
  exit;
}

$variant = $variant['data'][0];
$product_id = (int) $variant['product_id'];

// La columna `color_variant_id` ya existe; no se realizan alteraciones dinámicas aquí.

// Obtener imágenes asociadas a la variante
$images_query = Core::model('db', 'core')->db->query('SELECT * FROM `variants_images` WHERE `color_variant_id` = ' . intval($variant_id) . ' ORDER BY `num_image` DESC, `created_at` ASC');
$variant_images = [];
if ($images_query && $images_query->num_rows > 0)
{
  while ($r = $images_query->fetch_assoc())
  {
    $variant_images[] = $r;
  }
}

// Si se envía el formulario de edición
if (isset($_GET['edit_variant']) && $_GET['edit_variant'] == 'true')
{
  $msg = [];

  if (!isset($_POST['color_name']) || empty($_POST['color_name']))
  {
    $msg[] = 'Debes introducir un nombre para el color';
  }

  if (!empty($msg))
  {
    setToast([$msg]);
    redirect('admin/edit.color_variant', ['variant_id' => $variant_id]);
    exit;
  }

  $update = [];
  $update['color_name'] = cleanString($_POST['color_name']);
  $update['size_available'] = isset($_POST['size_available']) ? cleanString($_POST['size_available']) : '';

  // Reemplazar imagen de presentación si se sube nueva
  if (isset($_FILES['image']) && isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0)
  {
    $newImage = loadClass('core/extra')->uploadImage($_FILES['image'], $config['products_path']);
    if ($newImage)
    {
      // borrar imagen antigua
      if (!empty($variant['image']))
      {
        loadClass('core/extra')->deleteImage($variant['image'], $config['products_path']);
      }
      $update['image'] = $newImage;
    }
    else
    {
      $msg[] = 'No se pudo subir la imagen de presentación';
    }
  }

  // Manejar subida de imagenes de sudadera 1
  if (isset($_FILES['hoodie1']) && isset($_FILES['hoodie1']['error']) && $_FILES['hoodie1']['error'] == 0 && $_FILES['hoodie1']['size'] > 0)
  {
    $newHoodie1 = loadClass('core/extra')->uploadImage($_FILES['hoodie1'], $config['products_path']);
    if ($newHoodie1)
    {
      // Borrar imagen anterior si existe
      $q = Core::model('db', 'core')->db->query('SELECT * FROM `variants_images` WHERE `color_variant_id` = ' . intval($variant_id) . ' AND `num_image` = 1 LIMIT 1');
      if ($q && $q->num_rows > 0)
      {
        $r = $q->fetch_assoc();
        loadClass('core/extra')->deleteImage($r['image_url'], $config['products_path']);
        // Actualizar registro
        if (Core::model('db', 'core')->smartInsert('variants_images', ['image_url' => $newHoodie1, 'created_at' => time()], ['id', $r['id']]))
        {
          $msg[] = 'No se pudo actualizar la imagen Sudadera 1';
        }
      }
      else
      {
        // Insertar nuevo registro
        if (!Core::model('db', 'core')->smartInsert('variants_images', ['color_variant_id' => $variant_id, 'image_url' => $newHoodie1, 'num_image' => 1, 'created_at' => time()]))
        {
          $msg[] = 'No se pudo subir la imagen Sudadera 1';
        }
      }
    }
    else
    {
      $msg[] = 'No se pudo subir la imagen Sudadera 1';
    }
  }

  // Manejar subida de imagenes de sudadera 2
  if (isset($_FILES['hoodie2']) && isset($_FILES['hoodie2']['error']) && $_FILES['hoodie2']['error'] == 0 && $_FILES['hoodie2']['size'] > 0)
  {
    $newHoodie2 = loadClass('core/extra')->uploadImage($_FILES['hoodie2'], $config['products_path']);
    if ($newHoodie2)
    {
      // Borrar imagen anterior si existe
      $q = Core::model('db', 'core')->db->query('SELECT * FROM `variants_images` WHERE `color_variant_id` = ' . intval($variant_id) . ' AND `num_image` = 2 LIMIT 1');
      if ($q && $q->num_rows > 0)
      {
        $r = $q->fetch_assoc();
        loadClass('core/extra')->deleteImage($r['image_url'], $config['products_path']);
        // Actualizar registro
        if (!Core::model('db', 'core')->smartInsert('variants_images', ['image_url' => $newHoodie2, 'created_at' => time()], ['id', $r['id']]))
        {
          $msg[] = 'No se pudo actualizar la imagen Sudadera 2 en la base de datos';
        }
      }
      else
      {
        // Insertar nuevo registro
        if (!Core::model('db', 'core')->smartInsert('variants_images', ['color_variant_id' => $variant_id, 'image_url' => $newHoodie2, 'num_image' => 2, 'created_at' => time()]))
        {
          $msg[] = 'No se pudo insertar la imagen Sudadera 2 en la base de datos';
        }
      }
    }
    else
    {
      $msg[] = 'No se pudo subir la imagen Sudadera 2';
    }
  }



  // Si hay errores de subida, mostramos y no actualizamos
  if (!empty($msg))
  {
    setToast([$msg]);
    redirect('admin/edit.color_variant', ['variant_id' => $variant_id]);
    exit;
  }

  // Actualizar la variante
  $res = Core::model('db', 'core')->smartInsert('color_variants', $update, ['id', $variant_id]);

  if ($res === false)
  {
    setToast([['No se pudo actualizar la variante']]);
    redirect('admin/edit.color_variant', ['variant_id' => $variant_id]);
    exit;
  }

  setToast([['Variante actualizada correctamente']]);
  redirect('admin/edit.color_variant', ['variant_id' => $variant_id]);
  exit;
}
