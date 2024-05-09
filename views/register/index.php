<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <?php require_once "../html/MainHead.php"; ?>
    <style>
        /* Estilo adicional para ajustar el tamaño de la imagen */
        #icon {
            max-width: 150px;
            /* Cambia este valor según tu preferencia */
            height: auto;
        }

        .required::after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <?php require_once "../html/loading.php"; ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="../../public/images/icons/logo.png" id="icon" class="img-fluid" alt="User Icon">
                            <h1 class="mt-2">Regístrate</h1>
                        </div>

                        <form id="registroForm">
                            <div class="form-group">
                                <label class="col-form-label required">Cédula:</label>
                                <input type="number" id="cedula" class="form-control" name="cedula" pattern="[0-9]*" placeholder="Cédula">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label required">Nombres y Apellidos:</label>
                                <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Nombres y apellidos">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label required">Email:</label>
                                <input type="email" id="email" class="form-control" name="email" placeholder="Correo electrónico">
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="col-form-label required">Provincia:</label>
                                    <select class="form-control" id="provincia" name="provincia" required>
                                        <option value="">Seleccione una provincia...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-form-label required">Cantón:</label>
                                    <select class="form-control" id="canton" name="canton" required>
                                        <option value="">Seleccione un cantón...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label required">Dirección:</label>
                                <input name="direccion" id="direccion" class="form-control" type="text" placeholder="Dirección">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label">Referencia:</label>
                                <input name="referencia" id="referencia" class="form-control" type="text" placeholder="Referencia">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label required">Contraseña:</label>
                                <input type="password" id="pass" class="form-control" name="pass" placeholder="Contraseña">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label required">Repita su Contraseña:</label>
                                <input type="password" id="confpass" class="form-control" name="confpass" placeholder="Repita su contraseña">
                            </div>

                            <div class="text-danger mb-3">Los campos marcados con * son de carácter obligatorio</div>

                            <button class="btn btn-primary btn-block" type="button" id="btnEntrar">Registrar</button>

                        </form>

                        <div class="text-center mt-3">
                            <p>¿Ya tienes una cuenta?</p>
                            <a href="../login/">Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "../html/MainJS.php"; ?>
    <script src="../register/content.js"></script>
</body>

</html>