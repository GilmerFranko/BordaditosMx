<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los items de pedido
 *
 *
 */

class Order_items extends Model
{
  /**
   * Crea un nuevo item de pedido
   */
  public function createOrderItem($data)
  {
    {
      if ($r = loadClass('core/db')->smartInsert('order_items', $data))
      {
        return $r;
      }
      return 0;
    }
  }
}
