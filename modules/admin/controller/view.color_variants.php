<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para listar variantes de color de un producto
 *
 */

$page['name'] = 'Variantes de Color';
$page['code'] = 'adminViewColorVariants';

// Validar product_id
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id']))
{
  setToast([['Has introducido un ID de producto inválido']]);
  redirect('admin/view.products');
  exit;
}

$product_id = (int) $_GET['product_id'];

// Obtener producto (opcional, para mostrar nombre)
$product = loadClass('admin/products')->getProductById($product_id);

// Obtener variantes
$variants = Core::model('db', 'core')->getRows('color_variants', ['id', 'product_id', 'color_name', 'image', 'size_available'], ['product_id', $product_id], 0, 100);
$variants_list = [];
if ($variants && isset($variants['data']))
{
  $variants_list = $variants['data'];
}

error_log(var_export($variants_list, true));

// Para cada variante, obtener count de images
foreach ($variants_list as &$vnum)
{

  $q = Core::model('db', 'core')->db->query('SELECT COUNT(*) AS c FROM `variants_images` WHERE `color_variant_id` = ' . intval($vnum['id']));


  if ($q && $q->num_rows > 0)
  {
    $r = $q->fetch_assoc();
    $vnum['images_count'] = isset($r['c']) ? (int)$r['c'] : 0;
  }
  else
  {
    $vnum['images_count'] = 0;
  }
}
