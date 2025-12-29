<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los retos
 *
 *
 */

class challenges extends Model
{

	public function __construct()
	{
		parent::__construct();
		$this->session = Core::model('session', 'core');
	}


	/** 
	 * Optiene el ultimo reto de la base de datos
	 *
	 * @return array Un arreglo de retos
	 */
	public function getLastChallenge()
	{
		$sql = "SELECT * FROM site_challenges ORDER BY id DESC LIMIT 1";

		$query = $this->db->query($sql);

		if ($query and $query->num_rows > 0)

		{
			return $query->fetch_assoc();
		}
	}
}
