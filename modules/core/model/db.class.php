<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo incluye funciones variadas MySQL
 *
 *
 */

class Db extends Model
{

  public function __construct()
  {
    parent::__construct();
    $this->session = Core::model('session', 'core');
  }

  function __destruct()
  {
  }

  /**
   * Obtiene la cuenta de una columna
   *
   * @param string $table
   * @param string $column
   * @param array $where
   * @return string/int/array $input
   */
  public function getCount($table = null, $column = null, $where = null)
  {
    // Escapa el valor de $where[1] si es una cadena, y asegúrate de que esté entre comillas si no es numérico.
    $whereValue = is_numeric($where[1]) ? $where[1] : "'" . $this->db->real_escape_string($where[1]) . "'";

    error_log('SELECT COUNT(`' . $column . '`) FROM `' . $table . '` WHERE `' . $where[0] . '` = ' . $whereValue);
    // Construir la consulta SQL con el valor corregido.
    $query = $this->db->query('SELECT COUNT(`' . $column . '`) FROM `' . $table . '` WHERE `' . $where[0] . '` = ' . $whereValue);

    // Log de la consulta para depuración.

    // Ejecutar la consulta y devolver el resultado.
    if ($query == true && $query->num_rows > 0)
    {
      $result = $query->fetch_row();
      return $result[0];
    }

    return 0;
  }


  /**
   * Obtiene uno o más columnas de una fila
   *
   * @param string $table
   * @param string/array $columns
   * @param array $where
   * @return string/int/array $input
   */
  public function getColumns($table = null, $input = null, $where = null, $limit = 1, $sentence = false)
  {
    $columns = is_array($input) ? implode('`,`', $input) : $input;
    $where = is_null($where) ? 'ORDER BY RAND()' : 'WHERE `' . $where[0] . '` = \'' . $this->db->real_escape_string($where[1]) . '\'';
    $query = $this->db->query('SELECT `' . $columns . '` FROM `' . $table . '` ' . $where . ' LIMIT ' . $limit);
    error_log('SELECT `' . $columns . '` FROM `' . $table . '` ' . $where . ' LIMIT ' . $limit);
    if ($query == true)
    {
      if ($query->num_rows > 0)
      {
        $result = $sentence == true ? $query : $query->fetch_assoc();
        return is_array($input) ? $result : $result[$input];
      }
      else
      {
        //die('La consulta se ejecuto con exíto pero devolvió 0 filas');
        return false;
      }
    }

    return false;
  }

  /**
   * Obtiene una o mas filas de una tabla
   *
   * @param string $table
   * @param string/array $columns
   * @param array $where
   * @return string/int/array $input
   */
  public function getRows($table = null, $input = null, $where = null, $lowerLimit = 1, $upperLimit = 1, $sentence = false)
  {
    $columns = is_array($input) ? implode('`,`', $input) : $input;
    $where = is_null($where) ? 'ORDER BY RAND()' : 'WHERE `' . $where[0] . '` = \'' . $this->db->real_escape_string($where[1]) . '\'';
    $query = $this->db->query('SELECT `' . $columns . '` FROM `' . $table . '` ' . $where . ' LIMIT ' . $lowerLimit . ', ' . $upperLimit);
    error_log('SELECT `' . $columns . '` FROM `' . $table . '` ' . $where . ' LIMIT ' . $lowerLimit . ', ' . $upperLimit);
    if ($query == true)
    {
      $data['rows'] = $query->num_rows;

      if ($data['rows'] > 0)
      {
        while ($row = $query->fetch_assoc())
        {
          $data['data'][] = $row;
        }
      }
      return $data;
    }

    return false;
  }

  /**
   * Elimina una fila de la base de datos
   *
   * @param string $table     // NOMBRE DE LA TABLA
   * @param string $where     // NOMBRE COLUMNA WHERE
   * @param int $id           // ID A ELIMINAR
   * @param int $limit        // LIMITE A ELIMINAR
   * @return boolean/integer
   */
  function deleteRow($table = null, $id = null, $where = 'id', $limit = 1)
  {
    // BORRAR FILA
    $query = $this->db->query('DELETE FROM `' . $table . '` WHERE `' . $where . '` = \'' . $id . '\' LIMIT ' . $limit);
    //
    if ($query == true && $this->db->affected_rows > 0)
    {
      return true;
    }
    // RETORNA FALSE SI NO SE HA ELIMINADO NADA
    return false;
  }

