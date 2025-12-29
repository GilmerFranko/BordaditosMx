<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista del área "Perfil" de la cuenta
 *
 */
?>
<article id="memberAccountProfile" class="py-4">
  <div class="container">
    <!-- Área para la foto de perfil -->
    <!--
    <div class="text-center mb-4">
      <div id="profilePhotoArea" class="border rounded p-3" style="cursor: pointer;">
        <img id="pp_main_photo" src="<?= $config['avatar_url'] . '/' . $session->memberData['pp_main_photo'] ?>" alt="Foto de perfil" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
        <div id="uploadText" class="mt-2">Arrastra y suelta una imagen aquí o haz clic para seleccionar una.</div>
      </div>
      <input type="file" id="profilePhotoInput" name="avatar_pc" accept="image/*" style="display: none;">
    </div>-->
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="name" class="form-label">Nombre de usuario</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $session->memberData['name']; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="full_name" class="form-label">Nombre completo</label>
        <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $session->memberData['pp_full_name']; ?>" required>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-12">
        <label for="timezone" class="form-label">Zona horaria</label>
        <?php echo Core::model('account', 'members')->getTimezones($session->memberData['pp_timezone']); ?>
      </div>
    </div>
    <!--<div class="row">
      <div class="col-12">
        <label for="language" class="form-label">Seleccionar idioma</label>
        <select id="language" class="form-select" onchange="doGTranslate(this);">
          <option value="">Seleccionar idioma</option>
          <option value="en|en">English</option>
          <option value="en|fr">French</option>
          <option value="en|it">Italian</option>
          <option value="en|pt">Portuguese</option>
          <option value="en|es">Español</option>
        </select>
      </div>
    </div>-->
  </div>
</article>