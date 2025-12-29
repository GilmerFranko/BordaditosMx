<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de los formularios de foro
 *
 *
 */

require Core::view('head', 'core');
?>

<section id="adminContacts">
    <!-- BUSCADOR -->
    <nav class="teal darken-1">
        <div class="nav-wrapper">
            <form class="" action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'contacts'); ?>" method="post">
                <div class="input-field">
                    <input id="search" name="search" type="search" placeholder="Buscar..." value="<?php echo $search; ?>">
                    <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </div>
            </form>
        </div>
    </nav>
    <!-- ./BUSCADOR -->
    <div class="sectionContacts">
        <?php include Core::view('contacts.area'); ?>
    </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js" />
</script>