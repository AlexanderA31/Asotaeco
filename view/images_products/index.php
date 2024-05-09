<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Gestión de Imágenes</h1>
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
              <?php require_once '../images_products/modal.php'; ?>
             
            </div>
            <table id="miTabla" class="table table-bordered table-hover">

            </table>
            <script src="../images_products/content.js"></script>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>