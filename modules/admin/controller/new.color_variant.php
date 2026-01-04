<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para crear una variante de color
 *
 */

$page['name'] = 'Nueva Variante de Color';
$page['code'] = 'adminNewColorVariant';

// Obtener product_id
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id']))
{
  setToast([['Has introducido un ID de producto inválido']]);
  redirect('admin/view.products');
  exit;
}

$product_id = (int) $_GET['product_id'];

// Acción de creación
if (isset($_GET['do']) && $_GET['do'] == 'new')
{
  $msg = [];

  // Validaciones básicas
  if (!isset($_POST['color_name']) || empty($_POST['color_name']))
  {
    $msg[] = 'Debes introducir un nombre para el color';
  }

  // Comprobar imagen principal
  if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0)
  {
    $msg[] = 'Debes subir una imagen de presentación para la variante';
  }

  if (empty($msg))
  {
    global $config, $parser;

    $color_name = cleanString($_POST['color_name']);
    $size_available = isset($_POST['size_available']) ? cleanString($_POST['size_available']) : '';

    // Subir imagen principal
    $image_url = loadClass('core/extra')->uploadImage($_FILES['image'], $config['products_path']);

    if (!$image_url)
    {
      $msg[] = 'No se pudo subir la imagen principal';
      setToast([$msg]);
      redirect('admin/new.color_variant', ['product_id' => $product_id]);
      exit;
    }

    // Insertar variante
    $variantData = [
      'product_id' => $product_id,
      'color_name' => $color_name,
      'image' => $image_url,
      'size_available' => $size_available
    ];

    $variant_id = Core::model('db', 'core')->smartInsert('color_variants', $variantData);

    if ($variant_id === false || $variant_id == 0)
    {
      $msg[] = 'No se pudo crear la variante de color';
      // borrar imagen subida
      loadClass('core/extra')->deleteImage($image_url, $config['products_path']);
    }
    else
    {
      $msg2 = [];

      // Subir imágenes para sudadera 1
      if (isset($_FILES['hoodie1']) && isset($_FILES['hoodie1']['error']) && $_FILES['hoodie1']['error'] == 0 && $_FILES['hoodie1']['size'] > 0)
      {
        $newHoodie1 = loadClass('core/extra')->uploadImage($_FILES['hoodie1'], $config['products_path']);
        if (!$newHoodie1)
        {
          $msg2[] = 'No se pudo subir la imagen Sudadera 1';
        }
      }

      // Subir imágenes para sudadera 2 (Si existe)
      if (isset($_FILES['hoodie2']) && isset($_FILES['hoodie2']['error']) && $_FILES['hoodie2']['error'] == 0 && $_FILES['hoodie2']['size'] > 0)
      {
        $newHoodie2 = loadClass('core/extra')->uploadImage($_FILES['hoodie2'], $config['products_path']);
        if (!$newHoodie2)
        {
          $msg2[] = 'No se pudo subir la imagen Sudadera 2';
        }
      }
      // Insertar imágenes de sudadera
      if (isset($newHoodie1))
      {
        Core::model('db', 'core')->smartInsert('variants_images', ['color_variant_id' => $variant_id, 'image_url' => $newHoodie1, 'num_image' => 1, 'created_at' => time()]);
      }

      if (isset($newHoodie2))
      {
        Core::model('db', 'core')->smartInsert('variants_images', ['color_variant_id' => $variant_id, 'image_url' => $newHoodie2, 'num_image' => 2, 'created_at' => time()]);
      }

      if (empty($msg2))
      {
        $msg2[] = 'Variante creada con exito';
      }
      setToast([$msg2]);
      redirect('admin/view.products');
      exit;
    }

    setToast([$msg]);
    redirect('admin/view.products');
    exit;
  }
  else
  {
    setToast([$msg]);
    redirect('admin/new.color_variant', ['product_id' => $product_id]);
    exit;
  }
}
else
{
  // Mostrar formulario
  // Cargar producto básico (si es necesario)
  $product = loadClass('admin/products')->getProductById($product_id);
}
