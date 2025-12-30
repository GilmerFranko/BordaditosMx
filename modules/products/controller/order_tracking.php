<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para rastrear pedido
 *
 */
$page['name'] = 'Rastrear pedido';
$page['code'] = 'orderTraking';


if (isset($_GET['order_id']) && !empty($_GET['order_id']))
{
  $order_id = intval($_GET['order_id']);

  if (!$order = loadClass('products/orders')->getOrderById($order_id))
  {
    $msg[] = 'No se ha encontrado el pedido.';
  }
  //Optener articulos de pedido
  elseif (!$items = loadClass('products/orders')->getItemsByOrderId($order_id))
  {
    $msg[] = 'No se ha encontrado el pedido1.';
  }
  if (!empty($msg))
  {
    setTI([$msg]);
    //redirect('products/order_tracking');
    //exit;
  }

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
}
