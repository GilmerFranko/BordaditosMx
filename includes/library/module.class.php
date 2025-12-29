<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de cargar cada modulo que se requiera de una manera mas legible y facil
 *
 *
 */

class Module
{
	public function __construct()
	{
	}
	// Modulo predefinido
	private $module = 'clients';

	public function set_module($module)
	{
		$this->module = $module;
	}
	public function m($file = '')
	{
		return Core::model($file, $this->module);
	}
	public function v($file = '')
	{
		return Core::view($file, $this->module);
	}
	public function c($file = '')
	{
		return Core::controller($file, $this->module);
	}
}
