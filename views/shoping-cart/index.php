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


	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Carrito de compras
			</span>
		</div>
	</div>


	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table id="miTabla" class="table-shopping-cart">

							</table>
						</div>


					</div>
				</div>




				<!-- 

				 -->
				<form action="">
					<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">

						<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
							<h4 class="mtext-109 cl2 p-b-30">
								Total del Carrito
							</h4>

							<div class="flex-w flex-t bor12 p-b-13">
								<div class="size-208">
									<span class="stext-110 cl2">
										SubTotal:
									</span>
								</div>

								<div class="size-209">
									<span id="subtotal" class="mtext-110 cl2">
									</span>
								</div>
							</div>
							<div class="flex-w flex-t bor12 p-b-13">
								<div class="size-208">
									<span class="stext-110 cl2">
										Costo de envio:
									</span>
								</div>

								<div class="size-209">
									<span id="cenvio" class="mtext-110 cl2">$0.00
									</span>
								</div>
							</div>

							<div class="flex-w flex-t bor12 p-t-15 p-b-30">
								<div class="size-208 w-full-ssm">
									<span class="stext-110 cl2">
										Envió a:
									</span>
								</div>


								<div class="size-209 p-r-18 p-r-0-sm w-full-ssm">


									<p class="stext-111 cl6 p-t-2">
										Seleccione un método de envió para su compra
									</p>



								</div>


							</div>

							<div class="container1">
								<div class="row">
									<div class="col-12">
										<!-- Menú Desplegable -->
										<div class="card">
											<div class="card-header bg-warning text-black" id="menuHeader">
												<span id="toggleIcon">+</span> Información de Compra
											</div>
											<div class="card-body" id="menuBody" style="display: none;">
												<div class="form-group">
													<label class="col-form-label">Opciones de retiro:</label>
													<select class="form-control" id="id_envio" name="id_envio" required>
														<option value="">Seleccione...</option>
														<option value="1">Envió a domicilio</option>
														<option value="2">Retiro en oficina</option>
														<option value="3">Enviar Regalo</option>
													</select>
												</div>
											</div>
										</div>

										<div class="card">
											<div class="card-header bg-success text-white" id="menuHeader">
												<span id="toggleIcon">+</span> Información de Envió
											</div>
											<div class="card-body" id="menuBody" style="display: none;">
												<div class="form-group">
													<label class="col-form-label">Información de envió</label>
													<div class="bor8 bg0 m-b-22">
														<input name="nombre" id="nombre" class="form-control" type="text" placeholder="Nombres y Apellidos">
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
														<input name="direccion" id="direccion" class="form-control" type="text" placeholder="Dirección">
													</div>
													<div class="form-group">
														<label class="col-form-label">Referencia:</label>
														<input name="referencia" id="referencia" class="form-control" type="text" placeholder="Referencia">
													</div>
													<div class="form-group">
														<label class="col-form-label">Cédula:</label>
														<input name="ci" id="ci" class="form-control" type="text" placeholder="Documento de identidad">
													</div>
													<div class="form-group">
														<label class="col-form-label">Email:</label>
														<input name="email" id="email" class="form-control" type="text" placeholder="email">
													</div>
													<div class="form-group">
														<label class="col-form-label">Teléfono:</label>
														<input name="telefono" id="telefono" class="form-control" type="text" placeholder="Teléfono / Celular">
													</div>
												</div>

											</div>
										</div>

										<!-- Menú Desplegable -->
										<div class="card" id="infopago">
											<div class="card-header bg-primary text-white" id="menuHeader">
												<span id="toggleIcon">+</span> Información de Pago
											</div>
											<div class="card-body" id="menuBody" style="display: none;">
												<div id=mPago>
													<div class="form-group">
														<label class="col-form-label">Titular de cuenta: Asociación de producción textil ASOTAECO</label>
														<label class="col-form-label">Numero de cuenta interbancaria: 1703100010128998</label>
														<label class="col-form-label">Tipo de cuenta: Ahorros</label>
														<label class="col-form-label">Institución Bancaria: CACPE PASTAZA</label>
													</div>
													<div class="form-group">
														<label for="comprobante" class="col-form-label">Seleccione su método de pago</label>
														<select class="form-control" id="metododepago" name="metododepago" required onchange="toggleFields()">
															<option value="">Seleccione...</option>
															<option value="1">Deposito</option>
															<option value="2">Transferencia</option>
														</select>
														<br>
													</div>
													<div id="camposPago" class="form-group">
														<div class="bor8 bg0 m-b-22">
															<label for="comprobantef" class="col-form-label">Comprobante de pago:</label>
															<input type="file" class="form-control-file" id="comprobantef" name="comprobantef" accept=".jpg, .jpeg, .png,.pdf" multiple>
														</div>
														<label for="comprobante" class="col-form-label">Número de comprobante:</label>
														<div class="bor8 bg0 m-b-22">
															<input name="comprobante" id="comprobante" class="form-control" type="text" placeholder="Número de comprobante">
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="flex-w flex-t p-t-27 p-b-33">
								<div class="size-208">
									<span class="mtext-101 cl2">
										Total a pagar:
									</span>
								</div>

								<div class="size-209 p-t-1">
									<span id="totalspan" class="mtext-110 cl2">
									</span>
								</div>
							</div>

							<button id="btnpagar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
								Proceder al pago
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</form>


	<?php require_once "../html/footer.php"; ?>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>




</body>
<?php require_once "../html/MainJS.php"; ?>
<script src="../shoping-cart/content.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>



</html>