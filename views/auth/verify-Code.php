<div class="container">
    <form class="form-group register-form"  id="verify-form">
        <div class="mb-3 bg-form text-white p-5 rounded">
            <h2 class="text-center">Ingresa el codigo que enviamos a tu correo</h2>

            <label class=" fw-semibold" for="">Codigo:</label>
            <input type="number"  min="10000" max="99999" id="Code" class="form-control input-formU" value="<?php echo isset($_POST["Code"]) ? $_POST["Code"] : ''; ?>" required>
        
            <input type="submit" class="form-control btn-color fw-bold" onclick="handleVerifyForm()">
            <div class="d-flex justify-content-between">
                <a href="forgot-Password" class="text-white h6">No recibi un codigo</a>
            </div>
        </div>
    </form>
</div>