<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador de la página Top20
 *
 *
 */

$page['name'] = 'Top20';
$page['code'] = 'top20';

$search = (isset($_GET['search'])) ? $_GET['search'] : '';

// Optiene los productos
$products = loadClass('products/top20')->getAllProductsTop20(['name' => $search], 20);

// Optiene la imagen de la sección principal
$sectionHero = getColumns('configuration', ['id', 'image_section'], ['id', 1]);
