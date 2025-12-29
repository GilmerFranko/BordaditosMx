<?php defined('BORDAMEX') || exit;

/**
 *=======================================================
 *  BORDAMEX Project
 *-------------------------------------------------------
 * @author Gilmer Franco <gil2017.com@gmail.com>
 *=======================================================
 *
 * @Description Vista del área "Contraseña" de la sección "Contraseña" en la cuenta
 *
 */
?>

<article id="memberAccountSecurity" class="py-4">
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <label for="email" class="form-label">Tu Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $session->memberData['email']; ?>" disabled>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="currentPassword" class="form-label">Contraseña actual</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" autocomplete="new-password">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="newPassword" class="form-label">Nueva contraseña</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword">
            </div>
            <div class="col-md-6">
                <label for="confirmPassword" class="form-label">Confirme contraseña</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
            </div>
        </div>
        <!-- Descomentar esta sección si se desea agregar la opción de eliminar cuenta
    <div class="row">
      <div class="col-12">
        <p class="text-danger" id="msgDelete"></p>
        <button class="btn btn-danger w-100" onclick="deleteAccount();" id="deleteAccount">Eliminar Cuenta</button>
      </div>
    </div>
    -->
    </div>
</article>

<script>
    var token = '<?php echo $session->token; ?>';
</script>