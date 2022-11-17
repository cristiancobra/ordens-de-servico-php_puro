<?php
require_once '../../../src/controllers/ProductController.php';

// crud store/post
if (isset($_POST['sku']) && isset($_POST['description'])) {

	$data['id'] = $_GET['id'];
	$data['sku'] = $_POST['sku'];
	$data['description'] = $_POST['description'];

	if (isset($_POST['active'])) {
		$data['active'] = 1;
	} else {
		$data['active'] = 0;
	}

	$product = new Product($data);

	$productController = new ProductController;
	$productController->update($product);
}

$product = Product::find($_GET['id']);

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
				EDITAR INFORMAÇÕES DO PRODUTO
			</h3>
		</div>
	</div>

	<form name='product-form' method='post' action='<?php echo '/pages/product/edit.php?id=' . $product['id'] ?> '>
		<div class='row mt-4'>

			<div class='col-1 form-label'>
				<label for='formSku' class="form-label">
				Código
				</label>
			</div>
			<div class='col-4'>
				<input id='formSku' class='form-control' type='text' name='sku' value='<?php echo $product['sku'] ?>'>
			</div>

			<div class='row mt-4'>
				<div class='col-1'>
					<label for='formDescription' class="form-label">
					Descrição
					</label>
				</div>
				<div class='col-4'>
					<input id='formDescription' class='form-control' type='text' name='description' value='<?php echo $product['description'] ?>'>
				</div>
			</div>

			<div class='col-1'>
				<label class='form-label' for='formStatus' class='form-label'>
					Ativo
				</label>
			</div>
			<div class='col-1 ms-auto'>
				<div class="form-check form-switch">
					<input id="formActive" class="form-check-input" type="checkbox" name='active' value='<?php echo $product['active'] ?>' <?php if ($product['active'] == 1) { echo 'checked'; } ?> >
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