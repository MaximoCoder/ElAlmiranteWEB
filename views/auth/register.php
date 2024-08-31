
<div class="container">
    <form class="form-group register-form" action="register" method="post">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Registrarse</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <label for="" class="mt-4 fw-semibold">Nombre completo:</label>
            <input type="text" name="Nombre" class="form-control input-formU" value="<?php echo isset($_POST["Nombre"]) ? $_POST["Nombre"] : ''; ?>" required>
        
            <label class=" fw-semibold" for="">Correo:</label>
            <input type="email" name="Correo" class="form-control input-formU" value="<?php echo isset($_POST["Correo"]) ? $_POST["Correo"] : ''; ?>" required>
        
            <label class=" fw-semibold" for="">Contraseña:</label>
            <input type="password" name="Password" class="form-control input-formU" value="<?php echo isset($_POST["Password"]) ? $_POST["Password"] : ''; ?>" required>    
        
            <label class="fw-semibold" for="">Confirmar contraseña:</label>
            <input type="password" name="confirm_password" class="form-control input-formU" value="<?php echo isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : ''; ?>" required>    
            
            <input type="submit" value="Registrarse" class="form-control btn-color fw-bold">
            <a href="login" class="text-white">¿Ya tienes una cuenta?</a>
        </div>
    </form>
</div>