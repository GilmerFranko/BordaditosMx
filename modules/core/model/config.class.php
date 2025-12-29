<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo retorna la configuración desde la base de datos
 *
 *
 */

class Config extends Model
{
	public function getConfig()
	{
		return $this->config;
	}

	function __destruct()
	{
	}

	public function get($key = null)
	{
		return $this->config[$key];
	}

	public function set($key = null, $val = null)
	{
		$this->config[$key] = $val;
	}
}
