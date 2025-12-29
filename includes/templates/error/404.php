<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este archivo mostrará un error 404 (No encontrado)
 *
 *
 */

header('HTTP/1.1 404 Not Found');
//
$page['name'] = '404 - No encontrado';
//
require Core::view('head', 'core');
require Core::view('menu', 'core');
//
$message = (isset($message[0][0]) && !empty($message[0][0])) ? $message[0][0] : 'No se ha encontrado la p&aacute;gina que estaba buscando';
?>

<!-- Body -->
<section>
    <div class="container">
        <h1 style="text-align: center; padding: 21.1% 0 32% 0;"><?php echo $message; ?></h1>
    </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core');
exit; ?>
<!-- / Footer -->