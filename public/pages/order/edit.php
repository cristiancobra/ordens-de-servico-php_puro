<?php
require_once '../layouts/header.php';
require_once '../../../src/controllers/OrderController.php';

if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['address_number'])) {

	$data = new stdClass();
	$data->id = (int) $_GET['id'];
	$data->name = $_POST['name'];
	$data->address = $_POST['address'];
	$data->address_number = $_POST['address_number'];

	$orderController = new OrderController;
	$orderController->update($data);
}

$order = Order::findWithCustomer($_GET['id']);
$order = reset($order);
?>

<div class='container mt-5'>
	<div class='row'>
		<div class='col'>
			<h3 class='form-title'>
				EDITAR ORDEM DE SERVIÇO
			</h3>
		</div>
	</div>

	<form name='order-form' method='post' action='<?php echo '/pages/order/edit.php?id=' . $order['id'] ?> '>
		<div class='row mt-4'>

			<div class='col-1 form-label'>
				<label for='formName' class="form-label">
					Cliente
				</label>
			</div>
			<div class='col-4'>
				<input id='formName' class='form-control' type='text' name='name' value='<?php echo $order['name'] ?>'>
			</div>

			<div class='row mt-4'>
				<div class='col-1 form-label'>
					<label for='formCpf' class="form-label">
						CPF
					</label>
				</div>
				<div class='col-2'>
					<p class="text-start mt-3">
						<?php echo $order['cpf'] ?>
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
					<input id='formAddress' class='form-control' type='text' name='address' value='<?php echo $order['address'] ?>'>
				</div>
			</div>

			<div class='row mt-4'>
				<div class='col-1'>
					<label for='formAddressNumber' class="form-label">
						Número
					</label>
				</div>
				<div class='col-2'>
					<input id='formAddressNumber' class='form-control text-end' type='number' name='address_number' value='<?php echo $order['address_number'] ?>'>
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