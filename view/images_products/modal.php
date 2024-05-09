<button type="button" id="btnNuevo" class="btn btn-primary m-1" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Agregar Imágenes</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ingresar Nueva Imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioProveedor">
                    <input type="hidden" id="id" name="id">
                    <div id="divFile" class="form-group">
                        <label for="nombre" class="col-form-label">Imágenes:</label>
                        <input type="file" class="form-control-file" id="imagenes" name="imagenes" accept=".jpg, .jpeg, .png" multiple>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-form-label">Orden:</label>
                        <input type="number" class="form-control" id="orden" name="orden" required></input>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-1" id="btnGuardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Verificar si el evento hidden.bs.modal se está vinculando correctamente
    $('#miModal').on('hidden.bs.modal', function() {
    });

    // Agregar evento para mostrar el div al hacer clic en el botón "Agregar Imágenes"
    $("#btnNuevo").click(function() {
        $("#title").text("Agregar nuevas imágenes"); // Cambiar el título del modal
        $("#divFile").show(); // Mostrar el div "divFile"
    });
});



</script>