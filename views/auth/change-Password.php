<div class="container">
    <form class="form-group register-form"  method="post">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Cambia tu contraseña</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <label class=" fw-semibold" for="">Nueva contraseña:</label>
            <input type="password" name="newPassword" class="form-control input-formU" value="<?php echo isset($_POST["newPassword"]) ? $_POST["newPassword"] : ''; ?>" required>
            <label class=" fw-semibold" for="">Confirma nueva contraseña:</label>
            <input type="password" name="confirmPassword" class="form-control input-formU" value="<?php echo isset($_POST["confirmPassword"]) ? $_POST["confirmPassword"] : ''; ?>" required>
        
            <input type="submit" value="Guardar" class="form-control btn-color fw-bold">
            <div class="d-flex justify-content-between">
                <a href="login" class="text-white h6">Cancelar</a>
            </div>
        </div>
    </form>
</div>