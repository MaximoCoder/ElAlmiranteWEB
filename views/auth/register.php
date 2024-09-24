
<div class="container">
    <form class="form-group register-form" id="register-form">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Registrarse</h2>
            <label for="" class="mt-4 fw-semibold">Nombre completo:</label>
            <input type="text" id="Nombre" class="form-control input-formU" value="<?php echo isset($_POST["Nombre"]) ? $_POST["Nombre"] : ''; ?>" required>
        
            <label class=" fw-semibold" for="">Correo:</label>
            <input type="email" id="Correo" class="form-control input-formU" value="<?php echo isset($_POST["Correo"]) ? $_POST["Correo"] : ''; ?>" required>
        
            <label class=" fw-semibold" for="">Contraseña:</label>
            <input type="password" id="Password" class="form-control input-formU" value="<?php echo isset($_POST["Password"]) ? $_POST["Password"] : ''; ?>" required>    
        
            <label class="fw-semibold" for="">Confirmar contraseña:</label>
            <input type="password" id="confirm_password" class="form-control input-formU" value="<?php echo isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : ''; ?>" required>    
            
            <input type="submit" class="form-control btn-color fw-bold" onclick="handleRegisterForm()" >
            <a href="login" class="text-white">¿Ya tienes una cuenta?</a>
        </div>
    </form>
</div>