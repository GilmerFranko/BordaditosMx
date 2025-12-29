<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para obtener un pedido
 *
 */

$page['name'] = 'Pedido';
$page['code'] = 'viewOrder';


$msg = [];

if (!isset($_GET['order_id']) or empty($_GET['order_id']))
{
  $msg[] = 'No se ha enviado el ID del pedido.';
}

if (empty($msg))
{
  $orderId = intval($_GET['order_id']);

  if (!$order = Core::model('order', 'admin')->getOrderById($orderId))
  {
    setToast([$msg]);
    redirect('core/home-guest');
    exit;
  }
}
else
{
  setToast([$msg]);
  redirect('core/home-guest');
  exit;
}

//Optener articulos de pedido
$items = loadClass('admin/order')->getItemsByOrderId($orderId);

error_log(var_export($items, 1));

$class_order_status = [
  'Pending' => ['text' => 'Pendiente', 'class' => ' orange-text '],
  'Paid' => ['text' => 'Pagado', 'class' => ' blue-text '],
  'Shipped' => ['text' => 'Enviado', 'class' => ' purple-text '],
  'Delivered' => ['text' => 'Entregado', 'class' => ' green-text ']
];

$arr_methot_payment = ['Card' => 'Tarjeta', 'OXXO' => 'OXXO', 'Transfer' => 'Transferencia Bancaria'];

$statuses = ['Pending', 'Paid', 'Shipped', 'Delivered'];
$currentStatus = $order['order_status'];

// Buscamos el índice del estado actual (ej: 'Paid' es índice 1)
$currentIndex = array_search($currentStatus, $statuses);

$cos = [];
foreach ($statuses as $index => $status)
{
  if ($index < $currentIndex)
  {
    $cos[$status] = 'completed';
  }
  elseif ($index === $currentIndex)
  {
    $cos[$status] = 'active';
  }
  else
  {
    $cos[$status] = '';
  }
}
