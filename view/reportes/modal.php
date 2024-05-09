<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Nuevo</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Editar Publicidad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioPublicidad">
                    <input type="hidden" class="form-control" id="id" name="id" required>
                    <input type="hidden" id="publicidad_id" name="publicidad_id">
                    <div class="form-group">
                        <label for="titulo" class="col-form-label">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="imagen" class="col-form-label">Imagen:</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" required>
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
    $('#miModal').on('hidden.bs.modal', function() {
        document.getElementById("id").value = "";
        document.getElementById("titulo").value = "";
        document.getElementById("descripcion").value = "";
        document.getElementById("imagen").value = "";
    });
    $('#exampleModal').on('shown.bs.modal', function() {
        // Activa el campo id
        $('#id').prop('disabled', false);
        // Limpia el valor del campo id
        $('#publicidad_id').val('');
        $('#titulo').val('');
        // Restablece el valor del campo descripción
        $('#descripcion').val('');
        // Restablece el valor del campo imagen
        $('#imagen').val('');
    });
</script>