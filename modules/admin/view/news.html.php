<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página de las noticias
 *
 *
 */

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->



<?php
if (isset($_GET['save']) && isset($_SESSION['message']))
{
    echo Core::model('extra', 'core')->getToast($_SESSION['message']);
} ?>
<section id="adminNews">
    <div class="sectionNews">
        <blockquote class="flow-text">Noticias</blockquote>
        <!-- NUEVO FILTRO -->
        <form class="col s12" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'news', 'action', array('do' => 'new')); ?>" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="content" name="content" class="materialize-textarea" required></textarea>
                    <label for="content">Nueva noticia (permite HTML)</label>
                </div>
                <button class="btn waves-effect waves-light w100" type="submit" name="newNew">Agregar
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
        <!--./ NUEVO FILTRO -->
        <?php include Core::view('news.area'); ?>
    </div>
</section>
<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js" />
</script>