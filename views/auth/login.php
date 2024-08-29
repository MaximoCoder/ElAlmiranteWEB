
<div class="container">
    <form class="form-group register-form" action="login" method="post">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Inicia sesión</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <label class=" fw-semibold" for="">Correo:</label>
            <input type="email" name="email" class="form-control input-formU" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required>
        
            <label class=" fw-semibold" for="">Contraseña:</label>
            <input type="password" name="password" class="form-control input-formU" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ''; ?>" required>    
            <div class="d-flex justify-content-between">
                <a href="forgotPassword" class="text-white h6">olvide mi contraseña</a>
                <a href="register" class="text-white h6">¿aun no tienes una cuenta?</a>
            </div>
            <input type="submit" value="Iniciar sesión" class="form-control btn-color fw-bold">
        </div>
    </form>
</div>