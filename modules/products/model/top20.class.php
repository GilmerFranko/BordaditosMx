<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al Top 20
 *
 *
 */

class Top20 extends Model
{
  /** Optiene todos los productos */
  public function getAllProductsTop20($params = [], $limit = 20)
  {
    $where = [];

    // Filtrar por estado
    $where[] = 'p.`deleted_at` IS NULL';

    // Construir la cláusula WHERE
    $where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    // Consulta para obtener el total de resultados (sin límite de paginación)
    $total_query = $this->db->query(
      'SELECT COUNT(*) 
        FROM `products` AS p
        INNER JOIN `top_products` AS tp ON p.`id` = tp.`product_id`
        ' . $where_clause
    );

    list($data['total']) = $total_query->fetch_row();

    // Paginador
    $data['pages'] = Core::model('paginator', 'core')->pageIndex(array('products', 'top20', null, $params), $data['total'], $limit);

    // Construir la consulta SQL final con paginación
    $query = $this->db->query(
      'SELECT tp.`id` AS top_id, p.* 
        FROM `products` AS p
        INNER JOIN `top_products` AS tp ON p.`id` = tp.`product_id`
        ' . $where_clause . '
        ORDER BY 
            tp.`position` ASC
        LIMIT ' . $data['pages']['limit']
    );

    // Contar el total de resultados
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
}
