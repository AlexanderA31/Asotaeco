<button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Nuevo</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ingresar Nueva Talla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioProveedor">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Descripción:</label>
                        <input type="text" class="form-control" id="desc_talla" name="desc_talla" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Estado:</label>
                        <select class="form-control" id="est" name="est" required>
                            <option value="">Seleccione...</option>
                            <option value="0">Desactivado</option>
                            <option value="1">Activado</option>
                        </select>
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
        document.getElementById("nombre").value = "";
        document.getElementById("est").value = "";
        document.getElementById("desc_talla").value = "";
    });

    $('#miModal').on('shown.bs.modal', function() {
        $('#id').prop('disabled', false);
        $('#id').val('');
        $('#nombre').val('');
        $('#est').val('');
        $('#desc_talla').val('');
    });
</script>