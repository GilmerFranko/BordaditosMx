<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página de los reportes
 *
 *
 */

require Core::view('head', 'core');

if (isset($_GET['byThreadId']) && !empty($_GET['byThreadId']))
{
  // Agrega vista de reportes por hilo -->
  require Core::view('reports.groupby', 'admin');
}
else
{
  // Arega vista de todos los reportes
  require Core::view('reports.all', 'admin');
}


?>
<section>
  <?php require Core::view('footer', 'core'); ?>
</section>
<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js" />
</script>