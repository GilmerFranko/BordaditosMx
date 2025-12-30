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

class Products extends Model
{

  /** Optiene todos los productos */
  public function getAllProducts($params = [], $limit = 20)
  {
    $where = [];

    // Filtrar por nombre
    if (!empty($params['name']))
    {
      $where[] = 'p.`name` LIKE "%' . $params['name'] . '%"';
    }

    // Filtrar por estado
    $where[] = 'p.`deleted_at` IS NULL';

    // Ordenar por fecha (ascendente o descendente)
    $order_by = !empty($params['order_by']) && in_array($params['order_by'], ['asc', 'desc'])
      ? $params['order_by']
      : 'desc';

    // Construir la cláusula WHERE
    $where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    // Consulta para obtener el total de resultados (sin límite de paginación)
    $total_query = $this->db->query(
      'SELECT COUNT(*) as p
        FROM `products` AS p
        ' . $where_clause
    );

    $r = $total_query->fetch_assoc();
    $data['total'] = isset($r['p']) ? (int)$r['p'] : 0;
    // filas totales (compatibilidad con vistas que esperan 'rows')
    $data['rows'] = $data['total'];

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

  /**
   * Obtiene las imagenes de un producto
   *
   * @param int $product_id
   * @return 
   */
  public function getProductImages(int $product_id)
  {
    $query = $this->db->query(
      'SELECT * 
       FROM `product_images` 
       WHERE `product_id` = ' . intval($product_id)
    );

    error_log(var_export('SELECT * 
       FROM `product_images` 
       WHERE `product_id` = ' . intval($product_id), true));

    if ($query && $query->num_rows > 0)
    {
      while ($row = $query->fetch_assoc())
      {
        $images[] = $row;
      }
      return $images;
    }
    return false;
  }

  /**
   * Sube las imagenes del producto
   *
   * @return array
   */
  public function uploadFiles(): array
  {
    global $config;
    $msg = [false];
    $image_urls = [];

    // Si hay archivos para subir
    if (isset($_FILES['files']) && is_array($_FILES['files']['name']))
    {
      // Recorre los archivos
      foreach ($_FILES['files']['name'] as $key => $value)
      {
        // Si el archivo no está vacío
        if ($_FILES['files']['size'][$key] > 0)
        {
          // Sube el archivo
          $image_url = loadClass('core/extra')->uploadFile(
            [
              'name' => $_FILES['files']['name'][$key],
              'type' => $_FILES['files']['type'][$key],
              'tmp_name' => $_FILES['files']['tmp_name'][$key],
              'error' => $_FILES['files']['error'][$key],
              'size' => $_FILES['files']['size'][$key]
            ],
            $config['products_path']
          );
          // Si no ha ocurrido un error
          if ($image_url)
          {
            $image_urls[] = $image_url;
          }
          // Si ha habido un error
          else
          {
            // Borra las imagenes subidas
            foreach ($image_urls as $img)
            {
              loadClass('core/extra')->deleteImage($img, $config['products_path']);
            }
            $msg = [false, 'No se ha podido subir la imagen', 'error'];

            return $msg;
          }
        }
      }
    }

    // Carga imagen predefinida
    if (empty($image_urls))
    {
      return [false];
    }

    return [true, $image_urls];
  }

  /**
   * Crea un nuevo producto
   * @param array $data
   * @return int
   */
  public function newProduct(array $data): int
  {
    if ($r = loadClass('core/db')->smartInsert('products', $data))
    {
      return $r;
    }
    return 0;
  }

  /** Sube una imagen (el nombre) de un producto a la base de datos */
  public function newProductFile($product_id, $file_url)
  {
    return loadClass('core/db')->smartInsert('product_images', ['product_id' => $product_id, 'url' => $file_url, 'created_at' => time()]);
  }


  /**
   * Actualiza un registro en la tabla products con los datos proporcionados.
   *
   * @param int $id El ID del registro a actualizar
   * @param array $data Los datos del nuevo registro.
   * @return bool true si se pudo actualizar, false si no.
   */
  public function updateProduct($productId, $data): bool
  {
    $query = loadClass('core/db')->smartInsert('products', $data, ['id', $productId]);

    if ($query == true)
    {
      return true;
    }
    else
    {
      return false;
    }
  }


  /**
   * Verifica si un slug ya existe en la tabla products
   * @param string $slug El slug a verificar
   * @return bool
   */
  public function isSlugAvailable(string $slug, $product_id = null): bool
  {
    $where = 'WHERE p.`slug` = "' . $slug . '"';

    if ($product_id != null)
      $where .= ' AND p.`id` != ' . intval($product_id);

    $query = $this->db->query(
      'SELECT COUNT(*) 
       FROM `products` AS p 
       ' . $where . '
       '
    );

    if ($query && $query->num_rows > 0)
    {
      list($count) = $query->fetch_row();

      return $count == 0;
    }

    return false;
  }

  /** Elimina las imagenes de un producto */
  public function deleteProductFiles($product_id)
  {
    global $config;

    // Obtiene las imagenes del producto
    $query = $this->db->query(
      'SELECT * 
       FROM `products` 
       WHERE `id` = ' . intval($product_id)
    );

    if ($query && $query->num_rows > 0)
    {
      $row = $query->fetch_assoc();
      // Borra la imagen
      loadClass('core/extra')->deleteImage($row['image_url'], $config['products_path']);
    }
  }
}
