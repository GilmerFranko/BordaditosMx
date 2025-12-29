<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Plantilla de correo para notificar al usuario de un nuevo mensaje
 *
 */
$script_name = Core::config('script_name');

$year = date('Y');

$base_url = Core::config('base_url');

$subject = 'Tienes un nuevo mensaje en ' . $script_name;

// Genera el enlace al mensaje
$messageLink = gLink('members/view.messages', ['r_id' => $params['to_member']['member_id']]);

$content = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Language" content="es">
    <title>Nuevo mensaje en {$script_name}</title>
    <style>
        /* Estilos para correos electrónicos */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #85427e;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .body-content {
            padding: 20px;
        }
        .body-content p {
            margin: 0 0 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #85427e;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .footer {
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .footer a {
            color: #85427e;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tienes un nuevo mensaje en {$script_name}!</h1>
        </div>
        <div class="body-content">
            <p>Hola <strong>{$params['to_member']['name']}</strong>,</p>
            <p>{$params['from_member']['name']} Te ha enviado un nuevo mensaje en <strong>{$script_name}</strong>.</p>
            <p>Para leer tu mensaje, haz clic en el siguiente botón:</p>
            <p>¡Gracias por ser parte de nuestra comunidad!</p>
            <p style="text-align:center;">
                <a href="{$messageLink}" class="btn">Ver mensaje</a>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {$year} {$script_name} - Todos los derechos reservados.</p>
            <p><a href="{$base_url}">Visitar nuestro sitio</a></p>
        </div>
    </div>
</body>
</html>
HTML;
