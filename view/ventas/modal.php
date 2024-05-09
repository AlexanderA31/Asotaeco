<div class="modal fade" id="miModalV" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titlev">Nueva Venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioVenta">
                    <input type="hidden" class="form-control" id="idv" name="idv" required>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Cliente</label>
                        <input type="hidden" class="form-control" id="id_clientev" name="id_clientev" required>
                        <label class="form-control" id="clientev" name="clientev"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Recibe:</label>
                        <label class="form-control" id="recibev" name="recibev"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Teléfono:</label>
                        <label class="form-control" id="telefonov" name="telefonov"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Dirección:</label>
                        <label class="form-control" id="direccionv" name="direccionv"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label">Fecha</label>
                        <label type="text" class="form-control" id="fechav" name="fechav"></label>
                    </div>
                    <div class="form-group">
                        <label for="idPago" class="col-form-label"># Guía Servientrega:</label>
                        <input type="text" class="form-control" id="guia_servv" name="guia_servv">
                    </div>
                    <div class="form-group">
                        <label for="metodo_pago" class="col-form-label">Estado de Venta:</label>
                        <select class="form-control" id="estv" name="estv" required>
                            <option value="2">Enviada</option>
                            <option value="1">Pagada</option>
                            <option value="0">Pendiente</option>
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
    $('#miModalV').on('hidden.bs.modal', function() {
        document.getElementById("idv").value = "";
        document.getElementById("id_clientev").value = "";
        document.getElementById("clientev").textContent = "";
        document.getElementById("recibev").textContent = "";
        document.getElementById("direccionv").textContent = "";
        document.getElementById("telefonov").textContent = "";
        document.getElementById("guia_servv").value = "";
        document.getElementById("estv").value = "";
        document.getElementById("fechav").textContent = "";
    });
    $('#exampleModal').on('shown.bs.modal', function() {
        $('#idv').prop('disabled', false);
        $('#id_clientev').val('');
        $('#estv').val('');
        $('#guia_servv').val('');
        $('#clientev').text('');
        $('#recibev').text('');
        $('#direccionv').text('');
        $('#telefonov').text('');
        $('#fechav').val('');
    });
</script>