<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar algunas secciones de la administración
 *
 *
 */

class Admin extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->session = Core::model('session', 'core');
    }


    /**
     * Obtiene datos de una sección
     *
     * @param string $table     // NOMBRE DE LA TABLA
     * @param string $section   // NOMBRE DE LA SECCIÓN (PAGINADOR)
     * @param int $limit        // LÍMITE DE DATOS A OBTENER
     * @return object/array
     */
    function getSectionData($table, $section, $limit = 10)
    {
        $section = is_array($section) ? $section : array('admin', $section);
        // PALABRAS TOTALES
        $query = $this->db->query('SELECT COUNT(`id`) FROM `' . $table . '`');
        list($result['total']) = $query->fetch_row();
        // PAGINADOR
        $result['pages'] = Core::model('paginator', 'core')->pageIndex($section, $result['total'], $limit);
        // EJECUTA LA CONSULTA
        $query = $this->db->query('SELECT * FROM `' . $table . '` ORDER BY `id` DESC LIMIT ' . $result['pages']['limit']);
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
}
