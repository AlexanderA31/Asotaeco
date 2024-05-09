<!DOCTYPE html>
<html lang="es">

<head>
    <title>Guía de Tallas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require_once "../html/MainHead.php"; ?>
</head>

<body>
    <?php require_once "../html/MainHeader.php" ?>
    <br>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <section>
                            <h2 class="text-center display-4">Guía de Tallas</h2>
                            <p class="text-center lead">A continuación, te presentamos una guía de tallas para ayudarte a encontrar la talla perfecta.</p>
                        </section>
                        <hr>
                        <section>
                            <h2 class="text-center">Tallas para Hombres</h2>
                            <p class="text-center">Aquí tienes una guía de tallas para hombres:</p>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <img src="../../public/images/tallas/tallacamisahombres.jpg" class="img-fluid" alt="Talla Camisa Hombres">
                                </div>
                                <div class="col-md-6">
                                    <img src="../../public/images/tallas/tallapantalonhombres.jpg" class="img-fluid" alt="Talla Pantalón Hombres">
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
<script>
    timeS = 1000;
     setLoading(false);
</script>
    <?php require_once "../html/footer.php"; ?>
    <script type="text/javascript" src="content.js"></script>
    <?php require_once "../html/MainJS.php"; ?>

</body>

</html>
