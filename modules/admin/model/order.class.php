<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los pedidos
 *
 *
 */

class Order extends Model
{

  /** Optiene todos los pedidos */
  public function getAllOrders($params = [], $limit = 20)
  {
    $where = [];

    // Filtrar por nombre
    if (!empty($params['customer_name']))
    {
      $where[] = 'o.`customer_name` LIKE "%' . $params['customer_name'] . '%"';
    }

    // Filtrar por estado
    if (!empty($params['order_status']) and in_array($params['order_status'], ['Pending', 'Paid', 'Shipped', 'Delivered']))
    {
      $where[] = 'o.`order_status` = "' . $params['order_status'] . '"';
    }

    // Filtrar por fecha (mayor o menor que una fecha específica)
    if (!empty($params['filter_date']))
    {
      $where[] = 'DATE(o.`created_at`) = "' . $params['filter_date'] . '"';
    }

    // Ordenar por fecha (ascendente o descendente)
    $order_by = !empty($params['order_by']) && in_array($params['order_by'], ['asc', 'desc'])
      ? $params['order_by']
      : 'asc';

    // Construir la cláusula WHERE
    $where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    // Consulta para obtener el total de resultados (sin límite de paginación)
    $total_query = $this->db->query(
      'SELECT COUNT(*) as o
        FROM `orders` AS o
        ' . $where_clause
    );

    $r = $total_query->fetch_assoc();
    $data['total'] = isset($r['o']) ? (int)$r['o'] : 0;
    // filas totales (compatibilidad con vistas que esperan 'rows')
    $data['rows'] = $data['total'];

    // Paginador
    $data['pages'] = Core::model('paginator', 'core')->pageIndex(array('admin', 'orders', null, $params), $data['total'], $limit);

    // Construir la consulta SQL final con paginación
    $query = $this->db->query(
      'SELECT * 
        FROM `orders` AS o
        ' . $where_clause . '
        ORDER BY 
            o.`order_status` ' . $order_by . '
        LIMIT ' . $data['pages']['limit']
    );

    // Obtener los resultados de la consulta
    $data['data'] = array();
    if ($query)
    {
      while ($row = $query->fetch_assoc())
      {
        $data['data'][] = $row;
      }
    }

    return $data;
  }

  /**
   * Optiene un pedido por id
   *
   * @param int $order_id Identificador del pedido
   * @return array|bool Pedido encontrado o false si no se encontr
   */
  public function getOrderById($order_id)
  {
    $query = $this->db->query(
      'SELECT * 
        FROM `orders` AS o
        WHERE o.`id` = ' . (int)$order_id
    );

    if ($query)
    {
      $row = $query->fetch_assoc();
      return $row;
    }
    else
    {
      return false;
    }
  }

  /**
   * Optiene los articulos de un pedido
   *
   * @param int $order_id Identificador del pedido
   * @return array|bool Articulos del pedido encontrado o false si no se encontraron
   */
  public function getItemsByOrderId($order_id)
  {
    $query = $this->db->query(
      'SELECT *, oi.`id` AS `item_id`, p.`id` AS `product_id`, cv.`id` AS `variant_id`
        FROM `order_items` AS oi
        INNER JOIN `products` AS p
          ON oi.`product_id` = p.`id`
        INNER JOIN `color_variants` as cv
          ON oi.`variant_id` = cv.`id`
        WHERE oi.`order_id` = ' . (int)$order_id
    );

    $data = array();
    if ($query)
    {
      while ($row = $query->fetch_assoc())
      {
        $data[] = $row;
      }
    }

    return $data;
  }

  /**
   * Obtiene el número de ordenes que estan en pendiente
   *
   * @return int Número de ordenes en pendiente
   */
  public function getPendingOrdersCount()
  {
    $query = $this->db->query(
      'SELECT COUNT(*) AS `count`
        FROM `orders`
        WHERE `order_status` = \'Pending\''
    );

    if ($query)
    {
      $row = $query->fetch_assoc();
      return $row['count'];
    }
    else
    {
      return 0;
    }
  }

  /**
   * Actualiza un pedido
   *
   * @param int $order_id Identificador del pedido
   * @param array $data Información del pedido a actualizar
   * @return bool True si se actualizó correctamente, false en caso contrario
   */
  public function updateOrder($order_id, $data)
  {
    return Core::model('db', 'core')->smartInsert('orders', $data, array('id', $order_id));
  }

  /**
   * Actualiza un item de un pedido
   *
   * @param int $order_item_id Identificador del pedido
   * @param array $data Información del item a actualizar
   * @return bool True si se actualizo correctamente, false en caso contrario
   */
  public function updateItem($order_item_id, $data)
  {
    return Core::model('db', 'core')->smartInsert('order_items', $data, array('id', $order_item_id));
  }
}
