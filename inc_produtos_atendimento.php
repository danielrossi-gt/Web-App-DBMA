<?php
    session_start();
	require_once('conn/conn.php');
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
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">		
		<script src="jquery/jquery-3.2.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

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

		<div id="container">
			<div class='col-sm-12'>
				<div class='panel panel-primary' style="padding: 10px;">

<?php




	$idMov = $_SESSION["atendimento"];
	$produto = $_POST["cmbProdutos"];
	$qtde = $_POST["txtQtde"];
	$natureza = $_SESSION["param_natureza"];

	//Sequencial
	$sql = "SELECT MAX(SEQUENCIAL) SEQUENCIAL FROM titmmov WHERE IDMOV = $idMov";
	$query = ibase_query($conn, $sql) or die(ibase_errmsg());
	$row = ibase_fetch_object($query);	
	$sequencial = $row->SEQUENCIAL;
	$sequencial++;	

    //Preço
	$sql = "SELECT PRECO1 FROM tprd WHERE IDPRD = $produto";
	$query = ibase_query($conn, $sql) or die(ibase_errmsg());
	$row = ibase_fetch_object($query);	
	$preco = $row->PRECO1;

	$valorTotal = $qtde * $preco;
	$valorAcrescimo = 0;

    $compl = '';	

    if (isset($_POST["cmbAdIngr"])) {

    	$compl = ""; 

		foreach ($_POST["cmbAdIngr"] as $ingr) {

		    //Preço
			$sql = "SELECT NOMEFANTASIA, PRECO1 FROM tprd WHERE IDPRD = $ingr";
			$query = ibase_query($conn, $sql) or die(ibase_errmsg());
			$row = ibase_fetch_object($query);	
			$compl = $compl . " + " . $row->NOMEFANTASIA . CHR(10);
			$valorTotal = $valorTotal + ($row->PRECO1 * $qtde); 
			$valorAcrescimo = $valorAcrescimo + ($row->PRECO1* $qtde);

		}

	}

    if (isset($_POST["cmbRetIngr"])) {

    	$compl = $compl; 

		foreach ($_POST["cmbRetIngr"] as $ingr) {

		    //Preço
			$sql = "SELECT NOMEFANTASIA, PRECO1 FROM tprd WHERE IDPRD = $ingr";
			$query = ibase_query($conn, $sql) or die(ibase_errmsg());
			$row = ibase_fetch_object($query);	
			$compl = $compl . " - " . $row->NOMEFANTASIA . CHR(10);

		}

	}


	$sql = ibase_prepare("INSERT INTO TITMMOV (
							IDMOV,
							SEQUENCIAL,
							IDPRD,
							CODGRADE,
							COMPLDESCRICAO,
							VALORACRESCIMO,
							VALORDESCONTO,
							CODNAT,
							QUANTIDADEORIGINAL,
							VALORUNITARIO,
							VALORTOTAL,
							IMPRESSO
							)
						  VALUES (
						  	$idMov,
						    $sequencial,
							$produto,
							'00',
							'$compl',
							$valorAcrescimo,
							0,
							'$natureza',
							$qtde,
							'$preco',
							$valorTotal, 
							'N')");


	$trans = ibase_trans();
	ibase_execute($sql) or die("<div class=\"alert alert-danger\" role=\"alert\">
        						<strong>Erro!</strong> Ocorreu um problema ao gravar o pedido.
      							</div>        						
      							<br/>
        						<br/>
        						<br/>
        						<br/>");
	ibase_commit($trans);
	unset($trans);

	$sql = ibase_prepare("UPDATE TMOV 
		                     SET valorliquido = COALESCE(valorliquido, 0) + $valorTotal,
		                     	 valorbruto = COALESCE(valorbruto, 0) + $valorTotal
		                   WHERE IDMOV = $idMov");

	$trans = ibase_trans();
	

	ibase_execute($sql) or die("<div class=\"alert alert-danger\" role=\"alert\">
        						<strong>Erro!</strong> Ocorreu um problema ao gravar o pedido.
      							</div>        						
      							<br/>
        						<br/>
        						<br/>
        						<br/>");
	ibase_commit($trans);
	unset($trans);


    //echo "<div class=\"alert alert-success\" role=\"alert\">
//	 		<strong>Aviso!</strong> Pedido gravado com sucesso.
//				</div>        						
//				<br/>
//			<br/>
//			<br/>
//			<br/>
//			<a href='novo_produtos_atendimento.php' class='btn btn-lg btn-primary'>OK</a>";

	header("Location: novo_produtos_atendimento.php");

?>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>


    			</div>
    		</div>
		</div>  
	</body>

