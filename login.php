<?php
	require_once('conn/conn.php');
	$usuario = strtoupper($_POST["txtUsuario"]);
	$senha = $_POST["txtSenha"];
	
	$sql = "SELECT COUNT(1) CONT FROM usuario WHERE NOME = '$usuario' AND SENHA = '$senha'";
	$query = ibase_query($conn, $sql) or die(ibase_errmsg());
	$row = ibase_fetch_object($query);
	$cont = $row->CONT;
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
		<title>DBMA Login</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">		

	</head>
	<body class="background" style="padding: 20px;">
	
	<div class = "container">
  
	<?php
		
		if ($cont == 0) {

		echo "
			<div class='col-sm-12'>
			  <div class='panel panel-primary'>
				<div class='panel-heading'>
				  <h3 class='panel-title'>Login</h3>
				</div>
				<div class='panel-body'>
					<img width='100px' src='images\usuario_invalido.png' class='img-responsive' style='margin: 0 auto'>
					<h3>Usuário ou senha inválida.</h3>
					<button type='button' class='btn btn-lg btn-primary btn-block' onclick=\"location.href = 'index.html';\"'>Voltar</button>
				</div>
			  </div>
			</div>";
		}
		else {

			$sql = "SELECT CODUSUARIO, NOME, CODFUN FROM usuario WHERE NOME = '$usuario' AND SENHA = '$senha'";
			$query = ibase_query($conn, $sql) or die(ibase_errmsg());
			$row = ibase_fetch_object($query);

			//registrar informações do usuário
			session_start();
			$_SESSION["usuario_codigo"] = $row->CODUSUARIO;
			$_SESSION["usuario_nome"] = $row->NOME;
			$_SESSION["usuario_codfun"] = $row->CODFUN;

			//registrar parâmetros
			$sql = "SELECT CODTMV_PEDIDO, FILIAL_PEDIDO FROM PARAMGERAL";
			$query = ibase_query($conn, $sql) or die(ibase_errmsg());
			$row = ibase_fetch_object($query);

			$codtmv_pedido = $row->CODTMV_PEDIDO;
			$filial_pedido = $row->FILIAL_PEDIDO;
			$_SESSION["param_codtmv"] = $row->CODTMV_PEDIDO;
			$_SESSION["filial_pedido"] = $row->FILIAL_PEDIDO;

			$sql =  "SELECT PARAMMOV.STATUSDEFAULT, " .
					"	   PARAMMOV.SERIEDEFAULT, " .
					"	   PARAMMOV.CLIFORDEFAULT, " .
					"	   PARAMMOV.NATUREZADEFAULT, " .
					"	   PARAMMOV.CONDPGTODEFAULT, " .
					"	   PARAMMOV.CONTACAIXADEFAULT " .
					" FROM PARAMMOV WHERE CODTMV = '$codtmv_pedido'";

			$query = ibase_query($conn, $sql) or die(ibase_errmsg());
			$row = ibase_fetch_object($query);

			$_SESSION["param_status"] = $row->STATUSDEFAULT;
			$_SESSION["param_serie"] = $row->SERIEDEFAULT;
			$_SESSION["param_clifor"] = $row->CLIFORDEFAULT;
			$_SESSION["param_natureza"] = $row->NATUREZADEFAULT;
			$_SESSION["param_condpagto"] = $row->CONDPGTODEFAULT;
			$_SESSION["param_contacaixa"] = $row->CONTACAIXADEFAULT;





			$sql = "SELECT FILIAL, CODLOC FROM PARAMMOVTLOC WHERE CODTMV = '$codtmv_pedido' AND FILIAL = $filial_pedido";
			$query = ibase_query($conn, $sql) or die(ibase_errmsg());
			$row = ibase_fetch_object($query);

			$_SESSION["param_filial"] = $row->FILIAL;
			$_SESSION["param_codloc"] = $row->CODLOC;

			ibase_close($conn);

			header("Location: novo_atendimento.php");
		}
			
	?>
	
	</div>
  
  </body>
  </html>