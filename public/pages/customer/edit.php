<?php
require_once '../../../src/controllers/CustomerController.php';

if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['address_number'])) {

	$data['id'] = $_GET['id'];
	$data['name'] = $_POST['name'];
	$data['address'] = $_POST['address'];
	$data['address_number'] = $_POST['address_number'];

	$customer = new Customer($data);

	$customerController = new CustomerController;
	$customerController->update($customer);
}

$customer = Customer::find($_GET['id']);

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
				EDITAR INFORMAÇÕES DO CLIENTE
			</h3>
		</div>
	</div>

	<form name='customer-form' method='post' action='<?php echo '/pages/customer/edit.php?id=' . $customer['id'] ?> '>
		<div class='row mt-4'>

			<div class='col-1 form-label'>
				<label for='formName' class="form-label">
					Nome
				</label>
			</div>
			<div class='col-4'>
				<input id='formName' class='form-control' type='text' name='name' value='<?php echo $customer['name'] ?>'>
			</div>

			<div class='row mt-4'>
				<div class='col-1 form-label'>
					<label for='formCpf' class="form-label">
						CPF
					</label>
				</div>
				<div class='col-2'>
					<p class="text-start mt-3">
						<?php echo $customer['cpf'] ?>
					</p>
				</div>
			</div>

			<div class='row mt-4'>
				<div class='col-1'>
					<label for='formAddress' class="form-label">
						Endereço
					</label>
				</div>
				<div class='col-4'>
					<input id='formAddress' class='form-control' type='text' name='address' value='<?php echo $customer['address'] ?>'>
				</div>
			</div>

			<div class='row mt-4'>
				<div class='col-1'>
					<label for='formAddressNumber' class="form-label">
						Número
					</label>
				</div>
				<div class='col-2'>
					<input id='formAddressNumber' class='form-control text-end' type='number' name='address_number' value='<?php echo $customer['address_number'] ?>'>
				</div>
			</div>

		</div>

		<div class='row mt-5'>
			<div class='col text-end'>
				<button class="btn btn-primary" type='submit'>
					SALVAR
				</button>
			</div>
		</div>

	</form>

</div>

<?php
require_once '../layouts/footer.php';
?>