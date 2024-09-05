<div class="container">
    <form class="form-group register-form"  method="post">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Restaurar contraseña</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <label class=" fw-semibold" for="">Correo:</label>
            <input type="email" name="Correo" class="form-control input-formU" value="<?php echo isset($_POST["Correo"]) ? $_POST["Correo"] : ''; ?>" required>
        
            <input type="submit" value="Enviar codigo" class="form-control btn-color fw-bold">
            <div class="d-flex justify-content-between">
                <a href="login" class="text-white h6">Regresar</a>
            </div>
        </div>
    </form>
</div>