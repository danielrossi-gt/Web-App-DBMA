<?php

	$servidor = 'localhost:C:/DBMA/FONTES/BDFB/BEETHOVEN.FDB';
	
	//conexão com o banco, se der erro mostrara uma mensagem.
	if (!($conn=ibase_connect($servidor, 'SYSDBA', 'masterkey'))) {
		die('Erro ao conectar: ' . ibase_errmsg());	
	}

?>