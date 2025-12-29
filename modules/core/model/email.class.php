<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Este modelo incluye funciones variadas con utilización frecuente
 *
 * NOTA: ESTA CLASE NO ES UNICA; SE PARTICIONARÁ
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{

    /**
     * Envía un correo electrónico utilizando PHPMailer
     *
     * @param string $template
     * @param string $email
     * @param array  $params
     * @param string $subject
     * @param string $content
     * @return boolean
     */
    function sendEmail($template = 'normal', $email = NULL, $params = array(), $subject = null, $content = null)
    {
        global $config;

        // INCLUIR PLANTILLA
        require BG_INC . 'templates' . DS . 'mail' . DS . $template . '.mail.php';

        // Inicializa PHPMailer
        $mail = new PHPMailer(true);

        try
        {
            // Configuración del servidor SMTP
            //$mail->isSMTP();
            /* $mail->Host = 'mail..es'; // Cambia esto por el servidor SMTP que estés usando
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@.es'; // Cambia esto por tu correo electrónico
            $mail->Password = 'KPpq2&edzn970qgdL'; // Cambia esto por tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
             $mail->Port = 465; // Cambia esto por el puerto que utilices (587 es común para TLS)*/

            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'mail..es'; // Cambia esto por el host SMTP proporcionado por Plesk
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@.es'; // Tu dirección de correo en Plesk
            $mail->Password = 'KPpq2&edzn970qgdL'; // La contraseña de tu correo electrónico
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Puedes probar con `PHPMailer::ENCRYPTION_SMTPS` si es necesario
            $mail->Port = 587; // Plesk generalmente usa el puerto 587 para STARTTLS, o 465 para SMTPS

            // Configuración del remitente y destinatarios
            $mail->setFrom('no-reply@.es',  $config['script_name']); // Cambia esto por el nombre que desees mostrar
            $mail->addAddress($email);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->AltBody = strip_tags($content); // Alternativa en texto plano

            // Envía el correo
            $mail->send();
            return true;
        }
        catch (Exception $e)
        {
            // Manejo de errores
            error_log("No se pudo enviar el correo. Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
