<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Archivo que contiene varias funciones intuitivas, rápidas e imprescindibles
 * La mayoría de esas funciones ya están creadas en otros archivos pero se añadieron como enlace aquí para facilitar su uso
 *
 */

/**
 * Carga una clase de un modulo
 * @param  String $route Ruta
 * @return Class
 */
function loadClass(String $route)
{
  if ($route = explode('/', $route))
  {
    return Core::model($route[1], $route[0]);
  }
  return false;
}

/**
 * Carga la clase relacionada a una tabla
 * @param  String $tabla Nombre de la tabla
 * @return Class
 */
function db(String $table)
{
  return LoadTable::model($table . 'DB');
}

/**
 * Muestra un texto en la consola del navegador
 * @param  string $string
 */
function showlog($string = '', $var_export = true)
{
  if ($var_export)
  {
    $string = var_export($string, 1);
  }

  echo '<script>console.log(\'' . str_replace(array("'", '"'), array("\\'", '\"'), $string) . '\')</script>';
  setToast([$string]);
  error_log($string);
}


function setToast($data)
{
  loadClass('core/extra')->setToast($data);
}

function setSwal($data)
{
  loadClass('core/extra')->setSwal($data);
}

function setTI($data)
{
  loadClass('core/extra')->setTI($data);
}

/**
 * Escapa un string de inyeccion sql
 */
function esc($string)
{
  return db()->real_escape_string($string);
}

/**
 * Genera un enlace
 * (funcion minimizada)
 */
function gLink($route = null, $params = null, $redirect = false)
{
  if ($route = explode('/', $route))
  {
    if (!isset($route[1]) or empty($route[1]))
    {
      $route[1] = '';
    }
    return loadClass('core/extra')->generateUrl($route[0], $route[1], null, $params, $redirect);
  }
}

/**
 * Redirige a un enlace
 * (funcion minimizada)
 */
function redirect($route = null, $params = null)
{
  if ($route = explode('/', $route))
  {
    return loadClass('core/extra')->generateUrl($route[0], $route[1], null, $params, true);
  }
}

function gourl($route, $params = null)
{
  if ($route = explode('/', $route))
  {
    $url = loadClass('core/extra')->generateUrl($route[0], $route[1], null, $params);

    echo '<meta http-equiv="refresh" content="0; url=' . $url . '">';
    exit;
  }
}



/**
 * 
 */
function escape($string, $connect = null)
{
  global $extra;
  if ($connect == null)
  {
    $connect = $extra->db;
  }
  return $connect->real_escape_string($string);
}

/**
 * Limpia un string para evitar inseguridades como inyección SQL, XSS, y otros tipos de ataques.
 *
 * @param string $input El string a limpiar.
 * @param mysqli|null $db Conexión a la base de datos (si se utiliza para inyecciones SQL).
 * @return string El string limpio.
 */
function cleanInput($input, $db = null)
{
  // Elimina espacios al inicio y al final
  $input = trim($input);

  // Elimina caracteres no imprimibles y convierte todos los caracteres al formato UTF-8
  $input = mb_convert_encoding($input, 'UTF-8', 'UTF-8');

  // Evita inyecciones de código HTML y JavaScript (XSS)
  $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

  $input = escape($input);

  // Elimina etiquetas HTML y PHP
  $input = strip_tags($input);

  // Opcional: Limita la longitud del string para evitar desbordamientos
  $input = substr($input, 0, 10000);

  return $input;
}


/**Envia notificacion al usuario **/
function newNotification($to_member = null, $from_member = null, $key = 'general', $item = 0, $subitem = 0, $content = '', $myself = false, $check = false, $time = 'UNIX_TIMESTAMP()')
{
  return loadClass('members/notifications')->newNotification($to_member, $from_member, $key, $item, $subitem, $content, $myself, $check, $time);
}

/* Establecer mensaje de debug */
function debug($string)
{
  $_SESSION['debug'][] = $string;
  error_log($string);
}

/* Devuelve mensajes de debug en HTML con colores */
function debugHTML()
{
  if (isset($_SESSION['debug']))
  {
    foreach ($_SESSION['debug'] as $string)
    {
      echo '<span class="blue-text">' . $string . '</span><br>';
    }
  }
  unset($_SESSION['debug']);
}

/**
 * Genera un identificador único
 */
function generateUUID($length = 28)
{
  $key = substr(md5(uniqid(true) . microtime()), 0, $length);
  //
  return $key;
}

/**
 * Optiene el saldo de un usuario
 */
function getBalance($member_id = null)
{
  return loadClass('members/member')->getBalance($member_id);
}

/**
 * Limpia un string
 * @param mixed $var
 * @return string
 */
function cleanString($var, $escape = true)
{
  $var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  $var = trim($var);

  if ($escape)
  {
    $var = escape($var);
  }

  return $var;
}

/**
 * Obtiene uno o más columnas de una fila
 * @param string $table
 * @param array $where
 */
function getColumns($table, $columns = null, $where = [], $limit = 1, $sentence = false)
{
  return loadClass('core/db')->getColumns($table, $columns, $where, $limit, $sentence);
}


/**
 * Corta un string x caracteres
 * @param string $string
 * @param int $length
 * @return string
 */
function cutText($string, $length = 128)
{
  if (strlen($string) > $length)
  {
    $string = substr($string, 0, $length);
    $string = rtrim($string, "!,.-");
    $string = $string . '...';
  }

  return $string;
}

/**
 * Obtiene el texto plano de un string que puede contener BBCode
 * @param string $string
 * @return string
 */
