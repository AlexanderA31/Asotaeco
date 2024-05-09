<!DOCTYPE html>
<html lang="es">

<head>
    <title>Local de Ropa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require_once "../html/MainHead.php"; ?>
</head>

<body>
    <?php require_once "../html/MainHeader.php" ?>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <section>
                            <h2 class="text-center">Asotaeco</h2> <!-- Modificado el tamaño del encabezado -->
                            <p class="text-center lead" style="font-size: 1.5rem;">Dirección del local:</p> <!-- Modificado el tamaño del texto -->
                            <p class="text-center" style="font-size: 1.25rem;"> <!-- Modificado el tamaño del texto -->
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span style="display: block; font-size: 1.5rem;">Barrio “Las Palmas”, calle Ayahuasca</span> <!-- Ajuste de tamaño de fuente y cambio a bloque -->
                            </p>
                        </section>
                        <hr>
                        <section>
                            <div class="row justify-content-center">
                                <div class="col-md-8"> <!-- Ajusta el tamaño del contenedor según sea necesario -->
                                    <div class="map_main text-center"> <!-- Agrega la clase text-center para centrar el contenido -->
                                        <div class="map-responsive">
                                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.2313560558673!2d-77.81956842526523!3d-0.9828160353692498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d6a5fdca06774d%3A0x5dbc3647ff4e1453!2sAsociaci%C3%B3n%20%22Asotaeco%22!5e0!3m2!1ses!2sec!4v1706770322235!5m2!1ses!2sec" width="500" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                        </div>
                                    </div>
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

    <?php require_once "../html/footer.php"; ?>
    <script type="text/javascript" src="content.js"></script>
    <?php require_once "../html/MainJS.php"; ?>

</body>

</html>
