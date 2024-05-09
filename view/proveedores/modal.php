<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Nuevo</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ingresar Nuevo Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioProveedor">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="ruc" class="col-form-label">RUC:</label>
                        <input type="text" class="form-control" id="ruc" name="ruc" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="col-form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="col-form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
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
        document.getElementById("ruc").value = "";
        document.getElementById("nombre").value = "";
        document.getElementById("email").value = "";
        document.getElementById("telefono").value = "";
        document.getElementById("direccion").value = "";
    });

    $('#miModal').on('shown.bs.modal', function() {
        // Activa el campo id
        $('#id').prop('disabled', false);
        // Limpia el valor del campo id
        $('#id').val('');
        $('#ruc').val('');
        $('#nombre').val('');
        $('#email').val('');
        $('#telefono').val('');
        $('#direccion').val('');
    });
</script>