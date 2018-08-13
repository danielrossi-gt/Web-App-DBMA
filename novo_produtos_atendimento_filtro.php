<?php
    session_start();
	require_once('conn/conn.php');

	if (isset($_SESSION['filtro'])) {
		unset($_SESSION['filtro']);
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1,  maximum-scale=1, user-scalable=no">
		<!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
		<title>DBMA</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">		
		<script src="jquery/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	
	<body class="background">

        <?php
			include("navbar.inc");
		?>
	
		<div class = "container">
			

			<div class='col-sm-12'>

				<div class='panel panel-primary' style="padding: 10px;">

						<h4>Mesa: <?php echo $_SESSION["mesa"] ?> </h4> <hr/>

						<form id="frmFiltro" method="POST" action="novo_produtos_atendimento.php">

						
							<div class="selectContainer text-left" style="margin-left: 50px;">

					            	<?php

					            		$sql = "SELECT CODTB1, DESCRICAO FROM TABCLAS1 WHERE ATIVO = 1 AND CODTB1 <> 99 ORDER BY DESCRICAO";
										$query = ibase_query($conn, $sql) or die(ibase_errmsg());
										
										while ($row = ibase_fetch_object($query)) {

											$codTB1 = $row->CODTB1;
											$descricao = $row->DESCRICAO;

											echo "<div class='row' style='min-height:50px !important;'><input type='checkbox' class='big' id='chkFiltro' name='chkFiltro[]' value='$codTB1'>
    										      <label for='chkFiltro'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$descricao</label></div>";

										}

					            	?>

						        <br/>
							    <br/>


					        </div>
					        <div class="text-center">
						    	<button class="btn btn-lg btn-primary" type="submit">OK</button>    
						    </div>
						    <br/>


						</form>


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