<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los rangos de usuarios
 *
 *
 */

class Members extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    /**
     * Obtiene todos los usuarios del sitio
     * @param string $search
     * @param int $max (Cantidad de usuarios a mostrar)
     */
    function getMembers($search = '', $max = 20, $bots = false)
    {
        // PREFERENCIAS DE BÚSQUEDA
        //$where = empty($search) ? '' : 'WHERE ' . (ctype_digit($search) ? '`member_id` = \'' . $search . '\'' : 'MATCH(`name`, `email`) AGAINST(\''.$search.'\' IN BOOLEAN MODE)');
        $where = empty($search) ? '' : 'WHERE ' . (ctype_digit($search) ? '`member_id` = \'' . $search . '\'' : '`name` LIKE \'%' . $search . '%\' || `email` LIKE \'%' . $search . '%\'');

        // MIEMBROS TOTALES
        $query = $this->db->query('SELECT COUNT(*) FROM `members`' . $where);
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex(array('admin', 'members', null, array('search' => $search)), $result['total'], $max);
        // EJECUTA LA CONSULTA
        $query = $this->db->query('SELECT m.`member_id`, m.`name`, m.`email`, m.`group_id`, m.`banned`, m.`pp_thumb_photo`, m.`pp_joined`, g.`g_title`, g.`g_colour` FROM `members` AS m LEFT JOIN `members_groups` AS g ON g.`g_id` = m.`group_id` ' . $where . ' ORDER BY `member_id` DESC LIMIT ' . $result['pages']['limit']);
        //
        if ($query == true)
        {
            $result['data'] = $query;
            $result['rows'] = $query->num_rows;
            //
            return $result;
        }
        //
        return false;
    }

    /**
     * Obtiene información de un rango concreto
     */
    function getMember($id)
    {
        $query = $this->db->query('SELECT * FROM `members` WHERE `member_id` = \'' . $id . '\' LIMIT 1');
        //
        if ($query == true && $query->num_rows > 0)
        {
            return $query->fetch_assoc();
        }
        //
        return false;
    }

    /**
     * Actualiza las preferencias básicas de un usuario
     *
     * @param array   $values
     * @param integer $member_id
     * @return boolean
     */
    function editMember($values = array(), $member_id = 0)
    {
        $updates = Core::model('extra', 'core')->getIUP($values, '');
        //
        $query = $this->db->query('UPDATE `members` SET ' . $updates . ' WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        //
        return false;
    }

    /**
     * Obtiene cantidad de usuarios conectados
     *
     * @param int $min
     * @return int
     */
    function getOnlines($min = 5)
    {
        $time = time() - (60 * $min);
        $query = $this->db->query('SELECT COUNT(`member_id`) FROM `members` WHERE `last_activity` > ' . $time . ' LIMIT 1');
        //
        if ($query == true)
        {
            return $query->fetch_row()[0];
        }
        //
        return 0;
    }

    /**
     * Verifica si un usuario es moderador o admin
     *
     * @param int $member_id
     * @return int 1: admin, 2: moderador
     */
    function isAdmod($member_id)
    {
        $query = $this->db->query('SELECT `group_id` FROM `members` WHERE `member_id` = \'' . $member_id . '\' LIMIT 1');

        if ($query == true && $query->num_rows > 0)
        {
            $row = $query->fetch_assoc();
            return $row['group_id'];
        }
        //
        return 0;
    }


    /**
     * Banear un usuario
     * 
     * @param int $member_id
     * @param int $time
     * @return boolean
     */
    function banMember($member_id, $reason = 1)
    {
        $reason = $reason != 1 ? $reason : 'Incumplimiento con nuestras normas';

        return loadClass('core/db')->smartInsert(
            'members',
            ['banned' => time(), 'banned_reason' => $reason],
            ['member_id', $member_id]
        );
    }
}
