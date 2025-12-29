<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Modelo para obtener el resumen (pedido + items)
 *
 */

class Summary extends Model
{
  /**
   * Obtener pedido por ID junto con sus items y datos de producto/variante
   * @param int $order_id
   * @return array|false
   */
  public function getOrderById($order_id)
  {
    $order_id = intval($order_id);

    $order_rows = Core::model('db', 'core')->getRows('orders', ['id', 'customer_name', 'customer_whatsapp', 'shipping_address', 'shipping_state', 'shipping_city', 'shipping_method', 'payment_method', 'total_amount', 'estimated_delivery', 'order_status', 'created_at'], ['id', $order_id], 0, 1);
    if (!$order_rows || empty($order_rows['data']))
    {
      return false;
    }

    $order = $order_rows['data'][0];

    $items_rows = Core::model('db', 'core')->getRows('order_items', ['id', 'order_id', 'product_id', 'variant_id', 'size_hoodie_1', 'size_hoodie_2', 'quantity', 'price_at_purchase', 'subtotal'], ['order_id', $order_id], 0, 100);
    $items = [];
    if ($items_rows && isset($items_rows['data']))
    {
      foreach ($items_rows['data'] as $it)
      {
        $product = Core::model('db', 'core')->getRows('products', ['id', 'name', 'original_price', 'sale_price'], ['id', $it['product_id']], 0, 1);
        $variant = Core::model('db', 'core')->getRows('color_variants', ['id', 'image', 'color_name'], ['id', $it['variant_id']], 0, 1);

        $it['product'] = ($product && isset($product['data'][0])) ? $product['data'][0] : [];
        $it['variant'] = ($variant && isset($variant['data'][0])) ? $variant['data'][0] : [];

        $items[] = $it;
      }
    }

    return ['order' => $order, 'items' => $items];
  }
}
