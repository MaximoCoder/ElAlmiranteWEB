
<div class="container">
    <form class="form-group register-form" id="login-form">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Inicia sesión</h2>

            <label class=" fw-semibold" for="">Correo:</label>
            <input type="email" id="Correo" class="form-control input-formU" value="<?php echo isset($_POST["Correo"]) ? $_POST["Correo"] : ''; ?>" required>
        
            <label class=" fw-semibold" for="">Contraseña:</label>
            <input type="password" id="Password" class="form-control input-formU" value="<?php echo isset($_POST["Password"]) ? $_POST["Password"] : ''; ?>" required>    

            
            <input type="submit"  class="form-control btn-color fw-bold" onclick="handleLoginForm()">
            <div class="d-flex justify-content-between">
                <a href="forgot-Password" class="text-white fs-6">olvide mi contraseña</a>
                <a href="register" class="text-white fs-6">¿aun no tienes una cuenta?</a>
            </div>
        </div>
    </form>
</div>