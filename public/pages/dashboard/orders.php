<?php
require_once '../../../src/controllers/CustomerController.php';
require_once '../../../src/models/Order.php';

$data = new stdClass();

if (isset($_GET['id'])) {
	$data->id = $_GET['id'];
};

if (isset($_GET['name'])) {
	$data->name = $_GET['name'];
};

if (isset($_GET['date_min'])) {
	$data->date_min = $_GET['date_min'];
};

if (isset($_GET['date_max'])) {
	$data->date_max = $_GET['date_max'];
};

// all models and products for index foreach
$orders = Order::filterOrders($data);

// layout default
require_once '../layouts/header.php';
?>

<div class='container mt-5'>
	<div class='row'>
		<div class='col'>
			<h3 class='form-title'>
				CONSULTA DE ORDENS
			</h3>
		</div>
	</div>

	<form name='customer-form' method='GET' action='./orders.php'>
		<div class='row mt-3'>
			<div class='col-1'>
				<label class='form-label' for='formId' class="form-label">
					Código
				</label>
			</div>
			<div class='col-1'>
				<input id='formId' class='form-control' type='text' name='id' value=''>
			</div>
			<div class='col-1'>
				<label class='form-label' for='formName' class="form-label">
					Nome
				</label>
			</div>
			<div class='col-3'>
				<input id='formName' class='form-control' type='text' name='name' value=''>
			</div>
			<div class='col-1'>
				<label class='form-label p-1' for='formDateMin' class='form-label'>
					Data mín.
				</label>
			</div>
			<div class='col-2'>
				<input id='formDateMin' class='form-control text-end' type='date' name='date_min' value=''>
			</div>
			<div class='col-1'>
				<label class='form-label p-1' for='formDateMax' class='form-label'>
					Data máx.
				</label>
			</div>
			<div class='col-2'>
				<input id='formDateMax' class='form-control text-end' type='date' name='date_max' value=''>
			</div>

		</div>

		<div class='row mt-4'>
			<div class='offset-9 col-3 text-end'>
				<a href='./pages/dashboard/orders.php'>
					<button class="btn btn-secondary">
						LIMPAR
					</button>
				</a>
				<button class="btn btn-primary" type='submit'>
					FILTRAR
				</button>
			</div>
		</div>

	</form>

	</x-slot:form>

	<x-slot:table>

		<!-- table header -->
		<div class="row list mt-5">
			<div class="col-1 table-header">
				Número
			</div>
			<div class="col-3 table-header">
				Cliente
			</div>
			<div class="col-4 table-header">
				Produto
			</div>
			<div class="col-2 table-header">
				Data de abertura
			</div>
			<div class="col-2 table-header">
				Ações
			</div>
		</div>



		<!-- table lines -->
		<?php
		if ($orders) {
			foreach ($orders as $order) : ?>

				<div class="row list">
					<div class="col-1 text-center">
						<?php echo $order['id'] ?>
					</div>
					<div id="user-name" class="col-3">
						<p class="text-start">
							<?php echo $order['name'] ?>
						</p>
					</div>
					<div class="col-4">
						<p class="text-center">
							<?php echo $order['description'] ?>
						</p>
					</div>
					<div class="col-2">
						<p class="text-center">
							<?php echo $order['start_date'] ?>
						</p>
					</div>
					<div class="col-2">

						<?php
						if (isset($order['finished'])) {
							echo "<button type='button' id=" . $order['id'] . " class='btn btn-success w-100 pb-1' onClick='ajax(" . $order['id']  . ")'>";
							echo "FINALIZADA";
						} else {
							echo "<button type='button' id=" . $order['id'] . " class='btn btn-secondary w-100 pb-1' onClick='ajax(" . $order['id']  . ")'>";
							echo "AGUARDANDO";
						}
						echo "</button>";
						?>

					</div>

				</div>
		<?php endforeach;
		} ?>

</div>

<?php
require_once '../layouts/footer.php';
?>

<script>
	function ajax(orderId) {

		let url = 'http://localhost:8111/pages/api/activeOrders.php?id=' + orderId;

		let xhr = new XMLHttpRequest();

		xhr.open('GET', url);
		xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

		xhr.onload = function() {
			var order = JSON.parse(xhr.responseText);

			changeButton(order);
		}

		xhr.send();

	}

	function changeButton(order) {
		let button = document.getElementById(order.id);

		if (order.finished == 1) {
			button.className = 'btn btn-success w-100 pb-1';
			button.innerHTML = 'FINALIZADA';
		} else {
			button.className = 'btn btn-secondary w-100 pb-1';
			button.innerHTML = 'AGUARDANDO';
		}

	}
</script>