<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para eliminar una variante de color y sus imágenes
 *
 */

$page['name'] = 'Eliminar Variante de Color';
$page['code'] = 'adminDeleteColorVariant';

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
$v = Core::model('db', 'core')->getRows('color_variants', ['id', 'product_id', 'color_name', 'image', 'size_available'], ['id', $variant_id], 0, 1);
if (!$v || empty($v['data']))
{
  setToast([['Variante no encontrada']]);
  redirect('admin/view.color_variants', ['product_id' => $_GET['product_id']]);
  exit;
}

$variant = $v['data'][0];

error_log(var_export($variant, true));

$product_id = isset($variant['product_id']) ? (int)$variant['product_id'] : 0;

$msgs = [];

// Borrar imagen de presentación si existe
if (!empty($variant['image']))
{
  loadClass('core/extra')->deleteImage($variant['image'], $config['products_path']);
}

// Obtener y borrar imágenes asociadas en variants_images (campo image_url)
$q = Core::model('db', 'core')->db->query('SELECT * FROM `variants_images` WHERE `color_variant_id` = ' . intval($variant_id));
if ($q && $q->num_rows > 0)
{
  while ($row = $q->fetch_assoc())
  {
    if (!empty($row['image_url']))
    {
      loadClass('core/extra')->deleteImage($row['image_url'], $config['products_path']);
    }
  }
}

// Eliminar filas en variants_images
Core::model('db', 'core')->db->query('DELETE FROM `variants_images` WHERE `color_variant_id` = ' . intval($variant_id));

// Eliminar la variante
$deleted = Core::model('db', 'core')->deleteRow('color_variants', $variant_id);
if ($deleted)
{
  $msgs[] = 'Variante eliminada correctamente';
}
else
{
  $msgs[] = 'No se pudo eliminar la variante';
}

setToast([$msgs]);
// Redirigir a la lista de variantes del producto si tenemos product_id, sino al listado general
if ($product_id > 0)
  redirect('admin/view.color_variants', ['product_id' => $product_id]);
else
  redirect('admin/view.color_variants', ['product_id' => $_GET['product_id']]);

exit;
