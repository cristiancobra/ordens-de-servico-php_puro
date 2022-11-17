<?php
require_once '../../../src/controllers/OrderController.php';
require_once '../../../src/models/Order.php';
require_once '../../../src/models/Product.php';

// crud store/post
if (isset($_POST['name']) && isset($_POST['cpf']) && isset($_POST['product_id']) && isset($_POST['start_date']) ) {

	// Product
	$data['product_id'] = $_POST['product_id'];
	$data['start_date'] = $_POST['start_date'];
	$order = new Product($data);

	if (isset($_POST['active'])) {
		$dataOrder->active = $_POST['active'];
	}

	// Customer
	$dataCustomer = new stdClass();
	$dataCustomer->name = $_POST['name'];
	$dataCustomer->cpf = $_POST['cpf'];

	$orderController = new OrderController;
	$orderController->create($dataOrder, $dataCustomer);
}

// all models and products for index foreach
$orders = Order::findAllWithCustomer();
$products = Product::findActives();

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
				CADASTRAR ORDEM DE SERVIÇO
			</h3>
		</div>
	</div>

	<form name='customer-form' method='post' action='/pages/order/index.php'>
		<div class='row mt-3'>
			<div class='col-2'>
				<label for='formName' class="form-label">
					Nome do cliente
				</label>
			</div>
			<div class='col-5'>
				<input id='formName' class='form-control' type='text' name='name' value=''>
			</div>
			<div class='col-2'>
				<label for='formCpf' class="form-label">
					CPF do cliente
				</label>
			</div>
			<div class='col-3'>
				<input id='formCpf' class='form-control text-end' type='text' name='cpf' value=''>
			</div>
		</div>

		<div class='row mt-3'>
			<div class='col-2'>
				<label for='formOrder' class="form-label">
					Produto
				</label>
			</div>
			<div class='col-5'>
				<select class="form-select" aria-label="select-order" name='product_id' id='formOrder'>
					<option value='' selected>
						Selecione um produto
					</option>

					<?php
					foreach ($products as $product) {
						echo ('<option value=' . $product['id'] . '>' . $product['description'] . '</option>');
					}
					?>

				</select>
			</div>
			<div class='col-2'>
				<label for='formStartDate' class="form-label">
					Data de abertura
				</label>
			</div>
			<div class='col-3'>
				<input id='formStartDate' class='form-control text-end' type='date' name='start_date' value=''>
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
		ORDENS DE SERVIÇO ABERTAS
	</div>

	<!-- table header -->
	<div class="row list">
		<div class="col-3 table-header">
			Nome
		</div>
		<div class="col-3 table-header">
			CPF
		</div>
		<div class="col-4 table-header">
			Produto
		</div>
		<div class="col-2 table-header">
			Data de abertura
		</div>
	</div>

	<!-- table lines -->
	<?php 
	if ($orders) {
		foreach ($orders as $order) : ?>

		<div class="row list position-relative">
			<a class='stretched-link' href=' <?php echo '/pages/order/edit.php?id=' . $order['id'] ?> '>
			</a>
			<div id="user-name" class="col-3">
				<p class="text-start">
					<?php echo $order['name'] ?>
				</p>
			</div>
			<div class="col-3">
				<p class="text-center">
					<?php echo $order['cpf'] ?>
				<p>
			</div>
			<div class="col-4">
				<p class="text-center">
				<?php echo $order['description'] ?>
				<p>
			</div>
			<div class="col-2">
				<p class="text-center">
					<?php echo $order['start_date'] ?>
				<p>
			</div>
		</div>
	<?php endforeach; } ?>

</div>

<?php
require_once '../layouts/footer.php';
?>