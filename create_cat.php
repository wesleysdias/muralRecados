<?php
//create_cat.php
include 'connect.php';
include 'header.php';

echo '<h2>Criar uma Nova Turma</h2>';
if(isset($_SESSION['signed_in']) == false | isset($_SESSION['user_level']) != 1 )
{
	//the user is not an admin
	echo 'Desculpe, você não tem permissão para acessar esta página.';
}
else
{
	//the user has admin rights
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		//the form hasn't been posted yet, display it
		echo '<form method="post" action="">
			Nome: <input type="text" name="cat_name" /><br />
			Descrição:<br /> <textarea name="cat_description" /></textarea><br /><br />
			<input type="submit" value="Criar Turma" />
		 </form>';
	}
	else
	{
		//the form has been posted, so save it
		$sql = "INSERT INTO categories(cat_name, cat_description)
		   VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
				 '" . mysql_real_escape_string($_POST['cat_description']) . "')";
		$result = mysql_query($sql);
		if(!$result)
		{
			//mostra o erro!
			echo 'Erro' . mysql_error();
		}
		else
		{
			echo 'Nova turma criada com sucesso!';
		}
	}
}

include 'footer.php';
?>
