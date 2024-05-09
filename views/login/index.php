<?php
session_start();
if (!isset($_SESSION["user_session"]) || !isset($_SESSION['user_session']['user_id'])) {
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <?php require_once "../html/MainHead.php"; ?>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <?php require_once "../html/loading.php"; ?>

        <div class="wrapper fadeInDown">
            <div id="formContent">
                <!-- Icon -->
                <div class="fadeIn first mt-4">
                    <img src="../../public/images/icons/logo.png" id="icon" alt="User Icon" />
                    <h1>Iniciar Sesión</h1>
                </div>

                <form id="miForm">
                    <div class="p-3">
                        <div class="col-10 text-center input-group mb-3 mt-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Correo electrónico">
                        </div>
                        <div class="col-10 text-center input-group mb-3">
                            <input type="password" id="pass" name="pass" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <button id="btnentrar" class="btn btn-primary col-10 p-3 text-center align-content-center mb-3" type="button">Entrar</button>
                    <a href="../resetpass/">¿Olvidé mi contraseña?</a>
                </form>

                <div>
                    <p>¿Aun no tienes una cuenta?</p>
                    <a class="underlineHover" href="../register/">Regístrate</a>
                </div>

            </div>
        </div>
        <?php require_once "../html/MainJS.php"; ?>
        <script src="../login/content.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: ../main/");
    exit();
}
?>