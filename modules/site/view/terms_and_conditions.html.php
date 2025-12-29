<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 * @Description Vista de contacto
 *
 *
 */

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section id="termsAndConditions" class="container">
    <h3 class="center-align">Términos y Condiciones</h3>

    <div class="row">
        <div class="col s12">
            <p>Estos términos y condiciones regulan el uso del sitio web <strong><?php echo $config['script_name'] ?></strong>. Al acceder a este sitio web, aceptas estos términos y condiciones en su totalidad. Si no estás de acuerdo con alguno de estos términos, no utilices este sitio web.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>1. Uso del Sitio Web</h5>
            <p>El contenido de este sitio web es solo para fines informativos y de entretenimiento. No garantizamos la precisión, integridad o actualidad de la información proporcionada en este sitio web.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>2. Propiedad Intelectual</h5>
            <p>Todos los derechos de propiedad intelectual en este sitio web y su contenido son propiedad de <strong><?php echo $config['script_name'] ?></strong> o de sus licenciantes. Se prohíbe la reproducción, distribución o modificación del contenido de este sitio web sin el consentimiento previo por escrito de <strong><?php echo $config['script_name'] ?></strong>.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>3. Enlaces a Terceros</h5>
            <p>Este sitio web puede contener enlaces a sitios web de terceros. Estos enlaces se proporcionan únicamente para tu conveniencia y no implican ninguna aprobación por nuestra parte del contenido de esos sitios web.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>4. Limitación de Responsabilidad</h5>
            <p>En ningún caso seremos responsables ante ti por cualquier daño directo, indirecto, incidental, especial, consecuente u otro tipo de daño derivado del uso de este sitio web o de la información contenida en él.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>5. Modificaciones</h5>
            <p>Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. La versión más reciente de estos términos y condiciones se publicará en este sitio web y entrará en vigor inmediatamente después de su publicación.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>6. Ley Aplicable</h5>
            <p>Estos términos y condiciones se rigen por las leyes de Mexico y cualquier disputa relacionada con estos términos y condiciones se someterá a la jurisdicción exclusiva de los tribunales de Mexico.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <p>Si tienes alguna pregunta sobre estos términos y condiciones, contáctanos .</p>
        </div>
    </div>
</section>


<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->