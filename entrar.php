<?php
//signin.php
include 'connect.php';
include 'header.php';

echo '<h3>Acesso ao Sistema</h3><br />';

//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
	echo 'Você já tem acesso ao sistema, para sair <a href="signout.php">CLique aqui</a>.';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		/*o form ainda não foi enviado, mostre
		  perceba que o action="" isso fara com que seja enviado atraves da mesma pagina*/
		echo '
				<form class="form-horizontal" method="post" action="">
				  <div class="control-group">
				    <label class="control-label" for="user_name">Usuário</label>
				    <div class="controls">
				      <input type="text" id="inputEmail" name="user_name">
				    </div>
				  </div>
				  <div class="control-group">
				    <label class="control-label" for="inputPassword">Senha</label>
				    <div class="controls">
				      <input type="password" id="inputPassword" name="user_pass">
				    </div>
				  </div>
				  <div class="control-group">
				    <div class="controls">				      
				      <button type="submit" class="btn">Entrar</button>
				    </div>
				  </div>
				</form>';
	}
	else
	{
		/* processaremos os dados em 3 passos:
			1.	Verifica os dados
			2.	Deixa o usuario resolver os erros de preenchimento (se necessario)
			3.	Verifique se o dado esta correto e retorne a resposta.
		*/
		$errors = array(); /* declara array de erros (usar depois)*/
		
		if(!isset($_POST['user_name']))
		{
			$errors[] = 'O campo Usuário não pode ser vazio!';
		}
		
		if(!isset($_POST['user_pass']))
		{
			$errors[] = 'O campo Senha não pode ser vazio!';
		}
		
		if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
		{
			echo 'Alguns erros forma encontrados..<br /><br />';
			echo '<ul>';
			foreach($errors as $key => $value) /* ande pelo array de erros  */
			{
				echo '<li>' . $value . '</li>'; /* exiba o erro de forma elegante */
			}
			echo '</ul>';
			
		}
		else
		{
			//the form has been posted without errors, so save it
			//notice the use of mysql_real_escape_string, keep everything safe!
			//also notice the sha1 function which hashes the password
			$sql = "SELECT 
						user_id,
						user_name,
						user_level
					FROM
						users
					WHERE
						user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
					AND
						user_pass = '" . sha1($_POST['user_pass']) . "'";
						
			$result = mysql_query($sql);
			if(!$result)
			{
				//something went wrong, display the error
				echo 'Algo de errado ocorreu ao tentar acessar o sistema. Por favor tente mais tarde.';
				//echo mysql_error(); //debugging purposes, uncomment when needed
			}
			else
			{
				//the query was successfully executed, there are 2 possibilities
				//1. the query returned data, the user can be signed in
				//2. the query returned an empty result set, the credentials were wrong
				if(mysql_num_rows($result) == 0)
				{
					echo 'Usuário ou Senha não conferem! Tente novamente.';
				}
				else
				{
					//set the $_SESSION['signed_in'] variable to TRUE
					$_SESSION['signed_in'] = true;
					
					//we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
					while($row = mysql_fetch_assoc($result))
					{
						$_SESSION['user_id'] 	= $row['user_id'];
						$_SESSION['user_name'] 	= $row['user_name'];
						$_SESSION['user_level'] = $row['user_level'];
					}					

					echo 'Olá, ' . $_SESSION['user_name'] . '. <br /><a href="index.php">Prossiga para o mural de recados.</a>.';
					
					echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=index.php'>";


				}
			}
		}
	}
}

include 'footer.php';
?>