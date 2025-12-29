<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador de la página de vista de un producto
 *
 */

$page['name'] = 'Producto';
$page['code'] = 'product_view';

$variant_selected = $_GET['variant_selected'] ?? null;

if (!isset($_GET['product_id']) || empty($_GET['product_id']))
{
  redirect(gLink('products/home'));
}

$product_id = (int) $_GET['product_id'];
$product = loadClass('products/product')->getProductById($product_id);

$variants = loadClass('products/variants')->getProductVariants($product_id);
