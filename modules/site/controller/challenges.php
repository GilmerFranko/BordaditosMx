<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 * @Description Controlador de sección "Foro" del sitio
 *
 */

$page['name'] = 'Retos';
$page['code'] = 'challenges';

if (!$challenge = loadClass('site/challenges')->getLastChallenge())
{
    $challenge['title'] = '';
    $challenge['description'] = '';
    $challenge['challenged_id'] = '';
    $challenge['reward'] = '';
}