  /**
   * Suma o Resta valor a un campo de una tabla
   *
   * @param string $table
   * @param string $column
   * @param int $id
   * @param string $value
   * @param string $where
   * @param int $limit
   * @return boolean
   */
  function updateCount($table = null, $column = null, $id = null, $value = '+1', $where = 'id', $limit = 1)
  {
    $query = $this->db->query('UPDATE `' . $table . '` SET `' . $column . '` = `' . $column . '` ' . $value . ' WHERE `' . $where . '` = \'' . $id . '\' LIMIT ' . $limit);
    // RETORNAR
    if ($query == true && $this->db->affected_rows > 0)
    {
      return true;
    }
    //
    return false;
  }
  /**
   * Obtiene una o mas columnas de una una cantidad solicitada de filas
   *
   * @param string $table
   * @param string/array $columns
   * @param array $where
   * @return string/int/array $input
   */
  public function getAllRows($table = null, $input = null, $limit = 1, $sentence = false)
  {
    $columns = is_array($input) ? implode('`,`', $input) : $input;
    //$where = is_null($where) ? '' : 'WHERE `'.$where[0].'` = \''.$this->db->real_escape_string($where[1]).'\'';
    $query = $this->db->query('SELECT ' . $columns . ' FROM `' . $table . '`');
    if ($query == true && $query->num_rows > 0)
    {
      while ($row = $query->fetch_assoc())
      {
        $groups['data'][] = $row;
        $groups['rows'] = $query->num_rows;
      }
      return $groups;
    }
    return false;
  }


  public function get_last_id($table = 'members')
  {
    $query = $this->db->query('SELECT * FROM `' . $table . '` ORDER BY DESC LIMIT 1');
    if ($query == true && $query->num_rows > 0)
    {
      return $query;
    }
    return false;
  }


  /**
   * Inserta una fila en una tabla de la base de datos, tomando en cuenta si se debe insertar o actualizar.
   *
   * @param string $table
   * @param array $data
   * @param string|array $where
   * @return int|boolean
   */
  public function smartInsert($table = null, $data = null, $where = null)
  {
    if (!$table || !$data)
    {
      return false;
    }

    // Crear las columnas y valores a insertar
    $columns = implode('`, `', array_keys($data));
    $values = implode('\', \'', array_map([$this->db, 'real_escape_string'], array_values($data)));

    // Construir la cláusula WHERE si se especifica una condición
    $whereClause = '';

    // Preparar la consulta SQL para insertar o actualizar
    if (is_array($where) && count($where) === 2)
    {
      $whereClause = 'WHERE `' . $where[0] . '` = \'' . $this->db->real_escape_string($where[1]) . '\'';

      $setClause = '';
      foreach ($data as $key => $value)
      {
        $setClause .= '`' . $key . '` = \'' . $this->db->real_escape_string($value) . '\', ';
      }
      $setClause = rtrim($setClause, ', ');

      $sql = 'UPDATE `' . $table . '` SET ' . $setClause . ' ' . $whereClause;
      error_log('UPDATE `' . $table . '` SET ' . $setClause . ' ' . $whereClause);
    }
    else
    {
      $sql = 'INSERT INTO `' . $table . '` (`' . $columns . '`) VALUES (\'' . $values . '\')';
      error_log('INSERT INTO `' . $table . '` (`' . $columns . '`) VALUES (\'' . $values . '\')');
    }

    // Ejecutar la consulta y devolver el resultado
    $query = $this->db->query($sql);
    if ($query)
    {
      if (stripos($sql, 'INSERT') !== false)
      {
        return $this->db->insert_id;
      }
      else
      {
        return $this->db->affected_rows;
      }
    }
    else
    {
      return false;
    }
  }
}
