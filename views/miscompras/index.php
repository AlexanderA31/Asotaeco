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


	<section>
		<ul class="nav justify-content-center">
			<li class="nav-item">
				<button type="button" id="btncompras" class="nav-link active">Mi Compras</button>
			</li>
			<li class="nav-item">
				<button type="button" id="btnpagado" class="nav-link active">Pagadas</button>
			</li>
			<li class="nav-item">
				<button type="button" id="btnpendiente" class="nav-link">Pendientes</button>
			</li>
			<li class="nav-item">
				<button type="button" id="btnentregado" class="nav-link">Enviadas</button>
			</li>
		</ul>

	</section>


	<section>
		<div class="container py-5">
			
			<table id="miTabla" class="table table-bordered table-hover">

			</table>
			
		</div>

	</section>


	<?php require_once "../html/footer.php"; ?>


	<?php require_once "../html/MainJS.php"; ?>
	<script type="text/javascript" src="../miscompras/content.js"></script>

</body>

</html>