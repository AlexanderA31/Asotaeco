<?php
session_start();

if ($_SESSION['user_session']['rol_id'] == "1") {
	header("Location: ../../view/");
	exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Asotaeco</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
	<link rel="stylesheet" href="../main/styles.css">
</head>

<body>

	<!-- Header -->
	<?php require_once "../html/MainHeader.php"; ?>


	<section class="section-slide mb-5">

		<div id="sliderContainer" class="carousel slide h-100" data-ride="carousel">
			<ol id="sliderIndicators" class="carousel-indicators">
			</ol>

			<!-- Slides -->
			<div class="carousel-inner h-100">
			</div>

			<!-- Controles -->
			<a class="carousel-control-prev" href="#sliderContainer" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#sliderContainer" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>


	</section>
	</section>

	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Categorías
				</h3>
			</div>
		</div>


		<!-- Banner -->
		<div class="sec-banner bg0 p-t-80 p-b-50 position-relative z-index-100">

			<div class="container">
				<div class="row">


					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="../../public/images/banner-01.jpg" alt="IMG-BANNER">

							<a href="../shop/index.php?filter=Mujer" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Mujer
									</span>

									<span class="block1-info stext-102 trans-04">
										Temporada <?php echo date("Y"); ?>
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Comprar ahora
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="../../public/images/banner-02.jpg" alt="IMG-BANNER">

							<a href="../shop/index.php?filter=Hombre" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Hombre
									</span>

									<span class="block1-info stext-102 trans-04">
										Temporada <?php echo date("Y"); ?>
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Comprar ahora
									</div>
								</div>
							</a>
						</div>
					</div>

					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="../../public/images/banner-03.jpg" alt="IMG-BANNER">

							<a href="../shop/index.php?filter=Niños" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Niños
									</span>

									<span class="block1-info stext-102 trans-04">
										Ropa de temporada
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Comprar Ahora
									</div>
								</div>
							</a>
						</div>
					</div>


					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="../../public/images/banner-04.jpg" alt="IMG-BANNER">

							<a href="../shop/index.php?filter=Uniforme%20Escolar" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Estudiante
									</span>

									<span class="block1-info stext-102 trans-04">
										Temporada <?php echo date("Y"); ?>
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Comprar ahora
									</div>
								</div>
							</a>
						</div>
					</div>



					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							<img src="../../public/images/banner-05.jpg" alt="IMG-BANNER">

							<a href="../shop/index.php?filter=Deportivo" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										Deportivo
									</span>

									<span class="block1-info stext-102 trans-04">
										Temporada <?php echo date("Y"); ?>
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Comprar ahora
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="section-slide">
		<div class="wrap-slick1 rs2-slick1">
			<div class="slick1">
				<div class="item-slick1 bg-overlay1" style="background-color: #f0fff0; background-image: url(../../public/images/slide-04.jpg);" data-thumb="../../public/images/thumb-01.jpg" data-caption="Mujer">
					<div class="container h-full">
						<div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-202 txt-center cl0 respon2">
									Nueva ropa para mujer
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
									Frescura a cada paso
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="../shop/index.php?filter=Mujer" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
									Entrar
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1 bg-overlay1" style="background-color: #f0fff0; background-image: url(../../public/images/slide-06.jpg);" data-thumb="../../public/images/thumb-02.jpg" data-caption="Niño">
					<div class="container h-full">
						<div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-202 txt-center cl0 respon2">
									Nueva ropa de niño
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
									Por que nos preocupamos por ellos
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="../shop/index.php?filter=Niños" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
									Entrar
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1 bg-overlay1" style="background-color: #f0fff0; background-image: url(../../public/images/slide-07.jpg);" data-thumb="../../public/images/thumb-03.jpg" data-caption="Hombre">
					<div class="container h-full">
						<div class="flex-col-c-m h-full p-t-100 p-b-60 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-202 txt-center cl0 respon2">
									Ropa de hombre
								</span>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
									Todo lo nuevo por Asotaeco
								</h2>
							</div>

							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="../shop/index.php?filter=Hombre" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
									Entrar
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="wrap-slick1-dots p-lr-10"></div>
		</div>
	</section>

	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Productos
				</h3>
			</div>
		</div>
		<div id="containerR" class="container">
			<div id="productGrid" class="row"></div>
		</div>
	</section>

	<?php require_once "../html/MainJS.php"; ?>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../main/content.js"></script>;
</body>
<br><?php require_once('../html/footer.php'); ?>

</html>