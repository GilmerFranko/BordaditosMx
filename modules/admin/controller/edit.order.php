<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para editar un pedido
 *
 */

$page['name'] = 'Editar Pedido';
$page['code'] = 'adminEditOrder';

$msg = [];

if (!isset($_GET['order_id']) or empty($_GET['order_id']))
{
  $msg[] = 'No se ha enviado el ID del pedido.';
}

if (empty($msg))
{
  $orderId = intval($_GET['order_id']);

  if (!$order = loadClass('admin/order')->getOrderById($orderId))
  {
    $msg[] = 'No se ha encontrado el pedido.';
  }
  //Optener articulos de pedido
  elseif (!$items = loadClass('admin/order')->getItemsByOrderId($orderId))
  {
    $msg[] = 'No se ha encontrado el pedido1.';
  }
  if (!empty($msg))
  {
    setToast([$msg]);
    redirect('admin/orders');
    exit;
  }
}
else
{
  setToast([$msg]);
  redirect('admin/orders');
  exit;
}

error_log(var_export($_POST, true));

if (isset($_GET['action']) && $_GET['action'] == 'edit_order')
{
  $msg = [];

  if (!isset($_POST['customer_name']) or empty($_POST['customer_name']))
  {
    $msg[] = 'Debe ingresar un nombre.';
  }

  if (!isset($_POST['customer_whatsapp']) or empty($_POST['customer_whatsapp']))
  {
    $msg[] = 'Debe ingresar un WhatsApp.';
  }

  if (!isset($_POST['shipping_method']) or empty($_POST['shipping_method']))
  {
    $msg[] = 'Debe ingresar un metodo de envio.';
  }

  if (!isset($_POST['estimated_delivery']) or empty($_POST['estimated_delivery']))
  {
    $msg[] = 'Debe ingresar una fecha de entrega.';
  }

  if (!isset($_POST['shipping_city']) or empty($_POST['shipping_city']))
  {
    $msg[] = 'Debe ingresar una ciudad.';
  }

  if (!isset($_POST['shipping_state']) or empty($_POST['shipping_state']))
  {
    $msg[] = 'Debe ingresar un estado.';
  }

  if (!isset($_POST['shipping_address']) or empty($_POST['shipping_address']))
  {
    $msg[] = 'Debe ingresar una direccion.';
  }

  if (!isset($_POST['order_status']) or empty($_POST['order_status']))
  {
    $msg[] = 'Debe ingresar un estado de pedido.';
  }

  if (!isset($_POST['payment_method']) or empty($_POST['payment_method']))
  {
    $msg[] = 'Debe ingresar un metodo de pago.';
  }

  if (!isset($_POST['size_hoodie_1']) or empty($_POST['size_hoodie_1']))
  {
    $msg[] = 'Debe ingresar la talla 1.';
  }

  if (!isset($_POST['size_hoodie_2']) or empty($_POST['size_hoodie_2']))
  {
    $msg[] = 'Debe ingresar la talla 2.';
  }

  if (!isset($_POST['item_order_id']) or empty($_POST['item_order_id']))
  {
    $msg[] = 'Error';
  }

  if (empty($msg))
  {
    $eOrder = [
      'customer_name' => cleanString($_POST['customer_name']),
      'customer_whatsapp' => cleanString($_POST['customer_whatsapp']),
      'shipping_method' => cleanString($_POST['shipping_method']),
      'shipping_address' => cleanString($_POST['shipping_address']),
      'shipping_city' => cleanString($_POST['shipping_city']),
      'shipping_state' => cleanString($_POST['shipping_state']),
      'estimated_delivery' => cleanString($_POST['estimated_delivery']),
      'order_status' => cleanString($_POST['order_status']),
      'payment_method' => cleanString($_POST['payment_method']),
    ];

    $eItemOrder = [
      'size_hoodie_1' => cleanString($_POST['size_hoodie_1']),
      'size_hoodie_2' => cleanString($_POST['size_hoodie_2']),
    ];

    $itemOrderId = cleanString($_POST['item_order_id']);


    if (loadClass('admin/order')->updateOrder($orderId, $eOrder) === false)
    {
      $msg[] = 'No se ha podido actualizar el pedido.';
    }

    if (loadClass('admin/order')->updateItem($itemOrderId, $eItemOrder) === 0)
    {
      //$msg[] = 'No se ha podido actualizar el pedido.';
    }
    if (empty($msg))
    {
      setToast([['Pedido actualizado correctamente.']]);
      redirect('admin/edit.order', ['order_id' => $orderId]);
      exit;
    }
    else
    {
      setToast([$msg]);
      redirect('admin/edit.order', ['order_id' => $orderId]);
      exit;
    }
  }
  else
  {
    setToast([$msg]);
  }
}
