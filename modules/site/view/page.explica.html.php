<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 * @Description Pagina de preguntas frecuentes
 *
 *
 */

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<style>
    .collapsible-header {
        background-color: #313337;
    }
</style>
<!-- Body -->
<section id="pageTerms">
    <div class="container">
        <h4>TOQUE EN LA PREGUNTA QUE TENGAS DUDAS</h4>
        <div style="text-align:justify;" class="flow-text">
            <ul class="collapsible popout">
                <!-- PRIMERA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">place</i>¿Qué poner en nombre de usuario?</div>
                    <div class="collapsible-body"><span>Solo escribe tu nombre de ejemplo: Juan Pérez, Sofía Gómez.</span></div>
                </li>
                <!-- SEGUNDA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>¿Qué poner en correo electrónico?</div>
                    <div class="collapsible-body"><span>Aquí deberás poner tu correo electrónico, todos tienen un correo electrónico o pueden crear uno en Gmail o Hotmail, como ejemplo de correos electrónicos, maría24xsf@gmail.com juan123@hotmail.com. Con el correo electrónico podrás ingresar a <?php echo $config['script_name'] ?> después de registrarte.</span></div>
                </li>
                <!-- TERCERA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>¿Qué poner en contraseña?</div>
                    <div class="collapsible-body"><span>Elige una contraseña segura que no olvides, ya que con ella podrás volver a ingresar a <?php echo $config['script_name'] ?>, al poner la contraseña tendrás que repetirla en el siguiente campo.</span></div>
                </li>
                <!-- CUARTA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>¿Qué más hacer?</div>
                    <div class="collapsible-body"><span>Ahora selecciona si eres hombre o mujer y haz clic en Crear cuenta, si todo lo hiciste bien ya estás dentro de <?php echo $config['script_name'] ?>.</span></div>
                </li>

                </li>
            </ul>
        </div>
    </div>
</section>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->