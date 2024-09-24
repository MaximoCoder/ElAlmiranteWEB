<div class="container">
    <form class="form-group register-form"  id="forgot-form">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Restaurar contraseña</h2>
            <label class=" fw-semibold" for="">Correo:</label>
            <input type="email" id="Correo" class="form-control input-formU" value="<?php echo isset($_POST["Correo"]) ? $_POST["Correo"] : ''; ?>" required>
        
            <input type="submit"  class="form-control btn-color fw-bold" onclick="handleForgotForm()">
            <div class="d-flex justify-content-between">
                <a href="login" class="text-white h6">Regresar</a>
            </div>
        </div>
    </form>
</div>