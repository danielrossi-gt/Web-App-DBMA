		<nav class="navbar navbar-inverse" >
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			  </button>
			  <a class="navbar-brand" href="#"><?php  echo $_SESSION["usuario_nome"] ?></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
			  <ul class="nav navbar-nav navbar-right">
			    <li><a href="novo_atendimento.php">Novo Atendimento</a></li>

			    <?php 

			    	if (isset($_SESSION["atendimento"])) {

						echo "<li><a href='novo_produtos_atendimento_filtro.php'>Novo Filtro</a></li>";			    		
			    	}
			    ?>

				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
			  </ul>
			</div>
		  </div>
		</nav>