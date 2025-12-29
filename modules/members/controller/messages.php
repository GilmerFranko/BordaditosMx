<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal de Vista general de los mensajes
 *
 *
 */

$page['name'] = 'Mensajes';
$page['code'] = 'messagesView';


$messages = loadClass('members/messages')->getConversations($m_id, 5);
