<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este archivo mostrará un error de acceso prohibido (Forbidden)
 *
 *
 */

header('HTTP/1.1 403 Forbidden');
//
$page['name'] = '403 - Prohibido';
//
require Core::view('head', 'core');
require Core::view('menu', 'core');
?>

<!-- Body -->
<section>
    <div class="container">
        <h1 style="text-align: center; padding: 21.1% 0 32% 0;">Acceso prohibido</h1>
    </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->