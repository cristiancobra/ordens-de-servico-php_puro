<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/340c24fbce.js" crossorigin="anonymous"></script>

        <title>
			ORDENS DE SERVIÇO
		</title>

    </head>

    <body>
		<div id='nav-container' class="container">
			<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
				<div class="container">
					<a href="{{ url('/') }}">
						<img src="/images/logo-example.png" width="110px" height="100%">
					</a>
					<div class="collapse navbar-collapse ms-4" id="navbarSupportedContent">
						<!-- Left Side Of Navbar -->
						<ul class="navbar-nav me-auto">
							<li class="nav-item">
								<a class="nav-link" href="/">
									PAINEL
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/pages/customer/index.php">
									Clientes
								</a>
							</li>
							 <li class="nav-item">
							 	<a class="nav-link" href="/pages/product/index.php">
									Produtos
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/pages/order/index.php">
									Ordens
								</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>