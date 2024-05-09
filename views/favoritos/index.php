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
	<title>Shoping Cart</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
</head>

<body class="">

	<!-- Header -->
	<?php require_once "../html/MainHeader.php"; ?>

	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container py-5">

			<table id="miTabla" class="table table-bordered table-hover">

			</table>

		</div>
	</form>


	<?php require_once "../html/footer.php"; ?>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>


	<?php require_once "../html/MainJS.php"; ?>
	<script src="../favoritos/content.js"></script>

</body>

</html>