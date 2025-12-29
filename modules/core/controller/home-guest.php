<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador de la página principal
 *
 *
 */

$page['name'] = 'Inicio';
$page['code'] = 'homeGuest';

$search = (isset($_GET['search'])) ? $_GET['search'] : '';

// Optiene los productos
$products = loadClass('products/product')->getAllProducts(['name' => $search], 20);

// Optiene la imagen de la sección principal
$sectionHero = getColumns('configuration', ['id', 'image_section'], ['id', 1]);
