<?php
require_once '../../../src/controllers/ProductController.php';
require_once '../../../src/models/Product.php';

// crud store/post
if (isset($_POST['sku']) && isset($_POST['description'])) {

	$data = new stdClass();
	$data->sku = $_POST['sku'];
	$data->description = $_POST['description'];

	if (isset($_POST['active'])) {
		$data->active = $_POST['active'];
	}

	$productController = new ProductController;
	$productController->create($data);
}

// all models for index foreach
$products = Product::findAll();

// header template default
require_once '../layouts/header.php';
?>



<div class='container mt-5'>
	<?php
	if (isset($_GET['messageType'])) {
		echo "<div class='alert alert-" . $_GET['messageType'] . " mt-5' role='alert'>";
		echo $_GET['messageText'];
		echo "</div>";
	}
	?>

	<div class='row'>
		<div class='col'>
			<h3 class='form-title'>
				CADASTRAR PRODUTO
			</h3>
		</div>
	</div>

	<form name='customer-form' method='post' action='/pages/product/index.php'>
		<div class='row mt-3'>
			<div class='col-1'>
				<label class='form-label' for='formSku' class="form-label">
					Código
				</label>
			</div>
			<div class='col-2'>
				<input id='formSku' class='form-control' type='text' name='sku' value=''>
			</div>
			<div class='col-1'>
				<label class='form-label' for='formDescription' class="form-label">
					Descrição
				</label>
			</div>
			<div class='col-6'>
				<input id='formDescription' class='form-control' type='text' name='description' value=''>
			</div>
			<div class='col-1'>
				<label class='form-label' for='formStatus' class='form-label'>
					Ativo
				</label>
			</div>
			<div class='col-1 ms-auto'>
				<div class="form-check form-switch">
					<input class="form-check-input" name='active' type="checkbox" id="formActive" value=1 checked>
				</div>
			</div>
		</div>

		<div class='row mt-4'>
			<div class='offset-10 col-2 text-end'>
				<button class="btn btn-primary" type='submit'>
					CADASTRAR
				</button>
			</div>
		</div>

	</form>

	<div class="table-title">
		LISTA DE PRODUTOS
	</div>

	<!-- table header -->
	<div class="row list">
		<div class="col-2 table-header">
			Código
		</div>
		<div class="col-8 table-header">
			Descrição
		</div>
		<div class="col-2 table-header">
			Ativo
		</div>
	</div>

	<!-- table lines -->
	<?php foreach ($products as $product) : ?>

		<div class="row list position-relative">
			<a class='stretched-link' href=' <?php echo '/pages/product/edit.php?id=' . $product['id'] ?> '>
			</a>
			<div id="user-name" class="col-2">
				<p class="text-center">
					<?php echo $product['sku'] ?>
				</p>
			</div>
			<div class="col-8">
				<p class="text-start">
					<?php echo $product['description'] ?>
				<p>
			</div>
			<div class="col-2 text-center">
				<?php
				if ($product['active']) {
					echo ("<button type='button' class='btn btn-success w-100'>ATIVO</button>");
				} else {
					echo ("<button type='button' class='btn btn-secondary w-100'>DESATIVADO</button>");
				}
				?>
			</div>
		</div>
	<?php endforeach; ?>

</div>

<?php
require_once '../layouts/footer.php';
?>