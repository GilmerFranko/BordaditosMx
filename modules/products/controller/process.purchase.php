<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para procesar el pedido
 *
 */
$page['name'] = 'Proceso de pedido';
$page['code'] = 'processPurchase';

// Procesar pedido
if (isset($_GET['action']) && $_GET['action'] === 'process_purchase')
{
  $msg_order = [];
  // Validar datos obligatorios
  if (!isset($_POST['customer_name']) || empty($_POST['customer_name']))
  {
    $msg_order[] = 'Debe ingresar su nombre.';
  }

  // WhatsApp
  if (!isset($_POST['customer_whatsapp']) || empty($_POST['customer_whatsapp']))
  {
    $msg_order[] = 'Debe ingresar su WhatsApp.';
  }

  if (!isset($_POST['shipping_method']) || empty($_POST['shipping_method']))
  {
    $msg_order[] = 'Debe seleccionar un metodo de envío.';
  }

  if (!isset($_POST['shipping_address']) || empty($_POST['shipping_address']))
  {
    $msg_order[] = 'Debe ingresar su dirección de envío.';
  }

  if (!isset($_POST['shipping_state']) || empty($_POST['shipping_state']))
  {
    $msg_order[] = 'Debe ingresar su estado donde resivirá el pedido.';
  }

  if (!isset($_POST['shipping_city']) || empty($_POST['shipping_city']))
  {
    $msg_order[] = 'Debe ingresar su ciudad donde resivirá el pedido.';
  }

  if (!isset($_POST['estimated_delivery']) || empty($_POST['estimated_delivery']))
  {
    $msg_order[] = 'Ocurrio un error';
  }

  if (!isset($_POST['size_sweater_1']) || empty($_POST['size_sweater_1']))
  {
    $msg_order[] = 'Debe seleccionar la talla de la sudadera 1.';
  }


  if (!isset($_POST['product_id']) || empty($_POST['product_id']))
  {
    $msg_order[] = 'No ha seleccionado un producto.';
  }

  if (!isset($_POST['variant_id']) || empty($_POST['variant_id']))
  {
    $msg_order[] = 'No ha seleccionado una variante del producto.';
  }

  if (empty($msg_order))
  {
    $product_id = cleanString($_POST['product_id']);
    $variant_id = cleanString($_POST['variant_id']);
    $size_sweater_1 = cleanString($_POST['size_sweater_1']);
    $size_sweater_2 = isset($_POST['size_sweater_2']) ? cleanString($_POST['size_sweater_2']) : null;
    $customer_name = cleanString($_POST['customer_name']);
    $customer_whatsapp = cleanString($_POST['customer_whatsapp']);
    $estimated_delivery = cleanString($_POST['estimated_delivery']);
    $shipping_method = cleanString($_POST['shipping_method']);
    $shipping_address = cleanString($_POST['shipping_address']);
    $shipping_state = cleanString($_POST['shipping_state']);
    $shipping_city = cleanString($_POST['shipping_city']);

    // Cargar modelos
    $orderModel = loadClass('products/orders');
    $orderItemsModel = loadClass('products/order_items');

    $msg_order2 = [];

    // Validar existencia del producto y variante
    if (!$product = Core::model('product', 'products')->getProductById($product_id))
    {
      $msg_order2[] = 'El producto seleccionado no existe.';
    }
    if (!$variant = Core::model('variants', 'products')->getVariantById($variant_id))
    {
      $msg_order2[] = 'La variante seleccionada no existe.';
    }

    // Verificar que las tallas seleccionadas estén disponibles
    $size_available = explode(',', $variant['data'][0]['size_available']);

    // Validar talla sudadera 1
    if (!$size_available[0] == $size_sweater_1)
    {
      $msg1[] = 'La talla seleccionada para la primera sudadera no está disponible.';
    }

    // 
    if (isset($size_available[1]))
    {
      // Validar talla sudadera 2
      if (!$size_available[1] == $size_sweater_2)
      {
        $msg1[] = 'La talla seleccionada para la segunda sudadera no está disponible.';
      }
    }

    if (empty($msg_order2))
    {
      $data_order = [
        'customer_name' => $customer_name,
        'shipping_method' => $shipping_method,
        'shipping_address' => $shipping_address,
        'shipping_state' => $shipping_state,
        'shipping_city' => $shipping_city,
        'customer_whatsapp' => $customer_whatsapp,
        'estimated_delivery' => $estimated_delivery,
        'total_amount' => (isset($product['sale_price']) && $product['sale_price'] > 0) ? $product['sale_price'] : $product['original_price'],
        'order_status' => 'pending'
      ];

      // Crear pedido
      if ($order_id = $orderModel->createOrder($data_order))
      {
        $data_item_order = [
          'order_id' => $order_id,
          'product_id' => $product_id,
          'variant_id' => $variant_id,
          'size_hoodie_1' => $size_sweater_1,
          'size_hoodie_2' => $size_sweater_2,
          'quantity' => 1,
          'price_at_purchase' => (isset($product['sale_price']) && $product['sale_price'] > 0) ? $product['sale_price'] : $product['original_price']
        ];

        // Crear items del pedido
        if ($orderItemsModel->createOrderItem($data_item_order))
        {
          setTI([['Pedido creado exitosamente.']]);
          redirect('pedido/' . $order_id);
          exit;
        }
        else
        {
          error_log(var_export($order_id, 1));
          // Borrar el pedido creado si no se pudieron crear los items
          $orderModel->deleteOrderById($order_id);
          $msg_order2[] = 'No se pudo crear los items del pedido. Intente nuevamente.';
        }
      }
      else
      {
        $msg_order2[] = 'No se pudo crear el pedido. Intente nuevamente.';
      }
      if (!empty($msg_order2))
      {
        setTI([$msg_order2]);
        //redirect('core/home-guest', ['variant_id' => $variant_id]);
        //exit;
      }
    }
    else
    {
      setTI([$msg_order2]);
      //redirect('core/home-guest', ['variant_id' => $variant_id]);
      //exit;
    }
  }
  else
  {
    setTI([$msg_order]);
    //redirect('core/home-guest', ['variant_id' => $variant_id]);
    //exit;
  }
}

