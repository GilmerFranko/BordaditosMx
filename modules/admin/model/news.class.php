<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a las noticias
 *
 *
 */

class News extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }

    /**
     * Registra una noticia
     *
     * @param string $content
     * @return boolean/integer
     */
    function newNew($content = null)
    {
        //
        $query = $this->db->query('INSERT INTO `site_news` (`author`, `content`, `date`) VALUES (\'' . $this->session->memberData['member_id'] . '\', \'' . $this->db->real_escape_string($content) . '\', UNIX_TIMESTAMP()) ');
        //
        if ($query == true)
        {
            return $this->db->insert_id;
        }
        //
        return false;
    }
}
