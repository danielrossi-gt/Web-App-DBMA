<?php
    session_start();
	require_once('conn/conn.php');

	if (isset($_GET["produto"])) {
		$produto = $_GET["produto"];
	}
	else {
		$produto = "";
	}

	//filtro
	$filtro = "";

    if (isset($_POST['chkFiltro'])) {
    	$filtroSel = $_POST['chkFiltro'];
    	$_SESSION['filtro'] = $filtroSel;	
    }
    else {

    	if (isset($_SESSION['filtro'])) {
    		$filtroSel = $_SESSION['filtro'];			
    	}

    }

	if (isset($filtroSel)) {
		
		$filtro = "";

		foreach($filtroSel as $valor){
		    $filtro = $filtro . "'$valor',";
		}

		$filtro = $filtro . "'0'";

	}

	$sql = "SELECT COUNT(1) CONT FROM TPRD WHERE CODTB1 <> 99 ";

	if ($filtro != "") {
		$sql = $sql . "AND CODTB1 IN (" . $filtro . ") ";

	}

	$query = ibase_query($conn, $sql) or die(ibase_errmsg());
	$row = ibase_fetch_object($query);
    $cont = $row->CONT;

?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1,  maximum-scale=1, user-scalable=no">
		<!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
		<title>DBMA Login</title>

		<!-- Bootstrap -->
		<script src="jquery/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet" />

		<link href="css/style.css" rel="stylesheet">		

		<script type="text/javascript">

		function carrega_produto() {
			window.location.href = 'novo_produtos_atendimento.php?produto=' + document.getElementById('txtCodprod').value;
		}

		</script>
		
	</head>
	
	<body class="background">

        <?php
			include("navbar.inc");
		?>
	
		<div class = "container">
			
			<div class='col-sm-12'>

				<div class='panel panel-primary' style="padding: 10px;">

					<?php 
						if ($cont > 0) {
					?>



						<h4>Mesa: <?php echo $_SESSION["mesa"] ?> </h4> <hr/>

						<form id="frmProdutos" method="POST" action="inc_produtos_atendimento.php">

							<div class="selectContainer">
					            <label for="cmbAdIngr">Produto: </label>
					            <select name="cmbProdutos" class="form-control selectpicker input-lg" data-live-search="true" data-live-search-style="startsWith" title="Clique para selecionar um produto" required>
					                <!--<option value="">SELECIONE UM PRODUTO</option> -->

					            	<?php

					            		$sql = "SELECT IDPRD, CODIGOPRD, NOMEFANTASIA, COALESCE(PRECO1, 0) PRECO1 FROM TPRD WHERE CODTB1 <> 99";

					            		if ($filtro != "") {
					            			$sql = $sql . "AND CODTB1 IN (" . $filtro . ") ";

					            		}

					            		$sql = $sql . "ORDER BY NOMEFANTASIA";
					            		$query = ibase_query($conn, $sql) or die(ibase_errmsg());
					            		$selected = false;
									
										while ($row = ibase_fetch_object($query)) {

											$idProd = $row->IDPRD;
											$nomeProd = $row->NOMEFANTASIA . ' ';

											if ($produto == $row->CODIGOPRD && !$selected)  {
												echo "<option data-tokens='$nomeProd' value='$idProd' selected>$nomeProd</option>";
												$selected = true;
											}
											else {

												if (strpos($nomeProd, strtoupper($produto)) === 0 && !$selected) {
													echo "<option data-tokens='$nomeProd' value='$idProd' selected>$nomeProd</option>";
													$selected = true;
												}
												else {
													echo "<option data-tokens='$nomeProd' value='$idProd'>$nomeProd</option>";
												}
											}


										}

					            	?>

					            </select>
					            
					            <div style="margin-top:20px;">
					            <label for="txtQtde">Quantidade: </label>
					            <input type="number" class="form-control input-lg" pattern="[0-9]" id="txtQtde" name="txtQtde" min="0" step="0.001" required>
					            </div>

					            <div style="margin-top:20px;">
					            <label for="cmbAdIngr">Adicionar Ingredientes: </label>
								<select id="cmbAdIngr[]" name="cmbAdIngr[]" class="form-control" multiple>

					            	<?php

					            		$sql = "SELECT IDPRD, CODIGOPRD, NOMEFANTASIA, PRECO1 FROM TPRD WHERE CODTB1 = 99 ORDER BY NOMEFANTASIA";
										$query = ibase_query($conn, $sql) or die(ibase_errmsg());
										

										while ($row = ibase_fetch_object($query)) {

											$idProd = $row->IDPRD;
											$nomeProd = $row->NOMEFANTASIA;

											echo "<option value = '$idProd'>$nomeProd</option>";

										}

					            	?>

								</select>
								</div>

					            <div style="margin-top:20px;">
					            <label for="cmbRetIngr">Retirar Ingredientes: </label>
								<select id="cmbRetIngr[]" name="cmbRetIngr[]" class="form-control" multiple>

					            	<?php

					            		$sql = "SELECT IDPRD, CODIGOPRD, NOMEFANTASIA, PRECO1 FROM TPRD WHERE CODTB1 = 99 ORDER BY NOMEFANTASIA";
										$query = ibase_query($conn, $sql) or die(ibase_errmsg());
										

										while ($row = ibase_fetch_object($query)) {

											$idProd = $row->IDPRD;
											$nomeProd = $row->NOMEFANTASIA;

											echo "<option value = '$idProd'>$nomeProd</option>";

										}

					            	?>

								</select>
								</div>

						        <br/>
							    <button class="btn btn-lg btn-primary" type="submit">OK</button>    
							    <br/>
							    <br/>


					        </div>


						</form>

						<?php
				 			}
				 			else {
				 		?>

						<div class='panel-heading'>
						  <h3 class='panel-title'>Aviso</h3>
						</div>
						<div class='panel-body'>
							<!--<img width='100px' src='images\usuario_invalido.png' class='img-responsive' style='margin: 0 auto'> -->
							<br/>
							<h3>Nenhum produto encontrado para o filtro selecionado.</h3>
							<br/>
							<br/>
							<button type='button' class='btn btn-lg btn-primary btn-block' onclick="location.href = 'novo_produtos_atendimento.php';"'>Voltar</button>
						</div>


				 		<?php


				 			}

						?>
					</div>
				
			</div>

		</div>
  
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

  
	</body>
	
</html>