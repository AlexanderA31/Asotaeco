<!-- Content Wrapper. Contains page content -->


<?php
session_start();
if (empty($_SESSION['user_session'])) {
    header("Location: ../main");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Productos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require_once "../html/MainHead.php"; ?>
    <link rel="stylesheet" href="../miscompras/styles.css">
</head>

<body>

    <!-- Header -->
    <?php require_once "../html/MainHeader.php" ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mi Perfil</h1>
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
                                    </div>
                                    <div class="col-md-4">
                                        <h2>Mis Datos</h2>
                                        <input type="hidden" class="form-control" id="id_hidden" name="id_hidden" required>
                                        <div class="form-group">
                                            <label class="col-form-label">Cédula:</label>
                                            <input type="text" class="form-control" id="cedula" name="cedula" readonly oninput="limitarCaracteres(this, 10)" pattern="[0-9]*" title="Solo se permiten dígitos" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" readonly required>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-form-label">Nombres y Apellidos:</label>
                                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Teléfono:</label>
                                            <input type="number" class="form-control" id="telefono" pattern="[0-9]*" name="telefono">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Provincia:</label>
                                            <select class="form-control" id="provincias" name="provincias" required>
                                                <option value="">Seleccione una provincia...</option>
                                            </select>
                                            <br>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Canton:</label>
                                            <select class="form-control" id="canton" name="canton" required>
                                                <option value="">Seleccione un cantón...</option>
                                            </select>
                                            <br>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Dirección:</label>
                                            <input type="address" class="form-control" id="direccion" name="direccion" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Referencia:</label>
                                            <input name="referencia" id="referencia" class="form-control" type="text" placeholder="Referencia">
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <button type="button" id="btnActualizar" class="btn btn-success form-control">Actualizar mis datos</button>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <?php require_once 'modal.php' ?>

                                        </div>
                                    </div>
                                </div>
                            </form>

                            <script src="../miperfil/content.js"></script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <?php require_once "../html/footer.php"; ?>


    <?php require_once "../html/MainJS.php"; ?>
    <script type="text/javascript" src="../miscompras/content.js"></script>

</body>

</html>