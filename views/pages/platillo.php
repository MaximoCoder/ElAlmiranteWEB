<!-- PAGINA PARA CADA PLATILLO -->
<div class="container d-flex justify-content-center mb-5">
    <div class="row">
        <div class="col-sm-6 col-md-12">
            <h1 class="mt-4 fw-bold text-center"><?= $platillo['NombrePlatillo']; ?></h1>
        </div>
    </div>
    <div class="row d-flex align-items-center">
        <div class="col-sm-12 col-md-6">
            <div class="image-container">
                <img src="../uploads/<?= $platillo['img']; ?>" class="img-fluid w-100 h-100 object-fit-cover rounded" alt="<?= $platillo['NombrePlatillo']; ?>">
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="h5"><?= $platillo['DescripcionPlatillo']; ?></p>
            <p class="h6 fw-bold">Precio - $<?= $platillo['PrecioPlatillo']; ?></p>

            <!-- AGREGAR AL CARRITO -->
            <button class="btn btn-menu d-block w-100">Agregar al carrito<i class="bi bi-cart-plus fs-4"></i></button>

            <!-- REGRESAR AL MENU -->
            <a href="../pages/menu" class="btn mt-3 btn-outline-primary">Regresar al menu</a>
        </div>
    </div>
</div>
