<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo se encarga de gestionar lo relacionado a las variantes de productos
 *
 *
 */

class Variants extends Model
{

  /**
   * Obtiene las variantes de un producto y las imagenes asociadas
   * @param int $product_id ID del producto
   * @return array Variantes con sus imagenes
   */
  public function getProductVariants($product_id)
  {
    $variants = Core::model('db', 'core')->getRows('color_variants', ['id', 'product_id', 'color_name', 'image', 'size_available'], ['product_id', $product_id], 0, 100);
    $variants_list = [];
    if ($variants && isset($variants['data']))
    {
      foreach ($variants['data'] as $variant)
      {
        $variant['images'] = Core::model('db', 'core')->getRows('variants_images', ['id', 'color_variant_id', 'image_url'], ['color_variant_id', $variant['id']], 0, 100);
        $variants_list[] = $variant;
      }
    }
    return $variants_list;
  }

  /**
   * Obtiene una variante de un producto y las imagenes asociadas
   * @param int $variant_id ID de la variante
   * @return array|false Variante con sus imagenes o false si no existe
   */
  public function getVariantById($variant_id)
  {
    return Core::model('db', 'core')->getRows('color_variants', ['id', 'product_id', 'color_name', 'image', 'size_available'], ['id', $variant_id], 0, 1);
  }
}
