<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista de la página para la edicion del section "Hero"
 *
 */

require Core::view('head', 'core');
?>

<section>
  <!-- Estilos específicos para la gestión de la imagen Hero -->
  <style>
    .card-settings {
      border-radius: 12px;
      padding: 30px;
      margin-top: 20px;
    }

    .section-title {
      font-size: 1.4rem;
      font-weight: bold;
      color: #26a69a;
      display: flex;
      align-items: center;
      margin-bottom: 25px;
      border-bottom: 1px solid #eee;
      padding-bottom: 15px;
    }

    .section-title i {
      margin-right: 12px;
    }

    /* Contenedor de Vista Previa Dinámica */
    .hero-preview-wrapper {
      position: relative;
      width: 100%;
      min-height: 250px;
      max-height: 400px;
      border-radius: 8px;
      background-color: #eceff1;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px dashed #cfd8dc;
      margin-bottom: 20px;
    }

    #mainPreview {
      width: 100%;
      height: auto;
      display: block;
      object-fit: contain;
    }

    .no-image-placeholder {
      text-align: center;
      color: #90a4ae;
    }

    .file-field .btn {
      background-color: #26a69a;
    }

    .info-box {
      background-color: #fff3e0;
      padding: 15px;
      border-radius: 8px;
      border-left: 5px solid #ff9800;
      margin-top: 20px;
    }

    .info-box p {
      margin: 0;
      color: #e65100;
      font-size: 0.9rem;
    }
  </style>

  <div class="row">
    <div class="col s12">
      <div class="card card-settings z-depth-1">
        <div class="section-title">
          <i class="material-icons">wallpaper</i> Imagen de Sección Principal
        </div>

        <!-- El action debe apuntar a tu controlador de guardado -->
        <form id="heroForm" action="<?= glink('admin/edit.section-hero', ['save' => 'true']) ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <!-- Columna de Control -->
            <div class="col s12 m5">
              <p class="grey-text">Selecciona la imagen principal para la sección Hero de la página de inicio.</p>

              <div class="file-field input-field">
                <div class="btn waves-effect waves-light">
                  <span>Seleccionar Archivo</span>
                  <input type="file" id="imageInput" name="image_section" accept="image/*">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text" placeholder="Subir nueva imagen">
                </div>
              </div>

              <div class="info-box">
                <p>
                  <i class="material-icons left tiny">info</i>
                  Se recomienda una resolución de 1920x600px o superior para evitar pixelado.
                </p>
              </div>

              <div style="margin-top: 30px;">
                <button type="submit" class="btn-large teal waves-effect waves-light full-width" style="width: 100%;">
                  <i class="material-icons left">save</i> Actualizar Sección
                </button>
              </div>
            </div>

            <!-- Columna de Previsualización -->
            <div class="col s12 m7">
              <label class="center-align d-block" style="display: block; margin-bottom: 10px; font-weight: bold;">
                Vista Previa (Actual o Nueva)
              </label>
              <div class="hero-preview-wrapper" id="previewContainer">
                <?php
                // Simulamos la ruta de la imagen desde PHP
                $current_hero = isset($img['image_section']) ? $img['image_section'] : '';
                if (!empty($current_hero)):
                ?>
                  <img src="<?php echo $config['products_url'] . $current_hero; ?>" alt="Hero Actual" id="mainPreview">
                  <div id="placeholder" class="no-image-placeholder" style="display:none;">
                    <i class="material-icons large">image_not_supported</i>
                    <p>No hay imagen seleccionada</p>
                  </div>
                <?php else: ?>
                  <img src="" alt="Vista previa" id="mainPreview" style="display:none;">
                  <div id="placeholder" class="no-image-placeholder">
                    <i class="material-icons large">image</i>
                    <p>No se ha configurado ninguna imagen</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

</section>
<script>
  $(document).ready(function() {
    // Inicializar componentes de Materialize necesarios
    if (typeof M !== 'undefined') {
      M.updateTextFields();
    }

    // Manejar cambio en el input de imagen con jQuery
    $('#imageInput').on('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          $('#mainPreview').attr('src', e.target.result).fadeIn();
          $('#placeholder').hide();
        }

        reader.readAsDataURL(file);

        // Opcional: Notificar al usuario que hay cambios pendientes
        M.toast({
          html: 'Imagen lista para subir',
          classes: 'rounded blue-grey',
          displayLength: 2000
        });
      }
    });

    // Validación simple antes de enviar
    $('#heroForm').on('submit', function(e) {
      const fileInput = $('#imageInput');
      // Si quieres obligar a que siempre suban algo si no hay imagen actual
      /*
      if (fileInput.get(0).files.length === 0 && $('#mainPreview').attr('src') === "") {
          e.preventDefault();
          M.toast({html: 'Por favor selecciona una imagen primero', classes: 'rounded red'});
      }
      */
    });
  });
</script>