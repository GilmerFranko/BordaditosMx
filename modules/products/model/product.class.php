<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los productos
 *
 *
 */

class Product extends Model
{
  /**
   * Obtener todos los productos con filtros y paginación
   *
   * @param array $params Parámetros de filtro y ordenamiento
   * @param int $limit Número máximo de resultados por página
   * @return array Datos de productos y paginación
   */
  public function getAllProducts($params = [], $limit = 20)
  {
    $where = [];

    // Filtrar por nombre
    if (!empty($params['name']))
    {
      $where[] = 'p.`name` LIKE "%' . $params['name'] . '%"';
    }

    $where[] = 'p.`deleted_at` IS NULL';

    // Ordenar por fecha (ascendente o descendente)
    $order_by = !empty($params['order_by']) && in_array($params['order_by'], ['asc', 'desc'])
      ? $params['order_by']
      : 'desc';

    // Construir la cláusula WHERE
    $where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    // Consulta para obtener el total de resultados (sin límite de paginación)
    $total_query = $this->db->query(
      'SELECT COUNT(*) 
        FROM `products` AS p
        ' . $where_clause
    );

    list($data['total']) = $total_query->fetch_row();

    // Paginador
    $data['pages'] = Core::model('paginator', 'core')->pageIndex(array('admin', 'products', null, $params), $data['total'], $limit);

    // Construir la consulta SQL final con paginación
    $query = $this->db->query(
      'SELECT * 
        FROM `products` AS p
        ' . $where_clause . '
        ORDER BY 
            p.`created_at` ' . $order_by . '
        LIMIT ' . $data['pages']['limit']
    );
    error_log('SELECT * 
        FROM `products` AS p
        ' . $where_clause . '
        ORDER BY 
            p.`created_at` ' . $order_by . '
        LIMIT ' . $data['pages']['limit']);
    $data['rows'] = $query->num_rows;

    // Obtener los resultados de la consulta
    if ($query && $data['rows'] > 0)
    {
      while ($row = $query->fetch_assoc())
      {
        $data['data'][] = $row;
      }
    }

    return $data;
  }

  /**
   * Obtiene un producto por su ID
   *
   * @param int $product_id
   * @return array|false
   */
  public function getProductById(int $product_id)
  {
    $query = $this->db->query(
      'SELECT * 
       FROM `products` 
       WHERE `id` = ' . intval($product_id) . ' 
       LIMIT 1'
    );

    if ($query && $query->num_rows > 0)
    {
      return $query->fetch_assoc();
    }

    return false;
  }
}
