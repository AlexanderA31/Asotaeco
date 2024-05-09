<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Publicar Productos </h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="formularioProducto">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control" id="id_hidden" name="id_hidden" required>

                                    <div class="form-group">
                                        <label class="col-form-label">Producto:</label>
                                        <select class="form-control" id="id_producto" name="id_producto" required>
                                            <option value="">Seleccione...</option>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Proveedor:</label>
                                        <select class="form-control" id="id_proveedor" name="id_proveedor" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <!-- Campo oculto para el ID -->
                                    <div class="form-group">
                                        <label class="col-form-label">Costo Unitario Compra:</label>
                                        <input type="number" class="form-control" id="costo" name="costo" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Cantidad:</label>
                                        <input type="number" class="form-control" id="stock" name="stock" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Precio Unitario Público:</label>
                                        <input type="number" class="form-control" id="precio" name="precio" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Color:</label>
                                        <select class="form-control" id="id_color" name="id_color" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Talla:</label>
                                        <select class="form-control" id="id_talla" name="id_talla" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Agregar Producto</label>
                                        <button type="button" id="btnAdd" class="btn btn-info form-control">Guardar</button>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Total:</label>
                                        <div class="form-control">
                                            <span>$</span>
                                            <span id="total">50</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Productos disponibles</label>
                                        <button type="button" id="btnPagar" class="btn btn-primary form-control">Publicar</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Imagen Producto</label>
                                    <div>
                                        <img id="imgProd" src="../../public/images/products/defaultprod.png" alt="Producto por defecto" style="max-width: 200px; max-height: 40vh;">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <table id="miTabla" class="datatable table table-bordered table-hover">
                        </table>
                        <script src="../publicados/content.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>