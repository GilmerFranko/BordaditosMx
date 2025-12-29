<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Acciones para productos (nuevo / editar / eliminar)
 *
 */

global $config;

if (!isset($_GET['do']))
{
  Core::model('extra', 'core')->setToast(array(array('Faltan par&aacute;metros', 'error')));
  Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'error'), true);
}

// NUEVO PRODUCTO
if ($_GET['do'] == 'new')
{
  if (empty($_POST['name']))
  {
    Core::model('extra', 'core')->setToast(array(array('El nombre es obligatorio', 'error')));
    Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'error'), true);
  }

  $name = htmlspecialchars($_POST['name']);
  $slug = !empty($_POST['slug']) ? Core::model('extra', 'core')->generateSlug($_POST['slug']) : Core::model('extra', 'core')->generateSlug($name);
  $description = !empty($_POST['description']) ? $_POST['description'] : null;
  $original_price = isset($_POST['original_price']) ? (float)$_POST['original_price'] : null;
  $sale_price = isset($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;

  // Comprobar slug único
  $exists = Core::model('db', 'core')->getCount('products', 'id', array('slug', $slug));
  if ($exists > 0)
  {
    $slug .= '-' . time();
  }

  // Insertar producto
  $product_id = Core::model('db', 'core')->smartInsert('products', [
    'name' => $name,
    'slug' => $slug,
    'description' => $description,
    'original_price' => $original_price,
    'sale_price' => $sale_price,
    'status' => 1,
    'created_at' => time()
  ]);

  if (!$product_id)
  {
    Core::model('extra', 'core')->setToast(array(array('No se pudo crear el producto', 'error')));
    Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'error'), true);
  }

  // Subir imagenes (si hay)
  $image_urls = [];
  if (isset($_FILES['images']) && is_array($_FILES['images']['name']))
  {
    foreach ($_FILES['images']['name'] as $k => $nameFile)
    {
      if ($_FILES['images']['size'][$k] > 0)
      {
        $img = Core::model('extra', 'core')->uploadImage([
          'name' => $_FILES['images']['name'][$k],
          'type' => $_FILES['images']['type'][$k],
          'tmp_name' => $_FILES['images']['tmp_name'][$k],
          'error' => $_FILES['images']['error'][$k],
          'size' => $_FILES['images']['size'][$k]
        ], $config['products_path']);

        if ($img)
        {
          $image_urls[] = $img;
          // Guardar en product_images
          Core::model('db', 'core')->smartInsert('product_images', [
            'product_id' => $product_id,
            'url' => $img,
            'is_main' => count($image_urls) == 1 ? 1 : 0,
            'created_at' => time()
          ]);
        }
        else
        {
          // si falla una imagen, eliminar las ya subidas
          foreach ($image_urls as $im) Core::model('extra', 'core')->deleteImage($im, $config['products_path']);
          Core::model('extra', 'core')->setToast(array(array('No se pudo subir una imagen', 'error')));
          Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'error'), true);
        }
      }
    }
  }

  Core::model('extra', 'core')->setToast(array(array('Producto creado', 'success')));
  Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'success'), true);
}

// EDITAR PRODUCTO
elseif ($_GET['do'] == 'edit' && isset($_POST['id']) && ctype_digit($_POST['id']))
{
  $id = (int)$_POST['id'];
  $name = htmlspecialchars($_POST['name']);
  $slug = !empty($_POST['slug']) ? Core::model('extra', 'core')->generateSlug($_POST['slug']) : Core::model('extra', 'core')->generateSlug($name);
  $description = !empty($_POST['description']) ? $_POST['description'] : null;
  $original_price = isset($_POST['original_price']) ? (float)$_POST['original_price'] : null;
  $sale_price = isset($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;

  $updated = Core::model('db', 'core')->smartInsert('products', [
    'name' => $name,
    'slug' => $slug,
    'description' => $description,
    'original_price' => $original_price,
    'sale_price' => $sale_price,
    'updated_at' => time()
  ], ['id', $id]);

  if ($updated === false)
  {
    Core::model('extra', 'core')->setToast(array(array('No se pudo actualizar el producto', 'error')));
    Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'error'), true);
  }

  // Subir nuevas imagenes si las hay
  if (isset($_FILES['images']) && is_array($_FILES['images']['name']))
  {
    foreach ($_FILES['images']['name'] as $k => $nameFile)
    {
      if ($_FILES['images']['size'][$k] > 0)
      {
        $img = Core::model('extra', 'core')->uploadImage([
          'name' => $_FILES['images']['name'][$k],
          'type' => $_FILES['images']['type'][$k],
          'tmp_name' => $_FILES['images']['tmp_name'][$k],
          'error' => $_FILES['images']['error'][$k],
          'size' => $_FILES['images']['size'][$k]
        ], $config['products_path']);

        if ($img)
        {
          Core::model('db', 'core')->smartInsert('product_images', [
            'product_id' => $id,
            'url' => $img,
            'is_main' => 0,
            'created_at' => time()
          ]);
        }
      }
    }
  }

  Core::model('extra', 'core')->setToast(array(array('Producto actualizado', 'success')));
  Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'success'), true);
}

// ELIMINAR PRODUCTO
elseif ($_GET['do'] == 'delete' && isset($_GET['id']) && ctype_digit($_GET['id']))
{
  $id = (int)$_GET['id'];
  // Eliminar imágenes asociadas
  $images = Core::model('db', 'core')->getRows('product_images', '*', ['product_id', $id], 0, 100);
  if ($images && isset($images['data']))
  {
    foreach ($images['data'] as $img)
    {
      Core::model('extra', 'core')->deleteImage($img['url'], $config['products_path']);
      Core::model('db', 'core')->deleteRow('product_images', $img['id']);
    }
  }
  // Eliminar producto
  if (Core::model('db', 'core')->deleteRow('products', $id))
  {
    Core::model('extra', 'core')->setToast(array(array('Producto eliminado', 'success')));
  }
  else
  {
    Core::model('extra', 'core')->setToast(array(array('No se pudo eliminar el producto', 'error')));
  }

  Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'success'), true);
}
else
{
  Core::model('extra', 'core')->setToast(array(array('Acci&oacute;n desconocida', 'error')));
  Core::model('extra', 'core')->generateUrl('admin', 'products', NULL, array('save' => 'error'), true);
}
