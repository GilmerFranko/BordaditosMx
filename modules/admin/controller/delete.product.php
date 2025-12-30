<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador para eliminar un producto
 *
 */

if (isset($_GET['product_id']) && ctype_digit($_GET['product_id']))
{
  $product_id = (int) $_GET['product_id'];
  // Se verifica que exista el producto
  $product = loadClass('admin/products')->getProductById($product_id);
  if ($product != null)
  {
    // 1. Intentamos el borrado físico
    $sqlDelete = "DELETE FROM `products` WHERE id = $product_id";
    $result = $extra->db->query($sqlDelete);

    if ($result)
    {
      $row_affected = $extra->db->affected_rows;
      if ($row_affected > 0)
      {
        // Borra imagen
        $extra->deleteImage($product['image_url'], $config['products_path']);
        $msg = ["Producto eliminado permanentemente."];
      }
      else
      {
        $msg = ["Error al intentar eliminar el producto."];
      }
    }
    else
    {
      // 2. Si falló, verificamos si fue por una Foreign Key (Error 1451)
      // Accedemos al código de error de la conexión
      $errorCode = $extra->db->errno;

      if ($errorCode == 1451)
      {
        // 3. Procedemos al Soft Delete (Borrado Lógico)
        // Asumiendo que tienes una columna 'deleted_at' o 'status'
        $sqlSoftDelete = "UPDATE products SET deleted_at = NOW() WHERE id = $product_id";

        if ($extra->db->query($sqlSoftDelete))
        {
          $msg = ["El producto tiene registros asociados. Se ha marcado como inactivo (Soft Delete)."];
        }
        else
        {
          $msg = ["Error al intentar aplicar borrado lógico."];
        }
      }
      else
      {
        // Otro tipo de error de base de datos
        $msg = ["Error de base de datos: " . $extra->db->error];
      }
    }
  }
  else
  {
    $msg = ["El producto no existe."];
  }

  setToast([$msg]);
  redirect('admin/view.products');
}
else
{
  redirect('admin/view.products');
}
