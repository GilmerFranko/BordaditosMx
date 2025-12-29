<?php defined('BORDAMEX') || exit;

/**
 * @Description Pagina de preguntas frecuentes
 *
 *
 */

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<style type="text/css">
    .collapsible-header {
        background-color: #313337;
    }
</style>
<section id="pageFAQ">
    <div class="container">
        <center>
            <h4>Centro de ayuda y preguntas frecuentes</h4>
        </center>
        Toque la pregunta en la que tenga dudas para leer la respuesta. <b>Actualizado 1 de marzo de 2024</b>
        <div style="text-align:justify;" class="flow-text">
            <ul class="collapsible popout">
                <!-- PRIMERA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">place</i>¿Cómo realizo un depósito en mi cuenta?</div>
                    <div class="collapsible-body"><span>Puede realizar un depósito en su cuenta utilizando como método de pago criptomonedas, principalmente USDT, Todo mediante <strong> Binance </strong>. Una vez en su cuenta, vaya a la sección de depósitos y siga las instrucciones para completar la transacción.</span></div>
                </li>
                <!-- SEGUNDA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>¿Cómo puedo retirar mis ganancias?</div>
                    <div class="collapsible-body"><span>Para retirar sus ganancias, vaya a la sección de retiros en su cuenta y siga los pasos indicados. Puede seleccionar el método de retiro preferido y proporcionar la información necesaria para completar la solicitud.</span></div>
                </li>
                <!-- TERCERA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">place</i>¿Cuánto tiempo tarda en procesarse un retiro?</div>
                    <div class="collapsible-body"><span>El tiempo de procesamiento de un retiro puede variar según el método de pago seleccionado y las políticas del sitio. Por lo general, los retiros pueden tardar entre 1 y 2 horas en procesarse completamente.</span></div>
                </li>
                <!-- CUARTA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>¿Qué debo hacer si encuentro un problema con mi cuenta o una transacción?</div>
                    <div class="collapsible-body"><span>Si encuentra algún problema con su cuenta o una transacción, comuníquese con nuestro equipo de soporte. Puede encontrar opciones de contacto en la sección de ayuda o en la página de contacto del sitio.</span></div>
                </li>
                <!-- QUINTA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">whatshot</i>¿Cómo puedo obtener ayuda adicional si no encuentro la respuesta a mi pregunta aquí?</div>
                    <div class="collapsible-body"><span>Si no encuentra la respuesta a su pregunta en esta sección de preguntas frecuentes, puede comunicarse con nuestro equipo de soporte utilizando el formulario de contacto en el sitio. Estaremos encantados de ayudarle con cualquier duda o consulta.</span></div>
                </li>
                <!-- SEXTA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_drama</i>¿Es seguro realizar transacciones en este sitio?</div>
                    <div class="collapsible-body"><span>Sí, nuestro sitio utiliza medidas de seguridad avanzadas para proteger la información personal y financiera de nuestros usuarios. Todas las transacciones se realizan a través de conexiones seguras y se cifran para garantizar la seguridad de los datos.</span></div>
                </li>
                <!-- SEPTIMA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_drama</i>¿Qué debo hacer si olvidé mi contraseña?</div>
                    <div class="collapsible-body"><span>Si olvidó su contraseña, puede restablecerla siguiendo el enlace de "¿Olvidó su contraseña?" en la página de inicio de sesión. Se le pedirá que proporcione su dirección de correo electrónico y siga las instrucciones para restablecer su contraseña.</span></div>
                </li>
                <!-- OCTAVA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_drama</i>¿Cómo puedo cambiar mi información de contacto o detalles de la cuenta?</div>
                    <div class="collapsible-body"><span>Puede actualizar su información de contacto y detalles de la cuenta en la sección de configuración de su cuenta. Aquí puede cambiar su dirección de correo electrónico, número de teléfono u otra información personal según sea necesario.</span></div>
                </li>
                <!-- NOVENA PREGUNTA -->
                <li>
                    <div class="collapsible-header"><i class="material-icons">filter_drama</i>¿El sitio ofrece bonos o promociones para nuevos usuarios?</div>
                    <div class="collapsible-body"><!--<span>Sí, ofrecemos bonos y promociones para nuevos usuarios. Estos pueden incluir bonos de bienvenida, giros gratis o créditos adicionales en su cuenta al registrarse o realizar su primer depósito. Consulte la sección de promociones para obtener más información.</span>--> <span>Muy pronto!</span></div>
                </li>

            </ul>
        </div>
    </div>
</section>
<br>
<br>

<!-- / Body -->

<?php if ($session->is_admod || ($session->isAllowed('post_shout') && $session->memberData['pp_gender'] == 1))
{ ?>
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large purple darken-2 pulse" href="<?php echo $extra->generateUrl('shouts', 'new'); ?>">
            <i class="large material-icons">add_a_photo</i>
        </a>
    </div>
<?php } ?>