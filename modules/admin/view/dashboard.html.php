<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página principal de la administración
 *
 *
 */

require Core::view('head', 'core');
?>


<!-- Body -->
<section>
    <h1 class="center-align">Dashboard</h1> <!-- Título del dashboard -->

    <div class="row">

        <div class="col s12 m4">
            <div class="card card-custom">
                <div class="card-content white-text">

                    <p></p>
                </div>
            </div>
        </div>


        <div class="col s12 m4">
            <div class="card card-custom">
                <div class="card-content white-text">

                    <p></p>
                </div>
            </div>
        </div>


        <div class="col s12 m4">
            <div class="card card-custom">
                <div class="card-content white-text">

                    <p></p>
                </div>
            </div>
        </div>
    </div>
</section>


<style type="text/css">
    .card-custom {
        background: linear-gradient(to bottom right, #4CAF50, #2196F3);
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 200px;
        /* Ajusta esta altura según sea necesario */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        /* Centra horizontalmente */
        text-align: center;
        /* Centra verticalmente */
    }

    .card-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
    }

    .card-custom .card-title {
        color: white;
    }

    .card-custom p {
        font-size: 2em;
        /* Tamaño de la fuente grande */
        font-weight: bold;
        /* Texto en negrita */
        margin: 0;
        /* Elimina el margen para evitar espacios adicionales */
    }
</style>
<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js" />
</script>