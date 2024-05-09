<button type="button" class="btn btn-warning form-control" data-toggle="modal" data-target="#miModal" data-whatever="@mdo">Cambiar Contraseña</button>

<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Cambiar Contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioContraseña">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group">
                        <label for="contraseñaActual" class="col-form-label">Nueva Contraseña:</label>
                        <input type="password" class="form-control" id="pass" name="pass" required>
                    </div>

                    <div class="form-group">
                        <label for="nuevaContraseña" class="col-form-label">Confirme Contraseña:</label>
                        <input type="password" class="form-control" id="confPass" name="confPass" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary m-1" id="btnCambiarContraseña">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
      $('#id').val('');
    $('#miModal').on('hidden.bs.modal', function() {
        $('#pass').val('');
        $('#confPass').val('');
    });
</script>
