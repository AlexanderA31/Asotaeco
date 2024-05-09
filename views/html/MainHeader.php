<?php
session_start();

// Rutas
$inicio = "../";
$shop = "../shop";
$direccion = "../infoempresa/direccion.php";
$info_empresa = "../infoempresa/informacion.php";
$tallas_hombres = "../tallasg/hombres.php";
$tallas_mujeres = "../tallasg/mujer.php";
$tallas_niños = "../tallasg/niños.php";
$login = "../login";
$mis_compras = "../miscompras/";
$favoritos = "../favoritos";
$mi_perfil = "../miperfil";
$cerrar_sesion = "../../config/Logout.php";

if ($_SESSION['user_session']['rol_id'] == "1") {
    header("Location: ../../view/");
    exit();
}
?>
<header class="header-v4">
    <style>
        #subMenuCat {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Obtén grandes descuentos en todos nuestros productos
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="<?php echo $direccion; ?>" class="flex-c-m trans-04 p-lr-25">
                        Dirección
                    </a>

                    <a href="<?php echo $info_empresa; ?>" class="flex-c-m trans-04 p-lr-25">
                        Informacion
                    </a>
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <li>
                    <h4 class="navbar-brand">Asotaeco</h4>
                </li>
                <!-- Logo desktop -->
                <a href="<?php echo $inicio; ?>" class="logo">
                    <img src="../../public/images/icons/logo.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li>
                            <a href="<?php echo $inicio; ?>" class="menu-link">Inicio</a>
                        </li>
                        <li>
                            <a href="<?php echo $shop; ?>" class="menu-link">Comprar</a>
                        </li>

                        <!-- <li class="menu-item-with-submenu">
                            <a href="" class="menu-link">Categorias</a>
                            <ul id="subMenuCat" class="sub-menu">
                            </ul>
                        </li> -->
                        <script src="../html/content.js"></script>
                        <li class="menu-item-with-submenu">
                            <a href="" class="menu-link">Tallas</a>
                            <ul class="sub-menu">
                                <li><a href="<?php echo $tallas_hombres; ?>">Hombre</a></li>
                                <li><a href="<?php echo $tallas_mujeres; ?>">Mujer</a></li>
                                <li><a href="<?php echo $tallas_niños; ?>">Niños</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php echo $info_empresa; ?>" class="menu-link">Quienes somos</a>
                        </li>

                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div id="notify_cart" class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="0">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a id="notify_wish" href="<?php echo $favoritos; ?>" class=" icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-wish" data-notify="+">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>
                    <?php
                    if (!isset($_SESSION["user_session"]) || !isset($_SESSION['user_session']['user_id'])) {
                    ?>
                        <a href="<?php echo $login; ?>" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <i class="zmdi zmdi-account-circle"></i>
                        </a>
                    <?php } else { ?>
                        <div class="menu-desktop">
                            <ul class="main-menu">
                                <li class="menu-item-with-submenu">
                                    <a href="" class="menu-link  menu-item"> <i class="zmdi zmdi-account-circle mr-2"></i>
                                        <?php echo $_SESSION['user_session']['nombre']; ?></a>
                                    <ul class="sub-menu">

                                        <li> <a href="<?php echo $mis_compras; ?>" class="list-group-item list-group-item-action menu-item">
                                                <i class="fa fa-shopping-basket mr-2"></i> Mis Compras
                                            </a>
                                        </li>
                                        <li><a href="<?php echo $favoritos; ?>" class="list-group-item list-group-item-action menu-item">
                                                <i class="fa fa-heart-o mr-2"></i> Favoritos
                                            </a>
                                        </li>
                                        <li> <a href="<?php echo $mi_perfil; ?>" class="list-group-item list-group-item-action menu-item">
                                                <i class="fa fa-user mr-2"></i> Mi Perfil
                                            </a>
                                        </li>
                                        <li> <a href="<?php echo $cerrar_sesion; ?>" class="list-group-item list-group-item-action menu-item">
                                                <i class="fa fa-sign-out mr-2"></i> Cerrar Sesión
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="<?php echo $inicio; ?>"><img src="../../public/images/icons/logo.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">


            <div id="notify_cart" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="0">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a id="notify_wish" href="<?php echo $favoritos; ?>" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-wish" data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>


        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">


        <ul class="main-menu-m">
            <?php
            if (!isset($_SESSION["user_session"]) || !isset($_SESSION['user_session']['user_id'])) {
            ?>
                <li>
                    <a href="<?php echo $login; ?>" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                        <i class="zmdi zmdi-account-circle"></i> Iniciar Sesión
                    </a>
                </li>
            <?php } else { ?>
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="menu-item-with-submenu">
                            <button class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                <i class="zmdi zmdi-account-circle"></i> <?php echo $_SESSION['user_session']['nombre']; ?>
                            </button>
                            <ul class="sub-menu">

                                <li> <a href="<?php echo $mis_compras; ?>" class="list-group-item list-group-item-action menu-item">
                                        <i class="fa fa-shopping-basket mr-2"></i> Mis Compras
                                    </a>
                                </li>
                                <li><a href="<?php echo $favoritos; ?>" class="list-group-item list-group-item-action menu-item">
                                        <i class="fa fa-heart-o mr-2"></i> Favoritos
                                    </a>
                                </li>
                                <li> <a href="<?php echo $mi_perfil; ?>" class="list-group-item list-group-item-action menu-item">
                                        <i class="fa fa-user mr-2"></i> Mi Perfil
                                    </a>
                                </li>
                                <li> <a href="<?php echo $cerrar_sesion; ?>" class="list-group-item list-group-item-action menu-item">
                                        <i class="fa fa-sign-out mr-2"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            <?php } ?>
            <li>
                <a href="<?php echo $inicio; ?>">Inicio</a>
            </li>
            <li>
                <a href="<?php echo $shop; ?>">Comprar</a>
            </li>

            <span class="arrow-main-menu-m">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </span>
            </li>
            <li>
                <a href="<?php echo $info_empresa; ?>">Quienes somos</a>
            </li>
            <li>
                <a href="../contact">Contáctenos</a>
            </li>
        </ul>
    </div>


</header>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        try {
            document.querySelectorAll('.nav-link').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    var url = this.getAttribute('data-url');
                    fetch(url)
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('main-container').innerHTML = data;
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        } catch (e) {

        }
        id_user = 2;
        obtenerUsuario();

        function obtenerUsuario() {
            const userData = localStorage.getItem('user_data');

            if (userData) {
                let user = JSON.parse(localStorage.getItem('user_data')) || [];
                id_user = user.user_id;
                listadedeseos();
            } else {
                //id_user = 0;
            }
        }
        carritodecompras();



        function carritodecompras() {
            const cartData = localStorage.getItem('cart');

            if (cartData) {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                let numberOfProducts = cart.length;
                document.querySelector('.js-show-cart').setAttribute('data-notify', numberOfProducts);
            } else {
                document.querySelector('.js-show-cart').setAttribute('data-notify', '0');
            }
        }



        async function listadedeseos() {
            try {
                const response = await fetch(
                    "../../controllers/router.php?op=getWishList&id_user=" + id_user
                );
                const wishData = await response.json();

                if (wishData) {
                    let numberOfProducts = wishData.length;
                    document.querySelector('.js-show-wish').setAttribute('data-notify', numberOfProducts);
                } else {
                    document.querySelector('.js-show-wish').setAttribute('data-notify', '0');
                }
            } catch (error) {
                console.error("Error al obtener la lista de deseos:", error);
                document.querySelector('.js-show-wish').setAttribute('data-notify', '0');
            }
        }
    });
</script>
<div id="cart_contain">
    <?php require_once "cart.php"; ?>
</div>
<?php require_once '../html/loading.php'; ?>