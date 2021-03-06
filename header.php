<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 	<meta name="description" content="A short description." />
 	<meta name="keywords" content="put, keywords, here" />

 	<title>Mural de Recados IFBA - Sistemas de Informação</title>
	
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
	<link rel="stylesheet" href="style.css" type="text/css">
	
	
</head>
<body>
	
	<div id="wrapper">					

		<img src="img/cabecalho.png" alt="Mural de Recados" />
		<h1>Mural de Recados BSI</h1>
	<div id="menu">
		<a class="btn btn-info" href="index.php">Painel de Recados</a>
		<a class="btn btn-success" href="escrever_recado.php">Escrever Recado</a>

		<?php 
				if(isset($_SESSION['signed_in']))
				{

					if($_SESSION['user_level'] == 1)
						{
							//the user is not an admin
							echo '<a class="btn btn-success" href="cadastrar_turma.php">Cadastrar Turma</a>';
						}
				}

		 ?>
		
		<div id="userbar" class="text-right">
		<?php
		if(isset($_SESSION['signed_in']))
		{
			echo 'Olá <b>' . htmlentities($_SESSION['user_name']) . ' </b><a class="btn btn-danger" href="sair.php">Sair</a>';
		}
		else 
		{
			echo '<a class="btn btn-warning" href="entrar.php">Entrar</a> ou <a class="btn btn-info" href="cadastrar.php">Criar uma conta</a>';
		}
		?>
		</div>
	</div>
		<div id="content">