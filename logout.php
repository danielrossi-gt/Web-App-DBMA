<?php
  
    session_start();
    require_once('conn/conn.php');

   	//echo $_SESSION["atendimento"];


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

    session_destroy();
    header("Location: index.html");

?>