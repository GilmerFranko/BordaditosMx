<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 * @Description Vista de contacto
 *
 */

require Core::view('head', 'core');
?>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,600);

    body {
        font-family: 'Open Sans', sans-serif;
    }

    form {
        position: relative;
        margin: 20px auto;
        max-width: 400px;
    }

    h3 {
        font-size: 16px;
        font-weight: 600;
        color: rgba(0, 0, 0, 0.8);
    }

    .form-control {
        margin-bottom: 20px;
    }

    .form-floating label {
        color: #6c757d;
    }
</style>

<section id="<?php echo $page['code']; ?>" class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm p-4">
                    <blockquote class="blockquote mb-4">
                        Utiliza este formulario para ponerte en contacto con el administrador del sitio.
                        <strong>Nadie más leerá el mensaje.</strong>
                    </blockquote>
                    <form id="sendform" method="POST" action="">
                        <input type="hidden" name="member_id" value="<?php echo $session->memberData['member_id']; ?>">
                        <input type="hidden" name="contact" value="">

                        <?php if ($session->is_member == false)
                        { ?>
                            <!-- Nombre -->
                            <div class="form-floating mb-3">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nombre"
                                    value="<?php echo Core::model('extra', 'core')->getInputValue('name', 'post', $session->memberData['name']); ?>" required>
                                <label for="name"><i class="bi bi-person-fill me-2"></i>Nombre</label>
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                                    value="<?php echo Core::model('extra', 'core')->getInputValue('email', 'post', $session->memberData['email']); ?>" required>
                                <label for="email"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                            </div>
                        <?php } ?>

                        <!-- Título del mensaje -->
                        <div class="form-floating mb-3">
                            <input type="text" name="title" id="title" class="form-control" placeholder="Título corto del mensaje"
                                value="<?php echo Core::model('extra', 'core')->getInputValue('title', 'post'); ?>" required>
                            <label for="title"><i class="bi bi-chat-left-text-fill me-2"></i>Título corto del mensaje</label>
                        </div>

                        <!-- Contenido del mensaje -->
                        <div class="form-floating mb-3">
                            <textarea name="content" id="content" class="form-control" style="height: 150px;"
                                placeholder="Escribe aquí tu mensaje" required><?php echo Core::model('extra', 'core')->getInputValue('content', 'post'); ?></textarea>
                            <label for="content"><i class="bi bi-pencil-fill me-2"></i>Escribe aquí tu Mensaje</label>
                        </div>

                        <!-- Captcha -->
                        <div class="h-captcha" data-sitekey="ac48f6bb-17c3-4fcb-a43a-d1be043d20fb"></div>
                        <br>

                        <!-- Botón Enviar -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send-fill me-2"></i>Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://hcaptcha.com/1/api.js" async defer></script>
<!-- / Body -->

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->