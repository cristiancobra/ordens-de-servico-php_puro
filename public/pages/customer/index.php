<?php
require_once '../../../src/controllers/CustomerController.php';
require_once '../../../src/models/Customer.php';

// crud store/post
if (isset($_POST['name']) && isset($_POST['cpf']) && isset($_POST['address']) && isset($_POST['address_number'])) {

	$data = new stdClass();
	$data->name = $_POST['name'];
	$data->cpf = $_POST['cpf'];
	$data->address = $_POST['address'];
	$data->address_number = (int) $_POST['address_number'];

	$customerController = new CustomerController;
	$customerController->create($data);
}

// all models for index foreach
$customers = Customer::findAll();

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
				CADASTRAR CLIENTE
			</h3>
		</div>
	</div>

	<form name='customer-form' method='post' action='/pages/customer/index.php'>
		<div class='row mt-3'>
			<div class='col-1'>
				<label for='formName' class="form-label">
					Nome
				</label>
			</div>
			<div class='col-2'>
				<input id='formName' class='form-control' type='text' name='name' value=''>
			</div>
			<div class='col-1'>
				<label for='formCpf' class="form-label">
					CPF
				</label>
			</div>
			<div class='col-2'>
				<input id='formCpf' class='form-control text-end' type='text' name='cpf' value=''>
			</div>
			<div class='col-1'>
				<label for='formAddress' class="form-label">
					Endereço
				</label>
			</div>
			<div class='col-3'>
				<input id='formAddress' class='form-control' type='text' name='address' value=''>
			</div>
			<div class='col-1'>
				<label for='formAddressNumber' class="form-label">
					Número
				</label>
			</div>
			<div class='col-1'>
				<input id='formAddressNumber' class='form-control text-end' type='number' name='address_number' value=''>
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
		LISTA DE CLIENTES
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
			Endereço
		</div>
		<div class="col-2 table-header">
			Número
		</div>
	</div>

	<!-- table lines -->
	<?php foreach ($customers as $customer) : ?>

		<div class="row list position-relative">
			<a class='stretched-link' href=' <?php echo '/pages/customer/edit.php?id=' . $customer['id'] ?> '>
			</a>
			<div id="user-name" class="col-3">
				<p class="text-start">
					<?php echo $customer['name'] ?>
				</p>
			</div>
			<div class="col-3">
				<p class="text-center">
					<?php echo $customer['cpf'] ?>
				<p>
			</div>
			<div class="col-4">
				<p class="text-start">
					<?php echo $customer['address'] ?>
				<p>
			</div>
			<div class="col-2">
				<p class="text-center">
					<?php echo $customer['address_number'] ?>
				<p>
			</div>
		</div>
	<?php endforeach; ?>

</div>

<?php
require_once '../layouts/footer.php';
?>