function getPlainText($string)
{
  global $parser;

  $string = strip_tags($string);
  // Parsear el BBCode
  $parser->parse($string);
  // Obtener el texto sin las etiquetas BBCode
  $string = $parser->getAsText();
  // Quitar etiquetas sobrantes
  $string = preg_replace('/\[(\/?)(size|font|color)[^\]]*\]/i', '', $string);

  return $string;
}


/**
 *  Funcion para convertir una cadena de texto en un formato de texto con saltos de linea
 */
function tobr($string)
{
  $string = str_replace(htmlentities('[br]'), "<br>", $string);
  return nl2br($string);
}

function nl2br2($string)
{

  $string = str_replace(array("\r\n", "\r", "\n"), "<br>", $string);

  return $string;
}


/**
 * Reemplaza los saltos de linea <br> por saltos de linea normales \n
 * @param string $string
 * @return string
 */
function br2nl($string)
{
  return $nl = preg_replace('#<br\s*/?>#i', "\n", $string);
}
function bbbr2nl($string)
{
  return str_replace('[br]', "\n", $string);
}
/**
 * Gets the URL of an image
 *
 * @param string $image
 * @param string $path
 * @return string
 */
function gImage(string $image = '', string $path = null, bool $echo = true): string
{
  global $config;

  $urls = [
    'avatar' => $config['avatar_url'],
  ];

  return isset($urls[$path]) ? $urls[$path] . '/' . $image : $config['images_url'] . '/' . $image;
}

/**
 * Obtiene la extension de un archivo o cadena pasada como par ametro
 *
 * @param string $cadena El nombre del archivo o cadena a analizar
 * @return string La extension del archivo o cadena
 */
function obtenerExtension($cadena)
{
  $partes = explode('.', $cadena);
  return end($partes);
}

// Función para convertir cadenas de tamaño de php.ini (ej., "2M", "10G") a bytes
function convertToBytes($size)
{
  $size = trim($size);
  $last = strtolower($size[strlen($size) - 1]);
  $size = (int)$size;
  switch ($last)
  {
    case 'g':
      $size *= 1024;
    case 'm':
      $size *= 1024;
    case 'k':
      $size *= 1024;
  }
  return $size;
}


/**
 * Normaliza una cadena para usarla como slug.
 * - Convierte a UTF-8
 * - Transliteración (iconv) si está disponible
 * - Remueve caracteres no alfanuméricos reemplazándolos por guiones
 * - Colapsa guiones repetidos y recorta guiones al inicio/fin
 * - Convierte a minúsculas y limita longitud
 *
 * @param string $text Texto a normalizar
 * @param int $maxLength Longitud máxima del slug (0 para ilimitado)
 * @return string Slug limpio (si queda vacío devuelve 'n-a')
 */
function cleanSlug($text, $maxLength = 200)
{
  $text = (string)$text;
  $text = trim($text);

  // Asegurar codificación UTF-8
  $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

  // Intentar transliterar caracteres UTF-8 a ASCII (eg. á -> a)
  if (extension_loaded('iconv'))
  {
    $trans = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    if ($trans !== false)
    {
      $text = $trans;
    }
  }

  // Reemplazo manual para algunos caracteres si iconv no cubre todos los casos
  $map = array(
    'À' => 'A',
    'Á' => 'A',
    'Â' => 'A',
    'Ã' => 'A',
    'Ä' => 'A',
    'Å' => 'A',
    'Æ' => 'AE',
    'Ç' => 'C',
    'È' => 'E',
    'É' => 'E',
    'Ê' => 'E',
    'Ë' => 'E',
    'Ì' => 'I',
    'Í' => 'I',
    'Î' => 'I',
    'Ï' => 'I',
    'Ð' => 'D',
    'Ñ' => 'N',
    'Ò' => 'O',
    'Ó' => 'O',
    'Ô' => 'O',
    'Õ' => 'O',
    'Ö' => 'O',
    'Ø' => 'O',
    'Ù' => 'U',
    'Ú' => 'U',
    'Û' => 'U',
    'Ü' => 'U',
    'Ý' => 'Y',
    'Þ' => 'TH',
    'ß' => 'ss',
    'à' => 'a',
    'á' => 'a',
    'â' => 'a',
    'ã' => 'a',
    'ä' => 'a',
    'å' => 'a',
    'æ' => 'ae',
    'ç' => 'c',
    'è' => 'e',
    'é' => 'e',
    'ê' => 'e',
    'ë' => 'e',
    'ì' => 'i',
    'í' => 'i',
    'î' => 'i',
    'ï' => 'i',
    'ð' => 'd',
    'ñ' => 'n',
    'ò' => 'o',
    'ó' => 'o',
    'ô' => 'o',
    'õ' => 'o',
    'ö' => 'o',
    'ø' => 'o',
    'ù' => 'u',
    'ú' => 'u',
    'û' => 'u',
    'ü' => 'u',
    'ý' => 'y',
    'þ' => 'th',
    'ÿ' => 'y',
    'Ŕ' => 'R',
    'ŕ' => 'r'
  );
  $text = strtr($text, $map);

  // Pasar a minúsculas
  $text = strtolower($text);

  // Reemplazar cualquier caracter no alfanumérico por guiones
  $text = preg_replace('/[^a-z0-9]+/', '-', $text);

  // Colapsar guiones múltiples
  $text = preg_replace('/-+/', '-', $text);

  // Eliminar guiones del inicio y fin
  $text = trim($text, '-');

  // Limitar longitud
  if ($maxLength > 0 && strlen($text) > $maxLength)
  {
    $text = substr($text, 0, $maxLength);
    $text = rtrim($text, '-');
  }

  return $text === '' ? 'n-a' : $text;
}
