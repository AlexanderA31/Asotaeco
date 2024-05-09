<!DOCTYPE html>
<html lang="es">

<head>
	<title>Productos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once "../html/MainHead.php"; ?>
	<style>
		.pagination {
			justify-content: center;
		}
	</style>
</head>

<body>

	<!-- Header -->
	<?php require_once "../html/MainHeader.php" ?>



	<!-- Product -->

	<div class="bg0 m-t-23 p-b-140 section-fixed-height">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button id="btnall" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						Todos los Productos
					</button>

					<button id="btnmujer" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Mujer">
						Mujeres
					</button>

					<button id="btnhombre" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Hombre">
						Hombres
					</button>

					<button id="btnninio" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Niño">
						Niños
					</button>
					<button id="btnninia" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".Niña">
						Niñas
					</button>
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<!-- <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
					<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
					<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
					Filtrar
				</div> -->

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Buscar...
					</div>
				</div>

				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input id="searchInput" class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Buscar...">
					</div>
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Ordenar por
							</div>

							<ul>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
										Recientes
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Precio: Más alto
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Precio: Más bajo
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Precio
							</div>

							<ul>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04 filter-link-active">
										Todos
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$0.00 - $50.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$50.00 - $100.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$100.00 - $150.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$150.00 - $200.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										$200.00+
									</a>
								</li>
							</ul>
						</div>

						<div class="filter-col3 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Colores
							</div>

							<ul id="listaColores">

							</ul>
						</div>
					</div>
				</div>
			</div>

			<div id="container" class="row isotope-grid d-flex flex-wrap align-content-start ">

			</div>

			<nav id="pagination" aria-label="Page navigation" class="fixed-bottom text-center" style="z-index: 1050;">
				<ul class="pagination"></ul>
			</nav>



			<!-- Back to top -->
			<div class="btn-back-to-top" id="myBtn">
				<span class="symbol-btn-back-to-top">
					<i class="zmdi zmdi-chevron-up"></i>
				</span>
			</div>
		</div>

	</div>


	<?php require_once "../html/MainJS.php"; ?>
	<script type="text/javascript" src="../shop/content.js"></script>

	<div id="footer">

	</div>
</body>
<!-- Footer -->

</html>