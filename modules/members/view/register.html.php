<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página de registro
 */

require Core::view('head', 'core');
?>

<style>
  .logo {
    display: flex;
    justify-content: center;
    padding-bottom: 30px;
  }
</style>

<!-- Header -->
<?php require Core::view('menu', 'core'); ?>
<!-- / Header -->

<!-- Body -->
<section class="first-section content" id="membersRegister">
  <div class="logo">
    <img src="<?php echo Core::model('extra', 'core')->getLogo(); ?>" alt="Logo" width="160" />
  </div>

  <div class="container d-flex justify-content-center">
    <div class="card p-4" style="max-width: 600px; width: 100%;">
      <h2 class="text-center mb-4">Registro</h2>
      <form action="" method="post">
        <!-- Nombre y Apellido -->
        <div class="mb-3">
          <label for="username" class="form-label">Tu Nombre y Apellido o Apodo</label>
          <input type="text" id="username" name="name" class="form-control" placeholder="Ejemplo: Juan Perez"
            value="<?php echo Core::model('extra', 'core')->getInputValue('name', 'post'); ?>"
            pattern="[ A-Za-z]{4,30}" title="Nombre. De entre: 4. A: 30 Letras" required>
        </div>

        <!-- Correo Electrónico -->
        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@correo.com"
            value="<?php echo Core::model('extra', 'core')->getInputValue('email', 'post'); ?>" required>
        </div>

        <!-- Contraseña -->
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="password" class="form-label">Elije una Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" minlength="6" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="confirmPassword" class="form-label">Repite la Contraseña</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" minlength="6" required>
          </div>
        </div>

        <!-- Género -->
        <div class="mb-3">
          <label class="form-label d-block">Género</label>
          <div class="form-check form-check-inline">
            <input type="radio" id="genderMale" name="gender" value="0" class="form-check-input" required>
            <label for="genderMale" class="form-check-label">Hombre</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" id="genderFemale" name="gender" value="1" class="form-check-input" required>
            <label for="genderFemale" class="form-check-label">Mujer</label>
          </div>
          <div class="form-check form-check-inline">
            <input type="radio" id="genderOther" name="gender" value="2" class="form-check-input" required>
            <label for="genderOther" class="form-check-label">Prefiero no decirlo</label>
          </div>
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="mb-3">
          <label for="birthday" class="form-label">Fecha de Nacimiento</label>
          <input type="date" id="birthday" name="birthday" class="form-control" required>
        </div>

        <!-- Botón de Registro -->
        <div class="d-grid">
          <button type="submit" name="register" class="btn btn-primary">Crear Cuenta</button>
        </div>

        <!-- Link a Iniciar Sesión -->
        <div class="mt-3 text-center">
          <a href="<?php echo Core::model('extra', 'core')->generateUrl('members', 'login'); ?>" class="btn btn-link">
            ¿Ya tienes cuenta? Inicia Sesión
          </a>
        </div>

        <!-- Link de ayuda para el registro -->
        <div class="mt-2 text-center">
          <a href="<?php echo Core::model('extra', 'core')->generateUrl('site', 'pages', null, array('name' => 'explica')); ?>" class="btn btn-link">
            ¿Problemas para registrarte? ¡Haz clic aquí!
          </a>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->