<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para ver el pedido realizado
 *
 */
$page['name'] = 'Pedido';
$page['code'] = 'summary';

// Leer order_id
if (!isset($_GET['order_id']) || empty($_GET['order_id']))
{
  // Si no hay order_id, redirigir a home o página principal
  redirect('core/home-guest');
}

$order_id = intval($_GET['order_id']);

// Cargar modelo summary y obtener datos
$summaryModel = loadClass('products/summary');
$summary = $summaryModel->getOrderById($order_id);

if (!$summary)
{
  setTI(['No se encontró el pedido.']);
  redirect('core/home-guest');
}

$order = $summary['order'];
$items = $summary['items'];
