<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Subir excel a Base de datos con PHP | Antoni.me</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="css/estilos.css">
</head>
<body>

	<div class="container">
		<h4 class="text-center mb-4">Importar Tablas Excel a Base de datos con PHP</h4>
		<form action="controller/controllerImportarExcel.php" method="POST" enctype="multipart/form-data">
			<div class="row justify-content-center">
				<div class="col-md-7">
					<div class="form-group">
						<label for="cargar documento">Cargar documento excel:</label>
						<div class="custom-file">
							<input type="file" class="custom-file-input" name="documento" id="customFile">
							<label class="custom-file-label" for="customFile">Seleccionar archivo</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Guardar</button>
					<?php 
					if (isset($_GET['mensaje']) && $_GET['mensaje'] == "Confirmado") {
						?>
							<div class="alert alert-success mt-2">
								Excel subido.
							</div>
						<?php
					}
					?>
				</div>
			</div>
		</form>
	</div>

	<script
	src="https://code.jquery.com/jquery-3.5.1.js"
	integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
	crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
