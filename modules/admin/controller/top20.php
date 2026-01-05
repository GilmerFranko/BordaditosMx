<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco
 *=======================================================
 *
 * @Description Controlador para gestionar el Top 20 de productos
 */

$page['name'] = 'Top 20 Productos';
$page['code'] = 'adminTopProducts';

$msg = [];
$action = $_POST['action'] ?? null;

// Cargar el modelo de productos
$topProductsModel = loadClass('admin/top20c');
$productsModel = loadClass('admin/products');

// Manejar acciones
if ($action === 'add')
{
  $productId = intval($_POST['product_id'] ?? 0);

  if (!$productsModel->getProductById($productId))
  {
    $msg = 'El producto no existe.';
  }
  elseif ($topProductsModel->countTopProducts() >= 20)
  {
    $msg = 'El Top 20 ya está completo.';
  }
  elseif ($topProductsModel->isInTop($productId))
  {
    $msg = 'El producto ya está en el Top 20.';
  }
  else
  {
    $topProductsModel->addToTop($productId);
    $msg = 'Producto agregado al Top 20 exitosamente.';
  }

  echo json_encode(['success' => empty($msg), 'message' => $msg]);
  exit;
}

if ($action === 'remove')
{
  $productId = intval($_POST['product_id'] ?? 0);

  if (!$topProductsModel->isInTop($productId))
  {
    $msg = 'El producto no está en el Top 20.';
  }
  else
  {
    $topProductsModel->removeFromTop($productId);
    $msg = 'Producto eliminado del Top 20 exitosamente.';
  }

  echo json_encode(['success' => empty($msg), 'message' => $msg]);
  exit;
}

if ($action === 'search')
{
  $query = trim($_POST['query'] ?? '');

  if (strlen($query) < 3)
  {
    echo json_encode([]);
    exit;
  }

  $results = $topProductsModel->searchProductsNotInTop($query);
  echo json_encode($results);
  exit;
}

if ($action === 'move')
{
  $productId = intval($_POST['product_id'] ?? 0);
  $direction = $_POST['direction'] ?? '';  // Puede ser 'up' o 'down'

  if (!$topProductsModel->isInTop($productId))
  {
    $msg = ['success' => false, 'message' => 'El producto no está en el Top 20.'];
  }
  else
  {
    // Obtener el producto y su posición
    $product = $topProductsModel->getProductByIdInTop($productId);

    // Optener la posicicion más baja actual
    $lowestPosition = $topProductsModel->getLowestPosition();

    if ($product)
    {
      $currentPosition = $product['position'];
      // Lógica para mover el producto
      if ($direction === 'up' && $currentPosition > 1)
      {
        $topProductsModel->moveProductUp($productId, $currentPosition);
        $msg = ['success' => true, 'message' => 'Producto movido hacia arriba.'];
      }
      elseif ($direction === 'down' && $currentPosition < 20 and $lowestPosition > $currentPosition)
      {
        $topProductsModel->moveProductDown($productId, $currentPosition);
        $msg = ['success' => true, 'message' => 'Producto movido hacia abajo.'];
      }
      else
      {
        $msg = ['success' => false, 'message' => 'El producto no puede moverse más en esa dirección.'];
      }
    }
    else
    {
      $msg = ['success' => false, 'message' => 'El producto no está en el Top 20.'];
    }
  }
  echo json_encode(['success' => $msg['success'], 'message' => $msg['message']]);
  exit;
}

// Obtener datos para mostrar en la página
$topProducts = $topProductsModel->getTopProducts();
$availableProducts = $topProductsModel->getAvailableProductsNotInTop();

// Mostrar mensajes en caso de redirección
if (!empty($msg))
{
  setToast($msg);
}
