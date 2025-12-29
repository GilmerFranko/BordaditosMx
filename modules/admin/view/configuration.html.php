<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página de configuración de la administración
 *
 *
 */

require Core::view('head', 'core');
?>

<section>
  <div class="sectionConfiguration">
    <blockquote class="flow-text">
      Guardado por <?php echo $save_name; ?> el <?php echo $save_date; ?>
    </blockquote>
    <div class="row">
      <form action="<?php echo Core::model('extra', 'core')->generateUrl('admin', 'configuration'); ?>" method="post" class="col s12">

        <!-- NOMBRE DEL SITIO -->
        <div class="row">
          <div class="input-field col s6">
            <input id="script_name" name="script_name" type="text" class="validate" value="<?php echo $config['script_name']; ?>" required="required">
            <label for="script_name" class="active">Nombre del sitio (ej: Facebook)</label>
          </div>
          <div class="input-field col s6">
            <input id="script_abbreviation" name="script_abbreviation" type="text" class="validate" value="<?php echo $config['script_abbreviation']; ?>" required="required" maxlength="4">
            <label for="script_abbreviation" class="active">Siglas del sitio (ej: FB)</label>
          </div>
        </div>
        <!-- NOMBRE DE LA COOKIE -->
        <div class="row">
          <div class="input-field col s6" title="Es el nombre que se le da a la cookie que almacena la session del usuario">
            <input id="cookie_name" name="cookie_name" type="text" class="validate" value="<?php echo $config['cookie_name']; ?>" required="required">
            <label for="cookie_name" class="active">Nombre de cookie</label>
          </div>
          <div class="input-field col s6" title="Es el tiempo que dura la sesión del usuario al loguearse">
            <input id="cookie_time" name="cookie_time" type="number" class="validate" value="<?php echo $config['cookie_time']; ?>" required="required">
            <label for="cookie_time" class="active">Tiempo de cookie (d&iacute;as)</label>
          </div>
        </div>


        <div class="input-field">
          <i class="material-icons prefix">phone</i>
          <input type="tel" id="num_phone" name="num_phone" class="validate" value="<?php echo $config['num_phone']; ?>">
          <label for="num_phone">Número de teléfono (Añadir codigo +)</label>
        </div>
        <!-- CONFIGURACIÓN EXTRA -->
        <div class="row">
          <div class="input-field col s6" title="Si esta activo, el sitio queda inactivo para los usuarios">
            <div class="switch">
              <label>
                <input type="checkbox" value="1" name="maintenance" id="maintenance" <?php echo $config['maintenance'] == 1 ? 'checked="checked"' : ''; ?>>
                <span class="lever"></span>

              </label>
            </div>
            <label for="maintenance" class="active">Mantenimiento</label>
          </div>
          <div class="input-field col s6" title="Si está activado muestra el panel de depuración">
            <div class="switch">
              <label>

                <input type="checkbox" value="1" name="debug_mode" id="debug_mode" <?php echo $config['debug_mode'] == 1 ? 'checked="checked"' : ''; ?>>
                <span class="lever"></span>

              </label>
            </div>
            <label for="debug_mode" class="active">Depuraci&oacute;n</label>
          </div>
        </div>
        <div class="row" title="Si está activado valida el correo antes de registrarse">
          <div class="input-field col s6">
            <div class="switch">
              <label>
                <input type="checkbox" value="1" name="reg_validate" id="reg_validate" <?php echo $config['reg_validate'] == 1 ? 'checked="checked"' : ''; ?>>
                <span class="lever"></span>

              </label>
            </div>
            <label for="reg_validate" class="active">Validar por correo</label>
          </div>

          <div class="input-field col s6" title="Si está activo envía un correo al usuario al recibir un mensaje privado">
            <div class="switch">
              <label>
                <input type="checkbox" value="1" name="enable_email_on_message" id="enable_email_on_message" <?php echo $config['enable_email_on_message'] == 1 ? 'checked="checked"' : ''; ?>>
                <span class="lever"></span>

              </label>
            </div>
            <label for="enable_email_on_message" class="active">Enviar email al recibir un mensaje</label>
          </div>
        </div>

        <!-- BOTON GUARDAR -->
        <button class="btn waves-effect waves-light grey darken-3" type="submit" name="save">Guardar cambios
          <i class="material-icons right">save</i>
        </button>

      </form>
    </div>
  </div>
</section>


<!-- Footer -->
<?php require Core::view('footer', 'core'); ?>
<!-- / Footer -->

<!-- JS adicional -->
<script type="text/javascript" src="<?php echo $config['base_url']; ?>/static/js/admin.js" />
</script>