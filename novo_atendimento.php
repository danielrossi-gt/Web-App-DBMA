<?php
    session_start();
	require_once('conn/conn.php');
	
    /* SETA O ATENDIMENTO ABERTO PARA IMPRESSÃO, SE HOUVER */
	if (isset($_SESSION["atendimento"])) {

		$sql = "SELECT COUNT(1) CONT FROM TITMMOV WHERE IDMOV = " . $_SESSION["atendimento"];
		$query = ibase_query($conn, $sql) or die(ibase_errmsg());
		$row = ibase_fetch_object($query);

		if ($row->CONT > 0) {

			$sql = ibase_prepare("UPDATE TMOV SET IMPRESSO = 'N' WHERE IDMOV = " . $_SESSION["atendimento"]);
			$trans = ibase_trans();
			ibase_execute($sql);
			ibase_commit($trans);
			unset($trans);		

		}
		else {

			$sql = ibase_prepare("DELETE FROM TMOV WHERE IDMOV = " . $_SESSION["atendimento"]);
			$trans = ibase_trans();
			ibase_execute($sql);
			ibase_commit($trans);
			unset($trans);		

		}

		unset($_SESSION["atendimento"]);
		
	}


	
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1,  maximum-scale=1, user-scalable=no">
		<!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
		<title>DBMA Login</title>


	<script language='JavaScript'>
	function SomenteNumero(e){
	    var tecla=(window.event)?event.keyCode:e.which;   
	    if((tecla>47 && tecla<58)) return true;
	    else{
	    	if (tecla==8 || tecla==0) return true;
		else  return false;
	    }
	}
	</script>

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
			<form action="inc_atendimento.php" method="POST">
				<div class='col-sm-12'>
				  <div class='panel panel-primary'>
					<div class='panel-heading'>
					  <h3 class='panel-title'>Iniciar Atendimento</h3>
					</div>
					<div class='panel-body'>
						<div class="col-sm-4">
						</div>
						<div class="col-sm-4">
						    <label for="txtMesa">Informe a mesa:</label>
							<input type="number" class="form-control input-lg" name="txtMesa" id="txtMesa" onkeypress="return SomenteNumero(event)" required>
							<br/>
				  			<button class="btn btn-lg btn-primary" type="submit">OK</button>
						</div>
					</div>
				  	<br/>
				  </div>
				</div>
			</form>
		</div>
  
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster 
		<script src="jquery/jquery-3.2.0.min.js"></script>
		<script>window.jQuery || document.write('<script src="jquery/jquery-3.2.0.min.js"><\/script>')</script>
		<script src="js/bootstrap.min.js"></script>-->


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