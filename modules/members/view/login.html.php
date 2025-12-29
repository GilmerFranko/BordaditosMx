<?php defined('BORDAMEX') || exit;

/**
 *=======================================================

BORDAMEX Project - Diseño Modernizado
 *-------------------------------------------------------

@author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 */

require Core::view('head', 'core');
?>

<style>
  :root {
    --primary-color: #4e73df;
    --bg-gradient: linear-gradient(135deg, #f8f9fc 0%, #e2e8f0 100%);
  }

  body {
    background: var(--bg-gradient);
    min-height: 100vh;
  }

  #main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 15px;
  }

  .login-container {
    width: 100%;
    max-width: 420px;
  }

  .brand-logo {
    text-align: center;
    margin-bottom: 2rem;
    transition: transform 0.3s ease;
  }

  .brand-logo:hover {
    transform: scale(1.05);
  }

  .card-login {
    border: none;
    border-radius: 1.25rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    background: #ffffff;
  }

  .card-header-custom {
    padding: 2rem 2rem 0.5rem;
    background: transparent;
    border: none;
    text-align: center;
  }

  .card-header-custom h3 {
    font-weight: 700;
    color: #334155;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
  }

  .card-body-custom {
    padding: 1.5rem 2rem 2.5rem;
  }

  .form-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.025em;
  }

  .form-control {
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background-color: #f8fafc;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    background-color: #fff;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
  }

  .btn-login {
    padding: 0.8rem;
    font-weight: 700;
    border-radius: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
    background: var(--primary-color);
    border: none;
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
  }

  .forgot-link {
    color: #94a3b8;
    font-size: 0.9rem;
    text-decoration: none;
    transition: color 0.2s;
  }

  .forgot-link:hover {
    color: var(--primary-color);
  }

  /* Estilos para el Modal */
  .modal-content {
    border-radius: 1.25rem;
    border: none;
  }

  .modal-header {
    border-bottom: 1px solid #f1f5f9;
    padding: 1.5rem;
  }

  .input-group-text {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #94a3b8;
    border-top-left-radius: 0.75rem;
    border-bottom-left-radius: 0.75rem;
  }

  .input-group .form-control {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
</style>

<?php require Core::view('menu', 'core') ?>

<section class="content" id="main">
  <div class="login-container">

    <!-- Logo -->
    <div class="brand-logo">
      <img src="<?php echo Core::model('extra', 'core')->getLogo(); ?>" alt="Logo" width="180" />
    </div>

    <!-- Tarjeta de Login -->
    <div class="card card-login">
      <div class="card-header-custom">
        <h3>Bienvenido</h3>
        <p class="text-muted small">Ingresa tus credenciales para continuar</p>
      </div>

      <div class="card-body card-body-custom">
        <form action="<?php echo $extra->generateUrl('members', 'login'); ?>" method="post">

          <div class="mb-3">
            <label for="email" class="form-label">Usuario o Email</label>
            <input id="email" name="email" type="email" class="form-control"
              placeholder="ejemplo@correo.com"
              value="<?php echo Core::model('extra', 'core')->getInputValue('email'); ?>" required>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control"
              placeholder="••••••••" required>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="keepOpen" name="keepOpen" value="1" checked>
              <label class="form-check-label small text-secondary" for="keepOpen">
                Recordarme
              </label>
            </div>
          </div>

          <div class="d-grid">
            <button class="btn btn-primary btn-login" type="submit" name="login">
              Acceder al Sistema
            </button>
          </div>

          <div class="mt-4 text-center">
            <a href="#modalRecuperar" class="forgot-link" data-bs-toggle="modal">
              <i class="fa fa-question-circle me-1"></i> ¿Olvidaste tus datos?
            </a>
          </div>
        </form>
      </div>
    </div>

    <p class="mt-4 text-center text-muted small">
      &copy; <?php echo date('Y'); ?> BORDAMEX Project. Todos los derechos reservados.
    </p>
  </div>


</section>

<!-- Modal RECUPERAR CONTRASEÑA -->

<div class="modal fade" id="modalRecuperar" tabindex="-1" aria-labelledby="modalRecuperarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalRecuperarLabel">Recuperar Acceso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form action="" method="post">
          <!-- Opción 1: Contraseña -->
          <div class="mb-4">
            <h6 class="fw-bold mb-2">Olvidé mi contraseña</h6>
            <p class="text-muted small">Enviaremos un enlace de recuperación a tu correo.</p>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-envelope"></i></span>
              <input id="recover" name="recover" type="email" class="form-control" placeholder="Tu Email registrado" required>
            </div>
          </div>

          <div class="position-relative my-4">
            <hr>
            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">O TAMBIÉN</span>
          </div>

          <!-- Opción 2: Email -->
          <div class="mb-3">
            <h6 class="fw-bold mb-2">Olvidé mi correo</h6>
            <p class="text-muted small">Ingresa tus datos para recordarte el correo asociado.</p>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-user"></i></span>
              <input id="recoverEmail" name="recoverEmail" type="text" class="form-control" placeholder="Usuario" required>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text"><i class="fa fa-lock"></i></span>
              <input id="recoverEmailPass" name="recoverEmailPass" type="password" class="form-control" placeholder="Contraseña actual" required>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" name="recoverBtn" class="btn btn-primary px-4">Confirmar</button>
          </div>
        </form>
      </div>
    </div>
  </div>


</div>

<?php require Core::view('footer', 'core'); ?>