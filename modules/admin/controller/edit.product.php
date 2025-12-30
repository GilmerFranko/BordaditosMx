<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para editar un Producto
 *
 */

$page['name'] = 'Editar Producto';
$page['code'] = 'adminEditproduct';

// Obtener el valor de post_max_size de php.ini y convertirlo a bytes
$max_post_size = ini_get('post_max_size');
$max_post_size_bytes = convertToBytes($max_post_size);

// COMPROBAR SI SE HA ENVIADO EL FORMULARIO DE EDICIÓN
if (isset($_GET['edit_product']))
{
  $msg = [];

  // Verificar si CONTENT_LENGTH está configurado y si excede el límite
  if (isset($_SERVER['CONTENT_LENGTH']) && (int)$_SERVER['CONTENT_LENGTH'] > $max_post_size_bytes)
  {
    $msg[] = 'El archivo es demasiado grande';
  }

  // Debe tener un nombre
  if (!isset($_POST['name']) or empty($_POST['name']))
  {
    $msg[] = 'Debes introducir un nombre';
  }

  // Debe tener una descripción
  if (!isset($_POST['description']) or empty($_POST['description']))
  {
    $msg[] = 'Debes introducir una descripción';
  }

  // Debe tener un precio válido
  if (!isset($_POST['original_price']) or empty($_POST['original_price']) or !is_numeric($_POST['original_price']))
  {
    $msg[] = 'Debes introducir un precio';
  }

  // Si se ha introducido un slug
  if (isset($_POST['slug']) && !empty($_POST['slug']))
  {
    if (strlen($_POST['slug']) < 3)
    {
      $msg[] = 'El slug debe tener al menos 3 caracteres';
    }

    $slugtmp = cleanSlug(cleanString($_POST['slug']));
    // Verifica que el slug no esté en uso por otro producto
    if (!loadclass('admin/products')->isSlugAvailable($slugtmp, cleanInput($_GET['product_id'])))
    {
      $msg[] = 'El slug introducido está en uso por otro producto';
    }
    else
    {
      $slug = $slugtmp;
    }
  }

  error_log(var_export($_POST, true));

  if (empty($msg))
  {
    $productId = cleanInput($_GET['product_id']);
    $data = [
      'name' => cleanString($_POST['name']),
      'original_price' => cleanString($_POST['original_price']),
      'sale_price' => !empty($_POST['sale_price']) ? cleanString($_POST['sale_price']) : null,
      'status' => (isset($_POST['status']) and !empty($_POST['status'])) ? 1 : 0,
    ];

    $bbcode = $_POST['description'] ?? '';
    // Parsear el BBCode
    $parser->parse($bbcode);
    //
    $bbcode = cleanString($bbcode);
    $bbcode = str_replace('\n', '', $bbcode);
    $bbcode = str_replace('\r', '[br]', $bbcode);
    $bbcode = str_replace('\r\n', '[br]', $bbcode);
    $bbcode = str_replace('\n\r', '[br]', $bbcode);

    $data['description'] = $bbcode;

    // Si la variable slug está definida, actualizar el slug
    if (isset($slug))
      $data['slug'] = $slug;

    // Verifica si se debe actualizar la imagen principal
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0)
    {
      // Optiene la imagen actual para eliminarla después de subir la nueva
      $tmp = loadClass('admin/products')->getProductById($productId);
      $currentImage = $tmp['image_url'];

      // Subir la nueva imagen
      if ($image_url = loadClass('core/extra')->uploadImage($_FILES['image'], $config['products_path']))
      {
        $data['image_url'] = $image_url;
        // Elimina la imagen anterior
        loadClass('core/extra')->deleteImage($currentImage, $config['products_path']);
      }
      else
      {
        $msg[] = 'No se ha podido cargar la imagen';
      }
    }

    if (loadClass('admin/products')->updateProduct($productId, $data))
    {
      $msg[] = 'El Producto se ha editado correctamente';
    }
    else
    {
      $msg[] = 'No se ha editado el Producto';
    }
  }

  setToast([$msg]);
  redirect('admin/edit.product', ['product_id' => $productId]);
  exit;
}
else
{

  $msg = [];

  // Verificar si se ha pasado un ID válido para la edición
  if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id']))
  {
    $msg = ['Has introducido un ID incorrecto'];
  }

  // Verifica que no haya errores
  if (empty($msg))
  {
    $productId = (int)$_GET['product_id'];
    $product = loadClass('admin/products')->getProductById($productId);
    //$products_images = loadClass('admin/products')->getProductImages($productId);
  }
  else
  {
    setToast([$msg]);
    redirect('admin/dashboard');
    exit;
  }
}
