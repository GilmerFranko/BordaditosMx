<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a los pedidos
 *
 *
 */

class Orders extends Model
{

  /**
   * Crea un nuevo pedido
   *
   * @param int $user_id Identificador del usuario que realizo el pedido
   * @param int $total_cost Costo total del pedido
   * @return int|bool Identificador del pedido creado o false si no se pudo crear
   */
  public function createOrder($data)
  {
    {
      if ($r = loadClass('core/db')->smartInsert('orders', $data))
      {
        return $r;
      }
      return 0;
    }
  }

  // Borra un pedido
  public function deleteOrderById($order_id)
  {
    return loadClass('core/db')->deleteRow('orders', $order_id);
  }
}
