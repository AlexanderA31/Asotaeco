
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioProducto">
                    <input type="hidden" class="form-control" id="id" name="id" required>
                    <div class="form-group">
                        <label class="col-form-label">Producto:</label>
                        <label class="form-control" id="nombre" name="nombre"></label>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Cantidad:</label>
                        <label class="form-control" id="cantidad" name="cantidad"></label>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Talla:</label>
                        <label class="form-control" id="talla" name="talla"></label>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Color:</label>
                        <label class="form-control" id="color" name="color"></label>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Proveedor:</label>
                        <label class="form-control" id="prov_nombre" name="prov_nombre"></label>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Teléfono:</label>
                        <label class="form-control" id="telefono" name="telefono"></label>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Estado:</label>
                        <select class="form-control" id="est" name="est" required>
                            <option value="">Seleccione...</option>
                            <option value="0">Finalizado</option>
                            <option value="1">Pendiente</option>
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