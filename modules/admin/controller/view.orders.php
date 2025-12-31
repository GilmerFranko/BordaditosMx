<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para listar los pedidos
 *
 */

$page['name'] = 'Pedidos';
$page['code'] = 'viewOrders';

$filter_order_status = isset($_GET['filter_order_status']) ? cleanString($_GET['filter_order_status']) : null;

$filter_date = isset($_GET['filter_date']) ? cleanString($_GET['filter_date']) : null;

// Optiene todos los pedidos
$orders = loadClass('admin/order')->getAllOrders(['order_status' => $filter_order_status, 'filter_date' => $filter_date], 2000);

$class_order_status = [
  'Pending' => ['text' => 'Pendiente', 'class' => ' orange-text '],
  'Paid' => ['text' => 'Pagado', 'class' => ' blue-text '],
  'Shipped' => ['text' => 'Enviado', 'class' => ' purple-text '],
  'Delivered' => ['text' => 'Entregado', 'class' => ' green-text ']
];
