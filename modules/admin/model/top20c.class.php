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

class Top20c extends Model
{
  /**
   * Obtiene los productos del Top 20
   * @return array
   */
  public function getTopProducts(): array
  {
    $query = $this->db->query(
      'SELECT tp.product_id, p.name, p.image_url, tp.*
             FROM `top_products` AS tp
             JOIN `products` AS p ON tp.product_id = p.id
             ORDER BY tp.position ASC'
    );

    $data = [];
    if ($query && $query->num_rows > 0)
    {
      while ($row = $query->fetch_assoc())
      {
        $data[] = $row;
      }
    }

    return $data;
  }

  /**
   * Cuenta los productos en el Top 20
   * @return int
   */
  public function countTopProducts(): int
  {
    $query = $this->db->query('SELECT COUNT(*) AS total FROM `top_products`');
    list($total) = $query->fetch_row();
    return intval($total);
  }

  /**
   * Verifica si un producto ya está en el Top 20
   * @param int $productId
   * @return bool
   */
  public function isInTop(int $productId): bool
  {
    $query = $this->db->query(
      'SELECT 1 
             FROM `top_products` 
             WHERE `product_id` = ' . intval($productId)
    );

    return $query && $query->num_rows > 0;
  }

  /**
   * Agrega un producto al Top 20
   * @param int $productId
   * @return bool
   */
  public function addToTop(int $productId): bool
  {
    if ($this->countTopProducts() >= 20)
    {
      error_log('El Top 20 ya está completo.');
      return false;
    }

    // Determinar la nueva posición
    $position = $this->countTopProducts() + 1;

    $query = $this->db->query(
      'INSERT INTO `top_products` (`product_id`, `position`) 
             VALUES (' . intval($productId) . ', ' . intval($position) . ')'
    );

    return $query !== false;
  }

  /**
   * Elimina un producto del Top 20
   * @param int $productId
   * @return bool
   */
  public function removeFromTop(int $productId): bool
  {
    $query = $this->db->query(
      'DELETE FROM `top_products` 
             WHERE `product_id` = ' . intval($productId)
    );

    if ($query)
    {
      $this->reorderTopPositions();
      return true;
    }

    return false;
  }

  /**
   * Reordena las posiciones del Top 20
   * @return void
   */
  private function reorderTopPositions(): void
  {
    $query = $this->db->query(
      'SELECT `product_id` 
             FROM `top_products` 
             ORDER BY `position` ASC'
    );

    if ($query && $query->num_rows > 0)
    {
      $position = 1;
      while ($row = $query->fetch_assoc())
      {
        $this->db->query(
          'UPDATE `top_products` 
                     SET `position` = ' . $position . ' 
                     WHERE `product_id` = ' . intval($row['product_id'])
        );
        $position++;
      }
    }
  }

  /**
   * Obtiene los productos disponibles que no están en el Top 20
   * @return array
   */
  public function getAvailableProductsNotInTop(): array
  {
    $query = $this->db->query(
      'SELECT p.id, p.name 
             FROM `products` AS p
             WHERE p.id NOT IN (
                 SELECT tp.product_id 
                 FROM `top_products` AS tp
             )
             AND p.status = 1
             ORDER BY p.name ASC'
    );

    $data = [];
    if ($query && $query->num_rows > 0)
    {
      while ($row = $query->fetch_assoc())
      {
        $data[] = $row;
      }
    }

    return $data;
  }


  public function searchProductsNotInTop(string $query): array
  {
    global $config;

    $sql = "
        SELECT id, name, image_url 
        FROM products 
        WHERE name LIKE '%" . $query . "%' 
        AND id NOT IN (SELECT product_id FROM top_products)
        LIMIT 10
    ";

    $query = $this->db->query($sql);
    if ($query and $query->num_rows > 0)
    {
      while ($row = $query->fetch_assoc())
      {
        $row['image_url'] = $config['products_url'] . '/' . $row['image_url'];
        $data[] = $row;
      }
      return $data;
    }
    return [];
  }
  public function moveProductUp($productId, $currentPosition)
  {
    // Mover el producto hacia arriba (intercambiar con el producto anterior)
    $previousPosition = $currentPosition - 1;

    // Escapar valores para evitar inyecciones SQL
    $productId = (int) $productId;
    $previousPosition = (int) $previousPosition;

    // Realizar la actualización del producto que estaba en la posición anterior
    $query1 = "UPDATE top_products SET position = position + 1 WHERE position = $previousPosition";
    $this->db->query($query1);

    // Actualizar la posición del producto actual
    $query2 = "UPDATE top_products SET position = position - 1 WHERE product_id = $productId";
    $this->db->query($query2);
  }

  public function moveProductDown($productId, $currentPosition)
  {
    // Mover el producto hacia abajo (intercambiar con el producto siguiente)
    $nextPosition = $currentPosition + 1;

    // Escapar valores para evitar inyecciones SQL
    $productId = (int) $productId;
    $nextPosition = (int) $nextPosition;

    // Realizar la actualización del producto que estaba en la posición siguiente
    $query1 = "UPDATE top_products SET position = position - 1 WHERE position = $nextPosition";
    $this->db->query($query1);

    // Actualizar la posición del producto actual
    $query2 = "UPDATE top_products SET position = position + 1 WHERE product_id = $productId";
    $this->db->query($query2);
  }

  public function getProductByIdInTop($productId)
  {
    // Escapar el valor del ID del producto para evitar inyecciones SQL
    $productId = (int) $productId;  // Asegúrate de que el ID sea un número entero

    // Consulta directa
    $query = "SELECT id, position FROM top_products WHERE product_id = $productId AND position <= 20 LIMIT 1";
    // Ejecutar la consulta
    $result = $this->db->query($query);

    // Verificar si la consulta ha devuelto algún resultado
    if ($result && $result->num_rows > 0)
    {
      return $result->fetch_assoc(); // Devuelve el producto como un array asociativo
    }

    // Si no se encuentra el producto en el Top 20, retorna false
    return false;
  }

  // Optiene la posicion más baja actual
  public function getLowestPosition(): int
  {
    $query = $this->db->query('SELECT position FROM top_products ORDER BY position DESC LIMIT 1');
    return $query->num_rows > 0 ? $query->fetch_assoc()['position'] : 20;
  }
}
