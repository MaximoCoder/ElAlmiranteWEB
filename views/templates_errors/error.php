<div class="bg-light text-center d-flex flex-column  vh-100">
    <div class="container">
        <h1 class="display-3 fw-bold"><?php echo $errorCode; ?></h1>
        <h1 class="display-4 pb-3 fw-semibold"><?php echo $errorTitle; ?></h1>
        <img src="../images/errorFish.png" alt="Error Fish" class="img-fluid my-3 FishError">
        <a href="<?php echo $url; ?>" class="btn btn-primary mt-3 py-3 px-4">Regresar al inicio</a>
    </div>
</div>