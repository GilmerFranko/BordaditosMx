<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para obtener la lista de productos (área/ajax)
 *
 */

$page['name'] = 'Productos';
$page['code'] = 'viewProducts';

// Preferencias de búsqueda
$search = '';
if (isset($_REQUEST['search']))
{
  $search = htmlspecialchars($_REQUEST['search']);
  $_SESSION['products']['search'] = $search;
}
else
{
  if (isset($_SESSION['products']['search']))
  {
    $search = $_SESSION['products']['search'];
  }
}

// Procesos dinámicos (soporte para paginación vía AJAX)
if (!isset($_POST['ajax']) || (isset($_POST['ajax']) && isset($_GET['page'])))
{
  $page['name'] = 'Productos - Administraci&oacute;n';

  $params = array();
  if (!empty($search)) $params['name'] = $search;
  $limit = 2000;

  $products = Core::model('products', 'admin')->getAllProducts($params, $limit);

  if (empty($products) || (isset($products['rows']) && $products['rows'] < 1))
  {
    $message[] = array('No hay resultados de ' . $search, 'warning');
    Core::model('extra', 'core')->setToast($message);
  }

  if (isset($_POST['ajax']))
  {
    if ($products !== false)
    {
      echo '1: ';
      require Core::view('view.products');
      //exit;
    }
    else
    {
      //die('0: No se pudo cambiar de p&aacute;gina');
    }
  }
}

// Lógica para eliminar un producto
if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id']) && is_numeric($_POST['id']))
{
  $product_id = (int)$_POST['id'];

  if (loadClass('admin/products')->deleteProduct($product_id))
  {
    echo json_encode(['success' => true, 'message' => 'Producto eliminado correctamente']);
  }
  else
  {
    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el producto']);
  }
  exit;
}
