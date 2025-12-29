<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Configuración del sitio
 *
 *
 */

// La dirección principal del sitio, sin slash final.
$config['base_url']     = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . substr($_SERVER['PHP_SELF'], 0, -10);

// Dirección del sitio mediante carpetas, sin slash final.
$config['base_path']    = BG_DIR;

// Carpeta donde se alojan las imágenes del script
$config['images_url']   = $config['base_url'] . '/static/images';

// Dirección de avatares mediante url, sin el slash final.
$config['avatar_url']   = $config['base_url'] . '/filestore/uploads/avatar';

// Dirección del sitio mediante carpetas, sin el slash final.
$config['avatar_path']  = $config['base_path'] . 'filestore' . DS . 'uploads' . DS . 'avatar';

// Carpeta donde se alojan las imagenes subidas a los canales
$config['channels_path'] = $config['base_path'] . 'filestore' . DS . 'uploads' . DS . 'channels';
$config['channels_url']  = $config['base_url']  . '/filestore/uploads/channels/';

// Carpeta donde se alojan las imagenes subidas de las categoria foros
$config['forums_path'] = $config['base_path'] . 'filestore' . DS . 'uploads' . DS . 'forums';
$config['forums_url']  = $config['base_url']  . '/filestore/uploads/forums/';

// Carpeta donde se alojan las imagenes subidas de los foros
$config['threads_path'] = $config['base_path'] . 'filestore' . DS . 'uploads' . DS . 'threads';
$config['threads_url']  = $config['base_url']  . '/filestore/uploads/threads/';

// Carpeta donde se alojan las imagenes de productos
$config['products_path'] = $config['base_path'] . 'filestore' . DS . 'uploads' . DS . 'products';
$config['products_url']  = $config['base_url']  . '/filestore/uploads/products/';

// URL del foro
$config['forum_url']  = $config['base_url']  . '/f/';
// URL de los hilos
$config['thread_url'] = $config['base_url']  . '/t/';

// Carpeta donde se alojan los archivos con correos
$config['bulkemails_path']   = $config['base_path'] . 'filestore' . DS . 'uploads' . DS . 'bulkemails';

/** Id predeterminado del referi principal **/
$config['referi_id'] = 1;

// Foto predefinida para usuarios registrados
$config['default_male_profile_photo']   = 'default-male-avatar-profile.png';
$config['default_female_profile_photo'] = 'default-female-avatar-profile.png';

// Foto predifinida para hilos
$config['default_thread_photo'] = $config['images_url'] . '/default-thread-photo.png';
