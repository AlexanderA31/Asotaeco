<?php
session_start();
if (isset($_SESSION['user_session'])) {
  $userData = $_SESSION['user_session'];
  $modulo = $_REQUEST['modulo'] ?? '';
?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asotaeco | Dashboard</title>
    <?php require_once('../html/header.php'); ?>
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <?php require_once '../html/loading.php'; ?>
    <div class="wrapper">

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->

          <a class="nav-link" href="index.php?modulo=editarUsuario&id=<?php echo $userData['user_id']; ?>">
            <i class="far fa-user"></i>
            <?php echo $userData['nombre']; ?>
          </a>
          <a class="nav-link text-danger" href="../../config/Logout.php" title="Cerrar Sesión">
            <i class="fas fa-door-closed    "></i>
          </a>

        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
          <img src="../../public/dist/img/aso.png" alt="Asotaeco" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Asotaeco</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user index (optional) -->
          <div class="user-index mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <a href="#" class="d-block"><?php echo $userData['nombre']; ?></a>
            </div>
          </div>

          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Ecommerce -->
              <li class="nav-item <?php echo ($modulo === "estadisticas") ? "active menu-open " : ""; ?> ">
              <li class="nav-item">
                <a href="index.php?modulo=estadisticas" class="nav-link <?php echo ($modulo == "estadisticas" || $modulo == "") ? " active " : " "; ?>">
                  <i class="far fa-chart-bar nav-icon"></i>
                  <p>Home</p>
                </a>
              </li>
              </li>


              <li class="nav-item <?php echo ($modulo === "usuarios" || $modulo === "clientes") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "usuarios" || $modulo === "clientes") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-users nav-icon"></i>
                  <p>
                    Usuarios
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">
                  <li class="nav-item">
                    <a href="index.php?modulo=usuarios" class="nav-link <?php echo ($modulo == "usuarios") ? " active " : " "; ?> ">
                      <i class="far fa-user nav-icon"></i>
                      <p>Usuarios</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=clientes" class="nav-link <?php echo ($modulo == "clientes") ? " active " : " "; ?> ">
                      <i class="far fa-user nav-icon"></i>
                      <p>Clientes</p>
                    </a>
                  </li>

                </ul>
              </li>

              <li class="nav-item <?php echo ($modulo === "genero" || $modulo === "ocasion" || $modulo === "tallas" || $modulo === "colores" || $modulo === "tprendas") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "genero" || $modulo === "ocasion" || $modulo === "tallas" || $modulo === "colores" || $modulo === "tprendas") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-archive nav-icon"></i>
                  <p>
                    Categorías
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">
                  <li class="nav-item">
                    <a href="index.php?modulo=genero" class="nav-link <?php echo ($modulo == "genero") ? " active " : " "; ?>  ">
                      <i class="far fa-user nav-icon"></i>
                      <p>Genero</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=ocasion" class="nav-link <?php echo ($modulo == "ocasion") ? " active " : " "; ?>  ">
                      <i class="fa fa-bell-o nav-icon" aria-hidden="true"></i>
                      <p>Ocasión</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="index.php?modulo=tallas" class="nav-link <?php echo ($modulo == "tallas") ? " active " : " "; ?> ">
                      <i class="fa fa-truck nav-icon"></i>
                      <p>Tallas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=colores" class="nav-link <?php echo ($modulo == "colores") ? " active " : " "; ?> ">
                      <i class="fa fa-truck nav-icon"></i>
                      <p>Colores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=tprendas" class="nav-link <?php echo ($modulo == "tprendas") ? " active " : " "; ?> ">
                      <i class="fa fa-truck nav-icon"></i>
                      <p>Tipos de Prendas</p>
                    </a>
                  </li>
                </ul>
              </li>



              <li class="nav-item <?php echo ($modulo === "alertaspedido" || $modulo === "alertas" || $modulo === "controlstock" || $modulo === "proveedores") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "alertaspedido" || $modulo === "alertas" || $modulo === "controlstock"  || $modulo === "proveedores") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-archive nav-icon"></i>
                  <p>
                    Inventario
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">
                  <li class="nav-item">
                    <a href="index.php?modulo=controlstock" class="nav-link <?php echo ($modulo == "controlstock") ? " active " : " "; ?>  ">
                      <i class="fa fa-shopping-bag nav-icon" aria-hidden="true"></i>
                      <p>Stock Productos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=alertas" class="nav-link <?php echo ($modulo == "alertas") ? " active " : " "; ?>  ">
                      <i class="fa fa-bell-o nav-icon" aria-hidden="true"></i>
                      <p>Alertas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=alertaspedido" class="nav-link <?php echo ($modulo == "alertaspedido") ? " active " : " "; ?>  ">
                      <i class="fa fa-bell-o nav-icon" aria-hidden="true"></i>
                      <p>Alertas de Pedidos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=proveedores" class="nav-link <?php echo ($modulo == "proveedores") ? " active " : " "; ?> ">
                      <i class="fa fa-truck nav-icon"></i>
                      <p>Proveedores</p>
                    </a>
                  </li>
                </ul>
              </li>



              <li class="nav-item <?php echo ($modulo === "productos" || $modulo === "images_products") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "productos" || $modulo === "images_products") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-archive nav-icon"></i>
                  <p>
                    Productos
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">
                  <li class="nav-item">
                    <a href="index.php?modulo=productos" class="nav-link <?php echo ($modulo == "productos") ? " active " : " "; ?>  ">
                      <i class="fa fa-shopping-bag nav-icon" aria-hidden="true"></i>
                      <p>Gestión de Productos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=images_products" class="nav-link <?php echo ($modulo == "images_products") ? " active " : " "; ?> ">
                      <i class="fa fa-truck nav-icon"></i>
                      <p>Imágenes Productos</p>
                    </a>
                  </li>
                </ul>
              </li>


              <li class="nav-item <?php echo ($modulo === "publicados" || $modulo === "rpublicados") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "publicados" || $modulo === "rpublicados") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-book nav-icon"></i>
                  <p>
                    publicados
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">

                  <li class="nav-item">
                    <a href="index.php?modulo=publicados" class="nav-link <?php echo ($modulo == "publicados") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>publicar</p>
                    </a>
                  </li>
                  <!-- <li class="nav-item">
                    <a href="index.php?modulo=rpublicados" class="nav-link <?php echo ($modulo == "rpublicados") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>Reporte publicados</p>
                    </a>
                  </li> -->
                </ul>
              </li>


              <li class="nav-item <?php echo ($modulo === "ventas" || $modulo === "rventas") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "ventas" || $modulo === "rventas") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-book nav-icon"></i>
                  <p>
                    Ventas
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">
                  <li class="nav-item">
                    <a href="index.php?modulo=ventas" class="nav-link <?php echo ($modulo == "ventas") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>Ventas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="index.php?modulo=rventas" class="nav-link <?php echo ($modulo == "rventas") ? " active " : " "; ?> ">
                      <i class="fa fa-table nav-icon"></i>
                      <p>Reporte Ventas</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item <?php echo ($modulo === "publicidad") ? "active menu-open " : ""; ?> ">
                <a href="#" class="nav-link <?php echo ($modulo === "publicidad") ? "active menu-open " : ""; ?> ">
                  <i class="fas fa-cogs nav-icon"></i>
                  <p>
                    Sitio Web
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-3">
                  <li class="nav-item">
                    <a href="index.php?modulo=publicidad" class="nav-link <?php echo ($modulo == "publicidad") ? " active " : " "; ?> ">
                      <i class="fa fa-bullhorn nav-icon"></i>
                      <p>Publicidad</p>
                    </a>
                  </li>

                </ul>
              </li>

            </ul>
          </nav>



          <!-- /.sidebar-menu -->
        </div>

        <!-- /.sidebar -->
      </aside>
      <?php
      if (isset($_REQUEST['mensaje'])) {
      ?>
        <div class="alert alert-primary alert-dismissible fade show float-right" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
          </button>
          <?php echo $_REQUEST['mensaje'] ?>
        </div>
      <?php
      }
      if ($modulo == "estadisticas" || $modulo == "") {
        include_once "../estadisticas/index.php";
       ?> <script> setLoading(true);</script><?php
      }

      if ($modulo == "genero") {
        include_once "../genero/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "viewventa") {
        include_once "../view_venta/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "ocasion") {
        include_once "../ocasion/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "tallas") {
        include_once "../tallas/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "colores") {
        include_once "../colores/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "tprendas") {
        include_once "../tprendas/index.php";
        ?> <script> setLoading(true);</script><?php
      }

      if ($modulo == "usuarios") {
        include_once "../usuarios/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "clientes") {
        include_once "../clientes/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "controlstock") {
        include_once "../controlstock/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "productos") {
        include_once "../productos/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "images_products") {
        include_once "../images_products/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "alertas") {
        include_once "../alertas/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "alertaspedido") {
        include_once "../alertaspedido/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "reportes") {
        include_once "../reportes/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "ventas") {
        include_once "../ventas/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "rventas") {
        include_once "../rventas/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "publicados") {
        include_once "../publicados/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "rpublicados") {
        include_once "../rpublicados/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "productos") {
        include_once "../productos/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "publicidad") {
        include_once "../publicidad/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "proveedores") {
        include_once "../proveedores/index.php";
        ?> <script> setLoading(true);</script><?php
      }
      if ($modulo == "mercancias") {
        include_once "../mercancias/index.php";
        ?> <script> setLoading(true);</script><?php
      }

      ?>



    </div>
    <?php require_once('../html/MainJS.php') ?>

  </body>

  </html>
<?php
} else {
  header("Location: ../../index.php");
  exit();
}
?>