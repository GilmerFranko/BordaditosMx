<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado al sitio
 *
 *
 */

class Site extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }


    function __destruct()
    {
    }

    /**
     * Registra contacto
     *
     * @param array $contact
     * @param boolean $email
     * @return int $forum_id
     */
    public function newContact($contact = null, $email = true)
    {
        $query = $this->db->query('INSERT INTO `site_contacts` (`member_id`, `name`, `email`, `title`, `content`, `date`, `ip`) VALUES (\'' . $contact['member_id'] . '\', \'' . $this->db->real_escape_string($contact['name']) . '\', \'' . $this->db->real_escape_string($contact['email']) . '\',  \'' . $this->db->real_escape_string($contact['title']) . '\', \'' . $this->db->real_escape_string($contact['content']) . '\',   UNIX_TIMESTAMP(), \'' . $this->db->real_escape_string(Core::model('extra', 'core')->getIp()) . '\') ');

        error_log('INSERT INTO `site_contacts` (`member_id`, `name`, `email`, `title`, `content`, `date`, `ip`) VALUES (\'' . $contact['member_id'] . '\', \'' . $this->db->real_escape_string($contact['name']) . '\', \'' . $this->db->real_escape_string($contact['email']) . '\',  \'' . $this->db->real_escape_string($contact['title']) . '\', \'' . $this->db->real_escape_string($contact['content']) . '\',   UNIX_TIMESTAMP(), \'' . $this->db->real_escape_string(Core::model('extra', 'core')->getIp()) . '\') ');

        // SI SE HA AGREGADO
        if ($query == true)
        {
            // Retorna el ID registrado
            return $this->db->insert_id;
        }

        return false;
    }


    /**
     * Obtiene los foros
     *
     * @param string $search
     * @param int $limit
     * @param int $member_id
     * @return objectMySQL $forums
     */
    function getContacts($search = '', $limit = 20)
    {
        // PREFERENCIAS DE BÚSQUEDA
        $where = empty($search) ? '' : 'WHERE ' . (ctype_digit($search) ? '`member_id` = \'' . $search . '\'' : '`name` LIKE \'%' . $search . '%\' || `email` LIKE \'%' . $search . '%\'');

        // CONTACTOS TOTALES
        $query = $this->db->query('SELECT COUNT(`id`) FROM `site_contacts` ' . $where);
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex(array('admin', 'forums', null, array('search' => $search)), $result['total'], $limit);
        // EJECUTA LA CONSULTA
        $query = $this->db->query('SELECT `id`, `member_id`, `name`, `email`, `title`, `content`, `date` FROM `site_contacts` ' . $where . ' ORDER BY `id` DESC LIMIT ' . $result['pages']['limit']);
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
     * Borra un contacto
     *
     * @param integer $forum_id
     * @return boolean
     */
    function deleteContact($forum_id = null)
    {
        // BORRAR PALABRA
        $query = $this->db->query('DELETE FROM `site_contacts` WHERE `id` = \'' . $forum_id . '\' LIMIT 1');
        //
        if ($query == true)
        {
            return true;
        }
        // RETORNA FALSE SI NO SE HA ELIMINADO NADA
        return false;
    }
}
