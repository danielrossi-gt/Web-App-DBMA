<?php
    session_start();
	require_once('conn/conn.php');

	//Trava para não gravar campo PEDCLIENTE vazio
	if (isset($_POST["txtMesa"])) {
		$mesa = $_POST["txtMesa"];
	}
	else {
		header("Location: novo_atendimento.php");	
	}

	if ($mesa == '') {
		header("Location: novo_atendimento.php");	
	}
	
	//sequencial
	if ($mesa != 0) {
		$sql = "SELECT MAX(IDMOV) VALOR FROM TMOV WHERE PEDCLIENTE = $mesa AND STATUS = 'A'";
		$query = ibase_query($conn, $sql) or die(ibase_errmsg());
		$row = ibase_fetch_object($query);	
		$sequencial = $row->VALOR;
	}
	/*
	echo "sequencial: $sequencial $sql";
	
	if (is_null($sequencial)) {
  	  echo "é nulo";
	}
	else {
      echo "não é nulo";		
		
	}
	*/

	$jaExiste = 'NAO';
	
    if (is_null($sequencial)) {
	
	
		$sql = "SELECT VALOR FROM AUTOINC WHERE CODIGO = 'IDMOV'";
		$query = ibase_query($conn, $sql) or die(ibase_errmsg());
		$row = ibase_fetch_object($query);	
		$sequencial = $row->VALOR;
		$sequencial++;

		$sql = ibase_prepare("UPDATE AUTOINC SET VALOR = $sequencial WHERE CODIGO = 'IDMOV'");
		$trans = ibase_trans();
		ibase_execute($sql);
		ibase_commit($trans);
		unset($trans);
		
	}
	else {
		$jaExiste = 'SIM';
	}
	
	//data e hora atual
	$sql = "SELECT CAST('NOW' AS TIMESTAMP) DATAHORA FROM RDB\$DATABASE";
	$query = ibase_query($conn, $sql) or die(ibase_errmsg());
	$row = ibase_fetch_object($query);	
	$sysdate = $row->DATAHORA;

	//NUMEROMOV
	$sql = "SELECT CAST(MAX(NUMEROMOV) AS INTEGER) + 1 NUMEROMOV FROM TMOV";
	$query = ibase_query($conn, $sql) or die(ibase_errmsg());
	$row = ibase_fetch_object($query);	
	$numeromov = $row->NUMEROMOV;
	$numeromov = str_pad($numeromov, 6, "0", STR_PAD_LEFT);

	//parâmetros	
	$filial = $_SESSION['param_filial'];
	$codloc = $_SESSION["param_codloc"];
	$codtmv = $_SESSION["param_codtmv"];
	$serie = $_SESSION["param_serie"];
	$status = $_SESSION["param_status"];
	$usuario = $_SESSION["usuario_nome"];
	$natureza = $_SESSION["param_natureza"];
	$condpagto = $_SESSION["param_condpagto"];
	$codfunc = $_SESSION["usuario_codfun"];
	$caixa = $_SESSION["param_contacaixa"];
	$codcfo = $_SESSION["param_clifor"];

	//comando SQL
	if ($mesa != '') {

 		if ($jaExiste == 'NAO') {

			$sql = ibase_prepare("INSERT INTO TMOV (
									IDMOV,
									FILIAL,
									CODLOC,
									CODTMV,
									SERIE,
									SEQSERIE,
									NUMEROMOV,
									STATUS,
									DATAEMISSAO,
									DATAENTSAI,
									CODCFO,
									CODNAT,
									CODPGTO,
									CODFUN,
									USUARIOCRIACAO,
									DATACRIACAO,
									CODCXA,
									PEDCLIENTE,
									VALORDESCONTO,
									VALORFRETE,
									VALORACRESCIMO)
								  VALUES (
								    $sequencial,
									'$filial',
									'$codloc',
									'$codtmv',
									'$serie',
									0,
									'$numeromov',
									'$status',
									'$sysdate',
									'$sysdate',
									'$codcfo', 
									'$natureza',
									'$condpagto',
									'$codfunc',
									'$usuario',
									'$sysdate',
									'$caixa',
									'$mesa',
									0,
									0,
									0)");

			$trans = ibase_trans();
			ibase_execute($sql);
			ibase_commit($trans);
			unset($trans);

		}

	 	$_SESSION["atendimento"] = $sequencial;
	 	$_SESSION["mesa"] = $mesa;

	 	header("Location: novo_produtos_atendimento.php");

 	}
 	else {
 		header("Location: novo_atendimento.php");	
 	}

?>
