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
<section id="privacyPolicy" class="container">
    <h3 class="center-align">Política de Privacidad</h3>

    <div class="row">
        <div class="col s12">
            <p>En <strong><?php echo $config['script_name'] ?></strong>, consideramos que la privacidad de nuestros visitantes es extremadamente importante. Esta política de privacidad describe detalladamente los tipos de información personal que recibimos y recopilamos cuando visitas <strong><?php echo $config['script_name'] ?></strong> y cómo la utilizamos. Esperamos que esta política de privacidad te ayude a tomar decisiones informadas sobre la información personal que nos proporcionas.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>1. Información Recopilada</h5>
            <p>Al visitar <strong><?php echo $config['script_name'] ?></strong>, automáticamente recopilamos cierta información sobre tu visita, como tu dirección IP, tipo de navegador, páginas visitadas y la fecha y hora de tu visita. Esta información no te identifica personalmente y se utiliza para fines estadísticos y de análisis de tendencias.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>2. Uso de Cookies</h5>
            <p><strong><?php echo $config['script_name'] ?></strong> utiliza cookies para personalizar y mejorar tu experiencia en nuestro sitio. Las cookies son pequeños archivos de texto que se almacenan en tu computadora y nos permiten recordar tus preferencias y proporcionarte una experiencia más personalizada.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>3. Información Personal</h5>
            <p>Cuando te registras en<strong><?php echo $config['script_name'] ?></strong>] o participas en nuestras promociones o encuestas, es posible que te solicitemos información personal, como tu nombre, dirección de correo electrónico, dirección postal y número de teléfono. Esta información se utiliza para fines administrativos y para mejorar nuestros servicios.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>4. Divulgación a Terceros</h5>
            <p>En <strong><?php echo $config['script_name'] ?></strong>, no vendemos, intercambiamos ni transferimos tu información personal a terceros sin tu consentimiento, excepto en los casos en que esté permitido o requerido por la ley.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>5. Seguridad</h5>
            <p>Tomamos medidas razonables para proteger tu información personal contra el acceso no autorizado, el uso indebido o la divulgación. Sin embargo, ten en cuenta que ninguna transmisión de datos por Internet es completamente segura y no podemos garantizar la seguridad de la información que nos envías.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>6. Cambios en la Política de Privacidad</h5>
            <p>Podemos actualizar esta política de privacidad periódicamente mediante la publicación de una versión actualizada en nuestro sitio web. Te recomendamos que revises esta página regularmente para estar al tanto de cualquier cambio. La fecha de la última actualización de esta política de privacidad se indica al final de este documento.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5>7. Aceptación de los Términos</h5>
            <p>Al utilizar <strong><?php echo $config['script_name'] ?></strong>, aceptas los términos y condiciones de esta política de privacidad. Si no estás de acuerdo con esta política, te recomendamos que no utilices nuestro sitio web ni proporciones información personal a través de él.</p>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <p>Si tienes alguna pregunta sobre esta política de privacidad, contáctanos a [correo electrónico de contacto].</p>
        </div>
    </div>
</section>


<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->