unset($msg, $product_id, $variant_id, $size_sweater_1, $size_sweater_2, $size_available);

//Validaciones0
$msg = [];
if (!isset($_GET['product_id']) or empty($_GET['product_id']))
{
  $msg[] = 'No ha seleccionado un producto.';
}
if (!isset($_GET['variant_id']) or empty($_GET['variant_id']))
{
  $msg[] = 'No ha seleccionado una variante del producto.';
}
if (!isset($_GET['size_sweater_1']) or empty($_GET['size_sweater_1']))
{
  $msg[] = 'No ha seleccionado la talla de la sudadera 1';
}
if (!isset($_GET['size_sweater_2']) or empty($_GET['size_sweater_2']))
{
  //$msg[] = 'No ha seleccionado la talla de la sudadera 2';
}
if (empty($msg))
{
  $product_id = cleanString($_GET['product_id']);
  $variant_id = cleanString($_GET['variant_id']);
  $size_sweater_1 = cleanString($_GET['size_sweater_1']);
  $size_sweater_2 = (isset($_GET['size_sweater_2'])) ? cleanString($_GET['size_sweater_2']) : null;
  $msg1 = [];

  // Obtener datos del producto
  if (!$product = Core::model('product', 'products')->getProductById($product_id))
  {
    $msg1[] = 'El producto seleccionado no existe.';
  }
  // Obtener datos de la variante
  if (!$variant = Core::model('variants', 'products')->getVariantById($variant_id))
  {
    $msg1[] = 'La variante seleccionada no existe.';
  }

  $size_available = explode(',', $variant['data'][0]['size_available']);

  if (!$size_available[0] == $size_sweater_1)
  {
    $msg1[] = 'La talla seleccionada para la primera sudadera no está disponible.';
  }

  if (isset($size_available[1]))
  {
    if (!$size_available[1] == $size_sweater_2)
    {
      $msg1[] = 'La talla seleccionada para la segunda sudadera no está disponible.';
    }
  }

  if (!empty($msg1))
  {
    setTI([$msg]);
    //redirect('core/home-guest', ['variant_id' => $variant_id]);
    //exit;
  }
}
// Si hay errores, redirigir con mensajes
else
{
  setTI([$msg]);
  //redirect('core/home-guest', ['variant_id' => $variant_id]);
  //exit;
}
