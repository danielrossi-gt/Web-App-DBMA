<?php

	//$servidor = 'localhost:C:/DBMA/BDFB/SECRET.FDB';

	//$servidor = 'localhost:C:/DBMA/BDFB/BEETHOVEN.FDB';

	$servidor = 'localhost:C:/DBMA/BDFB/BELLAVIE.FDB';
	
	//conexão com o banco, se der erro mostrara uma mensagem.
	if (!($conn=ibase_connect($servidor, 'SYSDBA', 'masterkey'))) {
		die('Erro ao conectar: ' . ibase_errmsg());	
	}

?>