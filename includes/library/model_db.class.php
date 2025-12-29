<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de administrar y proporcionar metodos/funciones rapidas referente a tablas de la base de datos
 *
 *
 */

class Models extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function __destruct()
	{
		$this->resetAll();
	}

	/* Propiedades */
	public $id        = 'id';

	/* Tabla predefinida */
	private $table    = 'clients';
	/**
	 * Consulta SQL
	 */
	private $sentence = '';
	/**
	 * 	Clausula WHERE
	 */
	private $where    = array();
	/**
	 * 	Clausula Order By
	 */
	private $orderBy  = '';
	/**
	 * 	Clausula Limit
	 */
	private $limit    = '';
	/**
	 * 	Clausula Beetween
	 */
	private $between  = 'LIMIT 1';
	/**
	 * 	Clausula Like
	 */
	private $like     = '';
	/**
	 * 	Clausula Select
	 */
	private $select   = 'SELECT';
	/**
	 * 	Columnas Seleccionadas
	 */
	private $columns  = [];
	/**
	 * 	(((Propiedad FROM)))
	 */
	private $from     = 'FROM';

	/**
	 * Consulta de totales
	 * @var array
	 */
	private $totals   = array();

	/* Metodos */

	/**
	 * Establece la tabla a manipular
	 * @param [type] $table [description]
	 */
	public function set_table($table)
	{
		$this->table = $table;
	}

	public function get_table()
	{
		return $this->table;
	}

	/** CONSULTAS **/

	public function simpleInsert($data)
	{
		/** HACE FALTA AGREGAR UNA MEDIDA DE SEUGURIDAD PARA INYECCIONES SQL */
		$estruct = array_keys($data);
		$estruct = implode('`,`', $estruct);
		$values  = array_values($data);
		$values = implode('\',\'', $values);
		$sql     =  ('INSERT INTO ' . $this->table . ' (`' . $estruct . '`) VALUES (\'' . $values . '\')');

		if ($this->db->query($sql))
		{
			return true;
		}
		return false;
	}

	/**
	 * Devuelve la ultima fila de la tabla
	 * @return [type] [description]
	 */
	public function getLastRow($last = 1)
	{
		$sql = $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY ' . $this->id . ' DESC LIMIT 0, ' . $last . '');
		if ($sql and $sql->num_rows > 0) return (object) $sql->fetch_assoc();
		else return false;
	}

	/**
	 * 	Devuelve todas las filas de la tabla
	 * @return 	Array
	 */
	public function getAll()
	{
		$this->resetAll();
		$this->where['sql'] = '';
		$this->limit('none');
		return $this->get();
	}

	/**
	 * Establece las columnas a seleccionar
	 *
	 * @param  array|mixed  $columns
	 * @return $this
	 */
	public function select($columns = ['*'])
	{
		$this->columns = [];
		$this->bindings['select'] = [];
		$columns = is_array($columns) ? $columns : func_get_args();

		foreach ($columns as $as => $column)
		{

			$this->columns[] = $column;
		}
		$this->prepareColumns();
		return $this;
	}


	/** CLAUSULAS **/

	/**
	 * [where description]
	 * @param  string $column   Columna de la tabla
	 * @param  string $operator Operador logico
	 * @param  string $value    Valor a examinar
	 * @param  string $boolean  Determina si es imprecindible esta clausula where (and, or)
	 * @return
	 */
	public function where($column, $operator = null, $value = null, $boolean = 'and')
	{

		/**
		 * Almacena estructura de la clausula WHERE
		 */
		$this->where['struct'][] = array('column' => $column, 'operator' => $operator, 'value' => $value, 'boolean' => $boolean);

		/**
		 * Separador
		 */
		$space = ' ';


		/* Si $where no esta vacio entonces se concidera
  	 * necesaria la implementacion de los operadores
  	 */
		if (!empty($this->where['sql']))
		{
			/**
			 * ID del ultimo item
			 */
			$lastItem = (count($this->where['struct']) - 1);
			/**
			 * Operador del ultimo item
			 */
			$lastBoolean = $this->where['struct'][$lastItem]['boolean'];
			/**
			 * Se agrega la clausula al sql
			 */
			$this->where['sql'] .= $space . $lastBoolean . $space . $column . $space . $operator . $space . '\'' . $value . '\'';
		}
		else
		{
			/**
			 * Se agrega la clausula al sql
			 */
			$this->where['sql'] = 'WHERE ' . $column . $space . $operator . $space . '\'' . $value . '\'';
		}
		//echo $this->where['sql'];
		return $this;
	}

	/**
	 * Comprueba la integridad de la Clausula WHERE
	 * @return [type] [description]
	 */
	public function checkWhere()
	{
		if (isset($this->where['sql']))
		{
			return true;
		}
		else
		{
			$this->defaultWhere();
		}
		return false;
	}


	/**
	 * Devuelve la consulta SQL como resultado
	 * @param  boolean $count Determina si solo se requiere devolver la cantidad de filas encontradas
	 * @return mysqliObject/array/int
	 */
	public function get($count = false)
	{
		$this->exect();

		/* Construye la consulta */
		$this->sentence = $this->select . SPACE . $this->columns . SPACE . $this->totals['sql'] . SPACE . $this->from . SPACE . $this->table . SPACE . $this->where['sql'] . SPACE . $this->orderBy . SPACE . $this->limit;
		error_log('Sentencia: <strong style="color:blue">' . $this->sentence . '</strong>');
		/* Ejecuta la consulta */
		$query = $this->db->query($this->sentence);
		if ($query == true)
		{
			if ($count)
			{
				return $this->returnGet($query->num_rows);
			}

			elseif ($query->num_rows > 0)
			{


				/**
				 * Devuelve objeto cuando solo es un resultado
				 * @var [type]
				 */
				if ($query->num_rows == 1)
				{
					$result = $query->fetch_assoc();
					$return = (object) ($this->columns == '*') ? $result : (is_array($this->columns) ? $result : $result[$this->columns]);
					return $this->returnGet($return);
				}
				/**
				 * De ser mas de un resultado,
				 * Devuelve todos los resultados
				 * de forma empaquetada
				 */
				else
				{
					$row = [];
					while ($result = mysqli_fetch_assoc($query))
					{
						$row[] = $result;
					}
					return $this->returnGet($row);
				}
			}
			else
			{
				Core::model('errors', 'core')->setError('bd-syntax.no_arrows', __LINE__, __FILE__);
				return $this->returnGet(false);
			}
		}
		Core::model('errors', 'core')->setError('bd-syntax', __LINE__, __FILE__);
		return $this->returnGet(false);
	}

	/**
	 * Inicia la preparacion para ejecutar la consulta SQL
	 * @return $this
	 */
	public function exect()
	{
		if (!$this->checkWhere()) Core::model('errors', 'core')->setError('bd-syntax.where', __LINE__, __FILE__);
		if (!$this->prepareColumns());
		if (!$this->prepareTotals());
		//$this->verifyOrdeBy();
		//$this->verifyLimit();
		return $this;
	}

	/**
	 * Verifica integridad en las columnas seleccionadas
	 * @return String
	 */
	public function prepareColumns()
	{
		/**
		 * Si el array esta vacio entonces se concidera que el programador
		 * quiere solicitar todas las columnas de la tabla, si no
		 * se seleccionan solo las tablas que él indique.
		 * @var array string
		 */
		$this->columns = ($this->columns == null) ? '*' : ((is_array($this->columns) ?  '`' . implode('`,`', $this->columns) . '`' : $this->columns));
		$this->columns = $this->securityClean($this->columns);
	}

	/**
	 * Hace un limpieza de seguridad en una variable
	 * para impedir inyección SQL y otras inseguridades mas
	 * en revisión
	 * @param  String $var
	 * @return String
	 */
	public function securityClean(String $var)
	{
		return $this->db->real_escape_string($var);
	}

	/**
	 * Resetea todas las propiedades para una nueva consulta.
	 * @return  $this
	 */
	public function resetAll()
	{

		/**
		 * Consulta SQL
		 */
		$this->sentence = '';
		/**
		 * 	Clausula WHERE
		 */

		$this->where    = array();
		/**
		 * 	Clausula Order By
		 */

		$this->orderBy  = '';
		/**
		 * 	Clausula Limit
		 */
		$this->limit    = 'LIMIT 1';
		/**
		 * 	Clausula Beetween
		 */
		$this->between  = '';
		/**
		 * 	Clausula Like
		 */
		$this->like     = '';
		/**
		 * 	Clausula Select
		 */
		$this->select   = 'SELECT';
		/**
		 * 	Columnas Seleccionadas
		 */
		$this->columns  = [];
		/**
		 * 	(((Propiedad FROM)))
		 */
		$this->from     = 'FROM';
		/**
		 * Consulta de totales
		 * @var array
		 */
		$this->totals   = array();
	}

	/**
	 * [defaultWhere description]
	 * @return [type] [description]
	 */
	public function defaultWhere()
	{
		$this->where['sql'] = SPACE;
	}

	/**
	 * [whereID description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function whereID($id)
	{
		if (is_numeric($id))
		{
			$this->where($this->id, '=', $id);
			return $this;
		}
		else
		{
			Core::model('errors', 'core')->setError('argument.invalid', __LINE__, __FILE__);
			return false;
		}
		return false;
	}

	/**
	 * Devuelve la cantidad de filas encontradas
	 * Solo en un SELECT
	 * @return [type] [description]
	 */
	public function numRows()
	{
		return $this->get(true);
	}

	/**
	 * [count description]
	 * @param  [type] $column [description]
	 * @return [type]         [description]
	 */
	public function count($column)
	{
		$this->totals['t'][] = array('COUNT', $column);
		return $this;
	}

	/**
	 * Verifica integridad en las consultas de totales
	 * @return String
	 */
	public function prepareTotals()
	{
		/**
		 *
		 * @var array string
		 */

		if (!empty($this->totals))
		{
			$this->totals['sql'] = ', ';

			if (!empty($this->totals['t']))
			{
				foreach ($this->totals['t'] as $key => $value)
				{
					$this->totals['sql'] .= $value[0] . '(`' . $value[1] . '`)';
				}
			}


			$this->totals['sql'] = $this->securityClean($this->totals['sql']);
		}
		else
		{
			$this->totals['sql'] = '';
		}
	}

	/**
	 * Metodo para finalizar la ejecución de este
	 * modelo devolviendo la consulta final
	 * y al mismo tiempo formatear las
	 * variables utilizadas
	 * @return [type] [description]
	 */
	public function returnGet($return = null)
	{
		$this->resetAll();
		return $return;
	}

	/**
	 * Aplica un limite a la sentencia SELECT
	 * @param  integer/string $limit limite
	 * @return $this
	 */
	public function limit($limit = 1)
	{
		/**
		 * No aplicar limites
		 */
		if ($limit == 'none')
		{
			$this->limit = 'LIMIT 18446744073709551615';
		}
		else
		{
			$this->limit = 'LIMIT ' . $limit;
		}
		return $this;
	}
}
