<?php

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Archivo de conexion a mysql
 *
 *
 */

// INCLUYE CONFIGURACIÓN DE LA BASE DE DATOS
require BG_DIR . 'config.db.php';

// CONEXIÓN A LA BASE DE DATOS
$db = new MySQLi($db['hostname'], $db['username'], $db['userpass'], $db['database']);
// SI NO SE PUEDE CONECTAR A LA BASE DE DATOS
if ($db->connect_errno)
{
    die('Error al conectar: ' . $db->connect_error);
}
