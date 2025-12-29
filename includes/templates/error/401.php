<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este archivo mostrará un error de acceso no autorizado (Unauthorized)
 *
 *
 */

header('HTTP/1.1 401 Unauthorized');
//
$page['name'] = '401 - No autorizado';
//
require Core::view('head', 'core');
require Core::view('menu', 'core');

$message = !empty($page['message']) ? $page['message'] : 'No autorizado';
?>

<!-- Body -->
<section>
    <div class="container center-align">
        <h1><?php echo $message; ?></h1>
    </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->