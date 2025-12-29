<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal de las noticias
 *
 *
 */

$page['name'] = 'Noticias';
$page['code'] = 'adminNews';


// PROCESOS DINÁMICOS
if (!isset($_POST['ajax']) || (isset($_POST['ajax']) && isset($_GET['page'])))
{
    $page['name'] = 'Noticias - Administraci&oacute;n';
    //
    $news = Core::model('admin', 'admin')->getSectionData('site_news', 'news');
    //
    if ($news['rows'] < 1)
    {
        $message[] = array('No hay datos', 'warning');
        Core::model('extra', 'core')->setToast($message);
    }
    //
    if (isset($_POST['ajax']))
    {
        if ($news !== false)
        {
            echo '1: ';
            // SE INCLUYE EL AREA DE BOTS
            require Core::view('news.area');
            exit;
        }
        else
        {
            die('0: No se pudo cambiar de p&aacute;gina');
        }
    }
}
