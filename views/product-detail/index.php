<!DOCTYPE html>
<html lang="es">

<head>
	<title>Detalles del Producto</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
	<link rel="stylesheet" href="../main/styles.css">
</head>

<body>

	<?php require_once "../html/MainHeader.php" ?>
	<section class="section-slide mb-5">
		<div class="container">
			<div class="row">

				<div class="col-md-6 col-lg-7 p-b-30">
					<aside id="sliderIMG" class="col-lg-8">
					</aside>
				</div>

				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 id="tv-nombre" class="mtext-105 cl2 js-name-detail p-b-14">
							Espere....
						</h4>
						<div>
							<span class="mtext-106 cl2">$</span>
							<span id="tv-precio" class="mtext-106 cl2">
								00.00
							</span>
						</div>

						<p id="tv-descripcion" class="stext-102 cl3 p-t-23">
							Espere...
						</p>

						<!--  -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Talla
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select id="id_talla" class="form-control" name="id_talla">
										</select>
									</div>
								</div>
							</div>

							<div class="flex-w flex-r-m p-b-10">
								<div class="size-203 flex-c-m respon6">
									Color
								</div>

								<div class="size-204 respon6-next">
									<div class="rs1-select2 bor8 bg0">
										<select class="form-control" id="id_color" name="id_color" required>
										</select>
									</div>
								</div>
							</div>
							<div class="flex-c-m respon6">
								<p id="stock" style="margin-right: 5px;">0</p>
								<p>Unidades Disponibles</p>
							</div>
							<div class="flex-w flex-r-m p-b-10">
								<div class="size-204 flex-w flex-m respon6-next">
									<div class="wrap-num-product flex-w m-r-20 m-tb-10">
										<div id="disminuir" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-minus"></i>
										</div>

										<input id="input_stock" class="mtext-104 cl3 txt-center num-product" type="text" name="num-product" value="1" onkeypress="return soloNumeros(event)">

										<div id="sumar" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
											<i class="fs-16 zmdi zmdi-plus"></i>
										</div>
									</div>

									<button id="js-addcart-detail" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
										Agregar al carrito
									</button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require_once "../html/MainJS.php"; ?>
	<script src="../product-detail/content.js"></script>
</body>
<br><?php require_once('../html/footer.php'); ?>

</html>