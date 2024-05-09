<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Control de existencias</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label">Producto:</label>
                            <select class="form-control" id="id_producto" name="id_producto" required>
                                <option value="">Seleccione...</option>
                            </select>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="btnDPDF"><i class="fa fa-download" aria-hidden="true"></i> Descargar</button>
                            </div>
                        </div>
                        <table id="miTabla" class="table table-bordered table-hover">

                        </table>
                        <script src="../controlstock/content.js"></script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>