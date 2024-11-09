<section id="menu" class="bg-light ">
    <div class="container">
        <div class="row">
            <div class="col-12 intro-text">
                <h1>¡Explora todo nuestro menú!</h1>
                <p>Contamos con una alta variedad de platillos para los amantes del mar. Desde nuestras frescas tostadas de ceviche y sabrosos camarones, hasta los deliciosos tacos gobernador. Disfruta de nuestros cocteles refrescantes, reconfortantes caldos y abundantes mariscadas. No te pierdas nuestros filetes de pescado, el crujiente pescado frito y los picantes aguachiles. Y esto es solo el comienzo - ¡ven a descubrir el sabor del mar en cada bocado!</p>
            </div>
        </div>
    </div>

    <div class="p-4">
        <!-- Pestañas de Categorías -->
        <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-category="all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">Todos</button>
            </li>

            <?php foreach ($categories as $category): ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-<?= $category['IdCategoría']; ?>-tab" data-bs-toggle="pill" data-category="<?= $category['IdCategoría']; ?>" type="button" role="tab" aria-controls="pills-<?= $category['IdCategoría']; ?>" aria-selected="false"><?= $category['NombreCategoría']; ?></button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Contenido de las Pestañas -->
        <div class="tab-content" id="pills-tabContent">
            <!-- Todos -->
            <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
                <div class="row gy-4" id="products-all">
                    <!-- Productos se cargarán aquí dinámicamente -->
                </div>
            </div>

            <!-- Por cada categoría una nueva pestaña -->
            <?php foreach ($categories as $category): ?>
                <div class="tab-pane fade" id="pills-<?= $category['IdCategoría']; ?>" role="tabpanel" aria-labelledby="pills-<?= $category['IdCategoría']; ?>-tab" tabindex="0">
                    <div class="row gy-4" id="products-<?= $category['IdCategoría']; ?>">
                        <!-- Productos de esta categoría se cargarán aquí dinámicamente -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>