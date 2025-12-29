<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo incluye funciones variadas con utilización frecuente
 *
 * NOTA: ESTA CLASE NO ES UNICA; SE PARTICIONARÁ
 */

class Extra extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
        $this->session->platform = $this->getPlatform();

        /*if(count($_SESSION) > 1):

if($_SESSION['lastUrl'][1] != $this->getCurrentUrl()) $_SESSION['lastUrl'][] = $this->getCurrentUrl();

if(count($_SESSION['lastUrl'])>1 AND $_SESSION['lastUrl'][1] != $this->getCurrentUrl()) array_shift($_SESSION['lastUrl']);

endif;

if(count($_SESSION['lastUrl'])>2) array_shift($_SESSION['lastUrl']);*/
    }

    function __destruct()
    {
    }

    /**
     * Muestra un mensaje informativo TOAST MATERIALIZECSS
     */
    public function getToast($messages = array())
    {
        $messages = !empty($messages) ? $messages : (isset($_SESSION['message']) ? $_SESSION['message'] : array());

        foreach ($messages as $message)
        {

            if (!empty($message))
            {
                $html = '<script>window.onload = function() {';

                foreach ($message as $key => $msg)
                {
                    if (!empty($msg[0]))
                    {
                        $html .= ("M.toast({html: '" . $msg[0] . "'}); ");
                    }
                }
                $html .= '};</script>';

                unset($_SESSION['message']);

                return $html;
            }

            return '';
        }
    }

    /**
     * Muestra un mensaje informativo Sweet Alert
     */
    public function getSwal($messages = array())
    {
        $messages = !empty($messages) ? $messages : (isset($_SESSION['message_s']) ? $_SESSION['message_s'] : array());

        foreach ($messages as $message)
        {

            if (!empty($message))
            {
                $html = '<script>window.onload = function() {';

                $msg = $message[0];

                /* Es una alerta con boton para redireccionar */
                if (!empty($msg[0]) and isset($msg[3]))
                {
                    $html .= ("swal.fire({title: '" . $msg[0] . "', html: '" . $msg[1] . "', icon: '" . $msg[2] . "'}).then(function() { window.location.href = '" . $msg[3] . "';}); ");
                }
                elseif (!empty($msg[0]))
                {
                    $html .= ("swal.fire({title: '" . $msg[0] . "', html: '" . $msg[1] . "', icon: '" . $msg[2] . "'}); ");
                }

                $html .= '};</script>';

                unset($_SESSION['message_s']);

                return $html;
            }

            return '';
        }
    }


    /**
     * Muestra un mensaje informativo TOASTIFY
     */
    public function getTI($messages = array())
    {
        $messages = !empty($messages) ? $messages : (isset($_SESSION['message_ti']) ? $_SESSION['message_ti'] : array());

        foreach ($messages as $message)
        {

            if (!empty($message))
            {
                $html = '<script>window.onload = function() {';

                foreach ($message as $key => $msg)
                {
                    if (!empty($msg[0]))
                    {
                        $html .= ("Toastify({text: '" . $msg[0] . "', duration: 6000, backgroundColor: '#19191a'}).showToast(); ");
                    }
                }
                $html .= '};</script>';

                unset($_SESSION['message_ti']);

                return $html;
            }

            return '';
        }
    }


    function setToast($message = array())
    {
        /* Eliminar vacios */
        $message = array_filter($message);

        if (!empty($message))
        {
            /* Ordenar array */
            sort($message);

            /* Establece el mensaje en la sesión */
            $_SESSION['message'][] = $message;

            return true;
        }


        return false;
    }

    function setSwal($message = array())
    {
        /* Eliminar vacios */
        $message = array_filter($message);

        if (!empty($message))
        {
            /* Ordenar array */
            sort($message);

            /* Establece el mensaje en la sesión */
            $_SESSION['message_s'][] = $message;

            return true;
        }

        return false;
    }

    /**
     * Establece un mensaje informativo TOASTIFY
     */
    function setTI($message = array())
    {
        /* Eliminar vacios */
        $message = array_filter($message);

        if (!empty($message))
        {
            /* Ordenar array */
            sort($message);

            /* Establece el mensaje en la sesión */
            $_SESSION['message_ti'][] = $message;

            return true;
        }

        return false;
    }


    /**
     * Obtiene y retorna el valor de un input
     */
    function getInputValue($name = null, $type = 'post', $alt = null)
    {
        // VALOR PREDETERMINADO
        $value = $alt;
        // SI HAY CONTENIDO EN FORMULARIO
        if (($type == 'post' || $type = 'both') && isset($_POST[$name]))
        {
            $value = $_POST[$name];
        }
        // SI HAY CONTENIDO EN PARÁMETROS URL
        if (($type == 'get' || $type = 'both') && isset($_GET[$name]))
        {
            $value = $_GET[$name];
        }
        //
        if (!is_null($value))
        {
            $value = htmlspecialchars($value);
        }
        return $value;
    }

    // /**
    //  * Genera un enlace
    //  */
    // function generateUrl($app = NULL, $section = NULL, $area = NULL, $params = NULL, $redirect = false)
    // {
    //     $url  = $this->config['base_url'] . '/index.php?app=';
    //     $url .= (isset($app) ? $app : 'core') . '&section=';
    //     $url .= isset($section) ? $section : 'index';
    //     $url .= isset($area) ? '&area=' . $area : '';
    //     //
    //     if (isset($params) && is_array($params)) {
    //         foreach ($params as $key => $val) {
    //             $url .= '&' . $key . '=' . $val;
    //         }
    //     }
    //     //
    //     if ($redirect == true) {
    //         $this->redirectTo($url);
    //     }
    //     //
    //     return $url;
    // }

    /**
     * Genera un enlace
     */
    function generateUrl($app = NULL, $section = NULL, $area = NULL, $params = NULL, $redirect = false)
    {
        $url  = $this->config['base_url'] . '/';
        $url .= (isset($app) ? $app : 'core') . '/';
        $url .= isset($section) ? $section : 'index';
        $url .= isset($area) ? '&area=' . $area : '';
        //
        if (isset($params) && is_array($params))
        {
            foreach ($params as $key => $val)
            {
                $url .= '&' . $key . '=' . $val;
            }
        }
        //
        if ($redirect == true)
        {
            $this->redirectTo($url);
        }
        //
        return $url;
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
     * Limpia una cadena de caracteres
     */
    function cleanVar($var)
    {
        if (is_numeric($var) || ctype_digit($var))
        {
            $var = (int)$var;
        }
        //
        //filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        //
        $var = htmlspecialchars($var);
        //
        return $var;
    }

    /**
     * Controla el flood
     *
     * @param
     * @return string | boolean
     */
    public function antiFlood($type = 'general', $msg = '', $print = true, $flood = 5)
    {
        // SI SOY MOD/ADMIN NO TENGO ANTIFLOOD
        if ($this->session->is_admod == true)
        {
            return true;
        }

        // REDECLARAR VARIABLE
        $_SESSION['flood'][$type] = isset($_SESSION['flood'][$type]) ? $_SESSION['flood'][$type] : time() - $flood;
        // TIEMPO ACTUAL
        $now = time();
        // MENSAJE DE FLOOD
        $msg = empty($msg) ? 'No puedes realizar tantas acciones en tan poco tiempo.' : $msg;
        // TIEMPO TRANSCURRIDO
        $transcurrido = $now - $_SESSION['flood'][$type];
        // TIEMPO RESTANTE
        $restante = $flood - $transcurrido;
        // COMPROBAR FLOOD
        if ($transcurrido < $flood)
        {
            $msg = '0: ' . $msg . ': ' . $restante . ' segundos.';
            // TERMINAR O RETORNAR VALOR
            if ($print) die($msg);
            else return $restante;
        }
        else
        {
            // ACTUALIZAR ANTIFLOOD
            if (empty($_SESSION['flood'][$type]))
            {
                $_SESSION['flood'][$type] = time();
            }
            else $_SESSION['flood'][$type] = $now;

            // TODO BIEN
            return true;
        }
    }

    /**
     * Se establece el nivel de acceso a la página | MIEMBROS o VISITANTES
     */
    function setLevel($level = 0, $message = false, $redirTo = null)
    {
        if (is_string($level))
        {
            if ($this->session->isAllowed($level) === true) return true;
            else
            {
                if (empty($message)) $message = 'No tienes permisos para acceder aqu&iacute;.';
            }
        }
        // CUALQUIERA
        if ($level == 0) return true;
        // SÓLO VISITANTES
        elseif ($level == 1)
        {
            //var_dump($this->memberData); exit;
            if ($this->session->is_member == false) return true;
            else
            {
                if (isset($redirTo)) $this->redirectTo('/');
                if (empty($message)) $message = 'Esta p&aacute;gina s&oacute;lo puede ser vista por visitantes.';
            }
        }
        // SÓLO MIEMBROS
        elseif ($level == 2)
        {
            if ($this->session->is_member == true) return true;
            else
            {
                if (isset($redirTo)) $this->redirectTo($this->generateUrl('members', 'login', NULL, array('r' => $this->getCurrentUrl())));
                if (empty($message)) $message = 'Para poder ver esta p&aacute;gina debes identificarte.';
            }
        }
        // SÓLO MODERADORES Y ADMINISTRADORES
        elseif ($level == 3)
        {
            if ($this->session->is_admod) return true;
            else
            {
                if (isset($redirTo)) $this->redirectTo('/');
                if (isset($message)) $message = 'Est&aacute;s en un &aacute;rea restringida s&oacute;lo para moderadores.';
            }
        }
        // SÓLO ADMINISTRADORES
        elseif ($level == 4)
        {
            if ($this->session->is_admod == 1) return true;
            else
            {
                if (isset($redirTo)) $this->redirectTo('/');
                if (isset($message)) $message = 'Est&aacute;s intentando algo no permitido.';
            }
        }
        else
        {
            $message = 'Error desconocido';
        }
        //
        return array('title' => 'Error', 'message' => $message);
    }

    /**
     * Redireccionar a un enlace
     */
    function redirectTo($url)
    {
        $url = urldecode($url);
        if (isset($_POST['ajax']) || isset($_GET['page']))
        {
            echo "0: Redirigiendo... <script>window.location.href = '$url'</script>";
        }
        else
        {
            header("Location: $url");
        }
        exit;
    }


    /**
     * Devuelve el enlace de la página actual
     *
     * @return string
     */
    function getCurrentUrl($encode = true)
    {
        $current_url_domain = $_SERVER['HTTP_HOST'];
        $current_url_path = $_SERVER['REQUEST_URI'];
        $current_url_querystring = $_SERVER['QUERY_STRING'];
        $current_url = "http://" . $current_url_domain . $current_url_path;
        $current_url = isset($encdode) ? urlencode($current_url) : $current_url;
        //
        return $current_url;
    }

    /**
     * Retorna la estructura generada para una consulta con varias columnas
     */
    function getIUP($array, $prefix = '', $type = 'update')
    {
        //unset($array['ajax']);
        // NOMBRE DE LOS CAMPOS
        $fields = array_keys($array);
        // VALOR PARA LAS TABLAS
        $values = array_values($array);
        // DÍGITOS Y CARACTERES
        foreach ($values as $i => $val)
        {
            if ($type === 'update')
            {
                if (!is_numeric($val)) $sets[$i] = $prefix . $fields[$i] . " = '" . $this->db->real_escape_string($val) . "'";
                else $sets[$i] = $prefix . $fields[$i] . " = '" . $val . "'";
            }
            else
            {
                if (!is_numeric($val)) $sets[$i] = $prefix . $fields[$i] . " = '" . $this->db->real_escape_string($val) . "'";
                else $sets[$i] = $prefix . $fields[$i] . " = '" . $val . "'";
                //if(!is_numeric($val)) $sets[$i] = " '" . $this->db->real_escape_string($val) . "'";
                //else $sets[$i] = ' '.$val;
            }
        }
        //
        $values = implode(', ', $sets);
        //
        return $values;
    }


    function getIp()
    {
        return isset($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    function checkLoad()
    {
        if (empty($this->config['id']))
        {
            if ($this->session->isAllowed('admin'))
            {
                // MENSAJE DE ADVERTENCIA
                echo '<h1 style="color: red;">No se ha podido cargar la configuraci&oacute;n, por lo que debe crear una nueva</h1>';
                // INCLUYE EL ÁREA DE CONFIGURACIÓN
                require Core::view('configuration.area', 'admin');
                exit;
            }
            else
            {
                die('No se ha podido cargar la configuraci&ocaute;n del sitio. Contacte con el administrador.');
            }
        }
        elseif ($this->config['maintenance'] === '1' && $this->session->isAllowed('maintenance') === false)
        {
            $config = $this->config;
            $message[0] = 'Sitio web en mantenimiento';
            //
            require BG_TEMPLATES . 'error' . DS . '503.php';
            exit;
        }
    }

    /**
     * Aplica texto resaltado en el contenido de una variable
     */
    function getHighlight($what = null, $where = null)
    {
        if (!empty($what) && !empty($where))
        {
            // HTML RESALTADO
            $highlight = '<span class="yellow accent-2">' . $what . '</span>';
            // RETORNAR STRING RESALTADO
            return str_ireplace($what, $highlight, $where);
        }
        // RETORNAR LO TRAIDO
        return $where;
    }

    /** OBTIENE LA PLATAFORMA ACTUAL **/

    public function getPlatform()
    {
        if (isset($_SESSION['platform']))
        {
            return $_SESSION['platform'];
        }

        // SI ESTOY EN LA APP
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'link de app')
        {
            $platform = 'app';
        }
        // SI ESTOY EN NAVEGADOR MOVIL
        elseif ($this->isMobile() == true)
        {
            $platform = 'mobile';
        }
        // SI ESTOY EN ANDROID
        elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'android') !== false)
        {
            $platform = 'android';
        }
        // SI ESTOY EN PC
        else
        {
            $platform = 'pc';
        }

        // ESTABLECER SESION (evitar sobrecargas)
        $_SESSION['platform'] = $platform;
        // RETORNAR RESULTADO
        return $platform;
    }

    /**
     * Comprueba si es movil
     */
    public function isMobile()
    {
        if (isset($_SESSION['mobile']))
        {
            return $_SESSION['mobile'];
        }

        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
        // POSIBLES
        $mobiles = array(
            'midp',
            '240x320',
            'blackberry',
            'netfront',
            'nokia',
            'panasonic',
            'portalmmm',
            'sharp',
            'sie-',
            'sonyericsson',
            'symbian',
            'windows ce',
            'windows phone',
            'benq',
            'mda',
            'mot-',
            'opera mini',
            'philips',
            'pocket pc',
            'sagem',
            'samsung',
            'sda',
            'sgh-',
            'vodafone',
            'xda',
            'iphone',
            'android'
        );

        foreach ($mobiles as $mobile)
        {
            if (strpos($userAgent, $mobile)) //strstr
            {
                $_SESSION['mobile'] = true;
                return true;
            }
        }
        // NO ES MOVIL
        $_SESSION['mobile'] = false;
        return false;
    }

    /**
     * Corta un texto x caracteres
     *
     * @param string #texto a cortar
     * @param int #logitud a cortar
     * @return string
     */
    public function curtText($input = null, $limit = 128)
    {

        if (strlen($input) > $limit)
        {
            $input = substr($input, 0, $limit);
            $input = $input . "...";
            return $input;
        }
        else
        {
            return $input;
        }
    }
    /**
     * Devuelve la primera imagen\iframe\video de un html o la url de este
     *
     * @param string #html
     * @param boolean
     * @return <img>
     */
    public function getFirstImgHtml($html = null, $returnUrl = false)
    {

        $doc    =   new DOMDocument();
        @$doc->loadHTML($html);


        $imgs = $doc->getElementsByTagName('img');
        $iframes = $doc->getElementsByTagName('iframe');
        $video = $doc->getElementsByTagName('video');

        if (isset($imgs) and !empty($imgs) and count($imgs) > 0) :
            if ($returnUrl)
            {
                return $imgs->item(0)->getAttribute('src');
            }
            else
            {
                return '<img src="' . $imgs->item(0)->getAttribute("src") . '" style="filter: opacity(0);">';
            }

        //
        elseif (isset($iframes) and !empty($iframes) and count($iframes) > 0) :

            if ($returnUrl)
            {
                return $iframes->item(0)->getAttribute("src");
            }
            else
            {

                return '<iframe src="' . $iframes->item(0)->getAttribute("src") . '"></iframe>';
            }

        else :

            return '';

        endif;
    }
    /**
     * devuelve la ultima url
     *
     * @param string (url)
     */
    public function getLastUrl()
    {
        // DEVUELVE EL PRIMER ELEMENTO DEL ARRAY Y LO ELIMINA
        $last = $_SESSION['lastUrl'][0];
        return $last;
    }

    public function getLogo()
    {
        global $config;
        return $config['images_url'] . '/logo.png';
    }

    /**
     * Establece el módulo y la sección desde la friendly URL.
     *
     * @param string $module El nombre del módulo.
     * @param string $section La sección a la que se va a acceder.
     */
    public function setUrl($module, $section)
    {
        global $sModule, $sSection;

        // Definir un mapeo de módulos con sus secciones y cambios correspondientes.
        $defaultSections = [
            'login' => [
                'null0' => ['members', 'login']
            ],
            'home-guest' => [
                'null0' => ['core', 'home-guest']
            ],
            'core' => [
                'null0' => ['core', 'home-guest'],
                'nul2' => ['core', 'home-gduest']
            ],
            'mi-panel' => [
                'anuncios' => ['forums', 'my.threads'],
                'editar' => ['forums', 'edit.thread'],
                'publicar' => ['forums', 'new.thread'],
                'favoritos' => ['forums', 'my.favorites']
            ],
            'mensajes' =>
            [
                'todos' => ['members', 'messages']
            ],
            'anuncios' =>
            [
                'favoritos' => ['forums', 'my.favorites'],
            ]


        ];

        // Verificar si el módulo y la sección tienen un mapeo definido.
        if (isset($defaultSections[$module]) && isset($defaultSections[$module][$section]))
        {
            list($sModule, $sSection) = $defaultSections[$module][$section];
        }
    }

    /**
     * Sube una imagen desde el PC
     *
     * @param array    $image
     * @param string   $path   la ruta donde se va a subir la imagen
     * @return string con el nombre de la imagen subida, o false si no se pudo subir
     */
    function uploadImage($image = array(), $path = '')
    {
        // Verificar si el tipo de archivo es JPEG o PNG y no pese mas de 2MB
        if (($image['type'] == 'image/jpeg' || $image['type'] == 'image/png' || $image['type'] == 'image/gif') && $image['size'] <= 2097152)
        {
            // Crear el directorio si no existe
            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            // Mover la imagen original al directorio especificado con el nombre del juego
            $image_name = generateUUID() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($image['tmp_name'], $path . DS . $image_name))
            {
                return $image_name;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Sube un archivo desde el PC
     *
     * @param array    $image
     * @param string   $path   la ruta donde se va a subir la imagen
     * @return string con el nombre de la imagen subida, o false si no se pudo subir
     */
    function uploadFile($image = array(), $path = '')
    {
        // Verificar si el tipo de archivo es JPEG o PNG o MP4 y no pese mas de 1GB
        if (in_array($image['type'], array('image/jpeg', 'image/png', 'video/mp4')) && $image['size'] <= 1073741824)
        {
            // Crear el directorio si no existe
            if (!file_exists($path))
            {
                mkdir($path, 0777, true);
            }

            // Mover la imagen original al directorio especificado con el nombre del juego
            $image_name = generateUUID() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($image['tmp_name'], $path . DS . $image_name))
            {
                return $image_name;
            }
            else
            {
                setToast([['El archivo debe ser del siguiente formato: jpg, png o mp4']]);
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Elimina una imagen
     *
     * @param string   $image_name
     * @param string   $path   la ruta donde se encuentra la imagen
     * @return boolean true si se elimino, false de lo contrario
     */
    public function deleteImage($image_name, $path = '')
    {
        $image_path = $path . DS . $image_name;
        if (file_exists($image_path))
        {
            return unlink($image_path) ? true : false;
        }
        return true;
    }

    static function generateSlug(string $title): string
    {
        // Convertir a minúsculas
        $slug = strtolower($title);

        // Reemplazar caracteres especiales y espacios con guiones
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);

        // Eliminar guiones al principio y al final
        $slug = trim($slug, '-');

        return $slug;
    }


    /**
     * Verifica si un string contiene spam
     * 
     * Verifica si el string contiene @, o una url
     * 
     * @param string $string
     * @return bool true si contiene spam, false de lo contrario
     */
    static function containsSpam(string $string): bool
    {
        // Patrón para URLs (http, https, www)
        $patronUrls = '/\b(http:\/\/|https:\/\/|www\.)[^\s]+/i';

        // Patrón para dominios (ej: .com, .net, etc.)
        $patronDominios = '/\b\w+\.(com|net|org|edu|gov|info|biz|co|io|me|tech|xyz|site)\b/i';

        // Patrón para arrobas (correos electrónicos o usuarios)
        $patronArrobas = '/\b\w+@\w+\.\w{2,}\b/';

        // Verificar si el texto contiene spam
        if (preg_match($patronUrls, $string) || preg_match($patronDominios, $string) || preg_match($patronArrobas, $string))
        {
            return true; // Contiene spam
        }

        return false; // No contiene spam
    }
}
