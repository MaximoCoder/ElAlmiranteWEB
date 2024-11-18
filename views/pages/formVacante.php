<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg p-4">
                <h3 class="text-center text-danger mb-4">Formulario de Postulación</h3>

                <!-- Formulario -->
                <form action="https://formspree.io/f/mqaklakp" method="POST" enctype="multipart/form-data">
                    
                    <!-- Nombre Completo -->
                    <div class="mb-3">
                        <label for="nombreCompleto" class="form-label">Nombre Completo:</label>
                        <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" required placeholder="Ingresa tu nombre completo">
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required placeholder="Ingresa tu número telefónico">
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Ingresa tu correo electrónico">
                    </div>

                    <!-- Edad -->
                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="edad" name="edad" required placeholder="Ingresa tu edad">
                    </div>

                    <!-- Puesto Solicitado -->
                    <div class="mb-3">
                        <label for="puesto" class="form-label">Puesto Solicitado:</label>
                        <input type="text" class="form-control" id="puesto" name="puesto" required placeholder="Ingresa el puesto que deseas solicitar">
                    </div>

                    <!-- Subir CV -->
                    <div class="mb-3">
                        <label for="cv" class="form-label"><strong>Link de Google Drive para subir tu CV: (opcional)</strong></label><br>
                        <a href="https://drive.google.com/drive/folders/1EPB4dekteXdF7iIONN3P3mOKe2-Zky2C?usp=drive_link">Liga para subir tu CV</a>
                    </div>

                    <!-- Botón de Enviar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark w-100">Enviar Postulación</button>
                    </div>
                    <p id="statusForm"></p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  var form = document.getElementById("formPostulacion");
  
  async function handleSubmit(event) {
    event.preventDefault();
    var status = document.getElementById("statusForm");
    var data = new FormData(event.target);
    fetch(event.target.action, {
      method: form.method,
      body: data,
      headers: {
          'Accept': 'application/json'
      }
    }).then(response => {
      if (response.ok) {
        status.innerHTML = "¡Gracias por tu postulación! Se pondrán en contacto contigo pronto.";
        form.reset()
      } else {
        response.json().then(data => {
          if (Object.hasOwn(data, 'errors')) {
            status.innerHTML = data["errors"].map(error => error["message"]).join(", ")
          } else {
            status.innerHTML = "¡Oops! Hubo un problema al enviar tu postulación."
          }
        })
      }
    }).catch(error => {
      status.innerHTML = "¡Oops! Hubo un problema al enviar tu postulación."
    });
  }
  form.addEventListener("submit", handleSubmit)
</script>