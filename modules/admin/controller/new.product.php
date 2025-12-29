<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  VCO Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Controlador principal para crear un Producto
 *
 *
 */

$page['name'] = 'Nuevo producto';
$page['code'] = 'adminNewProduct';

// Obtener el valor de post_max_size de php.ini y convertirlo a bytes
$max_post_size = ini_get('post_max_size');
$max_post_size_bytes = convertToBytes($max_post_size);

// COMPROBAR SI SE HA ESPECIFICADO ACCION Y TIPO
if (isset($_GET['do']))
{
  // ACCIÓN SOBRE PALABRAS
  if ($_GET['do'] == 'new')
  {
    // Verificar si CONTENT_LENGTH está configurado y si excede el límite
    if (isset($_SERVER['CONTENT_LENGTH']) && (int)$_SERVER['CONTENT_LENGTH'] > $max_post_size_bytes)
    {
      $msg[] = 'El archivo es demasiado grande';
    }

    // Debe tener un nombre
    if (!isset($_POST['name']) or empty($_POST['name']))
    {
      $msg[] = 'Debes introducir un nombre';
    }

    // Debe tener una descripción
    if (!isset($_POST['description']) or empty($_POST['description']))
    {
      $msg[] = 'Debes introducir una descripción';
    }

    // Debe tener un precio válido
    if (!isset($_POST['original_price']) or empty($_POST['original_price']) or !is_numeric($_POST['original_price']))
    {
      $msg[] = 'Debes introducir un precio';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] != 0)
    {
      $msg[] = 'Debes subir una imagen para el producto';
    }

    // Si se ha introducido un slug
    if (isset($_POST['slug']) && !empty($_POST['slug']))
    {
      if (strlen($_POST['slug']) < 3)
      {
        $msg[] = 'El slug debe tener al menos 3 caracteres';
      }

      $slugtmp = cleanSlug(cleanString($_POST['slug']));
      // Verifica que el slug no esté en uso por otro producto
      if (!loadclass('admin/products')->isSlugAvailable($slugtmp))
      {
        $msg[] = 'El slug introducido está en uso por otro producto';
      }
      else
      {
        $slug = $slugtmp;
      }
    }


    // Si no hay mensajes de error, proceder a crear el producto
    if (!isset($msg))
    {

      // Preparar los datos del producto
      $data = [
        'name' => cleanString($_POST['name']),
        'original_price' => cleanString($_POST['original_price']),
        'sale_price' => !empty($_POST['sale_price']) ? cleanString($_POST['sale_price']) : null,
        'status' => (isset($_POST['status']) and !is_int($_POST['status'])) ? cleanString($_POST['status']) : 1,
        'created_at' => time()
      ];

      // Si la variable slug está definida, actualizar el slug
      if (isset($slug))
        $data['slug'] = $slug;


      $bbcode = $_POST['description'] ?? '';
      // Parsear el BBCode
      $parser->parse($bbcode);
      //
      $bbcode = cleanString($bbcode);
      $bbcode = str_replace('\n', '', $bbcode);
      $bbcode = str_replace('\r', '[br]', $bbcode);
      $bbcode = str_replace('\r\n', '[br]', $bbcode);
      $bbcode = str_replace('\n\r', '[br]', $bbcode);

      $data['description'] = $bbcode;

      if ($image_url = loadClass('core/extra')->uploadImage($_FILES['image'], $config['products_path']))
      {

        $data['image_url'] = $image_url;
        // Crear el nuevo producto
        $r_id = loadClass('admin/products')->newProduct($data);

        // Si se ha creado el producto
        if ($r_id)
        {
          $msg[] = 'El producto se ha creado correctamente';
        }
        // Si no
        else
        {
          $msg[] = 'No se ha podido crear el producto';
        }
      }
      else
      {
        $msg[] = 'No se ha podido cargar la imagen';
      }
    }
    // Mostrar mensajes de error o éxito
    setToast([$msg]);

    // Recargar la página
    redirect('admin/view.products');
  }
}
