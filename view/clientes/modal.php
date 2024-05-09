<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Nuevo</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ingresar Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioUsuario">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="email" class="col-form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group">
                        <label for="cedula" class="col-form-label">Cédula:</label>
                        <input type="number" class="form-control" id="cedula" name="cedula" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-form-label">Teléfono:</label>
                        <input type="number" class="form-control" id="telefono" name="telefono">
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
      document.getElementById("rol_id").value = "2";
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