<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al panel de administración
 *
 *
 */

class Configuration extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    /**
     * Actualiza las preferencias del sitio
     *
     * @param array   $values
     * @return boolean
     */
    function saveConfig($values = array())
    {
        $inserts = Core::model('extra', 'core')->getIUP($values, '', 'insert');
        //
        $query = $this->db->query('INSERT INTO `site_configuration` SET ' . $inserts . '');
        //
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }

    /**
     * Elimina una configuración
     *
     * @param integer  $id
     * @return boolean
     */
    function deleteConfig($id = 0)
    {
        $query = $this->db->query('DELETE FROM `site_configuration` WHERE `id` = \'' . $id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }
}
